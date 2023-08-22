<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.setting.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'maximum_events' => 'bail|required',
            'maximum_gift_value' => 'bail|required',
            'platform_fee_gift' => 'bail|required',
            'platform_fee_gift_type' => 'bail|required',
            'valr_maker_gifter' => 'bail|required',
            'valr_maker_gifter_type' => 'bail|required',
            'callpay_handling_fee_gifter' => 'bail|required',
            'callpay_handling_fee_gifter_type' => 'bail|required',
            'callpay_contigency_fee_gifter' => 'bail|required',
            'callpay_contigency_fee_gifter_type' => 'bail|required',
            'vat_tax_gift' => 'bail|required',
            'vat_tax_gift_type' => 'bail|required',
            'cg_withdrawal_fees' => 'bail|required',
            'cg_withdrawal_fees_type' => 'bail|required',
            'valr_taker_withdrawal_fees' => 'bail|required',
            'valr_taker_withdrawal_fees_type' => 'bail|required',
            'mercantile_withdrawal_fees' => 'bail|required',
            'mercantile_withdrawal_fees_type' => 'bail|required',
            'vat_tax_withdrawal' => 'bail|required',
            'vat_tax_withdrawal_type' => 'bail|required',
            'valr_fast_fees' => 'bail|required',
            'valr_normal_fees' => 'bail|required',
            'valr_fast_fees_type' => 'bail|required',
            'valr_normal_fees_type' => 'bail|required',
        ]);
        $setting = Setting::where('keys','maximum_events')->first();
        $setting->values = $request->maximum_events;
        $setting->save();

        $setting = Setting::where('keys','maximum_gift_value')->first();
        $setting->values = $request->maximum_gift_value;
        $setting->save();

        $setting = Setting::where('keys','single_gift_per_event')->first();
        $setting->values =  (!empty($request->single_gift_per_event) ? 1 : 0 );
        $setting->save();

        $setting = Setting::where('keys','platform_fee_gift')->first();
        $setting->values = $request->platform_fee_gift;
        $setting->save();

        $setting = Setting::where('keys','platform_fee_gift_type')->first();
        $setting->values = $request->platform_fee_gift_type;
        $setting->save();

        $setting = Setting::where('keys','valr_maker_gifter')->first();
        $setting->values = $request->valr_maker_gifter;
        $setting->save();

        $setting = Setting::where('keys','valr_maker_gifter_type')->first();
        $setting->values = $request->valr_maker_gifter_type;
        $setting->save();

        $setting = Setting::where('keys','callpay_handling_fee_gifter')->first();
        $setting->values = $request->callpay_handling_fee_gifter;
        $setting->save();

        $setting = Setting::where('keys','callpay_handling_fee_gifter_type')->first();
        $setting->values = $request->callpay_handling_fee_gifter_type;
        $setting->save();

        $setting = Setting::where('keys','callpay_contigency_fee_gifter')->first();
        $setting->values = $request->callpay_contigency_fee_gifter;
        $setting->save();

        $setting = Setting::where('keys','callpay_contigency_fee_gifter_type')->first();
        $setting->values = $request->callpay_contigency_fee_gifter_type;
        $setting->save();

        $setting = Setting::where('keys','vat_tax_gift')->first();
        $setting->values = $request->vat_tax_gift;
        $setting->save();

        $setting = Setting::where('keys','vat_tax_gift_type')->first();
        $setting->values = $request->vat_tax_gift_type;
        $setting->save();

        $setting = Setting::where('keys','cg_withdrawal_fees')->first();
        $setting->values = $request->cg_withdrawal_fees;
        $setting->save();

        $setting = Setting::where('keys','cg_withdrawal_fees_type')->first();
        $setting->values = $request->cg_withdrawal_fees_type;
        $setting->save();

        $setting = Setting::where('keys','valr_taker_withdrawal_fees')->first();
        $setting->values = $request->valr_taker_withdrawal_fees;
        $setting->save();

        $setting = Setting::where('keys','valr_taker_withdrawal_fees_type')->first();
        $setting->values = $request->valr_taker_withdrawal_fees_type;
        $setting->save();

        $setting = Setting::where('keys','mercantile_withdrawal_fees')->first();
        $setting->values = $request->mercantile_withdrawal_fees;
        $setting->save();

        $setting = Setting::where('keys','mercantile_withdrawal_fees_type')->first();
        $setting->values = $request->mercantile_withdrawal_fees_type;
        $setting->save();

        $setting = Setting::where('keys','vat_tax_withdrawal')->first();
        $setting->values = $request->vat_tax_withdrawal;
        $setting->save();

        $setting = Setting::where('keys','vat_tax_withdrawal_type')->first();
        $setting->values = $request->vat_tax_withdrawal_type;
        $setting->save();
        
        $valr_fast_fees = Setting::where('keys','valr_fast_fees')->first();
        if ($valr_fast_fees) {
            $valr_fast_fees->values = $request->valr_fast_fees;
            $valr_fast_fees->save();

        }

        $valr_normal_fees = Setting::where('keys','valr_normal_fees')->first();
        if ($valr_normal_fees) {
            $valr_normal_fees->values = $request->valr_normal_fees;
            $valr_normal_fees->save();

        }
        
        $valr_fast_fees_type = Setting::where('keys','valr_fast_fees_type')->first();
        if ($valr_fast_fees_type) {
            $valr_fast_fees_type->values = $request->valr_fast_fees_type;
            $valr_fast_fees_type->save();

        }

        $valr_normal_fees_type = Setting::where('keys','valr_normal_fees_type')->first();
        if ($valr_normal_fees_type) {
            $valr_normal_fees_type->values = $request->valr_normal_fees_type;
            $valr_normal_fees_type->save();

        }
        return redirect()->back()->with('req_success','Setting Has Been Updated');
    }

    public function valr_setting()
    {
        $data['settings'] = Setting::get()->toArray();
        return view('admin.setting.valr-index', $data);
    }

    public function valr_store(Request $request)
    {
         $request->validate([
            'branch_code' => 'bail|required',
            'account_number' => 'bail|required'
        ]);

        $valr_branch_code = Setting::where('keys','valr_branch_code')->first();
        if ($valr_branch_code) {
            $valr_branch_code->values = $request->branch_code;
            $valr_branch_code->save();
        }

        $valr_account_number = Setting::where('keys','valr_account_number')->first();
        if ($valr_account_number) {
            $valr_account_number->values = $request->account_number;
            $valr_account_number->save();
          
        }
        return redirect()->back()->with('req_success','Setting Has Been Updated');
    }
}