<?php
    $maximum_gift_value = \App\Models\Setting::where('keys', 'maximum_gift_value')->first();
    $maximum_events = \App\Models\Setting::where('keys', 'maximum_events')->first();
    $single_gift_per_event = \App\Models\Setting::where('keys', 'single_gift_per_event')->first();
    $platform_fee_gift = \App\Models\Setting::where('keys', 'platform_fee_gift')->first();
    $platform_fee_gift_type = \App\Models\Setting::where('keys', 'platform_fee_gift_type')->first();
    $valr_maker_gifter = \App\Models\Setting::where('keys', 'valr_maker_gifter')->first();
    $valr_maker_gifter_type = \App\Models\Setting::where('keys', 'valr_maker_gifter_type')->first();
    $callpay_handling_fee_gifter = \App\Models\Setting::where('keys', 'callpay_handling_fee_gifter')->first();
    $callpay_handling_fee_gifter_type = \App\Models\Setting::where('keys', 'callpay_handling_fee_gifter_type')->first();
    $callpay_contigency_fee_gifter = \App\Models\Setting::where('keys', 'callpay_contigency_fee_gifter')->first();
    $callpay_contigency_fee_gifter_type = \App\Models\Setting::where('keys', 'callpay_contigency_fee_gifter_type')->first();
    $vat_tax_gift = \App\Models\Setting::where('keys', 'vat_tax_gift')->first();
    $vat_tax_gift_type = \App\Models\Setting::where('keys', 'vat_tax_gift_type')->first();
    $cg_withdrawal_fees = \App\Models\Setting::where('keys', 'cg_withdrawal_fees')->first();
    $cg_withdrawal_fees_type = \App\Models\Setting::where('keys', 'cg_withdrawal_fees_type')->first();
    $valr_taker_withdrawal_fees = \App\Models\Setting::where('keys', 'valr_taker_withdrawal_fees')->first();
    $valr_taker_withdrawal_fees_type = \App\Models\Setting::where('keys', 'valr_taker_withdrawal_fees_type')->first();
    $mercantile_withdrawal_fees = \App\Models\Setting::where('keys', 'mercantile_withdrawal_fees')->first();
    $mercantile_withdrawal_fees_type = \App\Models\Setting::where('keys', 'mercantile_withdrawal_fees_type')->first();
    $vat_tax_withdrawal = \App\Models\Setting::where('keys', 'vat_tax_withdrawal')->first();
    $vat_tax_withdrawal_type = \App\Models\Setting::where('keys', 'vat_tax_withdrawal_type')->first();
    $valr_fast_fees = \App\Models\Setting::where('keys', 'valr_fast_fees')->first();
    $valr_fast_fees_type = \App\Models\Setting::where('keys', 'valr_fast_fees_type')->first();
    $valr_normal_fees = \App\Models\Setting::where('keys', 'valr_normal_fees')->first();
    $valr_normal_fees_type = \App\Models\Setting::where('keys', 'valr_normal_fees_type')->first();
?>
@include('admin.head')
    <title>Setting | Dashboard</title>
    <body>
        @include('admin.header-sidebar')
            <div class="main-content">
                <div class="overlay">
                    <div class="main-heading-box flex">
                        <h3>Settings</h3>
                    </div>
                    <form action="{{route('settingStore')}}" method="POST" enctype="application/x-www-form-urlencoded" class="notifications-form form-style add-beneficiary-form edit-form settings-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="maximum_events" class="form-label">Allowed maximum number of event per year</label>
                                <input type="number" step="any" class="form-control" id="maximum_events" placeholder="50" value="{{$maximum_events->values}}" name="maximum_events">
                            </div>
                            <div class="col-md-4">
                                <label for="maximum_gift_value" class="form-label">Allowed maximum worth of Gift values</label>
                                <input type="number" step="any" class="form-control" id="maximum_gift_value" placeholder="20000" value="{{$maximum_gift_value->values}}"  name="maximum_gift_value">
                            </div>
                            <div class="col-md-4 form-check-inlinae d-flex align-items-center">
                                <div class="checkbox-wrapper">
                                    <div class="form-check form-check-inline" style="max-width: 100%">
                                        <input class="form-check-input"  type="checkbox" id="single_gift_per_event" name="single_gift_per_event" <?php if ($single_gift_per_event->values == '1') echo 'checked'; ?>>
                                        <label for="name" class="form-check-label">Single Gift Per Event</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <h4 class="fees-heading-four">Gifter</h4>
                                </div>
                                <div class="row">
                                    <div class="col-4 label-column">
                                        <label class="form-label">CryptoGifting Fees</label>
                                    </div>
                                    <div class="col-4 pad-right">
                                        <input type="number" step="any" value="{{$platform_fee_gift->values}}" id="platform_fee_gift" name="platform_fee_gift" class="form-control" placeholder="50">
                                    </div>
                                    <div class="col-4 pad-right">
                                        <select class="form-select" name="platform_fee_gift_type">
                                          <option value="fixed" <?php if ($platform_fee_gift_type->values == 'fixed') echo 'selected'; ?>>Fixed</option>
                                          <option value="percentage" <?php if ($platform_fee_gift_type->values == 'percentage') echo 'selected'; ?>>Percentage</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 label-column">
                                        <label class="form-label">VALR (maker)</label>
                                    </div>
                                    <div class="col-4 pad-right">
                                        <input type="number" step="any" value="{{$valr_maker_gifter->values}}" id="valr_maker_gifter" name="valr_maker_gifter" class="form-control" placeholder="50">
                                    </div>
                                    <div class="col-4 pad-right">
                                        <select class="form-select" name="valr_maker_gifter_type">
                                          <option value="fixed" <?php if ($valr_maker_gifter_type->values == 'fixed') echo 'selected'; ?>>Fixed</option>
                                          <option value="percentage" <?php if ($valr_maker_gifter_type->values == 'percentage') echo 'selected'; ?>>Percentage</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 label-column">
                                        <label class="form-label">Call Pay Handling Fee</label>
                                    </div>
                                    <div class="col-4 pad-right">
                                        <input type="number" step="any" value="{{$callpay_handling_fee_gifter->values}}" id="callpay_handling_fee_gifter" name="callpay_handling_fee_gifter" class="form-control" placeholder="50">
                                    </div>
                                    <div class="col-4 pad-right">
                                        <select class="form-select" name="callpay_handling_fee_gifter_type">
                                          <option value="fixed" <?php if ($callpay_handling_fee_gifter_type->values == 'fixed') echo 'selected'; ?>>Fixed</option>
                                          <option value="percentage" <?php if ($callpay_handling_fee_gifter_type->values == 'percentage') echo 'selected'; ?>>Percentage</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 label-column">
                                        <label class="form-label">Call Pay Contigency</label>
                                    </div>
                                    <div class="col-4 pad-right">
                                        <input type="number" step="any" value="{{$callpay_contigency_fee_gifter->values}}" id="callpay_contigency_fee_gifter" name="callpay_contigency_fee_gifter" class="form-control" placeholder="50">
                                    </div>
                                    <div class="col-4 pad-right">
                                        <select class="form-select" name="callpay_contigency_fee_gifter_type">
                                          <option value="fixed" <?php if ($callpay_contigency_fee_gifter_type->values == 'fixed') echo 'selected'; ?>>Fixed</option>
                                          <option value="percentage" <?php if ($callpay_contigency_fee_gifter_type->values == 'percentage') echo 'selected'; ?>>Percentage</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 label-column">
                                        <label class="form-label">Vat</label>
                                    </div>
                                    <div class="col-4 pad-right">
                                        <input type="number" step="any" value="{{$vat_tax_gift->values}}" id="vat_tax_gift" name="vat_tax_gift" class="form-control" placeholder="50">
                                    </div>
                                    <div class="col-4 pad-right">
                                        <select class="form-select" name="vat_tax_gift_type">
                                          <option value="fixed" <?php if ($vat_tax_gift_type->values == 'fixed') echo 'selected'; ?>>Fixed</option>
                                          <option value="percentage" <?php if ($vat_tax_gift_type->values == 'percentage') echo 'selected'; ?>>Percentage</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <h4 class="fees-heading-four">Withdrawal</h4>
                                </div>
                                <div class="row">
                                    <div class="col-4 label-column">
                                        <label class="form-label">CryptoGifting Fees</label>
                                    </div>
                                    <div class="col-4 pad-right">
                                        <input type="number" step="any" value="{{$cg_withdrawal_fees->values}}" id="cg_withdrawal_fees" name="cg_withdrawal_fees" class="form-control" placeholder="50">
                                    </div>
                                    <div class="col-4 pad-right">
                                        <select class="form-select" name="cg_withdrawal_fees_type">
                                          <option value="fixed" <?php if ($cg_withdrawal_fees_type->values == 'fixed') echo 'selected'; ?>>Fixed</option>
                                          <option value="percentage" <?php if ($cg_withdrawal_fees_type->values == 'percentage') echo 'selected'; ?>>Percentage</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 label-column">
                                        <label class="form-label">VALR (taker)</label>
                                    </div>
                                    <div class="col-4 pad-right">
                                        <input type="number" step="any" value="{{$valr_taker_withdrawal_fees->values}}" id="valr_taker_withdrawal_fees" name="valr_taker_withdrawal_fees"  class="form-control" placeholder="50">
                                    </div>
                                    <div class="col-4 pad-right">
                                        <select class="form-select" name="valr_taker_withdrawal_fees_type">
                                          <option value="fixed" <?php if ($valr_taker_withdrawal_fees_type->values == 'fixed') echo 'selected'; ?>>Fixed</option>
                                          <option value="percentage" <?php if ($valr_taker_withdrawal_fees_type->values == 'percentage') echo 'selected'; ?>>Percentage</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 label-column">
                                        <label class="form-label">VALR (Normal withdrawl)</label>
                                    </div>
                                    <div class="col-4 pad-right">
                                        <input type="number" step="any" value="{{$valr_normal_fees->values}}" id="valr_normal_fees" name="valr_normal_fees"  class="form-control" placeholder="50">
                                    </div>
                                    <div class="col-4 pad-right">
                                        <select class="form-select" name="valr_normal_fees_type">
                                          <option value="fixed" <?php if ($valr_normal_fees_type->values == 'fixed') echo 'selected'; ?>>Fixed</option>
                                          <option value="percentage" <?php if ($valr_normal_fees_type->values == 'percentage') echo 'selected'; ?>>Percentage</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 label-column">
                                        <label class="form-label">VALR (Fast withdrawl)</label>
                                    </div>
                                    <div class="col-4 pad-right">
                                        <input type="number" step="any" value="{{$valr_fast_fees->values}}" id="valr_fast_fees" name="valr_fast_fees"  class="form-control" placeholder="50">
                                    </div>
                                    <div class="col-4 pad-right">
                                        <select class="form-select" name="valr_fast_fees_type">
                                          <option value="fixed" <?php if ($valr_fast_fees_type->values == 'fixed') echo 'selected'; ?>>Fixed</option>
                                          <option value="percentage" <?php if ($valr_fast_fees_type->values == 'percentage') echo 'selected'; ?>>Percentage</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 label-column">
                                        <label class="form-label">Mercantile (EFT Fee)</label>
                                    </div>
                                    <div class="col-4 pad-right">
                                        <input type="number" step="any" value="{{$mercantile_withdrawal_fees->values}}" id="mercantile_withdrawal_fees" name="mercantile_withdrawal_fees" class="form-control" placeholder="50">
                                    </div>
                                    <div class="col-4 pad-right">
                                        <select class="form-select" name="mercantile_withdrawal_fees_type">
                                          <option value="fixed" <?php if ($mercantile_withdrawal_fees_type->values == 'fixed') echo 'selected'; ?>>Fixed</option>
                                          <option value="percentage" <?php if ($mercantile_withdrawal_fees_type->values == 'percentage') echo 'selected'; ?>>Percentage</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 label-column">
                                        <label class="form-label">Vat</label>
                                    </div>
                                    <div class="col-4 pad-right">
                                        <input type="number" step="any" value="{{$vat_tax_withdrawal->values}}" id="vat_tax_withdrawal" name="vat_tax_withdrawal"  class="form-control" placeholder="50">
                                    </div>
                                    <div class="col-4 pad-right">
                                        <select class="form-select" name="vat_tax_withdrawal_type">
                                          <option value="fixed" <?php if ($vat_tax_withdrawal_type->values == 'fixed') echo 'selected'; ?>>Fixed</option>
                                          <option value="percentage" <?php if ($vat_tax_withdrawal_type->values == 'percentage') echo 'selected'; ?>>Percentage</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn blue-button">Update Setting</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <style>
        .notifications-form {
            max-width: 60%; 
        }
    </style>
@include('admin.footer')