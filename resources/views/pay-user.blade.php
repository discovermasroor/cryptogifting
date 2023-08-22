@include('head')
    <title>Send a Gift to {{ get_user_name($user_id) }} | CryptoGifting.com</title>
    <style>
        body{
            background: url({{asset('/public')}}/assets/images/web/banner-bg.png) no-repeat;
            background-size: cover;
            background-position: right center;
        }
        body .web-header,
        body header,
        .join-wrapper,
        footer{
            background: transparent !important;
        }
        .copyrights p{
            margin: 0 auto;
            padding: 15px 0;
        }
    </style>
    <body>
        @include('home-header')
        <section class="get-gift-flow">
            <div class="gift_flow">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="sec_hd">
                                How much would you like to Gift?
                                <small class="mt-0 mt-md-2">* Summary of Fees is displayed on checkout</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <form style="display:none" id="#payment-form" style="margin-top: 50px">
                                @csrf
                                <div class="text-center">
                                    <button id="pay-button" class="btn btn-primary btn-sx" type="button" data-payment-key="">Pay</button>
                                </div>
                            </form>
                            <form id="amount-form" action="" class="gift-form form-style">
                                @csrf
                                <div class="flow_2">
                                    <img src="{{asset('public')}}/assets/images/flow/crypto-gift.png" class="img-fluid for_large_screen" alt="">
                                    <img src="{{asset('public')}}/assets/images/flow/gift-box-1.png" class="img-fluid for_small_screen" alt="">
                                    <div class="flow_inner">
                                        <div class="input_wrapper">
                                            <p>Popular Amounts</p>
                                            <div class="radio_btn_wrapper">
                                                
                                                <div class="wrap">
                                                    <input type="radio" class="popular-amount" name="gift-amounts" id="R1000" value="1000">
                                                    <label for="R1000">R1000</label>
                                                </div>
                                                <div class="wrap">
                                                    <input type="radio" class="popular-amount" name="gift-amounts" id="R500" value="500">
                                                    <label for="R500">R500</label>
                                                </div>
                                                <div class="wrap">
                                                    <input type="radio" class="popular-amount" name="gift-amounts" id="R250" value="250">
                                                    <label for="R250">R250</label>
                                                </div>
                                                <div class="wrap">
                                                    <input type="radio" class="popular-amount" name="gift-amounts" id="R100" value="100">
                                                    <label for="R100">R100</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="converion_wrapper mt-4">
                                            <div>
                                                <label><span>R</span>
                                                <font>ZAR</font>
                                                </label>
                                                <div>
                                                    <input type="number" required step="any" name="gift_zar_amount" id="gift_amount" placeholder="0">
                                                    <div class="img_wrapper">
                                                        <img src="{{asset('public')}}/assets/images/flow/exchange.svg" alt=""
                                                            class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <label><span class="fab fa-btc"></span>
                                                    <font>Bitcoin</font>
                                                </label>
                                                <div>
                                                    <input type="text" disabled name="gift_btc_amount" id="gift_btc_amount" placeholder="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="extra-center">
                                    <button type="button" class="orange-button btn" id="pay-user-next">Pay</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fees Charges Popup Starts-->
            <div class="modal fade popup-style fees-popup" id="fees-modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mt-0 modal-dialog-big">
                    <div class="modal-content">
                        <div class="modal-body py-4 py-md-5 text-start">
                            <form action="" class="form-style">
                                <h3 class="heading">Order Sumary (Gifter)</h3>
                                <div class="detail mb-3">
                                    <p>Gift Amount: <span>R<span id="gift-amount"></span></span></p>
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
                                    <button type="button" data-bs-dismiss="modal" class="btn close naye-button mx-2">Cancel</button>
                                    <button type="button" id="pay-now" class="btn naye-button mx-2">Proceed</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fees Charges Popup Ends-->
        </section>
        <style>
            #gift_btc_amount{
                background-color: white !important;
                opacity: 1 !important;
            }
            .flow_inner .converion_wrapper>div label{
                width: 22%;
            }
            .orange-button{
                background-color: #fff;
                border: none !important;
                color: var(--bluee);
                font-size: 14px;
                padding: 10px 30px;
                display: block;
                width: 100%;
                max-width: 250px;
                margin: 0 auto;
                border-radius: 40px;
                font-weight: 500;
            }
        </style>
        <script type="text/javascript" src="https://services.callpay.com/ext/checkout/v3/checkout.js" id="og-checkout" data-origin="https://services.callpay.com"></script>
        <script>
            jQuery(document).ready(function($) {
                $('body #eftsecure_checkout_app').on('click', '.close-checkout', function (e) {
                });
                var btcRate = "{{$btc_rate}}";
                $('#gift_amount').on('change keyup', function () {
                    var givenAmount = $(this).val();
                    var result = givenAmount/btcRate;
                         result = result.toFixed(10);
                    $('#gift_btc_amount').val(result);
                });

                $('#pay-user-next').on('click', function (e) {
                    e.preventDefault();
                    var amount = parseFloat($('#gift_amount').val());
                    if (amount == '' || amount == undefined) {
                        displayError('Enter amount correctly!');
                        return false;

                    }
                    $('#gift-amount').html(amount);
                    var platform_fee_gift = "{{$platform_fee_gift}}";
                    var platform_fee_gift_type = "{{$platform_fee_gift_type}}";
                    var valr_maker_gifter = "{{$valr_maker_gifter}}";
                    var valr_maker_gifter_type = "{{$valr_maker_gifter_type}}";
                    var callpay_handling_fee_gifter = "{{$callpay_handling_fee_gifter}}";
                    var callpay_handling_fee_gifter_type = "{{$callpay_handling_fee_gifter_type}}";
                    var callpay_contigency_fee_gifter = "{{$callpay_contigency_fee_gifter}}";
                    var callpay_contigency_fee_gifter_type = "{{$callpay_contigency_fee_gifter_type}}";
                    var vat_tax_gift = "{{$vat_tax_gift}}";
                    var vat_tax_gift_type = "{{$vat_tax_gift_type}}";

                    var platformFeeFinal = 0.0;
                    var tptFeeFinal = 0.0;
                    var valrMakerFinal = 0.0;
                    var vatTaxFinal = 0.0;
                    var finalAmount = 0.0;
                    var AnotherCallpayHandlingFeeGifter = 0.0;
                    var AnotherCallpayContigencyFeeGifter = 0.0;

                    platform_fee_gift = parseFloat(platform_fee_gift);
                    valr_maker_gifter = parseFloat(valr_maker_gifter);
                    callpay_handling_fee_gifter = parseFloat(callpay_handling_fee_gifter);
                    callpay_contigency_fee_gifter = parseFloat(callpay_contigency_fee_gifter);
                    vat_tax_gift = parseFloat(vat_tax_gift);

                    if (platform_fee_gift_type == 'percentage') {
                        platformFeeFinal = (amount/100) * platform_fee_gift;
                        platformFeeFinal = (platformFeeFinal + amount) - amount;

                    } else {
                        platformFeeFinal = platform_fee_gift;

                    }
                    platformFeeFinal = parseFloat(platformFeeFinal);

                    if (vat_tax_gift_type == 'percentage') {
                        vatTaxFinal = (platformFeeFinal/(100 + vat_tax_gift)) * vat_tax_gift;
                        vatTaxFinal = (vatTaxFinal + platformFeeFinal) - platformFeeFinal;

                    } else {
                        vatTaxFinal = vat_tax_gift;

                    }
                    vatTaxFinal = parseFloat(vatTaxFinal);

                    if (valr_maker_gifter_type == 'percentage') {
                        valrMakerFinal = valr_maker_gifter;
                        var AnotherValrMaker = (valrMakerFinal * amount);

                    } else {
                        valrMakerFinal = valr_maker_gifter;
                        var AnotherValrMaker = (valr_maker_gifter + amount);

                    }
                    AnotherValrMaker = parseFloat(AnotherValrMaker);
                    
                    
                    var threeFeesesCombined = (platformFeeFinal);
                    finalAmount = threeFeesesCombined + amount + AnotherValrMaker;
                
                    var valrTakerPlatformFee = AnotherValrMaker + platformFeeFinal;
                    
                  

                    if (callpay_handling_fee_gifter_type == 'percentage') {
                        AnotherCallpayHandlingFeeGifter = (finalAmount/100) * callpay_handling_fee_gifter;
                        
                        AnotherCallpayHandlingFeeGifter = (AnotherCallpayHandlingFeeGifter + finalAmount) - finalAmount;

                    } else {
                        AnotherCallpayHandlingFeeGifter = callpay_handling_fee_gifter;

                    }
                    //AnotherCallpayHandlingFeeGifter = //parseFloat(AnotherCallpayHandlingFeeGifter);
                    finalAmount += AnotherCallpayHandlingFeeGifter;

                    if (callpay_contigency_fee_gifter_type == 'percentage') {
                        AnotherCallpayContigencyFeeGifter = (valrTakerPlatformFee*callpay_contigency_fee_gifter)/100;

                    } else {
                        AnotherCallpayContigencyFeeGifter = callpay_contigency_fee_gifter;

                    }
                    AnotherCallpayContigencyFeeGifter = parseFloat(AnotherCallpayContigencyFeeGifter);

                    finalAmount += AnotherCallpayContigencyFeeGifter;
                    finalAmount = parseFloat(finalAmount);
                    var finalThiredPartyAllFees = (AnotherCallpayHandlingFeeGifter + AnotherCallpayContigencyFeeGifter + AnotherValrMaker);
                    console.log('AnotherCallpayHandlingFeeGifter '+AnotherCallpayHandlingFeeGifter);
                    console.log('AnotherCallpayContigencyFeeGifter '+AnotherCallpayContigencyFeeGifter);
                    console.log('AnotherValrMaker '+AnotherValrMaker);
                    finalThiredPartyAllFees = parseFloat(finalThiredPartyAllFees);
                    
                    $('#final-amount').html(finalAmount.toFixed(2));
                    $('#cg-fees').html(platformFeeFinal.toFixed(2));
                    $('#vat-tax-final-amount').html(vatTaxFinal.toFixed(2));
                    $('#other-fees').html(finalThiredPartyAllFees.toFixed(2));
                    $('#fees-modal').modal('show');
                });

                $('.popular-amount').on('click', function () {
                    $('#gift_amount').val($(this).val());
                    var result = $(this).val()/btcRate;
                        result = result.toFixed(10);
                    $('#gift_btc_amount').val(result);
                });

                $('#pay-now').on('click', function(e){
                    e.preventDefault();
                    var gift_amount = $('#gift_amount').val();
                    var formData = new FormData();
                    formData.append('gift_amount', gift_amount);
                    formData.append('user_id', "{{$user_id}}");
                    formData.append('_token', "{{csrf_token()}}");
                    $('#preloader').removeClass('d-none');
                    $.ajax({
                        url: '{{route("giftAmount")}}',
                        type: 'POST',
                        data: formData,
                        dataType: 'JSON',
                        success: function (response) {
                            $('#pay-button').attr('data-payment-key', response.response.detail.payment_key);
                            $('#fees-modal').modal('hide');
                            $('#pay-button').click();
                        },
                        error: function (err) {
                            $('#preloader').addClass('d-none');
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

                function displaySuccess(message) {
                    var html = ''
                    html += '<div class="alert custom-alert alert-success d-flex align-items-center" role="alert">';
                    html += '<ul>';
                    html += '<li><i class="uil uil-check-circle"></i>'+message+'</li>';
                    html += '</ul>';
                    html += '</div>';
                    $('body').append(html);
                    setTimeout(function(){ $('body').find('div.alert.custom-alert').remove(); }, 5000);
                }
            });
            $(function() {
                $('#pay-button').on('click', function() {
                    $(this).hide();
                    var paymentKey = $(this).data('payment-key');
                    eftSec.checkout.settings.checkoutRedirect = true;
                    eftSec.checkout.init({
                        paymentKey: paymentKey,
                        paymentType: '3ds_redirect',
                        onLoad: function(x) {
                            $('#pay-button').show();
                            jQuery('#preloader').addClass('d-none');
                        },
                        cardOptions: {
                            rememberCard: false,
                            rememberCardDefaultValue: 0
                        },
                    });
                });
            });
        </script>
@include('footer')