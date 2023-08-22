@include('head')
    <title>Gift Crypto | Crypto Gifting</title>
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
                                <h2>You are about to Gift Crypto and change someone's life!</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 bada-form"  style="position: relative;">
                            <form action="" method="post">
                                <div class="flow_2">
                                    <img src="{{asset('public')}}/assets/images/dashboard/gift-box-new.png" class="img-fluid for_large_screen"
                                        alt="">
                                    <img src="{{asset('public')}}/assets/images/dashboard/gift-box-new-2.png" class="img-fluid for_small_screen"
                                        alt="">
                                    <div class="flow_inner">
                                        <form id="payment-form" style="margin-top: 50px; display:none">
                                            <div class="text-center d-none">
                                                <button id="pay-button" class="btn btn-primary btn-sx" type="button" data-payment-key="">Pay</button>
                                            </div>
                                        </form>
                                        <div class="yellow-gift-box">
                                            <form action="{{route('previewGift')}}" id="preview-gift-form" method="post">
                                                
                                                <div>
                                                    <label for="" class="form-label sr-only">Name</label>
                                                    <input type="text" required name="sender_name" id="sender_name" class="form-control" placeholder="What is your name?">
                                                </div>
                                                <div>
                                                    <label for="" class="form-label sr-only">Your Email</label>
                                                    <input type="email" required name="sender_email" id="sender_email" class="form-control" placeholder="What is your email address?">
                                                </div>
                                                <div>
                                                    <label for="" class="form-label sr-only">Recipient's Name</label>
                                                    <input type="text" required name="recipient_name" id="recipient_name" class="form-control" placeholder="What is the lucky recipient's name?">
                                                </div>
                                                <div>
                                                    <label for="" class="form-label sr-only">Message</label>
                                                    <textarea name="message" id="event-details" class="form-control"
                                                        placeholder="Type a message &#10;for the lucky recipient of your Crypto Gift"></textarea>
                                                    <small id='character'>280 character only</small>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="extra-center" id="new-buttons">
                                    <div>
                                        <button type="button" onclick="goBack()" class="btn white_btn">Back</button>
                                        <button type="submit" class="btn white_btn" id="next-button">Next</button>
                                    </div>
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
                        <?php 
                            $amount = session()->get('gift_zar_amount');
                            $platform_fee_gift = $platform_fee_gift;
                            $platform_fee_gift_type = $platform_fee_gift_type;
                            $valr_maker_gifter = $valr_maker_gifter;
                            $valr_maker_gifter_type = $valr_maker_gifter_type;
                            $callpay_handling_fee_gifter = $callpay_handling_fee_gifter;
                            $callpay_handling_fee_gifter_type = $callpay_handling_fee_gifter_type;
                            $callpay_contigency_fee_gifter = $callpay_contigency_fee_gifter;
                            $callpay_contigency_fee_gifter_type = $callpay_contigency_fee_gifter_type;
                            $vat_tax_gift = $vat_tax_gift;
                            $vat_tax_gift_type = $vat_tax_gift_type;

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
                            //$platformFeeFinal = number_format($platformFeeFinal, 2);
        
                            if ($vat_tax_gift_type == 'percentage') {
                                
                                $vatTaxFinal = ($platformFeeFinal/ (100 + $vat_tax_gift)) * $vat_tax_gift;
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
                            //$AnotherValrMaker = number_format($AnotherValrMaker, 2);
                            $threeFeesesCombined = ($platformFeeFinal);
                            $finalAmount = $threeFeesesCombined + $amount + $AnotherValrMaker;
                            $valrTakerPlatformFee = $AnotherValrMaker + $platformFeeFinal;

                            if ($callpay_handling_fee_gifter_type == 'percentage') {
                                $AnotherCallpayHandlingFeeGifter = ($finalAmount/100) * $callpay_handling_fee_gifter;
                                $AnotherCallpayHandlingFeeGifter = ($AnotherCallpayHandlingFeeGifter + $finalAmount) - $finalAmount;
        
                            } else {
                                $AnotherCallpayHandlingFeeGifter = $callpay_handling_fee_gifter;
        
                            }
                            //$AnotherCallpayHandlingFeeGifter = number_format($AnotherCallpayHandlingFeeGifter, 2);
                            $finalAmount += $AnotherCallpayHandlingFeeGifter;
                           

                            if ($callpay_contigency_fee_gifter_type == 'percentage') {
                                $AnotherCallpayContigencyFeeGifter = ($valrTakerPlatformFee*$callpay_contigency_fee_gifter)/100;
        
                            } else {
                                $AnotherCallpayContigencyFeeGifter = $callpay_contigency_fee_gifter;
        
                            }
                            //$AnotherCallpayContigencyFeeGifter = number_format($AnotherCallpayContigencyFeeGifter, 2);
                            $finalAmount += $AnotherCallpayContigencyFeeGifter;
                            //print_r('asdsad'.$finalAmount);
                            $finalAmount = number_format($finalAmount, 2);
                           // 
                            $finalThiredPartyAllFees = $AnotherCallpayHandlingFeeGifter + $AnotherCallpayContigencyFeeGifter + $AnotherValrMaker;
                            $finalThiredPartyAllFees = number_format($finalThiredPartyAllFees, 2);
                        ?>
                        <div class="modal-body py-4 py-md-5 text-start">
                            <form action="" class="form-style">
                            <h3 class="heading">Transaction Summary</h3>
                                <div class="detail mb-3">
                                    <p>Gift Amount: <span>R<span id="gift-amount">{{$amount}}</span></span></p>
                                </div>
                                <div class="detail mb-3">
                                    <p>CryptoGifting Handling Fee: <span>R<span id="cg-fees">{{number_format($platformFeeFinal, 2)}}</span></span></p>
                                    <p>3rd Party Transaction Fees: <span>R<span id="other-fees">{{$finalThiredPartyAllFees}}</span></span></p>
                                </div>
                                <div class="detail mb-3 total">
                                    <p><span>Total Amount: <br><font>(incl. VAT)</font></span><span>R<span id="final-amount">{{$finalAmount}}</span></span></p>
                                </div>
                                <div class="detail mb-3">
                                    <p>VAT <span>R<span id="vat-tax-final-amount">{{number_format($vatTaxFinal, 2)}}</span></span></p>
                                </div>
                                <div class="d-flex align-items-center justify-content-center do-button">
                                    <button type="button" data-bs-dismiss="modal" class="btn close naye-button mx-2">Cancel</button>
                                    <button type="button" id="preview-gift-proceed" class="btn naye-button mx-2">Proceed</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fees Charges Popup Ends-->
        </section>
    
   <script type="text/javascript" src="https://payments.avopay.co.za/ext/checkout/v3/checkout.js" id="og-checkout" data-origin="https://payments.avopay.co.za"></script>
    <script>


        jQuery(document).ready(function($) {
            function charLimit(input, maxChar) {
                var len = $(input).val().length;
                $('#character').text(len+'/'+maxChar);
                if (len > maxChar) {
                    $(input).val($(input).val().substring(0, maxChar));
                    alert('The message in your invite is longer than 280 characters. Please edit it so that it can be no longer than 280 charcaters');
                }
            }
            $(".payment-form-settings").on("load", function() {
                alert('asdasdas'); 
            });
           
            $("#event-details").on('keyup', function() {
                charLimit(this, 280); 
            });
            $('#next-button').on('click', function (e) {
                e.preventDefault();
                var message = $('#event-details').val();
                var senderName = $('#sender_name').val();
                var senderEmail = $('#sender_email').val();
                var recipientName = $('#recipient_name').val();
                if (message == '' || message == undefined || senderName == '' || senderName == undefined || senderEmail == '' || senderEmail == undefined || recipientName == '' || recipientName == undefined) {
                    displayError('Kindly add data in form properly!');
                    return false;

                }  else if (!ValidateEmail(senderEmail)) {
                    displayError('Please enter valid email!');
                    return false;

                }
                $('#fees-modal').modal('show');
            });

            $('#preview-gift-proceed').on('click', function (e) {
                e.preventDefault();
                var message = $('#event-details').val();
                var senderName = $('#sender_name').val();
                var senderEmail = $('#sender_email').val();
                var recipientName = $('#recipient_name').val();
                if (message == '' || message == undefined || senderName == '' || senderName == undefined || senderEmail == '' || senderEmail == undefined || recipientName == '' || recipientName == undefined) {
                    displayError('Kindly add data in form properly!');
                    return false;

                } else if (!ValidateEmail(senderEmail)) {
                    displayError('Please enter valid email!');
                    return false;

                }

                $('#preloader').removeClass('d-none');
                var formData = new FormData();
                formData.append('message', message);
                formData.append('sender_name', senderName);
                formData.append('sender_email', senderEmail);
                formData.append('recipient_name', recipientName);
                formData.append('_token', "{{csrf_token()}}");

                $.ajax({
                    url: '{{ route("previewGift") }}',
                    type: 'POST',
                    data: formData,
                    dataType: 'JSON',
                    success: function (response) {
                        $('#pay-button').attr('data-payment-key', response.response.detail.payment_key);
                        $('#pay-button').click();
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
            });
            $("#preview-gift-form").on('submit', function(e){
                e.preventDefault();
                var message = $('#event-details').val();
                var senderName = $('#sender_name').val();
                var senderEmail = $('#sender_email').val();
                var recipientName = $('#recipient_name').val();

                $('#preloader').removeClass('d-none');
                var formData = new FormData();
                formData.append('message', message);
                formData.append('sender_name', senderName);
                formData.append('sender_email', senderEmail);
                formData.append('recipient_name', recipientName);
                formData.append('_token', "{{csrf_token()}}");

                $.ajax({
                    url: '{{ route("previewGift") }}',
                    type: 'POST',
                    data: formData,
                    dataType: 'JSON',
                    success: function (response) {
                        $('#pay-button').attr('data-payment-key', response.response.detail.payment_key);
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

            function ValidateEmail(email) 
            {
                var re = /\S+@\S+\.\S+/;
                return re.test(email);
            }

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
        });

        function goBack()
        {
        window.history.back()
        }
    </script>
@include('footer')