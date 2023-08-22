<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventAcceptance;
use App\Models\Event;
use App\Models\User;
use App\Models\ContactUs;
use App\Models\Beneficiar;
use App\Models\EventGuestGroup;
use App\Models\ContactGuestList;
use App\Models\EventBeneficiar;
use App\Models\Contact;
use App\Models\BankDetail;
use App\Models\SIRecord;
use App\Models\Setting;
use App\Models\UserWallet;
use App\Models\RequestWithdrawal;

class ViewsController extends Controller
{
    public function home ()
    {
        return view('index');
    }

    public function generateSignature($apiSecret, $method, $url, $timestamp, $subAcccount = '',  $body = [])
    {
        $parsedUrl = parse_url($url);
        $uri = $parsedUrl['path'] ?? '';

        if (isset($parsedUrl['query'])) {
            $uri .= '?' . $parsedUrl['query'];
        }

        $data = $timestamp . $method . $uri;
        if (!empty($subAcccount)) {
            $data = $timestamp . $method . $uri . $subAcccount;

        }
        if (!empty($body)) {
            $data .= json_encode($body);

        }
        $hmac = hash_hmac('sha512', $data, $apiSecret);
        return $hmac;
    }


    public function dashboard (Request $request)
    {
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
        }
        $data = array();
        if ($request->has('search') && $request->filled('search')) {
            $benefs = Beneficiar::where('user_id', request()->user->user_id)->where('name', 'LIKE', '%'.$request->search.'%')->orWhere('surname', 'LIKE', '%'.$request->search.'%')->pluck('beneficiary_id')->toArray();

        }else {
            $benefs = Beneficiar::where('user_id', request()->user->user_id)->pluck('beneficiary_id')->toArray();

        }
        $date_array = array();
        $month_array = array();

        for ($i=0; $i<12; $i++) {
            $date_array[$i]['start_date'] = date('Y-m-1', strtotime('-'.$i.' month'));
            $date_array[$i]['end_date'] = date('Y-m-31', strtotime('-'.$i.' month'));
            $month_array[$i] = date('M', strtotime('-'.$i.' month'));

        }
        $all_months = array_reverse($month_array);
        $data['month_data'] = json_encode($all_months);
        $date_array = array_reverse($date_array);

        $events = EventAcceptance::query();
        $events->whereIn('beneficiary_id', $benefs);

        if ($request->has('gift_type') && $request->filled('gift_type')) {
            $gift_type = urldecode($request->gift_type);
            if ($gift_type == 'Create Event') {
                $events->where('event_id', '!=', NULL)->where('gifter_event_id', '=', NULL);
                foreach ($date_array as $key => $value) {
                    $amounts[] = EventAcceptance::whereIn('beneficiary_id', $benefs)->where('event_id', '!=', NULL)->where('gifter_event_id', '=', NULL)->whereBetween('created_at', [$value['start_date'].' 00:00:00', $value['end_date'].' 23:59:59'])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_COMPLETE_TRANSACTION, EventAcceptance::FLAG_COMPLETE_TRANSACTION])->sum('amount');
        
                }
                $data['graph_data'] = json_encode($amounts);

            } else if ($gift_type == 'Email to Email') {
                $events->where('event_id', '=', NULL)->where('gifter_event_id', '!=', NULL);
                foreach ($date_array as $key => $value) {
                    $amounts[] = EventAcceptance::whereIn('beneficiary_id', $benefs)->where('event_id', '=', NULL)->where('gifter_event_id', '!=', NULL)->whereBetween('created_at', [$value['start_date'].' 00:00:00', $value['end_date'].' 23:59:59'])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_COMPLETE_TRANSACTION, EventAcceptance::FLAG_COMPLETE_TRANSACTION])->sum('amount');
        
                }
                $data['graph_data'] = json_encode($amounts);

            } else {
                $events->where('event_id', '=', NULL)->where('gifter_event_id', '=', NULL);
                foreach ($date_array as $key => $value) {
                    $amounts[] = EventAcceptance::whereIn('beneficiary_id', $benefs)->where('event_id', '=', NULL)->where('gifter_event_id', '=', NULL)->whereBetween('created_at', [$value['start_date'].' 00:00:00', $value['end_date'].' 23:59:59'])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_COMPLETE_TRANSACTION, EventAcceptance::FLAG_COMPLETE_TRANSACTION])->sum('amount');
        
                }
                $data['graph_data'] = json_encode($amounts);

            }

        } else {
            foreach ($date_array as $key => $value) {
                $amounts[] = EventAcceptance::whereIn('beneficiary_id', $benefs)->whereBetween('created_at', [$value['start_date'].' 00:00:00', $value['end_date'].' 23:59:59'])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_COMPLETE_TRANSACTION, EventAcceptance::FLAG_COMPLETE_TRANSACTION])->sum('amount');
    
            }
            $data['graph_data'] = json_encode($amounts);
        }

        if ($request->has('month') && $request->filled('month')) {
            $events->where('created_at', 'LIKE', '%'.$request->month.'%');

        }
        $events->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_COMPLETE_TRANSACTION, EventAcceptance::FLAG_COMPLETE_TRANSACTION]);
        $data['zar_sum'] = array_sum($amounts);
        $data['total_gifts'] = EventAcceptance::whereIn('beneficiary_id', $benefs)->whereRaw('`flags` & ? = ? ', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ? = ? ', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_COMPLETE_TRANSACTION, EventAcceptance::FLAG_COMPLETE_TRANSACTION])->count();
        $data['recieved_till_date_zar_sum'] = EventAcceptance::whereIn('beneficiary_id', $benefs)->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_COMPLETE_TRANSACTION, EventAcceptance::FLAG_COMPLETE_TRANSACTION])->sum('amount');
        $data['average_amount_per_gift'] = EventAcceptance::whereIn('beneficiary_id', $benefs)->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_COMPLETE_TRANSACTION, EventAcceptance::FLAG_COMPLETE_TRANSACTION])->average('amount');
        $data['recieved_till_date_btc_sum'] = 0;
        if ($data['recieved_till_date_zar_sum'] > 0) {
            $data['recieved_till_date_btc_sum'] = $data['recieved_till_date_zar_sum'] / $btc_rate;

        }

        //user-wallet  

        $amount_in_btc = 0;
        $amount_in_zar = 0;
        $data['user_wallet_btc'] = 0;
        $data['user_wallet_zar'] = 0;

        $wallet_found = false;
        $wallet_withdrawal_found = false;
        
        $withdrawal_amount_in_btc = 0;
        $withdrawal_amount_in_zar = 0;
            $wallets = UserWallet::where('beneficiary_id', request()->user->user_id)->where('mode','add')->get();
            foreach ($wallets as $wallet) { 
                if ($wallet) {
                    $amount_in_btc += $wallet->final_amount;
                    $amount_in_zar += $wallet->paid_amount;
                    $wallet_found = true;
                }
            }

            $wallet_withdrawals = UserWallet::where('beneficiary_id', request()->user->user_id)->where('mode','withdrawal')->get();
            foreach ($wallet_withdrawals as $wallet_withdrawal) { 
                if ($wallet_withdrawal) {
                    $withdrawal_amount_in_btc += $wallet_withdrawal->final_amount;
                    $withdrawal_amount_in_zar += $wallet_withdrawal->paid_amount;
                    $wallet_withdrawal_found = true;
                }
            }
            
       
        if ($wallet_found) {
              $data['user_wallet_btc'] = $amount_in_btc;
              $data['user_wallet_zar'] = $amount_in_zar;
                    
        }else if($wallet_withdrawal_found) {
            $data['user_wallet_btc'] = $data['user_wallet_btc'] - $withdrawal_amount_in_btc;
            $data['user_wallet_zar'] = $data['user_wallet_zar'] - $withdrawal_amount_in_zar;
        }
        
        //end-user wallet

        

        
       
        $events->orderBy('id', 'desc');
        $events->with(['event_info', 'transaction_details','gift_event_info']);
        $data['event_gifts'] = $events->paginate(20);
        return view('user-dashboard.index', $data);
    }

    public function generateSignatureBenef($apiSecret, $method, $url, $timestamp, $subAcccount = '',  $body = [])
    {
        $parsedUrl = parse_url($url);
        $uri = $parsedUrl['path'] ?? '';

        if (isset($parsedUrl['query'])) {
            $uri .= '?' . $parsedUrl['query'];
        }

        $data = $timestamp . $method . $uri;
        if (!empty($subAcccount)) {
            $data = $timestamp . $method . $uri;

        }
        if (!empty($body)) {
            $data .= json_encode($body);

        }
        $data .= $subAcccount;
        
        $hmac = hash_hmac('sha512', $data, $apiSecret);
        return $hmac;
    }

    public function search_user (Request $request)
    {
        $request->validate([
            'search' => 'bail|required'
        ]);

        $search = $request->search;
        $user_id = request()->user->user_id;
        $events = Event::select('event_id', 'name')->where('creator_id', $user_id)->where('name', 'LIKE', '%'.$search.'%')->orderBy('id', 'DESC')->take(10)->get()->toArray();
        $contacts = Contact::select('contact_id', 'name', 'surname')->where('user_id', $user_id)->where('name', 'LIKE', '%'.$search.'%')->orWhere('surname', 'LIKE', '%'.$search.'%')->orWhere('email', 'LIKE', '%'.$search.'%')->orderBy('id', 'DESC')->take(10)->get()->toArray();

        $beneficiaries = Beneficiar::select('beneficiary_id', 'name', 'surname')->where('user_id', $user_id)->where('name', 'LIKE', '%'.$search.'%')->orWhere('surname', 'LIKE', '%'.$search.'%')->orWhere('email', 'LIKE', '%'.$search.'%')->orderBy('id', 'DESC')->take(10)->get()->toArray();

        $result = array_merge($events, $beneficiaries, $contacts);
        shuffle($result);
        return view('user-dashboard.search', ['search_results' => $result]);

    }

    public function search_admin (Request $request)
    {
        $request->validate([
            'search' => 'bail|required'
        ]);

        $search = $request->search;
        $events = Event::select('event_id', 'name')->where('name', 'LIKE', '%'.$search.'%')->orderBy('id', 'DESC')->take(10)->get()->toArray();
        
        $user = User::select('user_id', 'username', 'first_name', 'last_name')->where('first_name', 'LIKE', '%'.$search.'%')->orWhere('last_name', 'LIKE', '%'.$search.'%')->orWhere('email', 'LIKE', '%'.$search.'%')->orWhere('username', 'LIKE', '%'.$search.'%')->orderBy('id', 'DESC')->take(10)->get()->toArray();


        $contact_us = ContactUs::where('topic', 'LIKE', '%'.$search.'%')->orWhere('subject', 'LIKE', '%'.$search.'%')->orWhere('email', 'LIKE', '%'.$search.'%')->orWhere('description', 'LIKE', '%'.$search.'%')->orderBy('id', 'DESC')->take(10)->get()->toArray();

        $result = array_merge($events, $contact_us, $user);
        shuffle($result);
        return view('admin.search', ['search_results' => $result]);

    }

    public function contact_us (Request $request)
    {
        $data['topics'] = config('credentials.contact_form_topics');
        return view('contact-us', $data);
    }

    public function affiliates ()
    {
        $data['topics'] = config('credentials.contact_form_topics');
        return view('affiliates', $data);
    }

    public function sign_in (Request $request)
    {
        if (request()->user) return redirect(route('Index'))->with(['req_error' => 'You are already logged in!']);
        return view('sign-in');
    }

    public function sign_in_two_factor($id){
       
        $user = User::where("user_id",$id)->first();
        $google2fa_url = "/homasdasdasde";
        $secret_key = "XVQ2UIGO75XRUKJO";

        if($user->loginSecurity()->exists()){
            $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
            $google2fa_url = $google2fa->getQRCodeInline(
                'CryptoGifting',
                $user->email,
                $user->loginSecurity->google2fa_secret
            );
            $secret_key = $user->loginSecurity->google2fa_secret;
        }

        $data = array(
            'user' => $user,
            'secret' => $secret_key,
            'google2fa_url' => $google2fa_url
        );
        return view("sign-in-two-factor",$data);
    }

    public function sign_up (Request $request)
    {
        if (request()->user) return redirect(route('Index'))->with(['req_error' => 'You are already logged in!']);

        return view('sign-up');
    }

    public function terms_of_use ()
    {
        return view('terms-of-use');
    }

    public function help ()
    {
        return view('help');
    }

    public function give_us_feedback ()
    {
        $data['topics'] = config('credentials.contact_form_topics');
        return view('give-us-feedback', $data);
    }

    public function loyalty_program ()
    {
        $data['topics'] = config('credentials.contact_form_topics');
        return view('loyalty-program', $data);
    }
    public function earn_interest ()
    {
        return view('earn-interest');
    }

    public function our_fees ()
    {
        return view('our-fees');
    }

    public function privacy_policy ()
    {
        return view('privacy-policy');
    }

    public function admin_dashboard (Request $request)
    {
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
        }
        $data = array();
        // $benefs = Beneficiar::where('user_id', request()->user->user_id)->pluck('beneficiary_id')->toArray();
        $date_array = array();
        $month_array = array();

        for ($i=0; $i<12; $i++) {
            $date_array[$i]['start_date'] = date('Y-m-1', strtotime('-'.$i.' month'));
            $date_array[$i]['end_date'] = date('Y-m-31', strtotime('-'.$i.' month'));
            $month_array[$i] = date('M', strtotime('-'.$i.' month'));

        }
        $all_months = array_reverse($month_array);
        $data['month_data'] = json_encode($all_months);
        $date_array = array_reverse($date_array);

        $events = EventAcceptance::query();
        // $events->whereIn('beneficiary_id', $benefs);

        if ($request->has('gift_type') && $request->filled('gift_type')) {
            $gift_type = urldecode($request->gift_type);
            if ($gift_type == 'Create Event') {
                $events->where('event_id', '!=', NULL)->where('gifter_event_id', '=', NULL);
                foreach ($date_array as $key => $value) {
                    $amounts[] = EventAcceptance::where('event_id', '!=', NULL)->where('gifter_event_id', '=', NULL)->whereBetween('created_at', [$value['start_date'].' 00:00:00', $value['end_date'].' 23:59:59'])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->sum('amount');
        
                }
                $data['graph_data'] = json_encode($amounts);

            } else if ($gift_type == 'Email to Email') {
                $events->where('event_id', '=', NULL)->where('gifter_event_id', '!=', NULL);
                foreach ($date_array as $key => $value) {
                    $amounts[] = EventAcceptance::where('event_id', '=', NULL)->where('gifter_event_id', '!=', NULL)->whereBetween('created_at', [$value['start_date'].' 00:00:00', $value['end_date'].' 23:59:59'])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->sum('amount');
        
                }
                $data['graph_data'] = json_encode($amounts);

            } else {
                $events->where('event_id', '=', NULL)->where('gifter_event_id', '=', NULL);
                foreach ($date_array as $key => $value) {
                    $amounts[] = EventAcceptance::where('event_id', '=', NULL)->where('gifter_event_id', '=', NULL)->whereBetween('created_at', [$value['start_date'].' 00:00:00', $value['end_date'].' 23:59:59'])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->sum('amount');
        
                }
                $data['graph_data'] = json_encode($amounts);

            }

        } else {
            foreach ($date_array as $key => $value) {
                $amounts[] = EventAcceptance::whereBetween('created_at', [$value['start_date'].' 00:00:00', $value['end_date'].' 23:59:59'])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->sum('amount');
    
            }
            $data['graph_data'] = json_encode($amounts);
        }

        if ($request->has('month') && $request->filled('month')) {
            $events->where('created_at', 'LIKE', '%'.$request->month.'%');

        }
        $events->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID]);
        $data['zar_sum'] = array_sum($amounts);
        $data['total_gifts'] = EventAcceptance::whereRaw('`flags` & ? = ? ', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ? = ? ', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->count();
        $data['recieved_till_date_zar_sum'] = EventAcceptance::whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->sum('amount');
        $data['average_amount_per_gift'] = EventAcceptance::whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->average('amount');
        $data['recieved_till_date_btc_sum'] = 0;
        if ($data['recieved_till_date_zar_sum'] > 0) {
            $data['recieved_till_date_btc_sum'] = $data['recieved_till_date_zar_sum'] / $btc_rate;

        }
        $events->orderBy('id', 'desc');
        $events->with(['event_info', 'transaction_details','gift_event_info']);
        $data['event_gifts'] = $events->paginate(20);
        $data['account_balance_zar'] = 0;
        $data['account_balance_btc'] = 0;
        // return $data;
        date_default_timezone_set('Africa/Johannesburg');
        $apiKey = "f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01";
        $apiSecret = "71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802";
        $url = "https://api.valr.com/v1/account/balances";
        $amount_in_btc = 0;
        $timestamp = time() * 1000;
        $sig =  $this->generateSignature($apiSecret, 'GET', $url, $timestamp);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array (
                'X-VALR-API-KEY: '.$apiKey,
                'X-VALR-SIGNATURE: '.$sig,
                'X-VALR-TIMESTAMP: '.$timestamp
            )
        ));
        $beneficiary_amount_from_valr = curl_exec($curl);
        //$beneficiary_amount_from_valr_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
      
        foreach(json_decode($beneficiary_amount_from_valr) as $amount_main_account) {
            if($amount_main_account->currency == 'ZAR') {
                $data['account_balance_zar'] = $amount_main_account->total;
            }
            if($amount_main_account->currency == 'BTC') {
                $data['account_balance_btc'] = $amount_main_account->total;
            }
        }
       
        return view('admin.index', $data);
    }

    public function wallet ()
    {
        $data = array();
        $cg_withdrawal_fees = Setting::where('keys', 'cg_withdrawal_fees')->first();
        $cg_withdrawal_fees_type = Setting::where('keys', 'cg_withdrawal_fees_type')->first();
        $valr_taker_withdrawal_fees = Setting::where('keys', 'valr_taker_withdrawal_fees')->first();
        $valr_taker_withdrawal_fees_type = Setting::where('keys', 'valr_taker_withdrawal_fees_type')->first();
        $mercantile_withdrawal_fees = Setting::where('keys', 'mercantile_withdrawal_fees')->first();
        $mercantile_withdrawal_fees_type = Setting::where('keys', 'mercantile_withdrawal_fees_type')->first();
        $vat_tax_withdrawal = Setting::where('keys', 'vat_tax_withdrawal')->first();
        $vat_tax_withdrawal_type = Setting::where('keys', 'vat_tax_withdrawal_type')->first();
        $valr_fast_fees = Setting::where('keys', 'valr_fast_fees')->first();
        $valr_normal_fees = Setting::where('keys', 'valr_normal_fees')->first();
        $valr_fast_fees_type = Setting::where('keys', 'valr_fast_fees_type')->first();
        $valr_normal_fees_type = Setting::where('keys', 'valr_normal_fees_type')->first();

        $data['cg_withdrawal_fees'] = $cg_withdrawal_fees->values;
        $data['cg_withdrawal_fees_type'] = $cg_withdrawal_fees_type->values;
        $data['valr_taker_withdrawal_fees'] = $valr_taker_withdrawal_fees->values;
        $data['valr_taker_withdrawal_fees_type'] = $valr_taker_withdrawal_fees_type->values;
        $data['mercantile_withdrawal_fees'] = $mercantile_withdrawal_fees->values;
        $data['mercantile_withdrawal_fees_type'] = $mercantile_withdrawal_fees_type->values;
        $data['vat_tax_withdrawal'] = $vat_tax_withdrawal->values;
        $data['vat_tax_withdrawal_type'] = $vat_tax_withdrawal_type->values;
        $data['valr_fast_fees'] = $valr_fast_fees->values;
        $data['valr_normal_fees'] = $valr_normal_fees->values;
        $data['valr_fast_fees_type'] = $valr_fast_fees_type->values;
        $data['valr_normal_fees_type'] = $valr_normal_fees_type->values;

        $user_id = request()->user->user_id;
        $data['bank_found'] = false;
        $data['bank_details'] = false;
        $data['user_wallet'] = false;
        $data['btc_rate'] = false;
        $data['beneficiaries'] = Beneficiar::where('user_id', $user_id)->get();

        date_default_timezone_set('Africa/Johannesburg');
        $apiKey = "f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01";
        $apiSecret = "71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802";
        $url = "https://api.valr.com/v1/account/balances";

        $all_benefs = Beneficiar::where('user_id', $user_id)->get();
        $amount_in_btc = 0;
        $wallet_found = false;
        foreach ($all_benefs as $key => $value) {
            $wallet = UserWallet::where('user_id', request()->user->user_id)->where('beneficiary_id', $value->beneficiary_id)->orderBy('id', 'desc')->first();
            if ($wallet) {
                $amount_in_btc += $wallet->final_amount;
                $wallet_found = true;
            }
        }

        if ($wallet_found) {
            $data['user_wallet'] = $amount_in_btc;

            $curl = curl_init('https://api.valr.com/v1/public/marketsummary');
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.valr.com/v1/public/marketsummary',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
            ));
            $response = curl_exec($curl);
            $again_order_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            $response = json_decode($response);
            foreach ($response as $res_key => $res_value) {
                if ($res_value->currencyPair == 'BTCZAR') {
                    $data['btc_rate'] = $res_value->lastTradedPrice;
                    break;
                }
            }
        }
        $bank_account = BankDetail::where('user_id', $user_id)->first();
        if (!empty($bank_account) && $bank_account) {
            $data['bank_found'] = true;
            $data['bank_details'] = $bank_account;

        }
        $data['request_withdrawal'] = RequestWithdrawal::where('user_id', $user_id)->whereRaw('`flags` & ?=?', [RequestWithdrawal::FLAG_PROCESS, RequestWithdrawal::FLAG_PROCESS])->orderBy('id', 'DESC')->first();
        return view('user-dashboard.wallet', $data);
    }

    public function create_bank_account () {
        return redirect(route('BankInformation'))->with(['req_error' => 'Add bank account info first!']);
    }

    public function register_first ()
    {
        $route = route('Security');
        return redirect($route.'?model=kyc-model')->with(['req_error' => 'First register yourself with SmileKYC!']);
    }

    public function notifications ()
    {
        return view('user-dashboard.notifications');
    }

    public function profile ()
    {
        return view('user-dashboard.profile.index');
    }

    public function cookies_settings ()
    {
        return view('cookies-policy');
    }

    public function forget_password ()
    {
        return view('forget-password');
    }

    public function security (Request $request)
    {
        $user = request()->user;
        $google2fa_url = "/homasdasdasde";
        $secret_key = "XVQ2UIGO75XRUKJO";

        if($user->loginSecurity()->exists()){
            $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
            $google2fa_url = $google2fa->getQRCodeInline(
                'CryptoGifting',
                $user->email,
                $user->loginSecurity->google2fa_secret
            );
            $secret_key = $user->loginSecurity->google2fa_secret;
        }

        if ($user->loginSecurity()->exists() == true && $user->loginSecurity->google2fa_enable == true) 
            $authentication = true;
        else
            $authentication = false;

        $data = array(
            'user' => $user,
            'secret' => $secret_key,
            'google2fa_url' => $google2fa_url,
            'authentication' => $authentication
        );
        return view('user-dashboard.profile.security',$data);
    }

    public function settings ()
    {
        return view('user-dashboard.profile.settings');
    }

    public function me ()
    {
        return api_success('User Data', ['user' => request()->user]);
    }

    public function bank_information(){
        $data = array();
        $data['bank_found'] = false;
        $data['bank_details'] = '';
        $found = BankDetail::where('user_id', request()->user->user_id)->first();
        if ($found) {
            $data['bank_details'] = $found;
            $data['bank_found'] = true;
        }
        return view('user-dashboard.profile.bank-information', $data);
    }
}
