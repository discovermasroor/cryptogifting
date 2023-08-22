@include('user-dashboard.head')
    <title>Allocate Gifts | Dashboard</title>
    <?php
        $fees = \App\Models\Setting::where('keys', 'platform_fee')->first();
        $valr_transaction_fees = \App\Models\Setting::where('keys', 'valr_transaction_fees')->first();
        $vat_tax = \App\Models\Setting::where('keys', 'vat_tax')->first();
        $second_fees = \App\Models\Setting::where('keys', 'other_platform_fee')->first();
    ?>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content crypto-gift-page gifter-flow">
                <div class="overlay">
                    <div class="gift-box">
                        <h4 class="heading gifter-flow-heading"> How much would you like to Gift?</h4>
                        <div class="data">
                            <img src="{{asset('public/')}}/assets/images/dashboard/gift-box-1.png" class="img-fluid gift-box-img">
                            <form style="display:none" id="#payment-form" style="margin-top: 50px">
                                @csrf
                                <div class="text-center">
                                    <button id="pay-button" class="btn btn-primary btn-sx" type="button" data-payment-key="">Pay</button>
                                </div>
                            </form>
                            <form id="gift-form" action="{{route('StoreEventInvitation', [$event->event_id])}}" method="post" class="gift-form form-style">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="ethirium_allocation" value="">
                                <input type="hidden" name="gift_type_allocation" value="amount">
                                <div class="gift-amount">
                                    <span>Popular Amounts</span>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input popular-amount" type="radio" name="popular_amount" id="amount-4"
                                            value="1000">
                                        <label class="form-check-label" for="amount-4">R1000</label>
                                    </div>
                                    
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input popular-amount" type="radio" name="popular_amount" id="amount-3"
                                            value="500">
                                        <label class="form-check-label" for="amount-3">R500</label>
                                    </div>
                                    
                                    
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input popular-amount" type="radio" name="popular_amount" id="amount-2"
                                            value="250">
                                        <label class="form-check-label" for="amount-2">R250</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input popular-amount" type="radio" name="popular_amount" id="amount-1"
                                            value="100">
                                        <label class="form-check-label" for="amount-1">R100</label>
                                    </div>
                                    
                                </div>
                                <div class="custom-row" style="margin-bottom: 10px;">
                                    <div class="column column-1">
                                        <label for="">
                                            Gift Amount
                                        </label>
                                    </div>
                                    <div class="column column-2">
                                        <input type="number" class="form-control" name="gift_amount" id="gift_amount" placeholder="Enter Gift Amount">
                                    </div>
                                </div>
                                <div class="custom-row" style="margin-bottom: 90px;">
                                    <div class="column column-1">
                                        <label for="">BTC Amount</label>
                                    </div>
                                    <div class="column column-2">
                                    <input type="text" disabled name="gift_btc_amount" id="gift_btc_amount" placeholder="0" style="width: 100%;">
                                    </div>
                                </div>
                                <div class="checkboxes">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input gift-type" type="radio" name="gift_type" id="gift-allocation1"
                                            value="own_gift">
                                        <label class="form-check-label" for="gift-allocation1">I will give my own
                                            gift</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input gift-type" type="radio" name="gift_type" id="gift-allocation2"
                                            value="no_gift">
                                        <label class="form-check-label" for="gift-allocation2">I will give no
                                            gift</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="two-button-box mt-5 gifter-button">
                            <button type="button" class="blue-button btn" id="pay-user-next">Next</button>
                        </div>
                    </form>
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
                                        <p>CG Platform Fee: <span><span id="cg-fees">{{$fees->values}}</span>%</span></p>
                                        <p>Other Platform Fee: <span><span id="other-fees">{{$second_fees->values}}</span>%</span></p>
                                        <p>Transaction Fee: <span>R<span id="valr-tran-fees">{{$valr_transaction_fees->values}}</span></span></p>
                                    </div>
                                    <div class="detail mb-3">
                                        <p><span>VAT (<font id="vat-tax-amount">{{$vat_tax->values}}</font>%)</span><span>R<span id="vat-tax-final-amount"></span></span></p>
                                    </div>
                                    
                                    <div class="detail mb-3 total">
                                        <p><span>Total Amount: <br><font>(incl. VAT)</font></span><span>R<span id="final-amount"></span></span></p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center do-button">
                                        <button type="button" data-bs-dismiss="modal" class="btn close naye-button mx-2">Cancel</button>
                                        <button type="button" id="pay-now" class="btn naye-button mx-2">Proceed</button>
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fees Charges Popup Ends-->
            </div>
        </section>
    </main>
    <style>
        #gift_btc_amount{
            background-color: white !important;
            opacity: 1 !important;
        }
        p.info-tag{
            color: #fff;
            font-size: clamp(10px, 1vw, 13px);
            line-height: 1;
            width: 100%;
            max-width: 90%;
            margin: 0px 0 -10px;
            text-align: left;
        }
    </style>
    <script type="text/javascript" src="https://services.callpay.com/ext/checkout/v3/checkout.js" id="og-checkout" data-origin="https://services.callpay.com"></script>
    <script>
        jQuery(document).ready(function ($) {
            var btcRate = "{{$btc_rate}}";
            $('#pay-user-next').on('click', function(e) {
                if (!$("#gift-allocation1").prop("checked") && !$("#gift-allocation2").prop("checked")) {
                    var givenAmount = parseFloat($('#gift_amount').val());
                    if (givenAmount == '' || givenAmount == undefined) {
                        displayError('Enter amount correctly!');
                        return false;
                    }

                    $('#gift-amount').html(givenAmount);
                    var cgFees = parseFloat($('#cg-fees').html());
                    var otherFees = parseFloat($('#other-fees').html());
                    var valrTransFees = parseFloat($('#valr-tran-fees').html());
                    var VATTax = parseFloat($('#vat-tax-amount').html());
                    var totalFees = cgFees + otherFees;
                    var anotherTotalFees = (givenAmount/100) * totalFees;
                    var AgainFinalAmount = (anotherTotalFees + givenAmount) - givenAmount;
                    var LetsTest = (AgainFinalAmount/100) * VATTax;
                    var FinalAmountWithVatTax = AgainFinalAmount-LetsTest;
                    var finalAmountAfterDeductingVATTax = AgainFinalAmount - FinalAmountWithVatTax;
                    var finalAmount = anotherTotalFees + (givenAmount + valrTransFees + finalAmountAfterDeductingVATTax);
                    $('#vat-tax-final-amount').html(finalAmountAfterDeductingVATTax.toFixed(2));
                    $('#final-amount').html(finalAmount.toFixed(2));
                    $('#fees-modal').modal('show');
                } else {
                    $('#gift-form').submit();

                }
            });

            $('#gift_amount').on('change keyup', function () {
                var givenAmount = $(this).val();
                var result = givenAmount/btcRate;
                result = result.toFixed(10);
                $('#gift_btc_amount').val(result);
            });
            $('.popular-amount').on('click', function () {
                $('input[name="gift_type_allocation"]').val('amount');
                $('#gift_amount').val($(this).val());
                $('.gift-type').prop('checked', false);
                $('#gift_amount').val($(this).val());
                var result = $(this).val()/btcRate;
                result = result.toFixed(10);
                $('#gift_btc_amount').val(result);
            });
            $('#gift_amount').on('click', function () {
                $('.popular-amount').prop('checked', false);
                $('input[name="gift_type_allocation"]').val('amount');
                $('.gift-type').prop('checked', false);
            });

            $('.gift-type').on('click', function () {
                $('#gift_amount').val('');
                $('.popular-amount').prop('checked', false);
                $('input[name="gift_type_allocation"]').val($(this).val());
            });

            $('#pay-now').on('click', function(e) {
                if (!$("#gift-allocation1").prop("checked") && !$("#gift-allocation2").prop("checked")) {
                    e.preventDefault();
                    var gift_amount = $('#gift_amount').val();
                    var formData = new FormData();
                    formData.append('gift_amount', gift_amount);
                    formData.append('event_id', "{{$event->event_id}}");
                    formData.append('_token', "{{csrf_token()}}");
                    $('#preloader').removeClass('d-none');
                    $.ajax({
                        url: '{{route("GiftAmountDashboard")}}',
                        type: 'POST',
                        data: formData,
                        dataType: 'JSON',
                        success: function (response) {
                            $('#pay-button').attr('data-payment-key', response.response.detail.payment_key);
                            $('#pay-button').click();
                            $('#preloader').addClass('d-none');
                            $('#fees-modal').modal('hide');
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
                } else {
                    $('#gift-form').submit();

                }
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
                        jQuery('#preloader').addClass('d-none');
                        $('#pay-button').show();
                    },
                    cardOptions: {
                        rememberCard: false,
                        rememberCardDefaultValue: 0
                    },
                });
            });
        });
    </script>
@include('user-dashboard.footer')