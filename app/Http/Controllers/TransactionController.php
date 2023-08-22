<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Mail\SendGiftEmailRecipient;
use App\Mail\SendGiftEmailSender;

use App\Models\User;
use App\Models\GifterEvent;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\Beneficiar;
use App\Models\Setting;
use App\Models\UserWallet;
use App\Models\EventAcceptance;
use App\Models\VarlTransaction;
use DateTime;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user_id = request()->user->user_id;

        $data['beneficiars'] = Beneficiar::where('user_id', $user_id)->select('beneficiary_id', 'name', 'surname')->get();
        $data['events_list'] = Event::select('event_id', 'name')->where('creator_id', $user_id)->whereRaw('`flags` & ? != ? ', [Event::FLAG_CANCELLED, Event::FLAG_CANCELLED])->whereRaw('`flags` & ? != ? ', [Event::FLAG_UNPUBLISHED, Event::FLAG_UNPUBLISHED])->orderBy('event_date', 'desc')->take(10)->get();

        //$data['topups'] = [];//Transaction::where('user_id', $user_id)->where('type', 'add')->paginate(20);
        //$data['withdraws'] = Transaction::where('user_id', $user_id)->where('type', 'withdraw')->paginate(20);
        return view('user-dashboard.reports.history', $data);
    }

    public function etherium_wallet ()
    {
        $data['transactions'] = Transaction::where('user_id', request()->user->user_id)->where('currency', 'etherium')->paginate(20);
        return view('user-dashboard.wallets.etherium-wallet', $data);
    }

    public function bitcoin_wallet ()
    {
        $data['transactions'] = Transaction::where('user_id', request()->user->user_id)->where('currency', 'bitcoin')->paginate(20);
        return view('user-dashboard.wallets.bitcoin-wallet', $data);
    }

    public function zar_wallet ()
    {
        $data['transactions'] = Transaction::where('user_id', request()->user->user_id)->where('currency', 'zar')->paginate(20);
        return view('user-dashboard.wallets.zar-wallet', $data);
    }

    public function withdraw_bank_account_view(Request $request, $id)
    {
        $data = array();
        $data['benefs'] = Beneficiar::where('user_id', request()->user->user_id)->get();
        $data['sid'] = $id;
        return view('user-dashboard.wallets.withdraw-bank-account', $data);
    }

    public function bitcoin_withdraw_bank_account_view()
    {
        return view('user-dashboard.wallets.bitcoin-withdraw-bank-account');
    }

    public function etherium_withdraw_bank_account_view()
    {
        return view('user-dashboard.wallets.etherium-withdraw-bank-account');
    }
    
    public function etherium_wallet_yield_view()
    {
        return view('user-dashboard.wallets.etherium-wallet-yield');
    }

    public function saving_wallet_terms_view_etherium()
    {
        return view('user-dashboard.wallets.saving-wallet-terms-etherium');
    }

    public function create_etherium_wallet_view()
    {
        return view('user-dashboard.wallets.create-etherium-wallet');
    }

    public function ready_etherium_wallet_view ()
    {
        return view('user-dashboard.wallets.ready-etherium-wallet');
    }

    public function etherium_transfer_in_view ()
    {
        return view('user-dashboard.wallets.etherium-transfer-in');
    }

    public function etherium_transfer_out_view ()
    {
        return view('user-dashboard.wallets.etherium-transfer-out');
    }

    public function bitcoin_wallet_yield_view()
    {
        return view('user-dashboard.wallets.bitcoin-wallet-yield');
    }

    public function saving_wallet_terms_view_bitcoin()
    {
        return view('user-dashboard.wallets.saving-wallet-terms-bitcoin');
    }

    public function create_bitcoin_wallet_view()
    {
        return view('user-dashboard.wallets.create-bitcoin-wallet');
    }

    public function ready_bitcoin_wallet_view ()
    {
        return view('user-dashboard.wallets.ready-bitcoin-wallet');
    }

    public function bitcoin_transfer_in_view ()
    {
        return view('user-dashboard.wallets.bitcoin-transfer-in');
    }

    public function bitcoin_transfer_out_view ()
    {
        return view('user-dashboard.wallets.bitcoin-transfer-out');
    }

    public function store_email_gift_transaction_guest (Request $request, $gift_id)
    {
        if ($request->has('success') && $request->filled('success') && $request->has('status') && $request->filled('status') && $request->has('transaction_id') && $request->filled('transaction_id')) {
            $service_url = 'https://services.callpay.com/api/v1/gateway-transaction/'.$request->transaction_id;
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, "CryptoGiftingSandboxAdmin:eRxg6Q8zXGg2AayY");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $curl_response = curl_exec($curl);
            $response = json_decode($curl_response);
            curl_close($curl);

            $curl = curl_init('https://api.valr.com/v1/public/marketsummary');
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.valr.com/v1/public/marketsummary',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
            ));
            $btc_response = curl_exec($curl);
            curl_close($curl);
            $btc_response = json_decode($btc_response);

            if (!empty($btc_response)) {
                $btc_rate = 0;
                foreach ($btc_response as $key => $value) {
                    if ($value->currencyPair == 'BTCZAR') {
                        $btc_rate = $value->lastTradedPrice;
                        break;
                    }
                }
            }

            $response_in_array = (array) $response;

            $gift_event = GifterEvent::where('gifter_event_id', $gift_id)->first();
            $data['transaction_response'] = $request->all();
            $data['transaction_details'] = $response_in_array;

            $event_acc = new EventAcceptance;
            $event_acc->event_acceptance_id = (String) Str::uuid();
            $event_acc->gifter_event_id = $gift_id;
            $event_acc->gifter_id = $gift_event->sender_id;
            $event_acc->beneficiary_id = $gift_event->recipient_id;
            $event_acc->amount = $gift_event->gift_zar_amount;
         
            $event_acc->addFlag(EventAcceptance::FLAG_AMOUNT_GIFT);

            if ($event_acc->save()) {
                $amount = $event_acc->amount;
                $transaction = new Transaction;
                $transaction->transaction_id = (String) Str::uuid();
                $transaction->event_acceptance_id = $event_acc->event_acceptance_id;
                $transaction->amount = $response_in_array['amount'];
                $transaction->btc_rate = $btc_rate;
                $transaction->zar_into_btc = number_format($amount / $btc_rate, 10);
                $transaction->currency = $response_in_array['currency'];
                $transaction->response = json_encode($data);

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

                $transaction->cg_platform_fee = $platform_fee_gift;
                $transaction->cg_platform_fee_type = $platform_fee_gift_type;
                $transaction->vat_tax = $vat_tax_gift;
                $transaction->vat_tax_type = $vat_tax_gift_type;
                $transaction->valr_maker = $valr_maker_gifter;
                $transaction->valr_maker_type = $valr_maker_gifter_type;
                $transaction->callpay_handling = $callpay_handling_fee_gifter;
                $transaction->callpay_handling_type = $callpay_handling_fee_gifter_type;
                $transaction->callpay_contigency = $callpay_contigency_fee_gifter;
                $transaction->callpay_contigency_type = $callpay_contigency_fee_gifter_type;

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
                $transaction->cg_platform_fee_share = $platformFeeFinal;


                if ($vat_tax_gift_type == 'percentage') {
                    $vatTaxFinal = ($platformFeeFinal/ (100 + $vat_tax_gift)) * $vat_tax_gift;
                    $vatTaxFinal = ($vatTaxFinal + $platformFeeFinal) - $platformFeeFinal;

                } else {
                    $vatTaxFinal = $vat_tax_gift;

                }
                $transaction->vat_tax_share = $vatTaxFinal;

                if ($valr_maker_gifter_type == 'percentage') {
                    $valrMakerFinal = $valr_maker_gifter;
                    $AnotherValrMaker = ($valrMakerFinal * $amount);

                } else {
                    $valrMakerFinal = $valr_maker_gifter;
                    $AnotherValrMaker = ($valr_maker_gifter + $amount);

                }

                 
                $transaction->valr_maker_share = $AnotherValrMaker;
                
                $event_acc->amount_tax = $amount + number_format($AnotherValrMaker, 2);

                $event_acc->save();
               
                $threeFeesesCombined = ($platformFeeFinal);
                $finalAmount = $threeFeesesCombined + $amount + $AnotherValrMaker;
                $valrTakerPlatformFee = $AnotherValrMaker + $platformFeeFinal;

                if ($callpay_handling_fee_gifter_type == 'percentage') {
                    $AnotherCallpayHandlingFeeGifter = ($finalAmount/100) * $callpay_handling_fee_gifter;
                    $AnotherCallpayHandlingFeeGifter = ($AnotherCallpayHandlingFeeGifter + $finalAmount) - $finalAmount;

                } else {
                    $AnotherCallpayHandlingFeeGifter = $callpay_handling_fee_gifter;

                }
                $transaction->callpay_handling_share = $AnotherCallpayHandlingFeeGifter;

                $finalAmount += $AnotherCallpayHandlingFeeGifter;

                if ($callpay_contigency_fee_gifter_type == 'percentage') {
                    $AnotherCallpayContigencyFeeGifter = ($valrTakerPlatformFee*$callpay_contigency_fee_gifter)/100;

                } else {
                    $AnotherCallpayContigencyFeeGifter = $callpay_contigency_fee_gifter;

                }
                $transaction->callpay_contigency_share = $AnotherCallpayContigencyFeeGifter;
    
                // if ($request->status == 'failed' || $response_in_array['status'] == 'status') {
                if (false) {
                    admin_create_notification(false, '', false, '',  false, '', 'Someone has try to give gift but got failed', 'Someone has try to give gift but got failed transaction on callpay!');
                    $transaction->addFlag(Transaction::FLAG_FAIL);
                    $transaction->save();
                    return redirect(route('FailPayment'))->with(['req_error' => $request->reason]);
    
                } else {
                    admin_create_notification(false, '', false, '',  false, '', 'Someone has give gift', 'Someone has try to give gift and get successfull status on callpay!');
                    $transaction->addFlag(Transaction::FLAG_SUCCESS);
                    $transaction->save();
                    $event_acceptance = EventAcceptance::where('event_acceptance_id', $event_acc->event_acceptance_id)->first();
                    $event_acceptance->addFlag(EventAcceptance::FLAG_PAID);
                    $event_acceptance->save();

                    $gift_event->removeFlag(GifterEvent::FLAG_ACTIVE);
                    $gift_event->addFlag(GifterEvent::FLAG_ACTIVE);
                    $gift_event->save();

                    $sender = User::where('user_id', $gift_event->sender_id)->first();
                    $recipient = User::where('user_id', $gift_event->recipient_id)->first();

                    Mail::to($sender->email)->send(new SendGiftEmailSender($gift_event));
                    if (count(Mail::failures()) > 0) return redirect()->back()->with(['req_error' => 'Gift email is not send!']);
                    
                    Mail::to($recipient->email)->send(new SendGiftEmailRecipient($gift_event));
                    if (count(Mail::failures()) > 0) return redirect()->back()->with(['req_error' => 'Gift email is not send!']);

                    $event = GifterEvent::where('gifter_event_id', $gift_event->gifter_event_id)->with(['event_theme'])->first();
                    return redirect(route("previewGiftEventId", ["event_id" => $event->gifter_event_id]))->with("req_success","Your Gift Has Ready");
                }
            }
        } else {
            return redirect(route('FailPayment'))->with(['req_error' => 'There is some error! We couldn\'t fetch your payment info.']);

        }
        return redirect(route('FailPayment'))->with(['req_error' => 'There is some error!']);
    }

    public function store_transaction_guest (Request $request, $user_id, $amount)
    {
        if ($request->has('success') && $request->filled('success') && $request->has('status') && $request->filled('status') && $request->has('transaction_id') && $request->filled('transaction_id')) {
            $service_url = 'https://services.callpay.com/api/v1/gateway-transaction/'.$request->transaction_id;
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, "CryptoGiftingSandboxAdmin:eRxg6Q8zXGg2AayY");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $curl_response = curl_exec($curl);
            $response = json_decode($curl_response);
            curl_close($curl);
            $response_in_array = (array) $response;

            $curl = curl_init('https://api.valr.com/v1/public/marketsummary');
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.valr.com/v1/public/marketsummary',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
            ));
            $btc_response = curl_exec($curl);
            curl_close($curl);
            $btc_response = json_decode($btc_response);

            if (!empty($btc_response)) {
                $btc_rate = 0;
                foreach ($btc_response as $key => $value) {
                    if ($value->currencyPair == 'BTCZAR') {
                        $btc_rate = $value->lastTradedPrice;
                        break;
                    }
                }
            }

            $data['transaction_response'] = $request->all();
            $data['transaction_details'] = $response_in_array;

            $event_acc = new EventAcceptance;
            $event_acc->event_acceptance_id = (String) Str::uuid();

            if (request()->user) {
                $event_acc->gifter_id = request()->user->user_id;
                $event_acc->addFlag(EventAcceptance::FLAG_GUEST_GIFT);

            }
            $event_acc->beneficiary_id = $user_id;
            $event_acc->amount = $amount;
            $event_acc->addFlag(EventAcceptance::FLAG_AMOUNT_GIFT);

            if ($event_acc->save()) {
                $amount = $event_acc->amount;
                $transaction = new Transaction;
                $transaction->transaction_id = (String) Str::uuid();
                $transaction->event_acceptance_id = $event_acc->event_acceptance_id;
                $transaction->amount = $response_in_array['amount'];
                $transaction->btc_rate = $btc_rate;
                $transaction->zar_into_btc = number_format($amount / $btc_rate, 10);
                $transaction->currency = $response_in_array['currency'];
                $transaction->response = json_encode($data);

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

                $transaction->cg_platform_fee = $platform_fee_gift;
                $transaction->cg_platform_fee_type = $platform_fee_gift_type;
                $transaction->vat_tax = $vat_tax_gift;
                $transaction->vat_tax_type = $vat_tax_gift_type;
                $transaction->valr_maker = $valr_maker_gifter;
                $transaction->valr_maker_type = $valr_maker_gifter_type;
                $transaction->callpay_handling = $callpay_handling_fee_gifter;
                $transaction->callpay_handling_type = $callpay_handling_fee_gifter_type;
                $transaction->callpay_contigency = $callpay_contigency_fee_gifter;
                $transaction->callpay_contigency_type = $callpay_contigency_fee_gifter_type;

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
                $transaction->cg_platform_fee_share = $platformFeeFinal;


                if ($vat_tax_gift_type == 'percentage') {
                    $vatTaxFinal = ($platformFeeFinal/ (100 + $vat_tax_gift)) * $vat_tax_gift;
                    $vatTaxFinal = ($vatTaxFinal + $platformFeeFinal) - $platformFeeFinal;

                } else {
                    $vatTaxFinal = $vat_tax_gift;

                }
                $transaction->vat_tax_share = $vatTaxFinal;

                if ($valr_maker_gifter_type == 'percentage') {
                    $valrMakerFinal = $valr_maker_gifter;
                    $AnotherValrMaker = ($valrMakerFinal * $amount);

                } else {
                    $valrMakerFinal = $valr_maker_gifter;
                    $AnotherValrMaker = ($valr_maker_gifter + $amount);

                }

               // $AnotherValrMaker = number_format($AnotherValrMaker, 2);
                $transaction->valr_maker_share =  $AnotherValrMaker;

                $event_acc->amount_tax = $amount + number_format($AnotherValrMaker, 2);

                $event_acc->save();
                $threeFeesesCombined = ($platformFeeFinal);
                $finalAmount = $threeFeesesCombined + $amount + $AnotherValrMaker;
                $valrTakerPlatformFee = $AnotherValrMaker + $platformFeeFinal;

                if ($callpay_handling_fee_gifter_type == 'percentage') {
                    $AnotherCallpayHandlingFeeGifter = ($finalAmount/100) * $callpay_handling_fee_gifter;
                    $AnotherCallpayHandlingFeeGifter = ($AnotherCallpayHandlingFeeGifter + $finalAmount) - $finalAmount;

                } else {
                    $AnotherCallpayHandlingFeeGifter = $callpay_handling_fee_gifter;

                }
                $transaction->callpay_handling_share = $AnotherCallpayHandlingFeeGifter;

                $finalAmount += $AnotherCallpayHandlingFeeGifter;

                if ($callpay_contigency_fee_gifter_type == 'percentage') {
                    $AnotherCallpayContigencyFeeGifter = ($valrTakerPlatformFee*$callpay_contigency_fee_gifter)/100;

                } else {
                    $AnotherCallpayContigencyFeeGifter = $callpay_contigency_fee_gifter;

                }
                $transaction->callpay_contigency_share = $AnotherCallpayContigencyFeeGifter;

                // if ($request->status == 'failed' || $response_in_array['status'] == 'status') {
                if (false) {
                    admin_create_notification(false, '', false, '',  false, '', 'Someone has try to give gift but got failed', 'Someone has try to give gift but got failed transaction on callpay!');
                    $transaction->addFlag(Transaction::FLAG_FAIL);
                    $transaction->save();
                    return redirect(route('FailPayment'))->with(['req_error' => $request->reason]);
    
                } else {
                    admin_create_notification(false, '', false, '',  false, '', 'Someone has give gift', 'Someone has try to give gift and get successfull status on callpay!');
                    $transaction->addFlag(Transaction::FLAG_SUCCESS);
                    $transaction->save();
                    $event_acceptance = EventAcceptance::where('event_acceptance_id', $event_acc->event_acceptance_id)->first();
                    $event_acceptance->addFlag(EventAcceptance::FLAG_PAID);
                    $event_acceptance->save();
                    return redirect(route('ThankYouAfterPay'))->with(['req_success' => 'Successfully got your gift! Thank you so much.']);
    
                }
            }
        } else {
            return redirect(route('FailPayment'))->with(['req_error' => 'There is some error! We couldn\'t fetch your payment info.']);

        }
        return redirect(route('FailPayment'))->with(['req_error' => 'There is some error!']);
    }

    public function store_transaction (Request $request, $event_id, $amount, $contact_id)
    {
        if ($request->has('success') && $request->filled('success') && $request->has('status') && $request->filled('status') && $request->has('transaction_id') && $request->filled('transaction_id')) {
            $event_info = Event::where('event_id', $event_id)->first();
            $rsvp = session()->get('rsvp');
            $service_url = 'https://services.callpay.com/api/v1/gateway-transaction/'.$request->transaction_id;
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, "CryptoGiftingSandboxAdmin:eRxg6Q8zXGg2AayY");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $curl_response = curl_exec($curl);
            $response = json_decode($curl_response);
            curl_close($curl);

            $curl = curl_init('https://api.valr.com/v1/public/marketsummary');
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.valr.com/v1/public/marketsummary',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
            ));
            $btc_response = curl_exec($curl);
            curl_close($curl);
            $btc_response = json_decode($btc_response);

            if (!empty($btc_response)) {
                $btc_rate = 0;
                foreach ($btc_response as $key => $value) {
                    if ($value->currencyPair == 'BTCZAR') {
                        $btc_rate = $value->lastTradedPrice;
                        break;
                    }
                }
            }

            $response_in_array = (array) $response;
            $data['transaction_response'] = $request->all();
            $data['transaction_details'] = $response_in_array;

            $event_acc = new EventAcceptance;
            $event_acc->event_acceptance_id = (String) Str::uuid();
            $event_acc->event_id = $event_id;
            $event_acc->contact_id = $contact_id;
            $event_acc->beneficiary_id = $event_info->beneficiary_id;
            $event_acc->rsvp = $rsvp;
            $event_acc->amount = $amount;
            $event_acc->name = session()->get('contact_name');

            $event_acc->addFlag(EventAcceptance::FLAG_AMOUNT_GIFT);

            if ($event_acc->save()) {
                session()->forget('rsvp');
                session()->forget('contact_name');

                $amount = $event_acc->amount;
                $transaction = new Transaction;
                $transaction->transaction_id = (String) Str::uuid();
                $transaction->event_acceptance_id = $event_acc->event_acceptance_id;
                $transaction->amount = $response_in_array['amount'];
                $transaction->btc_rate = $btc_rate;
                $transaction->zar_into_btc = number_format($amount / $btc_rate, 10);
                $transaction->currency = $response_in_array['currency'];
                $transaction->response = json_encode($data);

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

                $transaction->cg_platform_fee = $platform_fee_gift;
                $transaction->cg_platform_fee_type = $platform_fee_gift_type;
                $transaction->vat_tax = $vat_tax_gift;
                $transaction->vat_tax_type = $vat_tax_gift_type;
                $transaction->valr_maker = $valr_maker_gifter;
                $transaction->valr_maker_type = $valr_maker_gifter_type;
                $transaction->callpay_handling = $callpay_handling_fee_gifter;
                $transaction->callpay_handling_type = $callpay_handling_fee_gifter_type;
                $transaction->callpay_contigency = $callpay_contigency_fee_gifter;
                $transaction->callpay_contigency_type = $callpay_contigency_fee_gifter_type;

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
                $transaction->cg_platform_fee_share = $platformFeeFinal;


                if ($vat_tax_gift_type == 'percentage') {
                    $vatTaxFinal = ($platformFeeFinal/ (100 + $vat_tax_gift)) * $vat_tax_gift;

                    $vatTaxFinal = ($vatTaxFinal + $platformFeeFinal) - $platformFeeFinal;

                } else {
                    $vatTaxFinal = $vat_tax_gift;

                }
                $transaction->vat_tax_share = $vatTaxFinal;

                if ($valr_maker_gifter_type == 'percentage') {
                    $valrMakerFinal = $valr_maker_gifter;
                    $AnotherValrMaker = ($valrMakerFinal * $amount);

                } else {
                    $valrMakerFinal = $valr_maker_gifter;
                    $AnotherValrMaker = ($valr_maker_gifter + $amount);

                }

                //$AnotherValrMaker = number_format($AnotherValrMaker, 2);
                $transaction->valr_maker_share = $AnotherValrMaker;

                $event_acc->amount_tax = $amount + number_format($AnotherValrMaker, 2);

                $event_acc->save();
                $threeFeesesCombined = ($platformFeeFinal);
                $finalAmount = $threeFeesesCombined + $amount + $AnotherValrMaker;
                $valrTakerPlatformFee = $AnotherValrMaker + $platformFeeFinal;

                if ($callpay_handling_fee_gifter_type == 'percentage') {
                    $AnotherCallpayHandlingFeeGifter = ($finalAmount/100) * $callpay_handling_fee_gifter;
                    $AnotherCallpayHandlingFeeGifter = ($AnotherCallpayHandlingFeeGifter + $finalAmount) - $finalAmount;

                } else {
                    $AnotherCallpayHandlingFeeGifter = $callpay_handling_fee_gifter;

                }
                $transaction->callpay_handling_share = $AnotherCallpayHandlingFeeGifter;

                $finalAmount += $AnotherCallpayHandlingFeeGifter;

                if ($callpay_contigency_fee_gifter_type == 'percentage') {
                    $AnotherCallpayContigencyFeeGifter = ($valrTakerPlatformFee*$callpay_contigency_fee_gifter)/100;

                } else {
                    $AnotherCallpayContigencyFeeGifter = $callpay_contigency_fee_gifter;

                }
                $transaction->callpay_contigency_share = $AnotherCallpayContigencyFeeGifter;

                // if ($request->status == 'failed' || $response_in_array['status'] == 'status') {
                if (false) {
                    admin_create_notification(false, '', false, '',  false, '', 'Someone has try to give gift but got failed', 'Someone has try to give gift but got failed transaction on callpay!');
                    $transaction->addFlag(Transaction::FLAG_FAIL);
                    $transaction->save();
                    return redirect(route('ThankYouViewContact'))->with(['req_error' => $request->reason]);

                } else {
                    admin_create_notification(false, '', false, '',  false, '', 'Someone has give gift', 'Someone has try to give gift and get successfull status on callpay!');
                    $transaction->addFlag(Transaction::FLAG_SUCCESS);
                    $transaction->save();
                    $event_acceptance = EventAcceptance::where('event_acceptance_id', $event_acc->event_acceptance_id)->first();
                    $event_acceptance->addFlag(EventAcceptance::FLAG_PAID);
                    $event_acceptance->save();
                    return redirect(route('ThankYouViewContact', [$event_acceptance->event_acceptance_id]))->with(['req_success' => 'Successfully got your gift! Thank you so much.']);
                }
            }
        } else {
            return redirect(route('FailPayment'))->with(['req_error' => 'There is some error! We couldn\'t fetch your payment info.']);

        }
    }

    public function transaction_history()
    {
        date_default_timezone_set('UTC');
        $date = date('Y-m-d');
       $time = date('H:i:s');
       
       $log = print_r('-----------------------------------------------------------------------------------------------------------------', true)."\n VALR CRON JOB HIT (GIFTING):\n".PHP_EOL;
       
       file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

       $end_time = $date.'T'.$time.'.000Z';
      
        
        $settings = Setting::where('keys','cron_start_time')->first();
        
        $cron_start_date = $settings->values;

     
     

        $log =  print_r('-Cron Job Timestamp: '.$date.' '.$time, true).PHP_EOL;
        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

        $log =  print_r('-Cron Job Start Time: '.$cron_start_date, true).PHP_EOL;
        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

        $log =  print_r('-Cron Job End Time: '.$end_time, true).PHP_EOL;
        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

      
       return  $all_today_gifts = EventAcceptance::whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_SENT_TO_EXCHANGE, EventAcceptance::FLAG_SENT_TO_EXCHANGE])->whereRaw('`flags` & ?!=?', [EventAcceptance::FLAG_COMPLETE_TRANSACTION, EventAcceptance::FLAG_COMPLETE_TRANSACTION])->pluck('beneficiary_id')->toArray();

        if (!empty($all_today_gifts)) {
            $all_today_gifts = array_unique($all_today_gifts);
            $all_beneficiaries = Beneficiar::whereIn("beneficiary_id", $all_today_gifts)->where('valr_account_id', '!=', NULL)->pluck('valr_account_id')->toArray();
            if (!empty($all_beneficiaries)) {

                $startTime = $cron_start_date;
                $endTime = $end_time;
    
                
               
                $apiKey = "f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01";
                $apiSecret = "71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802";
                $url = "https://api.valr.com/v1/account/transactionhistory?startTime=".$startTime."&endTime=".$endTime."&transactionTypes=FIAT_DEPOSIT,INTERNAL_TRANSFER&limit=199";
                $results = array();
                foreach ($all_beneficiaries as $key => $value) {
                    $timestamp = time() * 1000;
                    $sig =  $this->generateSignatureBenef($apiSecret, 'GET', $url, $timestamp, $value);
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
                        'X-VALR-TIMESTAMP: '.$timestamp,
                        'X-VALR-SUB-ACCOUNT-ID: '.$value,
                        ),
                    ));
                    $response = curl_exec($curl);
                    curl_close($curl);
                    $cron_response = json_decode($response);
                    if (!empty($cron_response)) {
                        $results[$value][] = $cron_response;

                    }
                    sleep(5);
                }
                
               // return $results;
                //if ($settings->values == "1") $settings->values = "2"; else $settings->values = "1";
                if($settings->values) $settings->values = $endTime;
                 // $settings->save();
                 $cron_job = $this->store_transactions($results, $startTime,$endTime);
                 
                 //return $cron_job;
                 
                if($cron_job){
                    $settings->save();
                }
            }
        }
        return '1';
    }

    public function store_transactions ($records, $startTime, $endTime)
    {
      
        date_default_timezone_set('UTC');
        $date = date('Y-m-d');
        $time = date('H:i:s');

        $counter = 0;
        $event_acceptance_id = '';
        if (!file_exists(storage_path("app/public/cron-job-logs/LogFile")))
            mkdir(storage_path("app/public/cron-job-logs/LogFile"), 0777, true);
        ini_set('max_execution_time', 600000000); //10 minutes

        //date_default_timezone_set('Africa/Johannesburg');
        $apiKey = "f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01";
        $apiSecret = "71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802";
        foreach ($records as $key => $value) {
            $valr_account_id = $key;
            $benef = Beneficiar::where('valr_account_id', $valr_account_id)->first();
            
         
                    
          //  print_r($benef);
            
            if ($benef) {
                  
                 
                            
                    $user = User::where('user_id', $benef->user_id)->first();
                    
                     $log =  print_r('-User Found:  '.$user->first_name.' '.$user->last_name, true).PHP_EOL;
                     file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                            
                    $log =  print_r('-Beneficiary Found: '.$benef->name.' '.$benef->surname, true).PHP_EOL;
                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    
                       
                     $log =  print_r('-Beneficiary ID Found: '.$benef->beneficiary_id, true).PHP_EOL;
                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                            
                    $log =  print_r('-Beneficiary VARL Sub-Account Found:  '.$benef->valr_account_name, true).PHP_EOL;
                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                   
                    
                $transactions = $value[0];
                $total_amount = 0;
                foreach ($transactions as $valr_key => $valr_value) {
                    if (!isset($valr_value->creditCurrency) || $valr_value->creditCurrency != "ZAR") {
                        continue;

                    }
                    
                     $found = EventAcceptance::where('beneficiary_id', $benef->beneficiary_id)->where('amount_tax', $valr_value->creditValue)->where('valr_trans_id', '=', NULL)->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_SENT_TO_EXCHANGE, EventAcceptance::FLAG_SENT_TO_EXCHANGE])->whereRaw('`flags` & ?!=?', [EventAcceptance::FLAG_COMPLETE_TRANSACTION, EventAcceptance::FLAG_COMPLETE_TRANSACTION])->orderBy('id', 'desc')->first();
                    if ($found) {
                        $total_amount += $valr_value->creditValue;
                        
                    }
                }
                
                if ($total_amount >= 10) {
                    
                
                    $log =  print_r('-Gift Amount Transaction Total: '.$total_amount, true).PHP_EOL;
                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    settype($total_amount, "string");
                    
                  

                        //Place Order
                        $url = "https://api.valr.com/v1/simple/btczar/order";
                        $timestamp = time() * 1000;
                        $body = array (
                            "payInCurrency" => "ZAR",
                            "payAmount" => $total_amount,
                            "side" => "BUY"

                        );
                        $sig =  $this->generateSignatureBenef($apiSecret, 'POST', $url, $timestamp, $benef->valr_account_id, $body);
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_POSTFIELDS => json_encode($body),
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_HTTPHEADER => array (
                                'X-VALR-API-KEY: '.$apiKey,
                                'X-VALR-SIGNATURE: '.$sig,
                                'X-VALR-TIMESTAMP: '.$timestamp,
                                'X-VALR-SUB-ACCOUNT-ID: '.$benef->valr_account_id
                            ),
                        ));
                        $order_response = curl_exec($curl);
                        $order_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                        curl_close($curl);
                        sleep(15);

                        if ($order_response_code == '202') {
                            
                            $order_response = json_decode($order_response);
                            $order_id = $order_response->id;

                            $log =  print_r('-Order ID Submitted: '.$order_response->id, true).PHP_EOL;
                            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                            // Get ORDER Details
                            $url = "https://api.valr.com/v1/simple/BTCZAR/order/".$order_id;
                            $timestamp = time() * 1000;
                            $sig =  $this->generateSignatureBenef($apiSecret, 'GET', $url, $timestamp, $benef->valr_account_id);
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
                                    'X-VALR-TIMESTAMP: '.$timestamp,
                                    'X-VALR-SUB-ACCOUNT-ID: '.$benef->valr_account_id
                                )
                            ));
                            $again_order_response = curl_exec($curl);
                            $again_order_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                            curl_close($curl);
                            sleep(5);
                            if ($again_order_response_code == '200') {
                                $found_order = json_decode($again_order_response);
                               
                                $log =  print_r('-Order Detail Found', true).PHP_EOL;
                                file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                
                                $json = json_encode ( $found_order, JSON_PRETTY_PRINT );

                                $log =  print_r('-Order Details:'.$json , true).PHP_EOL;
                                file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                if ($found_order->success) {

                                       
                                    $log =  print_r('-Order Status: Success', true).PHP_EOL;
                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                                    $log =  print_r('-Gifter Transaction Amount:  '.$found_order->paidAmount, true).PHP_EOL;
                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
    
                                    $log =  print_r('-Beneficiary Received Amount (BTC): '.$found_order->receivedAmount, true).PHP_EOL;
                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                                  
                                   
                                        foreach ($transactions as $valr_key => $valr_value_trans) {
                                            if (!isset($valr_value_trans->creditCurrency) || $valr_value_trans->creditCurrency != "ZAR") continue;

                                            $found_event_acceptance = EventAcceptance::where('beneficiary_id', $benef->beneficiary_id)->where('amount_tax', $valr_value_trans->creditValue)->where('valr_trans_id', '=', NULL)->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_SENT_TO_EXCHANGE, EventAcceptance::FLAG_SENT_TO_EXCHANGE])->whereRaw('`flags` & ?!=?', [EventAcceptance::FLAG_COMPLETE_TRANSACTION, EventAcceptance::FLAG_COMPLETE_TRANSACTION])->orderBy('id', 'desc')->first();
                                            if ($found_event_acceptance) {
                                                $found_event_acceptance->valr_trans_id = $valr_value_trans->id;
                                                $found_event_acceptance->removeFlag(EventAcceptance::FLAG_COMPLETE_TRANSACTION);
                                                $found_event_acceptance->addFlag(EventAcceptance::FLAG_COMPLETE_TRANSACTION);
                                                $found_event_acceptance->save();
                                               
                                            }
                                        }
                                        
                                         $log =  print_r('-Database Transactions Complete', true).PHP_EOL;
                                                file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                      

                                        $amount_in_btc = 0;
                                        $timestamp = time() * 1000;
                                        $url = "https://api.valr.com/v1/account/balances";
                                        $sig =  $this->generateSignatureBenef($apiSecret, 'GET', $url, $timestamp , $benef->valr_account_id);
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
                                                'X-VALR-TIMESTAMP: '.$timestamp,
                                                'X-VALR-SUB-ACCOUNT-ID: '.$benef->valr_account_id
                                            )
                                        ));
                                        $beneficiary_amount_from_valr = curl_exec($curl);
                                        $beneficiary_amount_from_valr_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                                        curl_close($curl);    
                                        sleep(5);
                                        if ($beneficiary_amount_from_valr_code == '200') {
                                           

                                            foreach(json_decode($beneficiary_amount_from_valr) as $b_key => $b_value) {
                                                if ($b_value->currency == 'BTC') {
                                                    $amount_in_btc = $b_value->available;
                                                  
                                                    break;
                                                }
                                            }
                                            $wallet = new UserWallet;
                                            $wallet->user_wallet_id = (String) Str::uuid();
                                            $wallet->user_id = $benef->user_id;
                                            $wallet->beneficiary_id = $benef->beneficiary_id;
                                            $wallet->paid_amount = $found_order->paidAmount;
                                            $wallet->paid_currency = $found_order->paidCurrency;
                                            $wallet->received_amount = $found_order->receivedAmount;
                                            $wallet->received_currency = $found_order->receivedCurrency;
                                            $wallet->fee_amount = $found_order->feeAmount;
                                            $wallet->fee_currency = $found_order->feeCurrency;
                                            $wallet->response = json_encode($found_order);
                                            $wallet->mode = 'add';
                                            $wallet->final_amount = $amount_in_btc;
                                            $wallet->addFlag(UserWallet::FLAG_MOVED_TO_SUBACCOUNT);
                                            $wallet->addFlag(UserWallet::FLAG_COMPLETE);
                                            $wallet->save();
                                            
                                            $log =  print_r('-Updating Beneficiary Wallet Amount (BTC): '.$amount_in_btc, true).PHP_EOL;
                                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                                    

                                            $log =  print_r('-Beneficiary Cron Job Completed ', true).PHP_EOL;
                                            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                                            $log =  print_r('-----------------------------------------------------------------------------------------------------------------', true)."\n".PHP_EOL;
                                            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                         
                                        } else {
                                            $log =  print_r('-Benficiary amount not fetched from valr! Error Code '.$beneficiary_amount_from_valr_code, true).PHP_EOL;
                                            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                        }
                                   
                                } else if ($found_order->processing) {
                                    $log =  print_r('-Order Status: Processing', true).PHP_EOL;
                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                                   
                                    $log =  print_r('-User Paid Amount: '.$found_order->paidAmount, true).PHP_EOL;
                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
    
                                    $log =  print_r('-User Received Amount in BTC : '.$found_order->receivedAmount, true).PHP_EOL;
                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                                    $found_wallet = UserWallet::where('user_id', $benef->user_id)->orderBy('id', 'desc')->first();
                                   
                                    $log =  print_r('-We found the beneficiary wallet', true).PHP_EOL;
                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);


                                    $wallet = new UserWallet;
                                    $user_wallet_id = (String) Str::uuid();
                                    $wallet->user_wallet_id = $user_wallet_id;
                                    $wallet->user_id = $benef->user_id;
                                    $wallet->beneficiary_id = $benef->beneficiary_id;
                                    $wallet->paid_amount = $found_order->paidAmount;
                                    $wallet->paid_currency = $found_order->paidCurrency;
                                    $wallet->received_amount = $found_order->receivedAmount;
                                    $wallet->received_currency = $found_order->receivedCurrency;
                                    $wallet->fee_amount = $found_order->feeAmount;
                                    $wallet->fee_currency = $found_order->feeCurrency;
                                    $wallet->response = json_encode($found_order);
                                    $wallet->mode = 'add';
                                    $wallet->final_amount = 0;

                                    $log =  print_r('-We have update the beneficiary wallet which still in process status', true).PHP_EOL;
                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);


                                    
                                    // if ($found_wallet) {
                                    //     $wallet->final_amount = $found_order->receivedAmount + $found_wallet->final_amount;

                                    // } else {
                                    //     $wallet->final_amount = $found_order->receivedAmount;

                                    // }
                                    $wallet->addFlag(UserWallet::FLAG_IN_PROCESS);
                                    if($wallet->save()){
                                        foreach ($transactions as $valr_key => $valr_value_trans) {
                                            if (!isset($valr_value_trans->creditCurrency) || $valr_value_trans->creditCurrency != "ZAR") {
                                                continue;

                                            }
                                            $found_event_acceptance = EventAcceptance::where('beneficiary_id', $benef->beneficiary_id)->where('amount_tax', $valr_value_trans->creditValue)->where('valr_trans_id', '=', NULL)->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_SENT_TO_EXCHANGE, EventAcceptance::FLAG_SENT_TO_EXCHANGE])->whereRaw('`flags` & ?!=?', [EventAcceptance::FLAG_COMPLETE_TRANSACTION, EventAcceptance::FLAG_COMPLETE_TRANSACTION])->orderBy('id', 'desc')->first();
                                            if ($found_event_acceptance) {
                                                $found_event_acceptance->valr_trans_id = $valr_value_trans->id;
                                                $found_event_acceptance->removeFlag(EventAcceptance::FLAG_COMPLETE_TRANSACTION);
                                                $found_event_acceptance->addFlag(EventAcceptance::FLAG_COMPLETE_TRANSACTION);
                                                $found_event_acceptance->save();
                                            }
                                        }
                                    }
                                    
                                } else {
                                    $log =  print_r('-Order Got Failed!', true).PHP_EOL;
                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                }
                            } else {
                                $log = print_r('-Order Details not Fetched! Error Code'.$again_order_response_code, true).PHP_EOL;
                              
                                file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                            }
                        } else {
                            $log = print_r('-Order got failed! Error Code:'.$order_response_code, true).PHP_EOL;
                          
                            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                        }
                    
                } else {
                    $log = print_r('-Total amount is less then 10', true).PHP_EOL;
                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                }
            } else {
                $log =  print_r('Beneficiary Not Found', true).PHP_EOL;
                file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
            }
            sleep(10);
        }
        return 1;
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

    public function update_orders ()
    {
        date_default_timezone_set('Africa/Johannesburg');
        $apiKey = "f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01";
        $apiSecret = "71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802";
        $user_withdrawals_orders = UserWallet::where('mode', 'add')->whereRaw('`flags` & ?=?', [UserWallet::FLAG_IN_PROCESS, UserWallet::FLAG_IN_PROCESS])->get();
        if ($user_withdrawals_orders) {
            foreach ($user_withdrawals_orders as $order_key => $order_value) {
                $order_obj = json_decode($order_value->response);
                if (empty($order_obj)) {
                    continue;
                }
                $benef = Beneficiar::where('beneficiary_id', $order_value->beneficiary_id)->first();
                $url = "https://api.valr.com/v1/simple/BTCZAR/order/".$order_obj->orderId;
                $timestamp = time() * 1000;
                $sig =  $this->generateSignatureBenef($apiSecret, 'GET', $url, $timestamp, $benef->valr_account_id);
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
                        'X-VALR-TIMESTAMP: '.$timestamp,
                        'X-VALR-SUB-ACCOUNT-ID: '.$benef->valr_account_id
                    )
                ));
                $again_order_response = curl_exec($curl);
                $again_order_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);
                if ($again_order_response_code == '200') {
                    $found_order = json_decode($again_order_response);
                    if ($found_order->success) {
                        $timestamp = time() * 1000;
                        $url = "https://api.valr.com/v1/account/balances";
                        $sig =  $this->generateSignatureBenef($apiSecret, 'GET', $url, $timestamp, $benef->valr_account_id);
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
                                'X-VALR-TIMESTAMP: '.$timestamp,
                                'X-VALR-SUB-ACCOUNT-ID: '.$benef->valr_account_id
                            )
                        ));
                        $beneficiary_amount_from_valr = curl_exec($curl);
                        $beneficiary_amount_from_valr_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                        curl_close($curl);
                        if ($beneficiary_amount_from_valr_code == '200') {
                            $amount_in_btc = 0;
                            foreach(json_decode($beneficiary_amount_from_valr) as $b_key => $b_value) {
                                if ($b_value->currency == 'BTC') {
                                    $amount_in_btc = $b_value->available;
                                    break;
                                }
                            }
                            $wallet = UserWallet::where('user_wallet_id', $order_value->user_wallet_id)->first();
                            $wallet->paid_amount = $found_order->paidAmount;
                            $wallet->paid_currency = $found_order->paidCurrency;
                            $wallet->received_amount = $found_order->receivedAmount;
                            $wallet->received_currency = $found_order->receivedCurrency;
                            $wallet->fee_amount = $found_order->feeAmount;
                            $wallet->fee_currency = $found_order->feeCurrency;
                            $wallet->response = json_encode($found_order);
                            $wallet->final_amount = $amount_in_btc;
                            $wallet->mode = 'add';
                            $wallet->removeFlag(UserWallet::FLAG_MOVED_TO_SUBACCOUNT);
                            $wallet->removeFlag(UserWallet::FLAG_IN_PROCESS);
                            $wallet->removeFlag(UserWallet::FLAG_COMPLETE);
                            $wallet->addFlag(UserWallet::FLAG_COMPLETE);
                            $wallet->addFlag(UserWallet::FLAG_MOVED_TO_SUBACCOUNT);
                            $wallet->save();
                        }
                            
                        
                    }
                }
            }
        }
        return '1';
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
}
