@include('user-dashboard.head')
    <title>Dashboard | Crypto Gifting</title>
    <script src="https://cdn.smileidentity.com/js/v1.0.0-beta.7/smart-camera-web.js"></script>    
    <body>
      <style>
          .hide {
            display: none;
            }

            .myDIV:hover + .hide {
                display: block;
                color: green;
                }
      </style>  
    <div id="preloader" class="d-none"></div>
        @include('user-dashboard.user-dashboard-header')
        <?php
            $total_btc_amount = 0;
            $total_amount_in_zar = 0;
            if ($user_wallet) {
                $total_btc_amount = $user_wallet;
                $total_amount_in_zar = (Double) $total_btc_amount * $btc_rate;
            }
            $avaliable_banks = array(
                "ABSA",
                "Standard Bank",
                "First National Bank",
                "NEDBANK",
                "CAPITEC",
                "INVESTEC",
                "TYME BANK",
                "AFRICAN BANK",
                "BIDVEST BANK",
                "OLD MUTUAL BANK"
            );

            $avaliable_accounts = array(
                "Current (cheque/bond) Account",
                "Savings Account",
                "Transmission Account",
                "Bond Account",
                "Subscription Share Account",
                "Fnbcard Account",
                "WesBank"
            );
        ?>
        <div class="main-content">
            <div class="overlay">
                <div class="main-heading-box flex">
                    <h1 style="color:#1947A1;" class="main-heading">Wallet</h1>
                    <?php if ($bank_found) { ?>
                        <div class="two-button-box m-0 justify-content-end" style="max-width: 400px">
                        </div>
                    <?php } ?>
                </div>
                <div class="text-center">
                    <h6 class="main-heading wallet-heading mt-2 mt-md-5 text-center">Combined wallet value</h6>
                </div>
                <h1 class="currency-heading">ZAR <?php echo number_format($total_amount_in_zar, 2); ?></h1>
                <div class="wallet-transactions-wrapper-wallets mt-0 mt-sm-3 mt-lg-5 px-0">
                    <div class="butttons-wrapper mb-3 mb-lg-5 myDIV">
                        <span></span>
                        
                        <?php if (!request()->user->approved_selfie) { ?>
                            <a href="{{route('RegisterFirstSmileKYC')}}" class="btn blue-button withdraw-button">withdraw</a>

                        <?php } else if(!$bank_found) { ?>
                            <a href="{{route('CreateBankAccount')}}" class="btn blue-button withdraw-button">withdraw</a>
                            
                        <?php //} else if(isset($request_withdrawal->process)  && $request_withdrawal->process== "1" ) { ?>
                                    <!-- <button disabled data-bs-toggle="modal" class="btn blue-button withdraw-button">withdraw</button>
                                    <div class="hide">Your Request still in progress, please wait for the request again</div> -->
                        <?php } else { ?>
                            <a href="#withdraw-final--popup" data-bs-toggle="modal" class="btn blue-button withdraw-button">withdraw</a>

                        <?php } ?>
                    </div>
                    
                    <a href="{{--route('ZarWallet')--}}" class="btn currency-btn">
                        <div class="icon-box">
                            <img src="{{asset('/public')}}/assets/images/dashboard/currency-south-africa.png" class="img-fluid">
                        </div>
                        <h5 class="currency-title">ZAR Wallet (Rands)</h5>
                        <div class="spot-wallet wallet-type">
                            <h6>ZAR Spot Wallet <i class="uil uil-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Your ZAR spot wallet shows you how much you currently hold in South African rands within your ZAR wallet"></i></h6>
                            <h2>ZAR 0.00<?php //echo $zar_spot_wallet; ?></h2>
                        </div>
                    </a>
                    <a href="{{--route('BitcoinWallet')--}}" class="btn currency-btn">
                        <div class="icon-box">
                            <img src="{{asset('/public')}}/assets/images/dashboard/currency-bitcoin.png" class="img-fluid">
                        </div>
                        <h5 class="currency-title">BTC Wallet (Bitcoin)</h5>
                        <div class="spot-wallet wallet-type">
                            <h6>BTC Spot Wallet  <i class="uil uil-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Your BTC spot wallet shows you how much you currently hold in Bitcoin within your BTC wallet"></i></h6>
                            <h2>BTC <?php echo number_format($total_btc_amount, 10); ?></h2>
                        </div>
                    </a>
                </div>
                <div class="modal fade popup-style" id="smile-popup" tabindex="-1" aria-labelledby="smile-popupLabel" aria-hidden="true">
                    <div class="modal-dialog ">
                        <div class="modal-content">
                            <div class="modal-body">
                                <img src="{{asset('public')}}/assets/images/dashboard/selfie.png" class="img-fluid image" >
                                <h5 class="popup-heading">Verify your identity</h5>
                                <form action="{{route('AuthenticationSmielKYC')}}" enctype="multipart/form-data" method="post" class="form-style text-center">
                                    @csrf
                                    <input type="hidden" class="form-control" id="sid" name="sid" value="">
                                    <div class="row">
                                        <?php if (!request()->user->first_name) { ?>
                                            <div class="col-md-6">
                                                <label for="documents-verifications" class="sr-only">First Name</label>
                                                <div class="input-group file-input">
                                                    <input type="text" required class="form-control" id="first-name" placeholder="John" name="first_name">
                                                    <label class="input-group-text" for="upload-address"><i class="uil uil-user"></i> <span>First <br>Name</span></label>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if (!request()->user->last_name) { ?>
                                            <div class="col-md-6">
                                                <label for="documents-verifications" class="sr-only">Last Name</label>
                                                <div class="input-group file-input">
                                                    <input type="text" required class="form-control" id="last-name" placeholder="Doe" name="last_name">
                                                    <label class="input-group-text" for="upload-address"><i class="uil uil-user"></i> <span>Last <br>Name</span></label>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="col-md-12">
                                            <label for="documents-verifications" class="sr-only">Documents Verification</label>
                                            <div class="input-group file-input">
                                                <input type="file" accept="image/*" required class="form-control" id="upload-address" name = "address_document">
                                                <label class="input-group-text" for="upload-address"><i class="uil uil-file-upload-alt"></i> <span>Address <br> Document</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="documents-verifications" class="sr-only">Documents Verification</label>
                                            <div class="input-group file-input">
                                                <input type="file" accept="image/*" required class="form-control" id="upload-file4" name = "bank_account">
                                                <label class="input-group-text" for="upload-file4"><i class="uil uil-file-upload-alt"></i> <span>Bank Account <br> Document</span></label>
                                            </div>
                                        </div>
                                        <?php if (!request()->user->answered_question) { ?>
                                            <div class="radio-box col-md-12">
                                                <p class="form-text">Are you a Domestic Politically Exposed Person (PEP) ?</p>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="domestic" required id="domestic1" value="yes">
                                                    <label class="form-check-label" for="domestic1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="domestic" required id="domestic2" value="no">
                                                    <label class="form-check-label" for="domestic2">No</label>
                                                </div>
                                            </div>

                                            <div class="radio-box col-md-12">
                                                <p class="form-text">Are you a Foreign Politically Exposed Person (PEP) ?</p>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="foreign" required id="oreign1" value="yes">
                                                    <label class="form-check-label" for="oreign1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="foreign" required id="oreign2" value="no">
                                                    <label class="form-check-label" for="oreign2">No</label>
                                                </div>
                                            </div>
                                            <div class="radio-box mb-2 col-md-12">
                                                <p class="form-text">I am over 18 years old?</p>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="over_eighteen_check" required id="over_eighteen1" value="yes">
                                                    <label class="form-check-label" for="over_eighteen1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="over_eighteen_check" required id="over_eighteen2" value="no">
                                                    <label class="form-check-label" for="over_eighteen2">No</label>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="col-md-12">
                                            <button class="orange-button btn mb-0">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($bank_found == true) { ?>
                    <div class="modal fade popup-style" id="withdraw-final--popup" tabindex="-1" aria-labelledby="withdraw-final--popupLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mt-0 modal-dialog-big">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h5 class="popup-heading">
                                        How much would you like to withdraw? 
                                    </h5>
                                    <form action="{{route('WithdrawalRequest')}}" id="withdrawal-request-form" method="POST" class="form-style">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="verification_code" id="verif-code-withdrawal" value="">
                                        <input type="hidden" name="accept_agreement" id="accept-agreement" value="">
                                        <div class="row">
                                            <div class="col-md-12 select-box px-0 px-md-2">
                                                <select class="form-control select-menu" id="choose-benef" name="beneficiary" required>
                                                    <option value="" disabled selected>Beneficiary</option>
                                                    <?php foreach ($beneficiaries as $benef_key => $benef_value) { ?>
                                                        <option value="{{$benef_value->beneficiary_id}}">@if($benef_value->beneficiary_id == request()->user->user_id) Self @else {{get_user_name($benef_value->beneficiary_id)}} @endif</option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 px-0 px-md-2 amount-row d-none">
                                                <div class="input-group">
                                                    <input type="text" readonly style="background-color: #fff;" id="amount" class="form-control" value="BTC">
                                                </div>
                                            </div>
                                            <div class="col-md-9 px-0 px-md-2 amount-row d-none">
                                                <div class="input-group">
                                                    <input type="number" step="any" name="withdrawal_amount" id="withdraw-amount" class="form-control" placeholder="Amount">
                                                     <button class="btn max-button" id="max-amount-button" type="button">MAX</button>
                                                </div>
                                            </div>
                                            <div class="col-md-12 px-0 px-md-2">
                                                <div class="checkbox-wrapper small-checkbox">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="withdrawal-amount-check" name="withdrawal_amount_check">
                                                        <label for="withdrawal-amount-check" class="form-check-label ms-1">Quick Withdrawal</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h6 class="sub-heading withdraw-btc-amount d-none" style="font-size: 18px;" data-total-amount="">
                                            Your Current Balance is <span class="amount"></span>
                                        </h6>
                                        <h6 class="sub-heading withdrawal-amount-container">Withdrawal Fees: <span class="withdrawal-amount">{{$valr_normal_fees}}</span> ZAR</h6>
                                        <button type="button" id="withdrawal-first-modal" class="close btn blue-button mt-3">Next</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="modal fade popup-style success-popup" id="withdraw-success-popup" tabindex="-1" aria-labelledby="withdraw-success-popupLabel" aria-hidden="true">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <img src="{{asset('/public')}}/assets/images/dashboard/zar-amico.png" class="img-fluid art-img">
                                <h1>success</h1>
                                <h4 class="mb-4">Your withdrawal was successful! Please allow for the withdrawal to reflect in your account within 48 hours. If you have any issues, please contact us via our live support on our website.</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade popup-style fees-popup" id="fees-modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered mt-0 modal-dialog-big">
                        <div class="modal-content">
                            <div class="modal-body py-4 py-md-5 text-start">
                                <form action="" class="form-style">
                                    <h3 class="heading">Order Summary (Estimated)</h3>
                                    <div class="detail mb-3">
                                        <p>Withdrawal Amount in ZAR: <span>R<span id="gift-amount"></span></span></p>
                                    </div>
                                    <div class="detail mb-3">
                                        <p>CryptoGifting Handling Fee: <span>R<span id="cg-fees"></span></span></p>
                                        <p>3rd Party Transaction Fees: <span>R<span id="other-fees"></span></span></p>
                                    </div>
                                    <div class="detail mb-3 total">
                                        <p><span>Total Amount: <br><font>(incl. VAT)</font></span><span>R<span id="final-amount"></span></span></p>
                                    </div>
                                    <div class="detail mb-3">
                                        <p>VAT <span>R<span id="vat-tax-final-amount"></span></span></p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center do-button booton-box">
                                        <button type="button" id="close-pay-now" class="btn close naye-button mx-2">Cancel</button>
                                        <button type="button" id="pay-now" class="btn naye-button mx-2">Proceed</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade popup-style fees-popup" id="insificiant-balance-model" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered mt-0 modal-dialog-big">
                        <div class="modal-content">
                            <div class="modal-body py-4 py-md-5 text-start">
                                <form action="" class="form-style">
                                    <h3 class="heading">Do not withdrawal this amount, the amount should be greater than R20 </h3>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Confirm Bank Details Popup Starts-->
                <?php if($bank_found == true) { ?>
                     <div class="modal fade popup-style" id="bank-details-confirm-modal" tabindex="-1" aria-labelledby="withdraw-final--popupLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mt-0 modal-dialog-big">
                            <div class="modal-content">
                                <div class="modal-body py-4 py-md-5">
                                    <form action="" class="form-style" style="max-width: 100%; margin: 0 auto !important">
                                        <h5 class="popup-heading mb-4">Bank Account Details</h5>
                                        <div class="row">
                                            <div class="col-md-6 px-0 px-md-2">
                                                <label for="" class="form-label" style="width: 100%; text-align: left;">Bank Name</label>
                                                <div class="input-group">

                                                    <select class="form-control select-menu" disabled id="new-bank-name" name="selected_bank" required>
                                                        <option value="" disabled selected>Choose Bank</option>
                                                        <?php foreach ($avaliable_banks as $bank_key => $bank_value) { ?>
                                                            <option value="{{$bank_value}}" <?php if ($bank_details->bank == $bank_value) echo 'selected'; ?>>{{$bank_value}}</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 px-0 px-md-2">
                                                <label for="" class="form-label" style="width: 100%; text-align: left;">Account Type</label>
                                                <div class="input-group">
                                                    <select class="form-control select-menu" disabled id="new-account-type" name="account_type" required>
                                                        <option value="" disabled selected>Choose Account Type</option>
                                                        <?php foreach ($avaliable_accounts as $account_key => $account_value) { ?>
                                                            <option value="{{$account_value}}" <?php if ($bank_details->account_type == $account_value) echo 'selected'; ?>>{{$account_value}}</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 px-0 px-md-2">
                                                <label for="" class="form-label" style="width: 100%; text-align: left;">Account Number</label>
                                                <div class="input-group">
                                                    <input type="number" disabled id="new-account-num" class="form-control" value="{{$bank_details->account_number}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 px-0 px-md-2">
                                                <label for="" class="form-label" style="width: 100%; text-align: left;">Branch Code</label>
                                                    <div class="input-group">
                                                    <input type="number" disabled id="new-branch-code" class="form-control" value="{{$bank_details->branch_code}}">
                                                </div>
                                            </div>
                                            <div class="col-md-12 px-0 px-md-2 mb-2">
                                                <div class="checkbox-wrapper small-checkbox">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="change-bank-details-check" name="withdrawal_amount_check">
                                                        <label for="change-bank-details-check" class="form-check-label ms-1">Edit Bank Details</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#" id="update-bank-info" class="btn blue-button my-3">Save</a>
                                        <div class="row">
                                            <div class="col-md-12 px-0 px-md-2 my-2">
                                                <div class="checkbox-wrapper small-checkbox">
                                                    <div class="form-check form-check-inline mb-0 me-0">
                                                        <input class="form-check-input" type="checkbox" id="acceptance" name="withdrawal_amount_check">
                                                        <label for="acceptance" class="form-check-label ms-1 text-start">
                                                            I have confirmed that these banking details are mine and accurate. I will not hold CryptoGifting liable for providing an incorrect bank account.
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 px-0 px-md-2 mb-2 d-none" id="vc-div">
                                                <div class="input-group mt-3">
                                                    <input type="number" id="verification-code" class="form-control" value="" placeholder="Verification Code">
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#" id="proceed" class="btn blue-button mt-3">Proceed</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                <!-- Confirm Bank Details Popup Ends-->
            </div>
        </div>
        </section>
        <style>
            .currency-btn h2{
                font-size: 1.7rem;
            }
            .currency-btn .wallet-type {
                max-width: 420px;
            }
            .form-style .input-group input {
                font-weight: 100;
            }
            #smile-popup .radio-box p {
                margin-left: 0px;
                margin-top: 10px;
            }
        </style>
        <!-- Daashboard Main Content Ends -->
        <script>
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
              return new bootstrap.Tooltip(tooltipTriggerEl)
            });
            jQuery(document).ready( function($) {
                var sendVerificition = false;
                var btcRate = "{{$btc_rate}}";
                var FastFees = "{{$valr_fast_fees}}";
                var NormalFees = "{{$valr_normal_fees}}";
                var FastFeesType = "{{$valr_fast_fees_type}}";
                var NormalFeesType = "{{$valr_normal_fees_type}}";

                $('#close-pay-now').on('click', function (e) {
                    $("#fees-modal").modal('hide');
                    $("#bank-details-confirm-modal").modal('show');

                });

                $('#pay-now').on('click', function (e) {
                    $("#withdraw-success-popup").modal('show');
                    $("#fees-modal").modal('hide');
                    setTimeout(function(){
                        $('#withdrawal-request-form').submit();
                        $("#withdraw-success-popup").modal('hide');
                        $('#preloader').removeClass('d-none');
                    }, 4000);

                });

                $('#acceptance').on('change', function () {
                    if ($(this).prop('checked')){
                        $('#accept-agreement').val('1');

                    } else {
                        $('#accept-agreement').val('0');

                    }
                });
                $('#proceed').on('click', function () {
                    if (!$('#acceptance').prop('checked')){
                        displayError('Please tick the checkbox first!');
                        return false;

                    }

                    if (sendVerificition) {
                        
                        var VC = $('#verification-code').val();
                        if (VC == '' || VC == undefined) {
                            displayError('Please enter Verfication code first!');
                            return false;

                        }
                        $('#verif-code-withdrawal').val($('#verification-code').val());
                        $("#bank-details-confirm-modal").modal('hide');

                        if ($('#withdrawal-amount-check').prop('checked')) {
                            var bankFeesFromDB = parseFloat(FastFees);

                        } else {
                            var bankFeesFromDB = parseFloat(NormalFees);

                        }
                        var amount = parseFloat($('#withdraw-amount').val());
                        var RateInZar = btcRate*amount;

                        var cg_withdrawal_fees = "{{$cg_withdrawal_fees}}";
                        var cg_withdrawal_fees_type = "{{$cg_withdrawal_fees_type}}";
                        var valr_taker_withdrawal_fees = "{{$valr_taker_withdrawal_fees}}";
                        var valr_taker_withdrawal_fees_type = "{{$valr_taker_withdrawal_fees_type}}";
                        var mercantile_withdrawal_fees = "{{$mercantile_withdrawal_fees}}";
                        var mercantile_withdrawal_fees_type = "{{$mercantile_withdrawal_fees_type}}";
                        var vat_tax_withdrawal_type = "{{$vat_tax_withdrawal_type}}";
                        var vat_tax_withdrawal = "{{$vat_tax_withdrawal}}";

                        var platformFeeFinal = 0.0;
                        var valrTakerFinal = 0.0;
                        var vatTaxFinal = 0.0;
                        var finalAmount = 0.0;
                        var BankFees = 0.0;
                        var thirdPartyFees = 0.0;
                        var mercantileFeesFinal = 0.0;

                        cg_withdrawal_fees = parseFloat(cg_withdrawal_fees);
                        valr_taker_withdrawal_fees = parseFloat(valr_taker_withdrawal_fees);
                        mercantile_withdrawal_fees = parseFloat(mercantile_withdrawal_fees);
                        vat_tax_withdrawal = parseFloat(vat_tax_withdrawal);
                        
                        if (cg_withdrawal_fees_type == 'percentage') {
                            platformFeeFinal = (RateInZar/100) * cg_withdrawal_fees;
                            platformFeeFinal = (platformFeeFinal + RateInZar) - RateInZar;

                        } else {
                            platformFeeFinal = cg_withdrawal_fees;

                        }
                        platformFeeFinal = parseFloat(platformFeeFinal);
                        //console.log("platformFeeFinal "+platformFeeFinal);
                        finalAmount += platformFeeFinal;

                        if (vat_tax_withdrawal_type == 'percentage') {
                            vatTaxFinal = (platformFeeFinal/ (100 + vat_tax_withdrawal) ) * vat_tax_withdrawal;
                            vatTaxFinal = (vatTaxFinal + platformFeeFinal) - platformFeeFinal;

                        } else {
                            vatTaxFinal = vat_tax_withdrawal;

                        }
                        vatTaxFinal = parseFloat(vatTaxFinal);
                     
                       // console.log("RateInZar "+RateInZar);
                       
    
                        if (valr_taker_withdrawal_fees_type == 'percentage') {
                            valrTakerFinal = valr_taker_withdrawal_fees;
                              //console.log("valr_taker_withdrawal_fees" +valr_taker_withdrawal_fees);
                            var AnotherValrMaker = (valrTakerFinal * RateInZar);
                             // console.log("AnotherValrMaker "+AnotherValrMaker);

                        } else {
                            valrTakerFinal = valr_taker_withdrawal_fees;
                            var AnotherValrMaker = (valr_taker_withdrawal_fees + RateInZar);

                        }
                        
                        
                        valrTakerFinal = parseFloat(AnotherValrMaker);
                       // console.log("valrTakerFinal "+valrTakerFinal);
                        thirdPartyFees += valrTakerFinal;
                        finalAmount += valrTakerFinal;

                        if (mercantile_withdrawal_fees_type == 'percentage') {
                            mercantileFeesFinal = (RateInZar/100) * mercantile_withdrawal_fees;
                            mercantileFeesFinal = (mercantileFeesFinal + RateInZar) - RateInZar;

                        } else {
                            mercantileFeesFinal = mercantile_withdrawal_fees;

                        }
                        mercantileFeesFinal = parseFloat(mercantileFeesFinal);
                        //console.log("mercantileFeesFinal "+mercantileFeesFinal);
                        thirdPartyFees += mercantileFeesFinal;
                        finalAmount += mercantileFeesFinal;

                        if ($('#withdrawal-amount-check').prop('checked')) {
                            if (FastFeesType == 'percentage') {
                                BankFees = (RateInZar/100) * FastFees;
                                BankFees = (BankFees + RateInZar) - RateInZar;
                            } else {
                                BankFees = FastFees;

                            }
                        } else {
                            if (NormalFeesType == 'percentage') {
                                BankFees = (RateInZar/100) * NormalFees;
                                BankFees = (BankFees + RateInZar) - RateInZar;
                            } else {
                                BankFees = NormalFees;

                            }
                        }
                        BankFees = parseFloat(BankFees);
                        BankFees = parseFloat(BankFees);
                       // console.log("BankFees "+BankFees);
                        thirdPartyFees += BankFees;
                        finalAmount += BankFees;

                        var AnotherThirdPartyFees = parseFloat(thirdPartyFees);
                        AnotherThirdPartyFees = AnotherThirdPartyFees;
                        var AnotherFinalAmopunt = parseFloat(finalAmount);
                        AnotherFinalAmopunt = RateInZar.toFixed(2) - AnotherFinalAmopunt.toFixed(2);
                        if(AnotherFinalAmopunt > 0) {
                            $('#gift-amount').html(RateInZar.toFixed(2));
                            $('#cg-fees').html(platformFeeFinal.toFixed(2));
                            $('#other-fees').html(AnotherThirdPartyFees.toFixed(2));
                            $('#vat-tax-final-amount').html(vatTaxFinal.toFixed(2));
                            $('#final-amount').html(AnotherFinalAmopunt.toFixed(2));
                            $("#fees-modal").modal('show');
                        }else {
                            $("#insificiant-balance-model").modal('show');
                        }
                        

                    } else {
                        $('#accept-agreement').val('1');
                        $('#preloader').removeClass('d-none');
                        var formData = new FormData();
                        formData.append('_token', "{{csrf_token()}}");
                        formData.append('benef_id', $(this).val());
                        $.ajax({
                            url: '{{ route("SendWithdrawalVerificationCode") }}',
                            type: 'POST',
                            data: formData,
                            success: function (response) {
                                sendVerificition = true;
                                displaySuccess(response.response.message);
                                $('#preloader').addClass('d-none');
                                $('#vc-div').removeClass('d-none');
                                $('#proceed').html('Next');
                            },
                            error: function (err) {
                                $('#preloader').addClass('d-none');
                                $('#selfie-modal').modal('hide');
                                if (err.status == 422) {
                                    displayError(err.responseJSON.errors, false);
                                } else {
                                    displayError(err.responseJSON.error.message);
                                }
                            },
                            async: true,
                            cache: false,
                            contentType: false,
                            processData: false,
                            timeout: 60000
                        });
                    }
                });

                $('#update-bank-info').on('click', function (e) {
                    e.preventDefault();
                    var newBank = $('#new-bank-name').val();
                    var newAccountType = $('#new-account-type').val();
                    var newAccNum = $('#new-account-num').val();
                    var newBranchCode = $('#new-branch-code').val();
                    if (newBank == '' || newAccountType == '' || newAccNum == '' ||newBranchCode == '') {
                        displayError('Oops, it seem as though you have not finished completing the form');
                        return false;
                    }
                    $('#preloader').removeClass('d-none');
                    var formData = new FormData();
                    formData.append('_token', "{{csrf_token()}}");
                    formData.append('bank', newBank);
                    formData.append('account_type', newAccountType);
                    formData.append('account_number', newAccNum);
                    formData.append('branch_code', newBranchCode);
                    $.ajax({
                        url: '{{ route("StoreBankDetailAjax") }}',
                        type: 'POST',
                        data: formData,
                        success: function (response) {
                            $('#preloader').addClass('d-none');
                            displaySuccess(response.response.message);
                            
                        },
                        error: function (err) {
                            $('#preloader').addClass('d-none');
                            $('#selfie-modal').modal('hide');
                            if (err.status == 422) {
                                displayError(err.responseJSON.errors, false);
                            } else {
                                displayError(err.responseJSON.error.message);
                            }
                            $('.withdraw-btc-amount').attr('data-total-amount', '0');
                            $('.withdraw-btc-amount').find('span.amount').html('0');
                        },
                        async: true,
                        cache: false,
                        contentType: false,
                        processData: false,
                        timeout: 60000
                    });
                });
                $('#change-bank-details-check').on('change', function () {
                    if ($(this).prop('checked')){
                        $('#new-bank-name').removeAttr('disabled');
                        $('#new-account-type').removeAttr('disabled');
                        $('#new-account-num').removeAttr('disabled');
                        $('#new-branch-code').removeAttr('disabled');
                        $('#new-account-num').addClass('bg-white');
                        $('#new-branch-code').addClass('bg-white');

                    } else {
                        $('#new-bank-name').attr('disabled', true);
                        $('#new-account-type').attr('disabled', true);
                        $('#new-account-num').attr('disabled', true);
                        $('#new-branch-code').attr('disabled', true);
                        $('#new-account-num').removeClass('bg-white');
                        $('#new-branch-code').removeClass('bg-white');

                    }
                });

                $('#withdrawal-first-modal').on('click', function (e) {
                    var benef = $('#choose-benef').val();
                    var amount = $('#withdraw-amount').val();
                    if (benef == '' || benef == undefined || amount == '' || amount == undefined) {
                        displayError('Oops, it seem as though you have not finished completing the form');
                        return false;
                    }
                    $('#withdraw-final--popup').modal('hide');
                    $('#bank-details-confirm-modal').modal('show');
                });
                $('#withdrawal-amount-check').on('change', function (e) {
                    if ($(this).prop('checked')){
                        $('.withdrawal-amount-container').find('span').html(FastFees);

                    } else {
                        $('.withdrawal-amount-container').find('span').html(NormalFees);
                    }
                });
                $('#max-amount-button').on('click', function () {
                    $('#withdraw-amount').val($('.withdraw-btc-amount').attr('data-total-amount'));

                });
                $('#choose-benef').on('change', function () {
                    if ($(this).val() == '' ) {
                        return false;

                    }
                    $('#preloader').removeClass('d-none');
                    $('.withdraw-btc-amount').addClass('d-none');
                    $('.amount-row').addClass('d-none');
                    var formData = new FormData();
                    formData.append('_token', "{{csrf_token()}}");
                    formData.append('benef_id', $(this).val());
                    $.ajax({
                        url: '{{ route("GetBeneficiaryWalletAmount") }}',
                        type: 'POST',
                        data: formData,
                        success: function (response) {
                            $('#preloader').addClass('d-none');
                            $('#withdraw-amount').val('');
                            $('.withdraw-btc-amount').attr('data-total-amount', response.response.detail.amount);
                            $('.withdraw-btc-amount').find('span.amount').html(response.response.detail.amount);
                            $('.amount-row').removeClass('d-none');
                            $('.withdraw-btc-amount').removeClass('d-none');
                        },
                        error: function (err) {
                            $('#preloader').addClass('d-none');
                            $('#selfie-modal').modal('hide');
                            if (err.status == 422) {
                                displayError(err.responseJSON.errors, false);
                            } else {
                                displayError(err.responseJSON.error.message);
                            }
                            $('.withdraw-btc-amount').attr('data-total-amount', '0');
                            $('.withdraw-btc-amount').find('span.amount').html('0');
                        },
                        async: true,
                        cache: false,
                        contentType: false,
                        processData: false,
                        timeout: 60000
                    });
                });

                var  app = document.querySelector('smart-camera-web');
                $(app).on('imagesComputed ', function(customEvent, originalEvent, data) {
                    $('#preloader').removeClass('d-none');
                    var formData = new FormData();
                    formData.append('_token', "{{csrf_token()}}");
                    $.map(customEvent.detail.images, function(value, index) {
                        if (value.image_type_id == 2) {
                            formData.append('images', value.image);
                        }
                    });
                    $.ajax({
                        url: '{{ route("AuthenticateSelfieUpload") }}',
                        type: 'POST',
                        data: formData,
                        success: function (response) {
                            $('#preloader').addClass('d-none');
                            displaySuccess('Selfie has been successfully added! Now provide some further info kindly');
                            $('#selfie-modal').modal('hide');
                            $('#smile-popup').modal('show');
                            $('#sid').val(response.response.detail.sid);
                        },
                        error: function (err) {
                            $('#preloader').addClass('d-none');
                            $('#selfie-modal').modal('hide');
                            if (err.status == 422) {
                                displayError(err.responseJSON.errors, false);
                            } else {
                                displayError(err.responseJSON.error.message);
                            }
                        },
                        async: true,
                        cache: false,
                        contentType: false,
                        processData: false,
                        timeout: 60000
                    });        
                });
                function displaySuccess(message) {
                    var html = ''
                    html += '<div class="alert custom-alert alert-success d-flex align-items-center" role="alert">';
                    html += '<ul>';
                    html += '<li><i class="uil uil-check-circle"></i>'+message+'</li>';
                    html += '</ul>';
                    html += '</div>';
                    $('body').append(html);
                    setTimeout(function(){ $('body').find('div.alert.custom-alert').remove(); }, 10000);
                }
                function displayError(message, single = true) {
                    var html = ''
                    html += '<div class="alert custom-alert alert-danger d-flex align-items-center" role="alert">';
                    html += '<ul>';

                    if (single) {
                        html += '<li><i class="uis uis-exclamation-triangle"></i>'+message+'</li>';

                    } else {
                        $.each(message, function(index, value){
                            html += '<li><i class="uis uis-exclamation-triangle"></i>'+value+'</li>';
                        });

                    }

                    html += '</ul>';
                    html += '</div>';
                    $('body').append(html);
                    setTimeout(function(){ $('body').find('div.alert.custom-alert').remove(); }, 5000);
                }
            });
        </script>
    </main>
@include('user-dashboard.footer')