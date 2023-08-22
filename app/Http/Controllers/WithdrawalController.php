<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Models\BankDetail;
use App\Models\User;
use App\Models\SIRecord;
use App\Models\Withdrawal;
use App\Models\Transaction;
use App\Models\UserWallet;
use App\Models\Setting;
use App\Models\Beneficiar;
use App\Models\EventAcceptance;
use App\Models\RequestWithdrawal;

class WithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $all_withdrawals = Withdrawal::query();

        if ($request->has('start_date') && $request->filled('start_date') && $request->has('end_date') && $request->filled('end_date') ) {
            $all_withdrawals->whereBetween('created_at', [$request->start_date.' 00:00:00', $request->end_date.' 23:59:59']);

        }

        if ($request->has('filter_status') && $request->filled('filter_status')) {
            if ($request->filter_status == 'Yes') {
                $all_withdrawals->whereRaw('`flags` & ?=?', [Withdrawal::FLAG_SENT_TO_CLIENT, Withdrawal::FLAG_SENT_TO_CLIENT]);

            } else {
                $all_withdrawals->whereRaw('`flags` & ?!=?', [Withdrawal::FLAG_SENT_TO_CLIENT, Withdrawal::FLAG_SENT_TO_CLIENT]);

            }
        }

        if ($request->has('export') && $request->filled('export') && $request->export == '1' && $request->has('transactions_list') && $request->filled('transactions_list')) {
            $all_withdrawals->whereIn('withdrawal_id', $request->transactions_list);
            $all_withdrawals->whereRaw('`flags` & ?=?', [Withdrawal::FLAG_COMPLETED, Withdrawal::FLAG_COMPLETED]);
            $all_withdrawals->with(['beneficiar', 'bank_info' => function ($query) {
                $query->withTrashed();
            }]);
            foreach ($all_withdrawals->get() as $gift) {
                $event_acc = Withdrawal::where('withdrawal_id', $gift->withdrawal_id)->first();
                $event_acc->removeFlag(Withdrawal::FLAG_SENT_TO_CLIENT);
                $event_acc->addFlag(Withdrawal::FLAG_SENT_TO_CLIENT);
                $event_acc->save();

            }

            $all_withdrawals->whereRaw('`flags` & ?=?', [Withdrawal::FLAG_SENT_TO_CLIENT, Withdrawal::FLAG_SENT_TO_CLIENT]);

            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=CG-withdrawals-".$request->start_date."_".$request->end_date.".csv",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );
            $callback = function() use($all_withdrawals) {
                $file = fopen('php://output', 'w');

                foreach ($all_withdrawals->get() as $task) {
                    $amount = number_format($task->requested_amount_by_user_in_zar-($task->all_charged_fees_in_zar+$task->valr_taker_share+$task->valr_withdrawal_fees_share), 2);
                    $row['bank_branch_code'] = $task->bank_info->branch_code;
                    $row['bank_account_number'] = $task->bank_info->account_number;
                    $row['amount'] = $amount;
                    $row['valr_name'] = 'CryptoGifting Withdrawal';
                    $row['beneficiary_id'] = $task->beneficiar->beneficiary_id;
                    $row['beneficiary_name'] = get_user_name($task->beneficiar->beneficiary_id);

                    fputcsv($file, array($row['bank_branch_code'], $row['bank_account_number'], $row['amount'], $row['valr_name'], $row['beneficiary_id'], $row['beneficiary_name']));
                }
                fclose($file);
            };
            return response()->stream($callback, 200, $headers);

        } else if ($request->has('transactions_list') && $request->filled('transactions_list') && !empty($request->transactions_list) && $request->has('status') && $request->filled('status') && ($request->status == 'Yes' || $request->status == 'No')) {
            $requested_withdrawals = Withdrawal::whereIn('withdrawal_id', $request->transactions_list)->get();
            foreach ($requested_withdrawals as $gift) {
                $event_acc = Withdrawal::where('withdrawal_id', $gift->withdrawal_id)->first();
                $event_acc->removeFlag(Withdrawal::FLAG_SENT_TO_CLIENT);
                if ($request->status == 'Yes') {
                    $event_acc->addFlag(Withdrawal::FLAG_SENT_TO_CLIENT);

                }
                $event_acc->save();
            }
        }

        $all_withdrawals->orderBy('id', 'desc');
        return view('admin.reports.withdrawals', ['withdrawals' => $all_withdrawals->paginate(20)]);
    }

    public function user_funds_withdrawn_detail(Request $request, $id) {
        $withdrawal = Withdrawal::where('withdrawal_id', $id)->with(['customer', 'user_wallet'])->first();
        $bank_info = BankDetail::where('bank_detail_id', $withdrawal->bank_detail_id)->withTrashed()->first();
        return view('user-dashboard.reports.withdrawal-detail', ['withdrawals' => $withdrawal, 'bank_info' => $bank_info]);
    }

    public function user_funds_withdrawn(Request $request) {
        
        

        $withdrawal = Withdrawal::where('user_id', request()->user->user_id);
        $beneficiaries = Beneficiar::where('user_id', request()->user->user_id)->get();
        
        if ($request->has('filter_beneficiary') && $request->filled('filter_beneficiary')) {
            $withdrawal->where('beneficiary_id',$request->filter_beneficiary);
        }

        if ($request->has('status') && $request->filled('status')) {
            
            if ($request->status == 'Completed') {
                $withdrawal->whereRaw('`flags` & ?=?', [Withdrawal::FLAG_COMPLETED, Withdrawal::FLAG_COMPLETED])->whereRaw('`flags` & ?=?', [Withdrawal::FLAG_SENT_TO_CLIENT, Withdrawal::FLAG_SENT_TO_CLIENT]);

            } else if($request->status == 'Failed') {
                $withdrawal->whereRaw('`flags` & ?=?', [Withdrawal::FLAG_FAILED, Withdrawal::FLAG_FAILED]);

            } else {
                $withdrawal->whereRaw('`flags` & ?!=?', [Withdrawal::FLAG_SENT_TO_CLIENT, Withdrawal::FLAG_SENT_TO_CLIENT]);
            }

        }

        if ($request->has('end_date') && $request->filled('end_date')) {
            $withdrawal->where('created_at', 'LIKE', '%'.$request->end_date.'%');
        }

        if ($request->has('search') && $request->filled('search')) {
            $withdrawal->where('requested_amount', 'LIKE', '%'.$request->search.'%')->orWhere('final_amount_in_btc', 'LIKE', '%'.$request->search.'%')->orWhere('final_amount_in_btc', 'LIKE', '%'.$request->search.'%');

            
        }

        if( $request->has('export') && isset($request->export)) {
            $request->validate([
                'withdrawal_list' => 'required',
            ]);

            $withdrawal = Withdrawal::whereIn('withdrawal_id',$request->withdrawal_list)->with(['beneficiar', 'bank_info' => function ($query) {
                $query->withTrashed();
            }])->get();
            


            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=CG-withdrawal.csv",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );


          
            $callback = function() use($withdrawal) {
                $file = fopen('php://output', 'w');
                foreach ($withdrawal as $task) {
                    $amount = number_format($task->requested_amount_by_user_in_zar-($task->all_charged_fees_in_zar+$task->valr_taker_share+$task->valr_withdrawal_fees_share), 2);
                    $row['bank_branch_code'] = $task->bank_info->branch_code;
                    $row['bank_account_number'] = $task->bank_info->account_number;
                    $row['amount'] = $amount;
                    $row['valr_name'] = 'CryptoGifting Withdrawal';
                    $row['beneficiary_id'] = $task->beneficiar->beneficiary_id;
                    $row['beneficiary_name'] = get_user_name($task->beneficiar->beneficiary_id);

                    fputcsv($file, array($row['bank_branch_code'], $row['bank_account_number'], $row['amount'], $row['valr_name'], $row['beneficiary_id'], $row['beneficiary_name']));
                }
                fclose($file);
             };
        
            return response()->stream($callback, 200, $headers);
        }


        $withdrawal->orderBy('id', 'desc');

        return view('user-dashboard.reports.funds-withdrawn',['withdrawal' => $withdrawal->paginate(20), 'beneficiaries' => $beneficiaries]);
    }

    public function withdraw_info_admin(Request $request, $id){
        
        $withdrawal = Withdrawal::where('withdrawal_id', $id)->with(['customer', 'user_wallet'])->first();
        $bank_info = BankDetail::where('bank_detail_id', $withdrawal->bank_detail_id)->withTrashed()->first();
        return view('admin.reports.withdrawal-detail', ['withdrawals' => $withdrawal, 'bank_info' => $bank_info]);
    }

    public function store (Request $request)
    {
        date_default_timezone_set('UTC');
        if (!file_exists(storage_path("app/public/cron-job-logs/LogFile")))
            mkdir(storage_path("app/public/cron-job-logs/LogFile"), 0777, true);

        $request->validate([
            'withdrawal_amount' => 'bail|required',
            'beneficiary' => 'bail|required',
            'verification_code' => 'bail|required|integer',
            'accept_agreement' => 'bail|required',
        ]);

        $log =  print_r('-----------------------------------------------------------------------------------------------------------------', true)."\n VALR CRON JOB HIT (WITHDRAWALS):\n".PHP_EOL;
        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
        
        $date = date('Y-m-d');
        $time = date('H:i:s');
        
        $log =  print_r('-Withdrawal Timestamp '.$date.' '.$time, true).PHP_EOL;
        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

    
        $apiKey = "f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01";
        $apiSecret = "71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802";
        $benef = Beneficiar::where('beneficiary_id', $request->beneficiary)->first();

        $log =  print_r('-Beneficiary Found: '.$benef->name.' '.$benef->surname, true).PHP_EOL;
        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

        $log =  print_r('-Beneficiary ID Found: '.$benef->beneficiary_id, true).PHP_EOL;
        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

        $log =  print_r('-Beneficiary VARL Sub-Account Name Found: '.$benef->valr_account_name, true).PHP_EOL;
        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

        $wd = new Withdrawal;
        if ($request->accept_agreement != '1') {
            return redirect()->back()->with(['req_error' => 'Accept Agreement First!']);

        }

        $current_user = User::where('user_id', request()->user->user_id)->first();

        $log =  print_r('-User Found: '.get_user_name(request()->user->user_id), true).PHP_EOL;
        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

        if ($current_user->withdrawal_verification_code != $request->verification_code) {
            return redirect()->back()->with(['req_error' => 'Enter Valid Verification Code!']);

        }
        $fast = false;

        $user_id = request()->user->user_id;
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
        } else {
            return redirect()->back()->with(['req_error' => 'There is some error!']);

        }

        $log =  print_r('-Checking User Balance', true).PHP_EOL;
        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

        $url = "https://api.valr.com/v1/account/balances";
        $timestamp = time() * 1000;
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
        $again_order_response = curl_exec($curl);
        $again_order_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        sleep(5);   
        if ($again_order_response_code == '200') {
            foreach(json_decode($again_order_response) as $b_key => $b_value) {
                if ($b_value->currency == 'BTC') {
                    $available_final_amount = $b_value->available;
                    $log =  print_r('-User Balance (BTC):  '.$b_value->available, true).PHP_EOL;
                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    break;
                }
            }
        } else {
            return redirect()->back()->with(['req_error' => 'There is some error! Please try again later.']);
        }

        $fast = false;
        if ($request->has('withdrawal_amount_check') && $request->filled('withdrawal_amount_check')) $fast = true;

        

        $bank_details = BankDetail::where('user_id', $user_id)->first();
        if ($bank_details) {
            $log =  print_r('-User Bank Account Details Found', true).PHP_EOL;

            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
            /* Bank information access */

            $wallet = UserWallet::where('user_id', $user_id)->where('beneficiary_id', $benef->beneficiary_id)->orderBy('id', 'desc')->first();
            if ($wallet) {
                if ($available_final_amount < $request->withdrawal_amount) {
                    $log =  print_r('-Amount is larger then available amount!', true).PHP_EOL;
                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    return redirect()->back()->with(['req_error' => 'Amount is larger then available amount!']);

                }

                $log =  print_r('-Amount is suitable for withdrawal!', true).PHP_EOL;
                file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                
                  $log =  print_r('-User Requested Withdrawal Amount (BTC): '.$request->withdrawal_amount, true).PHP_EOL;
                file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                    /* Amount are souitable for transfer */ 
                    $funds_move_result = $this->move_btc_from_sub_to_main_account($benef->valr_account_id, $request->withdrawal_amount);
                    sleep(5);
                    if ($funds_move_result == '1') {
                        
                        $wd->withdrawal_id = (String) Str::uuid();
                        $wd->user_wallet_id = (String) Str::uuid();
                        $wd->user_id = $user_id;
                        $wd->bank_detail_id = $bank_details->bank_detail_id;
                        $wd->beneficiary_id = $benef->beneficiary_id;
                        $wd->currency = "BTC";
                        $wd->addFlag(Withdrawal::FLAG_PROGRESS);
                        $wd->save();

                          /* Amount are souitable for move amount into main  */ 

                        $log = print_r('-BTC Funds Moved From Sub-Account to Main Account!', true).PHP_EOL;
                        
                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                        $sell_btc_result = $this->sell_btc_from_main_account($request->withdrawal_amount, $wd->withdrawal_id);
                        sleep(5);
                        if ($sell_btc_result != '2') {
                            $log =  print_r('-BTC Funds Sold from Main Account with Order ID: '.$sell_btc_result, true).PHP_EOL;
                            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                            date_default_timezone_set('Africa/Johannesburg');


                            $apiKey = "f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01";
                            $apiSecret = "71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802";
                            $url = "https://api.valr.com/v1/simple/BTCZAR/order/".$sell_btc_result;
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
                            $again_order_response = curl_exec($curl);
                            $again_order_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                            curl_close($curl);
                            sleep(5);
                            if ($again_order_response_code == '200') {
                                $found_order = json_decode($again_order_response);
                                $log =  print_r('-Order Detail Found', true).PHP_EOL;
                                file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                 
                                 $json = json_encode ( $found_order, JSON_PRETTY_PRINT );
                                 $log =  print_r('-Order Details:'.$json , true).PHP_EOL;
                                 file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                 
                                    $log =  print_r('-Calculating Withdrawal Fees', true).PHP_EOL;
                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                 
                                   $cg_withdrawal_fees = Setting::where('keys', 'cg_withdrawal_fees')->first();
                                    $cg_withdrawal_fees_type = Setting::where('keys', 'cg_withdrawal_fees_type')->first();
                                    $valr_taker_withdrawal_fees = Setting::where('keys', 'valr_taker_withdrawal_fees')->first();
                                    $valr_taker_withdrawal_fees_type = Setting::where('keys', 'valr_taker_withdrawal_fees_type')->first();
                                    $mercantile_withdrawal_fees = Setting::where('keys', 'mercantile_withdrawal_fees')->first();
                                    $mercantile_withdrawal_fees_type = Setting::where('keys', 'mercantile_withdrawal_fees_type')->first();
                                    $vat_tax_withdrawal = Setting::where('keys', 'vat_tax_withdrawal')->first();
                                    $vat_tax_withdrawal_type = Setting::where('keys', 'vat_tax_withdrawal_type')->first();
                                    $valr_fast_fees_type = Setting::where('keys', 'valr_fast_fees_type')->first();
                                    $valr_normal_fees_type = Setting::where('keys', 'valr_normal_fees_type')->first();
                                    $valr_fast_fees = Setting::where('keys', 'valr_fast_fees')->first();
                                    $valr_normal_fees = Setting::where('keys', 'valr_normal_fees')->first();

                                    $cg_withdrawal_fees = $cg_withdrawal_fees->values;
                                    $cg_withdrawal_fees_type = $cg_withdrawal_fees_type->values;
                                    $valr_taker_withdrawal_fees = $valr_taker_withdrawal_fees->values;
                                    $valr_taker_withdrawal_fees_type = $valr_taker_withdrawal_fees_type->values;
                                    $mercantile_withdrawal_fees = $mercantile_withdrawal_fees->values;
                                    $mercantile_withdrawal_fees_type = $mercantile_withdrawal_fees_type->values;
                                    $vat_tax_withdrawal = $vat_tax_withdrawal->values;
                                    $vat_tax_withdrawal_type = $vat_tax_withdrawal_type->values;
                                    $FastFees = $valr_fast_fees->values;
                                    $NormalFees = $valr_normal_fees->values;

                                    $wd->cg_platform_fees = $cg_withdrawal_fees;
                                    $wd->cg_platform_fees_type = $cg_withdrawal_fees_type;

                                    $wd->valr_taker = $valr_taker_withdrawal_fees;
                                    $wd->valr_taker_type = $valr_taker_withdrawal_fees_type;

                                    $wd->vat_tax = $vat_tax_withdrawal;
                                    $wd->vat_tax_type = $vat_tax_withdrawal_type;

                                    $amount = $request->withdrawal_amount;
                                    $wd->requested_amount = $amount;
                                    
                                    $wd->requested_amount_by_user_in_zar = $found_order->receivedAmount + $found_order->feeAmount;
                                    $AmountInZar = $found_order->receivedAmount +  $found_order->feeAmount;
                                    
                                    $log =  print_r('-Requested Amount (ZAR): '.$AmountInZar , true).PHP_EOL;
                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                    
                                    $wd->btc_zar_rate = $AmountInZar / $found_order->paidAmount;

                                    $platformFeeFinal = 0.0;
                                    $valrTakerFinal = 0.0;
                                    $vatTaxFinal = 0.0;
                                    $finalAmount = 0.0;
                                    $valrWithdrawalFees = 0.0;
                                    $BankFees = 0.0;
                                    $thirdPartyFees = 0.0;
                                    
                                    if ($cg_withdrawal_fees_type == 'percentage') {
                                        $platformFeeFinal = ($AmountInZar/100) * $cg_withdrawal_fees;
                                        $platformFeeFinal = ($platformFeeFinal + $AmountInZar) - $AmountInZar;

                                    } else {
                                        $platformFeeFinal = $cg_withdrawal_fees;

                                    }
                                    
                                    $log =  print_r('-Platform Fee: '.$platformFeeFinal , true).PHP_EOL;
                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                   
                                    $wd->cg_platform_fees_share = $platformFeeFinal;
                                    $finalAmount += $platformFeeFinal;

                                    if ($vat_tax_withdrawal_type == 'percentage') {
                                        $vatTaxFinal = ($platformFeeFinal/ (100 + $vat_tax_withdrawal)) * $vat_tax_withdrawal;
                                        $vatTaxFinal = ($vatTaxFinal + $platformFeeFinal) - $platformFeeFinal;

                                    } else {
                                        $vatTaxFinal = $vat_tax_withdrawal;

                                    }
                                    
                                    $log =  print_r('-VAT Tax: '.$vatTaxFinal , true).PHP_EOL;
                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                    
                                    $wd->vat_tax_share = $vatTaxFinal;

                                    if ($valr_taker_withdrawal_fees_type == 'percentage') {
                                        $valrTakerFinal = ($valr_taker_withdrawal_fees * $AmountInZar);

                                    } else {
                                        $valrTakerFinal = ($valr_taker_withdrawal_fees + $AmountInZar);

                                    }
                                    
                                    $log =  print_r('-VALR Taker Fee Final: '.$valrTakerFinal , true).PHP_EOL;
                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                    
                                    $wd->valr_taker_share =  $valrTakerFinal;

                                    if ($mercantile_withdrawal_fees_type == 'percentage') {
                                        $wd->bank_charges = $mercantile_withdrawal_fees;
                                        $mercantileFeesFinal = ($AmountInZar/100) * $mercantile_withdrawal_fees;
                                        $mercantileFeesFinal = ($mercantileFeesFinal + $AmountInZar) - $AmountInZar;
                                        $wd->bank_charges_type = 'percentage';

                                    } else {
                                        $wd->bank_charges = $mercantile_withdrawal_fees;
                                        $mercantileFeesFinal = $mercantile_withdrawal_fees;
                                        $wd->bank_charges_type = 'fixed';

                                    }
                                    
                                    $log =  print_r('-Mercantile Fees: '.$mercantileFeesFinal , true).PHP_EOL;
                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                    
                                    $finalAmount += $mercantileFeesFinal;
                                    $wd->bank_charges_share = $mercantileFeesFinal;

                                    if ($fast) {
                                        if ($valr_fast_fees_type == 'percentage') {
                                            $BankFees = ($AmountInZar/100) * $FastFees;
                                            $BankFees = ($BankFees + $AmountInZar) - $AmountInZar;
                                            $wd->valr_withdrawal_fees_type = 'percentage';

                                        } else {
                                            $BankFees = $FastFees;
                                            $wd->valr_withdrawal_fees_type = 'fixed';

                                        }
                                        $wd->valr_withdrawal_fees = $valr_withdrawal_fees;
                                    } else {
                                        if ($valr_normal_fees_type == 'percentage') {
                                            $BankFees = ($AmountInZar/100) * $NormalFees;
                                            $BankFees = ($BankFees + $AmountInZar) - $AmountInZar;
                                            $wd->valr_withdrawal_fees_type = 'percentage';
                                        } else {
                                            $BankFees = $NormalFees;
                                            $wd->valr_withdrawal_fees_type = 'fixed';

                                        }
                                        $wd->valr_withdrawal_fees = $BankFees;

                                    }
                                    
                                     $log =  print_r('-VALR Withdrawal Fees: '.$BankFees , true).PHP_EOL;
                                     file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                     $wd->valr_withdrawal_fees_share = $BankFees;
                                     
                                      

                                    $withdrawal_amount_for_bank = ($found_order->receivedAmount - $BankFees); 
                                    $withdrawal_amount_for_bank = (string) $withdrawal_amount_for_bank;
                                    $wd->valr_withdrawal_total_amount_bank = $withdrawal_amount_for_bank;
                                  
                                    

                                    $wd->all_charged_fees_in_zar = $finalAmount;
                                    $final_amount = $AmountInZar - $finalAmount;
                                    
                                    $final_amount_btc = $final_amount / $btc_rate;
                                    $wd->final_amount_in_btc = $final_amount_btc;

                                if ($found_order->success) {

                                    $log =  print_r('-Order Status: Success', true).PHP_EOL;
                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                                  
                                    $log =  print_r('-Order Processing Completed Successfully', true).PHP_EOL;                                    
                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                                    $bank_id = $this->get_bank_id();
                                    if ($bank_id != '2') {
                                        $log =  print_r('-Bank Account ID: '.$bank_id, true).PHP_EOL;
                                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                        
                                          $log =  print_r('-Withdrawal Amount (Amount that we are sending to VALR for the withdrawal to the bank account): '.$withdrawal_amount_for_bank, true).PHP_EOL;
                                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                                        $bank_transaction_result = $this->transfer_funds_from_main_account_to_bank_account($withdrawal_amount_for_bank, $bank_id, $fast, $wd->withdrawal_id);
                                        sleep(5);
                                        if ($bank_transaction_result != '2') {
                                            $log =  print_r('-Completed Withdrawal of Funds to Bank Account ', true).PHP_EOL;
                                            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

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
                                                $user_wallet = new UserWallet;
                                                $user_wallet_id = $wd->user_wallet_id;
                                                $user_wallet->user_wallet_id = $user_wallet_id;
                                                $user_wallet->user_id = $user_id;
                                                $user_wallet->beneficiary_id = $benef->beneficiary_id;
                                                $user_wallet->paid_amount = $found_order->paidAmount;
                                                $user_wallet->paid_currency = $found_order->paidCurrency;
                                                $user_wallet->received_amount = $found_order->receivedAmount - $wd->all_charged_fees_in_zar;
                                                $user_wallet->received_currency = $found_order->receivedCurrency;
                                                $user_wallet->fee_amount = $found_order->feeAmount;
                                                $user_wallet->fee_currency = $found_order->feeCurrency;
                                                $user_wallet->response = json_encode($found_order);
                                                $user_wallet->mode = 'withdrawal';
                                                $user_wallet->final_amount = $amount_in_btc;
                                                if ($user_wallet->save()) {
                                                    $wd->response = $again_order_response;
                                                    $wd->removeFlag(Withdrawal::FLAG_FAST);
                                                    if ($fast) {
                                                        $wd->addFlag(Withdrawal::FLAG_FAST);

                                                    }
                                                    $wd->removeFlag(Withdrawal::FLAG_PROGRESS);
                                                    $wd->removeFlag(Withdrawal::FLAG_COMPLETED);
                                                    $wd->removeFlag(Withdrawal::FLAG_FAILED);
                                                    $wd->addFlag(Withdrawal::FLAG_COMPLETED);
                                                    $wd->save();
                                                     $log =  print_r('Found Beneficiary Wallet Amount and now will update the database on our system!', true).PHP_EOL;
                                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                                    
                                                    $log =  print_r('-----------------------------------------------------------------------------------------------------------------', true).PHP_EOL;
                                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                                    return redirect(route('UserDashboard'))->with(['req_success' => 'We have received your request! Will let you know when we process it.']);
                                                }
                                                
                                            }

                                        }
                                    }
                                } else if ($found_order->processing) {
                                    $log =  print_r('-Order Status: Pending!', true).PHP_EOL;
                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                                    $user_wallet = new UserWallet;
                                    $user_wallet_id = $wd->user_wallet_id;
                                    $user_wallet->user_wallet_id = $user_wallet_id;
                                    $user_wallet->user_id = $user_id;
                                    $user_wallet->beneficiary_id = $benef->beneficiary_id;
                                    $user_wallet->response = json_encode($found_order);
                                    $user_wallet->mode = 'withdrawal';
                                    if ($user_wallet->save()) {
                                        $wd->response = $again_order_response;
                                        $wd->removeFlag(Withdrawal::FLAG_FAST);
                                        if ($fast) {
                                            $wd->addFlag(Withdrawal::FLAG_FAST);

                                        }
                                        $wd->removeFlag(Withdrawal::FLAG_PROGRESS);
                                        $wd->removeFlag(Withdrawal::FLAG_COMPLETED);
                                        $wd->removeFlag(Withdrawal::FLAG_FAILED);
                                        $wd->addFlag(Withdrawal::FLAG_PROGRESS);
                                        $wd->save();
                                        return redirect(route('UserDashboard'))->with(['req_success' => 'We have received your request! Will let you know when we process it.']);
                                    }
                                }
                            }
                            $log =  print_r('-Order Info can not get fetched! '.$again_order_response_code, true).PHP_EOL;
                            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                        }
                        $log =  print_r('-Sell btc from main account got failed!', true).PHP_EOL;
                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    }
                    $funds_move_result = json_decode($funds_move_result);
                    $wd->removeFlag(Withdrawal::FLAG_PROGRESS);
                    $wd->removeFlag(Withdrawal::FLAG_COMPLETED);
                    $wd->removeFlag(Withdrawal::FLAG_FAILED);
                    $wd->addFlag(Withdrawal::FLAG_FAILED);
                    $wd->save();
                    $failure_message = '';
                    if (isset($funds_move_result->message) && !empty($funds_move_result->message)) {
                        $failure_message = $funds_move_result->message;
                    }
                    $log =  print_r("Fail to funds is not in your account ".$failure_message, true).PHP_EOL;
                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
            }
            $log =  print_r('Wallet Record not found!', true).PHP_EOL;
            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

            return redirect()->back()->with(['req_error' => 'Wallet entry not found!']);
        }
        $log = print_r('Bank account not found!', true).PHP_EOL;
        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
        return redirect()->back()->with(['req_error' => 'Bank details not found!']);
    }

    public function withdrawal_cron (Request $request)
    {
        date_default_timezone_set('UTC');
        if (!file_exists(storage_path("app/public/cron-job-logs/LogFile")))
            mkdir(storage_path("app/public/cron-job-logs/LogFile"), 0777, true);


        $log =  print_r('-----------------------------------------------------------------------------------------------------------------', true)."\n VALR CRON JOB HIT (WITHDRAWALS):\n".PHP_EOL;
        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
        
        $date = date('Y-m-d');
        $time = date('H:i:s');

        $end_time = $date.'T'.$time.'.000Z';

        $settings = Setting::where('keys','cron_withdrawal_start_time')->first();
        
        $cron_start_date = $settings->values;
        
        $log =  print_r('-Withdrawal Timestamp '.$date.' '.$time, true).PHP_EOL;
        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

        $log =  print_r('-Withdrawal Cron Job Start Time: '.$cron_start_date, true).PHP_EOL;
        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

        $log =  print_r('-Withdrawal Cron Job End Time: '.$end_time, true).PHP_EOL;
        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

    
        $apiKey = "f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01";
        $apiSecret = "71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802";
        

        $request_withdrawals = RequestWithdrawal::whereRaw('`flags` & ?=?', [RequestWithdrawal::FLAG_PROCESS, RequestWithdrawal::FLAG_PROCESS])->get();
        foreach ($request_withdrawals as $request_withdrawal) { 
            $benef = Beneficiar::where('beneficiary_id', $request_withdrawal->beneficiary_id)->first();

            $log =  print_r('-Beneficiary Found: '.$benef->name.' '.$benef->surname, true).PHP_EOL;
            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

            $log =  print_r('-Beneficiary ID Found: '.$benef->beneficiary_id, true).PHP_EOL;
            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

            $log =  print_r('-Beneficiary VARL Sub-Account Name Found: '.$benef->valr_account_name, true).PHP_EOL;
            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
           
            $current_user = User::where('user_id', $request_withdrawal->user_id )->first();
            $log =  print_r('-User Found: '.get_user_name($request_withdrawal->user_id), true).PHP_EOL;
            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
            $fast = false;
            $user_id = $request_withdrawal->user_id;
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
            } else {
              $log =  print_r('-Last trade value is not found', true).PHP_EOL;
             file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

            }

            $log =  print_r('-Checking User Balance', true).PHP_EOL;
            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

            $url = "https://api.valr.com/v1/account/balances";
            $timestamp = time() * 1000;
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
            $again_order_response = curl_exec($curl);
            $again_order_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            sleep(5);   
            if ($again_order_response_code == '200') {
                foreach(json_decode($again_order_response) as $b_key => $b_value) {
                    if ($b_value->currency == 'BTC') {
                        $available_final_amount = $b_value->available;
                        $log =  print_r('-User Balance (BTC):  '.$b_value->available, true).PHP_EOL;
                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                        break;
                    }
                }
            } else {
                $log =  print_r('-User Balance (BTC):  Not Found: '.$again_order_response, true).PHP_EOL;
                file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
            }
           

            $fast = false;
            if ($request_withdrawal->withdrawal_type && $request_withdrawal->withdrawal_type == "1") $fast = true;
    

            if ($request_withdrawal->bank_detail_id) {

                $log =  print_r('-User Bank Account Details Found', true).PHP_EOL;
                file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                
                $wallet = UserWallet::where('user_id', $user_id)->where('beneficiary_id', $benef->beneficiary_id)->orderBy('id', 'desc')->first();
                if ($wallet) {
                    if ($available_final_amount < $request_withdrawal->request_amount) {
                        $log =  print_r('-Amount is larger then available amount!', true).PHP_EOL;
                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    } else {

                        $log =  print_r('-Amount is suitable for withdrawal!', true).PHP_EOL;
                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    
                        $log =  print_r('-User Requested Withdrawal Amount (BTC): '. $request_withdrawal->request_amount, true).PHP_EOL;
                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                    
                        /* Amount are souitable for transfer */ 
                        $funds_move_result = $this->move_btc_from_sub_to_main_account($benef->valr_account_id,  $request_withdrawal->request_amount);
                        sleep(5);
                        if ($funds_move_result == '1') {
                            $wd = new Withdrawal;
                            $wd->withdrawal_id = (String) Str::uuid();
                            $wd->user_wallet_id = (String) Str::uuid();
                            $wd->user_id = $user_id;
                            $wd->bank_detail_id = $request_withdrawal->bank_detail_id;
                            $wd->beneficiary_id = $benef->beneficiary_id;
                            $wd->currency = "BTC";
                            $wd->addFlag(Withdrawal::FLAG_PROGRESS);
                            $wd->save();

                            /* Amount are souitable for move amount into main  */ 

                            $log = print_r('-BTC Funds Moved From Sub-Account to Main Account!', true).PHP_EOL;
                            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                            $sell_btc_result = $this->sell_btc_from_main_account($request_withdrawal->request_amount, $wd->withdrawal_id);
                            sleep(5);
                            if ($sell_btc_result != '2') {
                                $log =  print_r('-BTC Funds Sold from Main Account with Order ID: '.$sell_btc_result, true).PHP_EOL;
                                file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                                $apiKey = "f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01";
                                $apiSecret = "71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802";
                                $url = "https://api.valr.com/v1/simple/BTCZAR/order/".$sell_btc_result;
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
                                $again_order_response = curl_exec($curl);
                                $again_order_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                                curl_close($curl);
                                sleep(5);
                                if ($again_order_response_code == '200') {
                                        $wd->response = $again_order_response;
                                        $wd->save();
                                        $found_order = json_decode($again_order_response);
                                        $log =  print_r('-Order Detail Found', true).PHP_EOL;
                                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                    
                                        $json = json_encode ( $found_order, JSON_PRETTY_PRINT );
                                        $log =  print_r('-Order Details:'.$json , true).PHP_EOL;
                                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                        
                                        $log =  print_r('-Calculating Withdrawal Fees', true).PHP_EOL;
                                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                    
                                        $cg_withdrawal_fees = Setting::where('keys', 'cg_withdrawal_fees')->first();
                                        $cg_withdrawal_fees_type = Setting::where('keys', 'cg_withdrawal_fees_type')->first();
                                        $valr_taker_withdrawal_fees = Setting::where('keys', 'valr_taker_withdrawal_fees')->first();
                                        $valr_taker_withdrawal_fees_type = Setting::where('keys', 'valr_taker_withdrawal_fees_type')->first();
                                        $mercantile_withdrawal_fees = Setting::where('keys', 'mercantile_withdrawal_fees')->first();
                                        $mercantile_withdrawal_fees_type = Setting::where('keys', 'mercantile_withdrawal_fees_type')->first();
                                        $vat_tax_withdrawal = Setting::where('keys', 'vat_tax_withdrawal')->first();
                                        $vat_tax_withdrawal_type = Setting::where('keys', 'vat_tax_withdrawal_type')->first();
                                        $valr_fast_fees_type = Setting::where('keys', 'valr_fast_fees_type')->first();
                                        $valr_normal_fees_type = Setting::where('keys', 'valr_normal_fees_type')->first();
                                        $valr_fast_fees = Setting::where('keys', 'valr_fast_fees')->first();
                                        $valr_normal_fees = Setting::where('keys', 'valr_normal_fees')->first();

                                        $cg_withdrawal_fees = $cg_withdrawal_fees->values;
                                        $cg_withdrawal_fees_type = $cg_withdrawal_fees_type->values;
                                        $valr_taker_withdrawal_fees = $valr_taker_withdrawal_fees->values;
                                        $valr_taker_withdrawal_fees_type = $valr_taker_withdrawal_fees_type->values;
                                        $mercantile_withdrawal_fees = $mercantile_withdrawal_fees->values;
                                        $mercantile_withdrawal_fees_type = $mercantile_withdrawal_fees_type->values;
                                        $vat_tax_withdrawal = $vat_tax_withdrawal->values;
                                        $vat_tax_withdrawal_type = $vat_tax_withdrawal_type->values;
                                        $FastFees = $valr_fast_fees->values;
                                        $NormalFees = $valr_normal_fees->values;

                                        $wd->cg_platform_fees = $cg_withdrawal_fees;
                                        $wd->cg_platform_fees_type = $cg_withdrawal_fees_type;

                                        $wd->valr_taker = $valr_taker_withdrawal_fees;
                                        $wd->valr_taker_type = $valr_taker_withdrawal_fees_type;

                                        $wd->vat_tax = $vat_tax_withdrawal;
                                        $wd->vat_tax_type = $vat_tax_withdrawal_type;

                                        $amount = $request_withdrawal->request_amount;
                                        $wd->requested_amount = $amount;
                                        
                                        $wd->requested_amount_by_user_in_zar = $found_order->receivedAmount + $found_order->feeAmount;
                                        $AmountInZar = $found_order->receivedAmount +  $found_order->feeAmount;
                                        
                                        $log =  print_r('-Requested Amount (ZAR): '.$AmountInZar , true).PHP_EOL;
                                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                        
                                        $wd->btc_zar_rate = $AmountInZar / $found_order->paidAmount;

                                        $platformFeeFinal = 0.0;
                                        $valrTakerFinal = 0.0;
                                        $vatTaxFinal = 0.0;
                                        $finalAmount = 0.0;
                                        $valrWithdrawalFees = 0.0;
                                        $BankFees = 0.0;
                                        $thirdPartyFees = 0.0;
                                        
                                        if ($cg_withdrawal_fees_type == 'percentage') {
                                            $platformFeeFinal = ($AmountInZar/100) * $cg_withdrawal_fees;
                                            $platformFeeFinal = ($platformFeeFinal + $AmountInZar) - $AmountInZar;

                                        } else {
                                            $platformFeeFinal = $cg_withdrawal_fees;

                                        }
                                        
                                        $log =  print_r('-Platform Fee: '.$platformFeeFinal , true).PHP_EOL;
                                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                    
                                        $wd->cg_platform_fees_share = $platformFeeFinal;
                                        $finalAmount += $platformFeeFinal;

                                        if ($vat_tax_withdrawal_type == 'percentage') {
                                            $vatTaxFinal = ($platformFeeFinal/ (100 + $vat_tax_withdrawal)) * $vat_tax_withdrawal;
                                            $vatTaxFinal = ($vatTaxFinal + $platformFeeFinal) - $platformFeeFinal;

                                        } else {
                                            $vatTaxFinal = $vat_tax_withdrawal;

                                        }
                                        
                                        $log =  print_r('-VAT Tax: '.$vatTaxFinal , true).PHP_EOL;
                                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                        
                                        $wd->vat_tax_share = $vatTaxFinal;

                                        if ($valr_taker_withdrawal_fees_type == 'percentage') {
                                            $valrTakerFinal = ($valr_taker_withdrawal_fees * $AmountInZar);

                                        } else {
                                            $valrTakerFinal = ($valr_taker_withdrawal_fees + $AmountInZar);

                                        }
                                        
                                        $log =  print_r('-VALR Taker Fee Final: '.$valrTakerFinal , true).PHP_EOL;
                                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                        
                                        $wd->valr_taker_share =  $valrTakerFinal;

                                        if ($mercantile_withdrawal_fees_type == 'percentage') {
                                            $wd->bank_charges = $mercantile_withdrawal_fees;
                                            $mercantileFeesFinal = ($AmountInZar/100) * $mercantile_withdrawal_fees;
                                            $mercantileFeesFinal = ($mercantileFeesFinal + $AmountInZar) - $AmountInZar;
                                            $wd->bank_charges_type = 'percentage';

                                        } else {
                                            $wd->bank_charges = $mercantile_withdrawal_fees;
                                            $mercantileFeesFinal = $mercantile_withdrawal_fees;
                                            $wd->bank_charges_type = 'fixed';

                                        }
                                        
                                        $log =  print_r('-Mercantile Fees: '.$mercantileFeesFinal , true).PHP_EOL;
                                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                        
                                        $finalAmount += $mercantileFeesFinal;
                                        $wd->bank_charges_share = $mercantileFeesFinal;

                                        if ($fast) {
                                            if ($valr_fast_fees_type == 'percentage') {
                                                $BankFees = ($AmountInZar/100) * $FastFees;
                                                $BankFees = ($BankFees + $AmountInZar) - $AmountInZar;
                                                $wd->valr_withdrawal_fees_type = 'percentage';

                                            } else {
                                                $BankFees = $FastFees;
                                                $wd->valr_withdrawal_fees_type = 'fixed';

                                            }
                                            $wd->valr_withdrawal_fees = $valr_withdrawal_fees;
                                        } else {
                                            if ($valr_normal_fees_type == 'percentage') {
                                                $BankFees = ($AmountInZar/100) * $NormalFees;
                                                $BankFees = ($BankFees + $AmountInZar) - $AmountInZar;
                                                $wd->valr_withdrawal_fees_type = 'percentage';
                                            } else {
                                                $BankFees = $NormalFees;
                                                $wd->valr_withdrawal_fees_type = 'fixed';

                                            }
                                            $wd->valr_withdrawal_fees = $BankFees;

                                        }
                                        
                                        $log =  print_r('-VALR Withdrawal Fees: '.$BankFees , true).PHP_EOL;
                                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                        $wd->valr_withdrawal_fees_share = $BankFees;
                                        
                                        

                                        $withdrawal_amount_for_bank = ($found_order->receivedAmount - $BankFees); 
                                        $withdrawal_amount_for_bank = (string) $withdrawal_amount_for_bank;
                                        
                                    
                                        

                                        $wd->all_charged_fees_in_zar = $finalAmount;
                                        $final_amount = $AmountInZar - $finalAmount;
                                        
                                        $final_amount_btc = $final_amount / $btc_rate;
                                        $wd->final_amount_in_btc = $final_amount_btc;

                                    if ($found_order->success) {

                                        $log =  print_r('-Order Status: Success', true).PHP_EOL;
                                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                                    
                                        $log =  print_r('-Order Processing Completed Successfully', true).PHP_EOL;                                    
                                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                                        $bank_id = $this->get_bank_id();
                                        if ($bank_id != '2') {
                                            $log =  print_r('-Bank Account ID: '.$bank_id, true).PHP_EOL;
                                            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                            
                                            $log =  print_r('-Withdrawal Amount (Amount that we are sending to VALR for the withdrawal to the bank account): '.$withdrawal_amount_for_bank, true).PHP_EOL;
                                            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                                            $bank_transaction_result = $this->transfer_funds_from_main_account_to_bank_account($withdrawal_amount_for_bank, $bank_id, $fast, $wd->withdrawal_id);
                                            sleep(5);
                                            if ($bank_transaction_result != '2') {
                                                $log =  print_r('-Completed Withdrawal of Funds to Bank Account ', true).PHP_EOL;
                                                file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

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
                                                    $user_wallet = new UserWallet;
                                                    $user_wallet_id = $wd->user_wallet_id;
                                                    $user_wallet->user_wallet_id = $user_wallet_id;
                                                    $user_wallet->user_id = $user_id;
                                                    $user_wallet->beneficiary_id = $benef->beneficiary_id;
                                                    $user_wallet->paid_amount = $found_order->paidAmount;
                                                    $user_wallet->paid_currency = $found_order->paidCurrency;
                                                    $user_wallet->received_amount = $found_order->receivedAmount - $wd->all_charged_fees_in_zar;
                                                    $user_wallet->received_currency = $found_order->receivedCurrency;
                                                    $user_wallet->fee_amount = $found_order->feeAmount;
                                                    $user_wallet->fee_currency = $found_order->feeCurrency;
                                                    $user_wallet->response = json_encode($found_order);
                                                    $user_wallet->mode = 'withdrawal';
                                                    $user_wallet->final_amount = $amount_in_btc;
                                                    if ($user_wallet->save()) {
                                                        $wd->response = $again_order_response;
                                                        $wd->removeFlag(Withdrawal::FLAG_FAST);
                                                        if ($fast) {
                                                            $wd->addFlag(Withdrawal::FLAG_FAST);

                                                        }
                                                        $wd->removeFlag(Withdrawal::FLAG_PROGRESS);
                                                        $wd->removeFlag(Withdrawal::FLAG_COMPLETED);
                                                        $wd->removeFlag(Withdrawal::FLAG_FAILED);
                                                        $wd->addFlag(Withdrawal::FLAG_COMPLETED);
                                                        $wd->save();

                                                        $request_withdrawal->removeFlag(RequestWithdrawal::FLAG_PROCESS);
                                                        $request_withdrawal->addFlag(RequestWithdrawal::FLAG_COMPLETE);
                                                        $request_withdrawal->save();

                                                        
                                                        $log =  print_r('Found Beneficiary Wallet Amount and now will update the database on our system!', true).PHP_EOL;
                                                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                                        
                                                        $log =  print_r('-----------------------------------------------------------------------------------------------------------------', true).PHP_EOL;
                                                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                                   
                                                    }else {
                                                        $log =  print_r('-User Wallet is not created', true).PHP_EOL;
                                                       file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                                    }
                                                    
                                                }else {
                                                    $log =  print_r('-Wallet is not updated: '.$beneficiary_amount_from_valr, true).PHP_EOL;
                                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                                }

                                            }else {
                                                $log =  print_r('-funds are not transfer into bank account: ', true).PHP_EOL;
                                                file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                            }
                                        }else {
                                            $log =  print_r('-Bank ID is not found', true).PHP_EOL;                                    
                                           file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                        }
                                    } else if ($found_order->processing) {
                                        $log =  print_r('-Order Status: Pending!', true).PHP_EOL;
                                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                                        $user_wallet = new UserWallet;
                                        $user_wallet_id = $wd->user_wallet_id;
                                        $user_wallet->user_wallet_id = $user_wallet_id;
                                        $user_wallet->user_id = $user_id;
                                        $user_wallet->beneficiary_id = $benef->beneficiary_id;
                                        $user_wallet->response = json_encode($found_order);
                                        $user_wallet->mode = 'withdrawal';
                                        if ($user_wallet->save()) {
                                            $wd->response = $again_order_response;
                                            $wd->removeFlag(Withdrawal::FLAG_FAST);
                                            if ($fast) {
                                                $wd->addFlag(Withdrawal::FLAG_FAST);

                                            }
                                            $wd->removeFlag(Withdrawal::FLAG_PROGRESS);
                                            $wd->removeFlag(Withdrawal::FLAG_COMPLETED);
                                            $wd->removeFlag(Withdrawal::FLAG_FAILED);
                                            $wd->addFlag(Withdrawal::FLAG_PROGRESS);
                                            $wd->save();

                                        }
                                    }
                                }else {
                                    $log =  print_r('-Order Info can not get fetched! '.$again_order_response, true).PHP_EOL;
                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                }
                            } else {
                                $log =  print_r('-Sell btc from main account got failed! '.$sell_btc_result, true).PHP_EOL;
                                file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);    
                            }
                        }else {
                            $funds_move_result = json_decode($funds_move_result);
                            $wd->removeFlag(Withdrawal::FLAG_PROGRESS);
                            $wd->removeFlag(Withdrawal::FLAG_COMPLETED);
                            $wd->removeFlag(Withdrawal::FLAG_FAILED);
                            $wd->addFlag(Withdrawal::FLAG_FAILED);
                            $wd->save();
                            $failure_message = '';
                            if (isset($funds_move_result->message) && !empty($funds_move_result->message)) {
                                $failure_message = $funds_move_result->message;
                            }
                            $log =  print_r("-Fail to funds is not in your account ".$failure_message, true).PHP_EOL;
                            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                        }
                        
                    }
                } else {
                    $log =  print_r('-Wallet Record not found!', true).PHP_EOL;
                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                }
                

            } else {
                $log = print_r('-Bank account not found!', true).PHP_EOL;
                file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
            }
            
        }
    }

    public function withdrawal_request (Request $request)
    {
        date_default_timezone_set('UTC');
        if (!file_exists(storage_path("app/public/cron-job-logs/LogFile")))
            mkdir(storage_path("app/public/cron-job-logs/LogFile"), 0777, true);

        $request->validate([
            'withdrawal_amount' => 'bail|required',
            'beneficiary' => 'bail|required',
            'verification_code' => 'bail|required|integer',
            'accept_agreement' => 'bail|required',
        ]);


    
        $apiKey = "f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01";
        $apiSecret = "71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802";
        $benef = Beneficiar::where('beneficiary_id', $request->beneficiary)->first();

        
        if ($request->accept_agreement != '1') {
            return redirect()->back()->with(['req_error' => 'Accept Agreement First!']);

        }

        $current_user = User::where('user_id', request()->user->user_id)->first();

        if ($current_user->withdrawal_verification_code != $request->verification_code) {
            return redirect()->back()->with(['req_error' => 'Enter Valid Verification Code!']);

        }
        $fast = false;

        $user_id = request()->user->user_id;
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
        } else {
            return redirect()->back()->with(['req_error' => 'There is some error!']);

        }

      
        $url = "https://api.valr.com/v1/account/balances";
        $timestamp = time() * 1000;
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
        $again_order_response = curl_exec($curl);
        $again_order_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        sleep(5);   
        if ($again_order_response_code == '200') {
            foreach(json_decode($again_order_response) as $b_key => $b_value) {
                if ($b_value->currency == 'BTC') {
                    $available_final_amount = $b_value->available;
                    break;
                }
            }
        } else {
            return redirect()->back()->with(['req_error' => 'There is some error! Please try again later.']);
        }

        $fast = false;
        if ($request->has('withdrawal_amount_check') && $request->filled('withdrawal_amount_check')) $fast = true;

        $bank_details = BankDetail::where('user_id', $user_id)->first();
        if ($bank_details) {
            /* Bank information access */

            $wallet = UserWallet::where('user_id', $user_id)->where('beneficiary_id', $benef->beneficiary_id)->orderBy('id', 'desc')->first();
            if ($wallet) {
                if ($available_final_amount < $request->withdrawal_amount) {
                     return redirect()->back()->with(['req_error' => 'Amount is larger then available amount!']);

                }

                $request_withdrawal = new RequestWithdrawal;
                $request_withdrawal->withdrawal_request_id = (String) Str::uuid();
                $request_withdrawal->user_id = $user_id;
                $request_withdrawal->bank_detail_id = $bank_details->bank_detail_id;
                $request_withdrawal->beneficiary_id = $benef->beneficiary_id;
                $request_withdrawal->request_amount = $request->withdrawal_amount;
                $request_withdrawal->addFlag(RequestWithdrawal::FLAG_PROCESS);
                if($request_withdrawal->save()) {
                    return redirect(route('UserDashboard'))->with(['req_success' => 'We have received your request! Will let you know when we process it.']);
                } 
            }

            return redirect()->back()->with(['req_error' => 'Wallet entry not found!']);
        }
       
        return redirect()->back()->with(['req_error' => 'Bank details not found!']);
    }

    public function get_bank_id()
    {
       // date_default_timezone_set('Africa/Johannesburg');
        $apiKey = "f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01";
        $apiSecret = "71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802";
        $url = "https://api.valr.com/v1/wallet/fiat/ZAR/accounts";
        $timestamp = time() * 1000;
        $sig =  $this->generateSignature($apiSecret, 'GET', $url, $timestamp, '', []);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array (
                'X-VALR-API-KEY: '.$apiKey,
                'X-VALR-SIGNATURE: '.$sig,
                'X-VALR-TIMESTAMP: '.$timestamp
            ),
        ));
        $bank_accounts = curl_exec($curl);
        $bank_accounts_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $bank_accounts = json_decode($bank_accounts);
        foreach ($bank_accounts as $key => $value) {
            if ($value->branchCode == '450105') {
                return $value->id;
            }
        }
        return '2';
    }

    public function transfer_funds_from_main_account_to_bank_account ($total_amount, $bank_account_id, $fast, $withdrawal_id)
    {
        //date_default_timezone_set('Africa/Johannesburg');
        $apiKey = "f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01";
        $apiSecret = "71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802";
        $url = "https://api.valr.com/v1/wallet/fiat/ZAR/withdraw";
        $timestamp = time() * 1000;
        $body = array (
            "linkedBankAccountId" => $bank_account_id,
            "amount" => $total_amount,
            "fast" => false,
        );
        if ($fast) $body['fast'] = true;

        $sig =  $this->generateSignature($apiSecret, 'POST', $url, $timestamp, '', $body);
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
                'X-VALR-TIMESTAMP: '.$timestamp
            ),
        ));
         $order_response = curl_exec($curl);
         $order_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        //return array($order_response);
        if ($order_response_code == '202') {
            $wd = Withdrawal::where('withdrawal_id',$withdrawal_id)->first();
            $wd->bank_response = json_encode($order_response);
            $wd->save();
            $order_response = json_decode($order_response);
            return $order_response->id;

        }
        return '2';
    }

    public function move_btc_from_sub_to_main_account ($beneficiary_account, $total_amount)
    {
       // date_default_timezone_set('Africa/Johannesburg');
        $apiKey = "f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01";
        $apiSecret = "71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802";
        $url = "https://api.valr.com/v1/account/subaccounts/transfer";
        $timestamp = time() * 1000;
        $body = array (
            "fromId" => $beneficiary_account,
            "toId" => "0",
            "currencyCode" => "BTC",
            "amount" => $total_amount
        );
        $sig =  $this->generateSignature($apiSecret, 'POST', $url, $timestamp, '', $body);
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
                'X-VALR-TIMESTAMP: '.$timestamp
            )
        ));
        $transfer_funds_result = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpcode == '202') {
            return '1';

        }
        return $transfer_funds_result;
    }

    public function sell_btc_from_main_account ($total_amount, $withdrawal_id)
    {
        //date_default_timezone_set('Africa/Johannesburg');
        $apiKey = "f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01";
        $apiSecret = "71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802";
        $url = "https://api.valr.com/v1/simple/btczar/order";
        $timestamp = time() * 1000;
        $body = array (
            "payInCurrency" => "BTC",
            "payAmount" => $total_amount,
            "side" => "SELL"

        );
        $sig =  $this->generateSignature($apiSecret, 'POST', $url, $timestamp, '', $body);
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
                'X-VALR-TIMESTAMP: '.$timestamp
            ),
        ));
        $order_response = curl_exec($curl);
        $order_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($order_response_code == '202') {
            $order_response = json_decode($order_response);
            $wd = Withdrawal::where('withdrawal_id',$withdrawal_id)->first();
            $wd->order_id = json_encode($order_response);
            $wd->save();
            return $order_response->id;
        }
        return '2';
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

    public function test_webhook()
    {
        $valr_keys = config('services.valr');
        $valr_keys['api_key'];
         // Get Bank Account ID
            // date_default_timezone_set('Africa/Johannesburg');
            // $apiKey = "f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01";
            // $apiSecret = "71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802";
            // $url = "https://api.valr.com/v1/wallet/fiat/ZAR/accounts";
            // $timestamp = time() * 1000;
            // $sig =  $this->generateSignature($apiSecret, 'GET', $url, $timestamp, '', []);
            // $curl = curl_init();
            // curl_setopt_array($curl, array(
            //     CURLOPT_URL => $url,
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => '',
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 0,
            //     CURLOPT_FOLLOWLOCATION => true,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_HTTPHEADER => array (
            //         'X-VALR-API-KEY: '.$apiKey,
            //         'X-VALR-SIGNATURE: '.$sig,
            //         'X-VALR-TIMESTAMP: '.$timestamp
            //     ),
            // ));
            // $bank_accounts = curl_exec($curl);
            // $bank_accounts_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            // curl_close($curl);
            // $bank_accounts = json_decode($bank_accounts);
            // foreach ($bank_accounts as $key => $value) {
            //     if ($value->branchCode == '450105') {
            //         return $value->id;
            //     }
            // }
            // return '2';



        // Transfer Funds into bank account
            // $total_amount = '258.65247399975';
            // $bank_account_id = 'bee09887-9bd7-4452-a6fa-49dcd989ebdd';
            // date_default_timezone_set('Africa/Johannesburg');
            // $apiKey = "f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01";
            // $apiSecret = "71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802";
            // $url = "https://api.valr.com/v1/wallet/fiat/ZAR/withdraw";
            // $timestamp = time() * 1000;
            // $body = array (
            //     "linkedBankAccountId" => $bank_account_id,
            //     "amount" => $total_amount,
            //     "fast" => true
            // );
            // $sig =  $this->generateSignature($apiSecret, 'POST', $url, $timestamp, '', $body);
            // $curl = curl_init();
            // curl_setopt_array($curl, array(
            //     CURLOPT_URL => $url,
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => '',
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 0,
            //     CURLOPT_FOLLOWLOCATION => true,
            //     CURLOPT_POSTFIELDS => json_encode($body),
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => 'POST',
            //     CURLOPT_HTTPHEADER => array (
            //         'X-VALR-API-KEY: '.$apiKey,
            //         'X-VALR-SIGNATURE: '.$sig,
            //         'X-VALR-TIMESTAMP: '.$timestamp
            //     ),
            // ));
            // $order_response = curl_exec($curl);
            // $order_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            // curl_close($curl);
            // return $order_response = json_decode($order_response);


        date_default_timezone_set('Africa/Johannesburg');
        $apiKey = "f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01";
        $apiSecret = "71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802";
        $url = "https://api.valr.com/v1/simple/btczar/order";
        $body = array (
            "payInCurrency" => "ZAR",
            "payAmount" => "10",
            "side" => "BUY",
        );
        $timestamp = time() * 1000;
        $subaccount = '931152049814077440';
        $sig =  $this->generateSignatureBenef($apiSecret, 'POST', $url, $timestamp, $subaccount, $body);
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
                'X-VALR-SUB-ACCOUNT-ID: 931152049814077440'
            )
        ));
        $transfer_funds_result = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        print_r($httpcode);
          return (json_decode($transfer_funds_result));

        // date_default_timezone_set('Africa/Johannesburg');
        // $timestamp = time() * 1000;
        // $apiKey = "f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01";
        // $apiSecret = "71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802";
        // $url = "https://api.valr.com/v1/account/balances";
        // $sig =  $this->generateSignature($apiSecret, 'GET', $url, $timestamp , '931152049814077440');
        // $curl = curl_init();
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => $url,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'GET',
        //     CURLOPT_HTTPHEADER => array (
        //         'X-VALR-API-KEY: '.$apiKey,
        //         'X-VALR-SIGNATURE: '.$sig,
        //         'X-VALR-TIMESTAMP: '.$timestamp,
        //         'X-VALR-SUB-ACCOUNT-ID: 931152049814077440'
        //     )
        // ));
        // $again_order_response = curl_exec($curl);
        // $again_order_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        // curl_close($curl);
        // return json_decode($again_order_response);  
        
        
        // date_default_timezone_set('Africa/Johannesburg');
        // $timestamp = time() * 1000;
        // $apiKey = "f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01";
        // $apiSecret = "71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802";
        // $url = "https://api.valr.com/v1/simple/BTCZAR/quote";
        // $sig =  $this->generateSignature($apiSecret, 'POST', $url, $timestamp);
        // $curl = curl_init();
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => $url,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_HTTPHEADER => array (
        //         'X-VALR-API-KEY: '.$apiKey,
        //         'X-VALR-SIGNATURE: '.$sig,
        //         'X-VALR-TIMESTAMP: '.$timestamp
        //     )
        // ));
        // $again_order_response = curl_exec($curl);
        // $again_order_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        // curl_close($curl);
        // return json_decode($again_order_response);  


    }

    public function get_beneficiary_wallet_amount(Request $request)
    {
        $request->validate([
            'benef_id' => 'bail|required'
        ]);
        $wallet = UserWallet::where('user_id', request()->user->user_id)->where('beneficiary_id', $request->benef_id)->orderBy('id', 'desc')->first();
        if ($wallet) return api_success('User Wallet Data', ['amount' => $wallet->final_amount]);

        return api_error('No Amount Found!', 404);
    }

    public function update_withdrawals ()
    {
        date_default_timezone_set('Africa/Johannesburg');
        $apiKey = "f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01";
        $apiSecret = "71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802";
        $user_withdrawals_orders = Withdrawal::whereRaw('`flags` & ?=?', [Withdrawal::FLAG_PROGRESS, Withdrawal::FLAG_PROGRESS])->with('user_wallet')->get();
        if ($user_withdrawals_orders) {
            foreach ($user_withdrawals_orders as $order_key => $order_value) {
                $order_obj = json_decode($order_value->order_id);
                if (empty($order_obj)) {
                    continue;
                }
                $date = date('Y-m-d');
                $time = date('H:i:s');
                $log =  print_r('-----------------------------------------------------------------------------------------------------------------', true)."\n VALR CRON JOB HIT (WITHDRAWALS):\n".PHP_EOL;
                file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                 $benef = Beneficiar::where('beneficiary_id', $order_value->beneficiary_id)->first();
                 
                 $log =  print_r('-Withdrawal Timestamp '.$date.' '.$time, true).PHP_EOL;
                 file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
         
               
                $log =  print_r('-Beneficiary Found: '.$benef->name.' '.$benef->surname, true).PHP_EOL;
                file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
    
                $log =  print_r('-Beneficiary ID Found: '.$benef->beneficiary_id, true).PHP_EOL;
                file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
    
                $log =  print_r('-Beneficiary VARL Sub-Account Name Found: '.$benef->valr_account_name, true).PHP_EOL;
                file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                $url = "https://api.valr.com/v1/simple/BTCZAR/order/".$order_obj->id;
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
                $again_order_response = curl_exec($curl);
                $again_order_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);
                //print_r($again_order_response);
                if ($again_order_response_code == '200') {
                    $found_order = json_decode($again_order_response);
                    if ($found_order->success) {
                        $bank_id = $this->get_bank_id();
                        if ($bank_id != '2') {
                          
                            $log =  print_r('-Got Bank Account ID!', true).PHP_EOL;
                            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                            $withdrawl_amount = $order_value->valr_withdrawal_total_amount_bank;
                            $withdrawl_amount = (string) $withdrawl_amount;
                            print_r($withdrawl_amount);
                            die;
                            
                            
                            if(isset($order_value) && $order_value->bank_response) {
                                $bank_transaction_result = json_decode($order_value->bank_response);
                               
                            } else {
                                $bank_transaction_result = $this->transfer_funds_from_main_account_to_bank_account($withdrawl_amount, $bank_id, $order_value->fast, $order_value->withdrawal_id);
                            }
                              
                            if ($bank_transaction_result != '2') {
                                $amount_in_btc = 0;
                                $url = "https://api.valr.com/v1/account/balances";
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
                               // print_r($beneficiary_amount_from_valr);

                                $beneficiary_amount_from_valr_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                                curl_close($curl);
                                if ($beneficiary_amount_from_valr_code == '200') {
                                    $log =  print_r('-Transfer funds from main account to bank account!', true).PHP_EOL;
                                    file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

                                    foreach(json_decode($beneficiary_amount_from_valr) as $b_key => $b_value) {
                                        if ($b_value->currency == 'BTC') {
                                            $amount_in_btc = $b_value->available;
                                            $log = print_r('-Found Beneficiary Wallet Amount and now will update the database on our system!', true).PHP_EOL;
                                            file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                            break;
                                        }
                                    }
                                   
                                     $user_wallet = UserWallet::where('user_wallet_id', $order_value->user_wallet_id)->first();
                                    if(!empty($user_wallet) && isset($user_wallet->paid_amount)){
                                        $user_wallet = $user_wallet;
                                    }else {
                                       $user_wallet = new UserWallet;
                                       $user_wallet->user_wallet_id = $order_value->user_wallet_id;
                                       $user_wallet->user_id = $order_value->user_id;
                                       $user_wallet->beneficiary_id = $order_value->beneficiary_id;
                                    }
                                   
                                    $user_wallet->paid_currency = $found_order->paidCurrency;
                                    $user_wallet->received_amount = $found_order->receivedAmount - $order_value->all_charged_fees_in_zar;
                                    $user_wallet->received_currency = $found_order->receivedCurrency;
                                    $user_wallet->fee_amount = $found_order->feeAmount;
                                    $user_wallet->fee_currency = $found_order->feeCurrency;
                                    $user_wallet->response = json_encode($found_order);
                                    $user_wallet->mode = 'withdrawal';
                                    $user_wallet->final_amount = $amount_in_btc;
                                    if ($user_wallet->save()) {
                                        $wd = Withdrawal::where('withdrawal_id', $order_value->withdrawal_id)->first();
                                        $wd->response = json_encode($found_order);
                                        $wd->removeFlag(Withdrawal::FLAG_PROGRESS);
                                        $wd->removeFlag(Withdrawal::FLAG_COMPLETED);
                                        $wd->removeFlag(Withdrawal::FLAG_FAILED);
                                        $wd->addFlag(Withdrawal::FLAG_COMPLETED);
                                        $wd->save();
                                        $log =  print_r('-----------------------------------------------------------------------------------------------------------------', true).PHP_EOL;
                                        file_put_contents(storage_path("app/public/cron-job-logs/").'/LogFile/Withdrawal_Log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                                    }
                                }
                            }
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