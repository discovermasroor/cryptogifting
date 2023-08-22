<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\Models\GifterEvent;
use App\Models\EventTheme;
use App\Models\Setting;
use App\Models\User;
use App\Models\Beneficiar;

use App\Mail\SendGiftEmailRecipient;
use App\Mail\SendGiftEmailSender;

class GifterEventController extends Controller
{
    public function index (Request $request)
    {
        $data = array();
        $gifter_event = GifterEvent::query();
        $gifter_event->with(['event_theme', 'event_acceptance']);
        $gifter_event->orderBy('id', 'desc');
        $data['gifter_event'] = $gifter_event->paginate('30');

        return view('admin.reports.get-gift', $data);
    }

    public function get_crypto(Request $request){
        
        session()->put('email', urlencode($request->email));

        if ($request->get_crypto) {
            session()->put('flags', 1); 
            return view('gift-flow.get-crypto.get-crypto');

        } else {
            session()->put('flags', 2); 
            return redirect()->route('Allocate',['email'=> urlencode($request->email)]);
        }
    }

    public function amount_allocation($email) {
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
                return view('gift-flow.amount-allocate',['email' => urldecode($email), 'btc_rate' => $btc_rate]);

            }
        }
        return redirect(route('Index'))->with(['req_error' => 'There is some error!']);
    }
    
    public function gift_card (Request $request)
    {
        $request->validate([
            'gift_zar_amount' => 'bail|required'
        ]);

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
                $result = $request->gift_zar_amount/$btc_rate;
                session()->put('gift_btc_amount', $result);
            }
        }
        session()->put('gift_zar_amount', $request->gift_zar_amount);
        return redirect(route('ChooseThemeForGift'))->with(['req_success' => 'Please choose theme!']);
    }

    public function choose_theme_for_gift ()
    {
        $all_themes = EventTheme::whereRaw('`flags` & ? = ?', [EventTheme::FLAG_ACTIVE , EventTheme::FLAG_ACTIVE])->get();
        return view('gift-flow.gift-cards', ['themes' => $all_themes]);
    }

    public function gift_card_selected(Request $request)
    {
        $request->validate([
            'theme' => 'bail|required|string',

        ]);
        session(['gifter_event_theme'=> $request->theme]);
        return redirect(route('AddGiftDetailsView'))->with(['req_success' => 'Please add details!']);
    }

    public function add_gift_details_view(Request $request)
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

        return view('gift-flow.gift-card-selected', ['platform_fee_gift' => $platform_fee_gift->values, 'platform_fee_gift_type' => $platform_fee_gift_type->values, 'valr_maker_gifter' => $valr_maker_gifter->values, 'valr_maker_gifter_type' => $valr_maker_gifter_type->values, 'callpay_handling_fee_gifter' => $callpay_handling_fee_gifter->values, 'callpay_handling_fee_gifter_type' => $callpay_handling_fee_gifter_type->values, 'callpay_contigency_fee_gifter' => $callpay_contigency_fee_gifter->values, 'callpay_contigency_fee_gifter_type' => $callpay_contigency_fee_gifter_type->values, 'vat_tax_gift' => $vat_tax_gift->values, 'vat_tax_gift_type' => $vat_tax_gift_type->values]);
    }

    public function preview_gift(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sender_name' => 'required|bail|string',
            'sender_email' => 'required|bail|email',
            'recipient_name' => 'required|bail|string',
            'message' => 'required'
        ]);
        if ($validator->fails()) return response()->json(['status' => false, 'error' => [ "message" => "Validation Errors"], 'detail' => $validator->errors()], 422);

        $recipient_email = urldecode(session()->get("email"));
        $sender = $this->user_create($request->sender_email, $request->sender_name);
        $recipient = $this->user_create($recipient_email, $request->recipient_name);

        $flags = session()->get("flags");
        $amount_zar =  session()->get('gift_zar_amount');
        $amount_btc =  session()->get('gift_btc_amount');
        $gifter_event = new GifterEvent();
        $gifter_event->gifter_event_id = Str::uuid();
        $gifter_event->sender_name = $request->sender_name;
        $gifter_event->sender_id = $sender->user_id;
        $gifter_event->recipient_name = $request->recipient_name;
        $gifter_event->recipient_id = $recipient->user_id;
        $gifter_event->gift_zar_amount = $amount_zar;
        $gifter_event->gift_btc_amount = $amount_btc;
        $gifter_event->message = $request->message;
        $gifter_event->theme_id = session()->get('gifter_event_theme');

        if ($flags == 1) {
            $gifter_event->addFlag(GifterEvent::FLAG_GET_CRYPTO);

        } else {
            $gifter_event->addFlag(GifterEvent::FLAG_GIFT_CRYPTO);

        }

        if ($gifter_event->save()) {
            
            session()->forget('gift_zar_amount');
            session()->forget('gifter_event_theme');
            session()->forget('gift_btc_amount');
            $amount = $gifter_event->gift_zar_amount;
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
            //$vatTaxFinal = number_format($vatTaxFinal, 2);
    
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
            //$finalAmount = ($finalAmount, 2);

            $benef = Beneficiar::where('beneficiary_id', $recipient->user_id)->first();
            $curl_post_data['amount'] = $finalAmount;
            $curl_post_data['merchant_reference'] = $benef->valr_account_id;
            $curl_post_data['return_url'] = route('StoreEmailGiftTransaction', [$gifter_event->gifter_event_id]);
            $curl_post_data['payment_success_url'] = route('StoreEmailGiftTransaction', [$gifter_event->gifter_event_id]);
            $curl_post_data['success_url'] = route('StoreEmailGiftTransaction', [$gifter_event->gifter_event_id]);
            $curl_post_data['error_url'] = route('StoreEmailGiftTransaction', [$gifter_event->gifter_event_id]);
            $curl_post_data['notify_url'] = route('StoreEmailGiftTransaction', [$gifter_event->gifter_event_id]);
            
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

            } else {
                return api_error('payment key Error');

            }
        } else {
            return api_error();
        }
    }

    public function gift_preview_event_id ($data)
    {
        $event = GifterEvent::where('gifter_event_id',$data)->with(['event_theme'])->first();
        return view('gift-flow.gifter-preview',array("event"=>$event));
    }

    public function show ($id)
    {
        $gift = GifterEvent::where('gifter_event_id', $id)->with(['event_theme', 'recipient', 'sender', 'event_acceptance.transaction_details'])->first();
        return view('admin.reports.get-gifts-show', ["gift" => $gift]);
    }

    public function user_create ($email, $customer_name) {
        $user = User::where('email', $email)->first();

        if ($user) {
            return $user;

        } else {
            $user = new User();
            $user->user_id = (String) Str::uuid();
            $user->username = explode('@', $email)[0].rand(1000, 9999);
            $user->email = $email;
            $user->addFlag(User::FLAG_GIFTER_USER);
            if ($user->save()) {
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
                $beneficiar->name = $customer_name;
                if($beneficiar->save()) {
                    $result = sub_accounts($customer_name, $beneficiar->beneficiary_id);

                    if (isset($result->id) && !empty($result->id) ) {
                        $beneficiar->valr_account_id = $result->id;
                        $beneficiar->save();
                    }
                }
            }
            return $user;
        }
    }
}
