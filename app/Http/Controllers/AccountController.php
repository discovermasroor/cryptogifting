<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\UserRegisterMail;
use App\Mail\UserLoginMail;
use App\Mail\ResetPasswordLinkMail;
use App\Mail\ForgotPasswordConfirmEmail;
use App\Mail\VerificationSuccessfull;
use App\Models\User;
use App\Models\Event;
use App\Models\Beneficiar;
use App\Models\LoginAttempt;
use App\Models\EventAcceptance;
use App\Models\Setting;
use App\Models\LoginSecurity;


use Luno\Client;
use Luno\Request\CreateAccount;
use Luno\Error;

class AccountController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required'

        ]);
        $user = User::where('email', $request->email)->with('loginSecurity')->first();
        if ($user && HASH::check($request->password, $user->password)) {

            if($user->loginSecurity != NULL && $user->loginSecurity->google2fa_enable == true)
                return redirect(route("TwoFactorAuthView",[$user->user_id]))->with(['req_success' => 'You have Activate Two Factor Authentication, Kindly provide the Google Authenticator Code']);
            
            request()->user = $user;
            $login_attempt = new LoginAttempt;
            $login_attempt->user_id = $user->user_id;
            $login_attempt->access_token = generate_token($user);
            $login_attempt->access_expiry = date("Y-m-d H:i:s", strtotime("1 year"));

            if (!$login_attempt->save()) {
                return redirect(route('SignIn'))->with(['req_error' => 'There is some error!']);

            }
            $browser = '';
            $system = '';
            if ($request->has('browser') && $request->filled('browser')) {
                $browser = $request->browser;

            }

            if ($request->has('system') && $request->filled('system')) {
                $system = $request->system;

            }
            session(['usertoken'=> $login_attempt->access_token]);
            $ip = $this->getUserIpAddr();
            Mail::to($user->email)->send(new UserLoginMail($user, $system, $browser, $ip));
            if (count(Mail::failures()) > 0) return redirect(route('UserDashboard'))->with(['req_error' => 'Login email couldn\'t send!']);

            if ($user->admin) {
                return redirect(route('AdminDashboard'))->with(['req_success' => 'Login Successfull!']);

            }

            if (!$user->first_name && !$user->last_name) {
                return redirect(route('UserDashboard'))->with(['req_name' => '']);

            } else if (!$user->approved_selfie) {
                return redirect(route('UserDashboard'))->with(['req_kyc' => '']);

            } else {
                return redirect(route('UserDashboard'))->with(['req_success' => 'Welcome back! '.$user->first_name.' '.$user->last_name]);

            }
        }
        return redirect(route('SignIn'))->with(['req_error' => 'Invalid Credentials OR Deactive Status!']);
    }

    public function getUserIpAddr(){
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';    
        return $ipaddress;
     }

    public function two_factor_authentication(Request $request)
    {
        
        $request->validate([          
            'password' => 'required|bail|integer'
        ]);

        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

       $password = $request->input('password');
       $user = User::where('user_id', $request->user_id)->with('loginSecurity')->first();
       $get_secret = $user->loginSecurity->google2fa_secret;
       
       if($google2fa->verifyKey($get_secret,$password)){
            
            request()->user = $user;
            $login_attempt = new LoginAttempt;
            $login_attempt->user_id = $user->user_id;
            $login_attempt->access_token = generate_token($user);
            $login_attempt->access_expiry = date("Y-m-d H:i:s", strtotime("1 year"));

            if (!$login_attempt->save()) {
                return redirect(route('SignIn'))->with(['req_error' => 'There is some error!']);

            }
            $browser = '';
            $system = '';
            if ($request->has('browser') && $request->filled('browser')) {
                $browser = $request->browser;

            }

            if ($request->has('system') && $request->filled('system')) {
                $system = $request->system;

            }

            session(['usertoken'=> $login_attempt->access_token]);
            $ip = $this->getUserIpAddr();
            Mail::to($user->email)->send(new UserLoginMail($user, $system, $browser, $ip));
            if (count(Mail::failures()) > 0) return redirect(route('UserDashboard'))->with(['req_error' => 'Login email couldn\'t send!']);

            return redirect(route('UserDashboard'))->with(['req_success' => 'Login Successfull!']);
       }else{
            return redirect()->back()->with(['req_error' => 'Invalid 2FA code. Please try again. If the issue persists, please contact us via the online chat or the the Contact Us page']);
       }
    }

    public function contact_user_verification (Request $request, $id)
    {
        $user = User::where('user_id', $id)->first();
        return view('contact-user-verification', ['user' => $user]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email|unique:users',
            'password' => 'bail|required',
            'first_name' => 'bail|required',
            'last_name' => 'bail|required',
        ]);

        $user = new User;
        $user->user_id = (String) Str::uuid();
        $user->username = explode('@', $request->email)[0].rand(1000, 9999);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->email_verification_code = rand(1000, 9999);
        $user->addFlag(User::FLAG_ACTIVE);
        $user->addFlag(User::FLAG_CUSTOMER);

        if ($user->save()) {
            
            Mail::to($user->email)->send(new UserRegisterMail($user));
            if (count(Mail::failures()) > 0) {
                return api_error('Register email couldn\'t be send!');

            }

            return api_success1('Account created! Please verify your email address by clicking on the link in the email that we sent you.');
        }
        return api_error();
    }

    public function resend_email_token (Request $request)
    {
        $user = User::where('email', $request->email)->first();
        Mail::to($user->email)->send(new UserRegisterMail($user));
        if (count(Mail::failures()) > 0) return api_error('Register email couldn\'t be send!');

        return api_success1('We have sent you an email with the verify link. Kindly click on that and proceed!');
    }

    public function verify_email (Request $request, $token)
    {
        $data = array();
        $data['success'] = '';
        $data['error'] = 'Invalid Token';
        $user = User::where('email_verification_code', $token)->first();
        if ($user) {
            $user->email_verification_code = 0;
            $user->removeFlag(User::FLAG_EMAIL_VERIFIED);
            $user->addFlag(User::FLAG_EMAIL_VERIFIED);

            if (!$user->save()) {
                $data['success'] = '';
                $data['error'] = 'There is some error!';
                return view('verify-email', $data);

            }
            request()->user = $user;
            $login_attempt = new LoginAttempt;
            $login_attempt->user_id = $user->user_id;
            $login_attempt->access_token = generate_token($user);
            $login_attempt->access_expiry = date("Y-m-d H:i:s", strtotime("1 year"));

            if (!$login_attempt->save()) {
                $data['success'] = '';
                $data['error'] = 'There is some error!';
                return view('verify-email', $data);

            }
            session(['usertoken'=> $login_attempt->access_token]);
           $response = create_call_pay_user($user);

            if (isset($response->id) && !empty($response->id)) {
                $user_info = User::where('user_id', $user->user_id)->first();
                $user_info->call_pay_user_id = $response->id;
                $user_info->call_pay_response = json_encode($response);
                $user_info->save();

            }

            $beneficiar = new Beneficiar;
            $beneficiar->beneficiary_id = $user->user_id;
            $beneficiar->user_id = $user->user_id;
            $beneficiar->email = $user->email;
            $beneficiar->name = $user->first_name;
            $beneficiar->surname = $user->last_name;

            if($beneficiar->save()) {
                $name = $beneficiar->name.' '.$beneficiar->surname;
                $result = sub_accounts($name, $beneficiar->beneficiary_id);

                if (isset($result->id) && !empty($result->id) ) {
                   admin_create_notification(false, '', false, '', true, $beneficiar->beneficiary_id, 'A user has registered in our platform', 'A user named '.$name.' has signup in platform. Click to update his Valr Payment Reference ID');
                    $beneficiar->valr_account_id = $result->id;
                    $beneficiar->save();
                    Mail::to($user->email)->send(new VerificationSuccessfull($user));
                    if (count(Mail::failures()) > 0) return redirect(route('UserDashboard'))->with(['req_error' => 'Login email couldn\'t send!']);
        
                    return redirect(route('UserDashboard'))->with(['req_success' => 'Welcome to your dashboard!']);

                } else {
                    Beneficiar::where('beneficiary_id', $beneficiar->beneficiary_id)->delete();
                    return redirect(route('UserDashboard'))->with(['req_error' => 'Account can not be created on VALR! There is some error, try again.']);

                }
            } else {
                return redirect(route('UserDashboard'))->with(['req_error' => 'There is some error!']);

            }
            return redirect(route('UserDashboard'))->with(['req_success' => 'Email successfully verified! Welcome to your dashboard.']);
        }
        return view('verify-email', $data);
    }

    public function verify_email_for_forget_password (Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->reset_password_token = (String) Str::uuid();
            if ($user->save()) {
                Mail::to($user->email)->send(new ResetPasswordLinkMail($user));
                if (count(Mail::failures()) > 0) return redirect(route('ForgetPassword'))->with(['req_error' => 'Login email couldn\'t send!']);

                return redirect(route('ForgetPassword'))->with(['req_success' => 'We have sent you a link on to your email address. Kindly open it and change your password!','send_email' => 1]);
            }
        }
        return redirect(route('ForgetPassword'))->with(['req_error' => 'Invalid email!']);
    }

    public function reset_password (Request $request, $token)
    {
        $user = User::where('reset_password_token', $token)->first();
        if ($user) {
            return view('reset-password', ['token' => $token]);
        }
        return redirect(route('Index'))->with(['req_error' => 'Invalid reset password token!']);
    }

    public function update_password (Request $request, $token)
    {
        $request->validate([
            'password' => 'bail|required',
            'confirm_password' => 'bail|required|same:password',

        ]);

         $user = User::where('reset_password_token', $token)->first();
        if ($user) {
            $user->reset_password_token = NULL;
            $user->password = Hash::make($request->password);
            if ($user->save()) {
                Mail::to($user->email)->send(new ForgotPasswordConfirmEmail($user));
                if (count(Mail::failures()) > 0) return redirect(route('SignIn'))->with(['req_error' => 'Login email couldn\'t send!']);
                return redirect(route('SignIn'))->with(['req_success' => 'Your password has been updated successfully! You can now log into your profile again!']);
            }
        }else {
            return redirect(route('Index'))->with(['req_error' => 'There is some error!']);
        }
        
    }

    public function logout(Request $request){
        if ($request->login_attempt) {
			$request->login_attempt->access_expiry = date("Y-m-d H:i:s");
			$request->login_attempt->save();
		}
        return redirect(route('Index'))->with(['req_success' => "Logout Successfull!"]);
    }

    public function get_address(Request $request)
    {
       
        $url = 'https://maps.googleapis.com/maps/api/place/autocomplete/json?key=AIzaSyA89-etKIfiHgLKrSEuwCBTGKimI6a-_aQ&libraries=(places)&input=' . $request->address_key;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$data = array();
		if ($httpcode == 200) {
			$result = json_decode($result);
			foreach ($result->predictions as $key => $value) {
				$data[$key]['place_id'] = $value->place_id;
				$data[$key]['name'] = $value->description;

			}
			return $data;
		}
		return $data;
    }

    public function pay_user (Request $request, $id)
    {
        $platform_fee_gift = Setting::where('keys', 'platform_fee_gift')->first();
        $platform_fee_gift_type = Setting::where('keys', 'platform_fee_gift_type')->first();
        $valr_maker_gifter = Setting::where('keys', 'valr_maker_gifter')->first();
        $valr_maker_gifter_type = Setting::where('keys', 'valr_maker_gifter_type')->first();
        $callpay_handling_fee_gifter = Setting::where('keys', 'callpay_handling_fee_gifter')->first();
        $callpay_handling_fee_gifter_type = Setting::where('keys', 'callpay_handling_fee_gifter_type')->first();
        $callpay_contigency_fee_gifter = Setting::where('keys', 'callpay_contigency_fee_gifter')->first();
        
        $callpay_contigency_fee_gifter_type = Setting::where('keys', 'callpay_contigency_fee_gifter_type')->first();
        $vat_tax_gift = Setting::where('keys', 'vat_tax_gift')->first();
        $vat_tax_gift_type = Setting::where('keys', 'vat_tax_gift_type')->first();

        $curl = curl_init('https://api.valr.com/v1/public/marketsummary');
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.valr.com/v1/public/marketsummary',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        if (!empty($response)) {
            $btc_rate = 0;
            foreach ($response as $key => $value) {
                if ($value->currencyPair == 'BTCZAR') {
                    $btc_rate = $value->lastTradedPrice;
                    break;
                }
            }
            if ($btc_rate > 0) {
                return view('pay-user', ['user_id' => $id, 'btc_rate' => $btc_rate, 'platform_fee_gift' => $platform_fee_gift->values, 'platform_fee_gift_type' => $platform_fee_gift_type->values, 'valr_maker_gifter' => $valr_maker_gifter->values, 'valr_maker_gifter_type' => $valr_maker_gifter_type->values, 'callpay_handling_fee_gifter' => $callpay_handling_fee_gifter->values, 'callpay_handling_fee_gifter_type' => $callpay_handling_fee_gifter_type->values, 'callpay_contigency_fee_gifter' => $callpay_contigency_fee_gifter->values, 'callpay_contigency_fee_gifter_type' => $callpay_contigency_fee_gifter_type->values, 'vat_tax_gift' => $vat_tax_gift->values, 'vat_tax_gift_type' => $vat_tax_gift_type->values]);
            }
        }
        return redirect(route('Index'))->with(['req_error' => 'There is some error!']);
    }

    public function gift_amount (Request $request)
    {
        $amount = $request->gift_amount;
        $platform_fee_gift = Setting::where('keys', 'platform_fee_gift')->first();
        $platform_fee_gift_type = Setting::where('keys', 'platform_fee_gift_type')->first();
        $valr_maker_gifter = Setting::where('keys', 'valr_maker_gifter')->first();
        $valr_maker_gifter_type = Setting::where('keys', 'valr_maker_gifter_type')->first();
        $callpay_handling_fee_gifter = Setting::where('keys', 'callpay_handling_fee_gifter')->first();
        $callpay_handling_fee_gifter_type = Setting::where('keys', 'callpay_handling_fee_gifter_type')->first();
        $callpay_contigency_fee_gifter = Setting::where('keys', 'callpay_contigency_fee_gifter')->first();
        $callpay_contigency_fee_gifter_type = Setting::where('keys', 'callpay_contigency_fee_gifter_type')->first();
        $vat_tax_gift = Setting::where('keys', 'vat_tax_gift')->first();
        $vat_tax_gift_type = Setting::where('keys', 'vat_tax_gift_type')->first();

        $platform_fee_gift = $platform_fee_gift->values;
        $platform_fee_gift_type = $platform_fee_gift_type->values;
        $valr_maker_gifter = $valr_maker_gifter->values;
        $valr_maker_gifter_type = $valr_maker_gifter_type->values;
        $callpay_handling_fee_gifter = $callpay_handling_fee_gifter->values;
        $callpay_handling_fee_gifter_type = $callpay_handling_fee_gifter_type->values;
        $callpay_contigency_fee_gifter = $callpay_contigency_fee_gifter->values;
        $callpay_contigency_fee_gifter_type = $callpay_contigency_fee_gifter_type->values;
        $vat_tax_gift = $vat_tax_gift->values;
        $vat_tax_gift_type = $vat_tax_gift_type->values;

        $platformFeeFinal = '';
        $tptFeeFinal = '';
        $valrMakerFinal = '';
        $vatTaxFinal = '';
        $finalAmount = '';
        $AnotherCallpayHandlingFeeGifter = '';
        $AnotherCallpayContigencyFeeGifter = '';

        $platform_fee_gift = $platform_fee_gift;
        $valr_maker_gifter = $valr_maker_gifter;
        $callpay_handling_fee_gifter = $callpay_handling_fee_gifter;
        $callpay_contigency_fee_gifter = $callpay_contigency_fee_gifter;
        $vat_tax_gift = $vat_tax_gift;

        if ($platform_fee_gift_type == 'percentage') {
            $platformFeeFinal = ($amount/100) * $platform_fee_gift;
            $platformFeeFinal = ($platformFeeFinal + $amount) - $amount;

        } else {
            $platformFeeFinal = $platform_fee_gift;

        }
       // $platformFeeFinal = number_format($platformFeeFinal, 2);

        if ($vat_tax_gift_type == 'percentage') {
            $vatTaxFinal = ($platformFeeFinal/(100 + $vat_tax_gift)) * $vat_tax_gift;
            $vatTaxFinal = ($vatTaxFinal + $platformFeeFinal) - $platformFeeFinal;

        } else {
            $vatTaxFinal = $vat_tax_gift;

        }
       // $vatTaxFinal = number_format($vatTaxFinal, 2);

        if ($valr_maker_gifter_type == 'percentage') {
            $valrMakerFinal = $valr_maker_gifter;
            $AnotherValrMaker = ($valrMakerFinal * $amount);

        } else {
            $valrMakerFinal = $valr_maker_gifter;
            $AnotherValrMaker = ($valr_maker_gifter + $amount);

        }
       // $AnotherValrMaker = number_format($AnotherValrMaker, 2);
        $threeFeesesCombined = ($platformFeeFinal);
        $finalAmount = $threeFeesesCombined + $amount + $AnotherValrMaker;
        $valrTakerPlatformFee = $AnotherValrMaker + $platformFeeFinal;

        if ($callpay_handling_fee_gifter_type == 'percentage') {
            $AnotherCallpayHandlingFeeGifter = ($finalAmount/100) * $callpay_handling_fee_gifter;
            $AnotherCallpayHandlingFeeGifter = ($AnotherCallpayHandlingFeeGifter + $finalAmount) - $finalAmount;

        } else {
            $AnotherCallpayHandlingFeeGifter = $callpay_handling_fee_gifter;

        }
      //  $AnotherCallpayHandlingFeeGifter = number_format($AnotherCallpayHandlingFeeGifter, 2);

        $finalAmount += $AnotherCallpayHandlingFeeGifter;

        if ($callpay_contigency_fee_gifter_type == 'percentage') {
            $AnotherCallpayContigencyFeeGifter = ($valrTakerPlatformFee*$callpay_contigency_fee_gifter)/100;

        } else {
            $AnotherCallpayContigencyFeeGifter = $callpay_contigency_fee_gifter;

        }
       // $AnotherCallpayContigencyFeeGifter = number_format($AnotherCallpayContigencyFeeGifter, 2);
        $finalAmount += $AnotherCallpayContigencyFeeGifter;
      //  $finalAmount = number_format($finalAmount, 2);

        $benef = Beneficiar::where('beneficiary_id', $request->user_id)->first();
        $curl_post_data['amount'] = $finalAmount;
        $curl_post_data['merchant_reference'] = $benef->valr_account_id;
        $curl_post_data['return_url'] = route('StoreTransactionGuest', [$benef->beneficiary_id, $request->gift_amount]);
        $curl_post_data['payment_success_url'] = route('StoreTransactionGuest', [$benef->beneficiary_id, $request->gift_amount]);
        $curl_post_data['success_url'] = route('StoreTransactionGuest', [$benef->beneficiary_id, $request->gift_amount]);
        $curl_post_data['error_url'] = route('StoreTransactionGuest', [$benef->beneficiary_id, $request->gift_amount]);
        $curl_post_data['notify_url'] = route('StoreTransactionGuest', [$benef->beneficiary_id, $request->gift_amount]);
        
        $service_url = 'https://services.callpay.com/api/v1/payment-key';
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, "CryptoGiftingSandboxAdmin:eRxg6Q8zXGg2AayY");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$curl_response = curl_exec($curl);
		$response = json_decode($curl_response);
		curl_close($curl);

        if ($response->key) {
            return api_success('payment key data', ['payment_key' => $response->key]);

        }
        return api_error('payment key Error');
    }

    public function gift_amount_dashboard (Request $request)
    {
        $event = Event::where('event_id', $request->event_id)->with(['event_beneficiar'])->first();

        $amount = $request->gift_amount;
        $platform_fee_gift = Setting::where('keys', 'platform_fee_gift')->first();
        $platform_fee_gift_type = Setting::where('keys', 'platform_fee_gift_type')->first();
        $valr_maker_gifter = Setting::where('keys', 'valr_maker_gifter')->first();
        $valr_maker_gifter_type = Setting::where('keys', 'valr_maker_gifter_type')->first();
        $callpay_handling_fee_gifter = Setting::where('keys', 'callpay_handling_fee_gifter')->first();
        $callpay_handling_fee_gifter_type = Setting::where('keys', 'callpay_handling_fee_gifter_type')->first();
        $callpay_contigency_fee_gifter = Setting::where('keys', 'callpay_contigency_fee_gifter')->first();
        $callpay_contigency_fee_gifter_type = Setting::where('keys', 'callpay_contigency_fee_gifter_type')->first();
        $vat_tax_gift = Setting::where('keys', 'vat_tax_gift')->first();
        $vat_tax_gift_type = Setting::where('keys', 'vat_tax_gift_type')->first();

        $platform_fee_gift = $platform_fee_gift->values;
        $platform_fee_gift_type = $platform_fee_gift_type->values;
        $valr_maker_gifter = $valr_maker_gifter->values;
        $valr_maker_gifter_type = $valr_maker_gifter_type->values;
        $callpay_handling_fee_gifter = $callpay_handling_fee_gifter->values;
        $callpay_handling_fee_gifter_type = $callpay_handling_fee_gifter_type->values;
        $callpay_contigency_fee_gifter = $callpay_contigency_fee_gifter->values;
        $callpay_contigency_fee_gifter_type = $callpay_contigency_fee_gifter_type->values;
        $vat_tax_gift = $vat_tax_gift->values;
        $vat_tax_gift_type = $vat_tax_gift_type->values;

        $platformFeeFinal = '';
        $tptFeeFinal = '';
        $valrMakerFinal = '';
        $vatTaxFinal = '';
        $finalAmount = '';
        $AnotherCallpayHandlingFeeGifter = '';
        $AnotherCallpayContigencyFeeGifter = '';

        $platform_fee_gift = $platform_fee_gift;
        $valr_maker_gifter = $valr_maker_gifter;
        $callpay_handling_fee_gifter = $callpay_handling_fee_gifter;
        $callpay_contigency_fee_gifter = $callpay_contigency_fee_gifter;
        $vat_tax_gift = $vat_tax_gift;

        if ($platform_fee_gift_type == 'percentage') {
            $platformFeeFinal = ($amount/100) * $platform_fee_gift;
            $platformFeeFinal = ($platformFeeFinal + $amount) - $amount;

        } else {
            $platformFeeFinal = $platform_fee_gift;

        }
        $platformFeeFinal = $platformFeeFinal;

        if ($vat_tax_gift_type == 'percentage') {
            $vatTaxFinal = ($platformFeeFinal/100) * $vat_tax_gift;
            $vatTaxFinal = ($vatTaxFinal + $platformFeeFinal) - $platformFeeFinal;

        } else {
            $vatTaxFinal = $vat_tax_gift;

        }
        $vatTaxFinal = $vatTaxFinal;

        if ($valr_maker_gifter_type == 'percentage') {
            $valrMakerFinal = $valr_maker_gifter;
            $AnotherValrMaker = ($valrMakerFinal * $amount);

        } else {
            $valrMakerFinal = $valr_maker_gifter;
            $AnotherValrMaker = ($valr_maker_gifter + $amount);

        }
        $AnotherValrMaker = $AnotherValrMaker;
        $threeFeesesCombined = ($platformFeeFinal);
        $finalAmount = $threeFeesesCombined + $amount + $AnotherValrMaker;
        $valrTakerPlatformFee = $AnotherValrMaker + $platformFeeFinal;

        if ($callpay_handling_fee_gifter_type == 'percentage') {
            $AnotherCallpayHandlingFeeGifter = ($finalAmount/100) * $callpay_handling_fee_gifter;
            $AnotherCallpayHandlingFeeGifter = ($AnotherCallpayHandlingFeeGifter + $finalAmount) - $finalAmount;

        } else {
            $AnotherCallpayHandlingFeeGifter = $callpay_handling_fee_gifter;

        }
        $AnotherCallpayHandlingFeeGifter = $AnotherCallpayHandlingFeeGifter;

        $finalAmount += $AnotherCallpayHandlingFeeGifter;

        if ($callpay_contigency_fee_gifter_type == 'percentage') {
            $AnotherCallpayContigencyFeeGifter = ($valrTakerPlatformFee*$callpay_contigency_fee_gifter)/100;

        } else {
            $AnotherCallpayContigencyFeeGifter = $callpay_contigency_fee_gifter;

        }
        $AnotherCallpayContigencyFeeGifter = $AnotherCallpayContigencyFeeGifter;
        $finalAmount += $AnotherCallpayContigencyFeeGifter;
        $finalAmount = $finalAmount;

        $curl_post_data['amount'] = $finalAmount;
        $curl_post_data['merchant_reference'] = $event->event_beneficiar->valr_account_id;
        $curl_post_data['return_url'] = route('StoreTransaction', [$request->event_id, $request->gift_amount, $request->contact_id]);
        $curl_post_data['payment_success_url'] = route('StoreTransaction', [$request->event_id, $request->gift_amount, $request->contact_id]);
        $curl_post_data['success_url'] = route('StoreTransaction', [$request->event_id, $request->gift_amount, $request->contact_id]);
        $curl_post_data['error_url'] = route('StoreTransaction', [$request->event_id, $request->gift_amount, $request->contact_id]);
        $curl_post_data['notify_url'] = route('StoreTransaction', [$request->event_id, $request->gift_amount, $request->contact_id]);
        
        $service_url = 'https://services.callpay.com/api/v1/payment-key';
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, "CryptoGiftingSandboxAdmin:eRxg6Q8zXGg2AayY");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$curl_response = curl_exec($curl);
		$response = json_decode($curl_response);
		curl_close($curl);
        if ($response->key) {
            return api_success('payment key data', ['payment_key' => $response->key]);

        }
        return api_error('payment key Error');
    }

    public function thank_you_for_gift (Request $request)
    {
       return view('thank-you');
    }

    public function fail_payment (Request $request)
    {
       return view('fail-payment');
    }

    public function register_account_gifter_view (Request $request, $id)
    {
       $user = User::where('user_id', $id)->whereNull('password')->first();
        if ($user) {
            if ($user->gifter_user) {
                return view('update-password', ['user' => $user]);

            } else if (isset(request()->user) && (request()->user->user_id == $user->user_id)) {
                return redirect(route('UserDashboard'))->with(['req_error' => 'You are already logged in!']);

            }
            return redirect(route('SignIn'))->with(['req_success' => 'Kindly login to see your gifts!']);
        }
        return redirect(route('Index'))->with(['req_error' => 'There is some error!']);
    }

    public function register_account_gifter (Request $request, $id)
    {
        $user = User::where('user_id', $id)->whereNull('password')->first();
        if ($user) {
            if ($user->gifter_user) {
                return view('update-password', ['user' => $user]);

            } else if (isset(request()->user) && (request()->user->user_id == $user->user_id)) {
                return redirect(route('UserDashboard'))->with(['req_error' => 'You are already logged in!']);

            }
            return redirect(route('SignIn'))->with(['req_success' => 'Kindly login to see your gifts!']);
        }
        return redirect(route('SignIn'))->with(['req_success' => 'Kindly login to see your gifts!']);
    }

    public function register_account_gifter_add(Request $request, $id)
    {
        $request->validate([
            'password' => 'bail|required',
            'confirm_password' => 'bail|required|same:password'
        ]);

        $user = User::where('user_id', $id)->first();
        $user->password = Hash::make($request->password);
        $user->removeFlag(User::FLAG_EMAIL_VERIFIED);
        $user->removeFlag(User::FLAG_GIFTER_USER);
        $user->addFlag(User::FLAG_EMAIL_VERIFIED);
        $user->addFlag(User::FLAG_ACTIVE);
        $user->addFlag(User::FLAG_CUSTOMER);

        if ($user->save()) {
            request()->user = $user;
            $login_attempt = new LoginAttempt;
            $login_attempt->user_id = $user->user_id;
            $login_attempt->access_token = generate_token($user);
            $login_attempt->access_expiry = date("Y-m-d H:i:s", strtotime("1 year"));

            if (!$login_attempt->save()) {
                return redirect()->back()->with(['req_error' => "There is some error!"]);

            }
            session(['usertoken'=> $login_attempt->access_token]);
            return redirect(route('UserDashboard'))->with(['req_success' => 'Email successfully verified! Welcome to your dashboard.']);
        }
    }
}
