@include('head')
    <title>Sign Up | Crypto Gifting</title>
    <body>
        <main>
            <section class="join-wrapper">
                <div class="overlay"></div>
                <div class="main-container signup">
                    <div class="column column-img">
                        <div class="inner-wrapper">
                            <img src="{{asset('/public')}}/assets/images/web/signup-img.png" class="img-fluid signup-img">
                            <div class="slider-wrapper">
                                <img src="{{asset('/public')}}/assets/images/web/triangle.png" class="img-fluid triangle">
                                <div class="owl-carousel owl-theme signup-slider">
                                    <div class="item">
                                        <img src="{{asset('/public')}}/assets/images/web/Quote-icon-1.png" class="img-fluid quote-1">
                                        <h5>Anastasia Kondratyeva</h5>
                                        <p>
                                            This is the easiest and most user friendly crypto platform I have ever come across
                                        </p>
                                        <img src="{{asset('/public')}}/assets/images/web/Quote-icon-2.png" class="img-fluid quote-2">
                                    </div>
                                    <div class="item">
                                        <img src="{{asset('/public')}}/assets/images/web/Quote-icon-1.png" class="img-fluid quote-1">
                                        <h5>Joao Henriques</h5>
                                        <p>
                                            In just a few steps I setup an event and received Bitcoin for my birthday
                                        </p>
                                        <img src="{{asset('/public')}}/assets/images/web/Quote-icon-2.png" class="img-fluid quote-2">
                                    </div>
                                    <div class="item">
                                        <img src="{{asset('/public')}}/assets/images/web/Quote-icon-1.png" class="img-fluid quote-1">
                                        <h5>Sevi Spanoudi</h5>
                                        <p>
                                            sending or receiving crypto without complicating processes...super straigh forward
                                        </p>
                                        <img src="{{asset('/public')}}/assets/images/web/Quote-icon-2.png" class="img-fluid quote-2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column column-form">
                        <a href="{{route('Index')}}" class="heading-anchor">
                            <h1>CryptoGifting</h1>
                        </a>
                        <div class="form-wrapper">

                            <form class="multi-step-form">
                                <input type="hidden" name="user_email" id="user-email" value="{{$user->email}}">
                                <fieldset class="mb-0 mb-lg-4">
                                    <div class="form-card">
                                        <h2>Your mobile number?</h2>
                                        <p class="p1 text-center">We will use it to send you security alerts</p>
                                        <div class="input-wrapper">
                                            <div class="input-box">
                                                <input id="user-phone" name="phone" type="tel" class="form-control" placeholder="Ex: 122233344">
                                            </div>
                                            <img src="{{asset('/public')}}/assets/images/web/check-icon.png" class="img-fluid" width="20px">
                                        </div>
                                    </div>
                                    <!-- <button type="button" class="previous btn"><i
                                            class="fas fa-long-arrow-alt-left"></i></button> -->
                                    <button type="button" class="btn orange-button" id="add-phone">next</button>
                                    <button type="button" class="btn next orange-button phone-next-button" style="display:none !important;"></button>
                                </fieldset>
                                <!-- Step 3 End -->

                                <fieldset>
                                    <div class="form-card">
                                        <h2>check your sms</h2>
                                        <p class="p1">Enter the 4-digit code we sent to <a href="#" id="sent-phone-number"></a> to
                                            confirm your number
                                        </p>
                                        <div class="input-wrapper pin-code">
                                            <input type="text" class="form-control" maxlength="1" required oninput="this.value=this.value.replace(/[^0-9]/g,'');" onkeyup="movetoNext(this, 'code-2')" id="code-1">
                                            <input type="text" class="form-control" maxlength="1" required oninput="this.value=this.value.replace(/[^0-9]/g,'');" onkeyup="movetoNext(this, 'code-3')" id="code-2">
                                            <input type="text" class="form-control" maxlength="1" required oninput="this.value=this.value.replace(/[^0-9]/g,'');" onkeyup="movetoNext(this, 'code-4')" id="code-3">
                                            <input type="text" class="form-control" maxlength="1" required oninput="this.value=this.value.replace(/[^0-9]/g,'');" id="code-4">
                                        </div>
                                    </div>
                                    <button type="button" class="previous btn"><i
                                            class="fas fa-long-arrow-alt-left"></i></button>
                                    <button type="button" class="btn orange-button" id="verify-phone-number">verify</button>
                                    <a href="#" id="resend-code" class="resend mb-0 mb-md-5">resend code</a>
                                </fieldset>
                                <!-- Step 4 End -->
                            </form>
                            <p class="p2">Already have an account? <a href="{{route('SignIn')}}">Sign In</a></p>

                        </div>
                    </div>

                </div>
            </section>
        </main>
        <div id="preloader" class="d-none"></div>
        <script src="{{asset('/public')}}/assets/js/custom-js.js"></script>
        <script src="{{asset('/public')}}/assets/js/custom-select.js"></script>
        <script src="{{asset('/public')}}/assets/js/multi-step-form.js"></script>
        <script>
            function movetoNext(current, nextFieldID) {
                if (current.value.length >= current.maxLength) {
                    document.getElementById(nextFieldID).focus();
                }
            }
            jQuery(document).ready(function ($) {
                var input = document.querySelector("#user-phone");
                window.intlTelInput(input);

                $('#add-phone').on('click', function (e) {
                    e.preventDefault();
                    var email = $('#user-email').val();
                    var phoneNumber = $("#user-phone").val();
                    var countryCodeTitle = $('.iti__selected-flag').attr('title');
                    var countryCode = countryCodeTitle.substring(countryCodeTitle.indexOf('+'), $('.iti__selected-flag').attr('title').length);

                    if (countryCode == '' || countryCode == undefined || phoneNumber == '' || phoneNumber == undefined) {
                        displayError('Please enter phone number correctly!');
                        return false;
                    }

                    $('#preloader').removeClass('d-none');
                    var formData = new FormData();
                    formData.append('country_code', countryCode);
                    formData.append('phone', phoneNumber);
                    formData.append('email', email);
                    formData.append('_token', "{{csrf_token()}}");

                    $.ajax({
                        url: '{{ route("AddPhone") }}',
                        type: 'POST',
                        data: formData,
                        dataType: 'JSON',
                        success: function (response) {
                            displaySuccess(response.response.message);
                            $('#sent-phone-number').html(countryCode+phoneNumber);
                            $('.phone-next-button').click();
                            $('#preloader').addClass('d-none');

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

                $('#resend-code').on('click', function (e) {
                    e.preventDefault();
                    var email = $('#user-email').val();
                    var phoneNumber = $("#user-phone").val();
                    var countryCodeTitle = $('.iti__selected-flag').attr('title');
                    var countryCode = countryCodeTitle.substring(countryCodeTitle.indexOf('+'), $('.iti__selected-flag').attr('title').length);

                    if (countryCode == '' || countryCode == undefined || phoneNumber == '' || phoneNumber == undefined) {
                        displayError('Please enter phone number correctly!');
                        return false;
                    }

                    $('#preloader').removeClass('d-none');
                    var formData = new FormData();
                    formData.append('country_code', countryCode);
                    formData.append('phone', phoneNumber);
                    formData.append('email', email);
                    formData.append('_token', "{{csrf_token()}}");

                    $.ajax({
                        url: '{{ route("ResendPhoneToken") }}',
                        type: 'POST',
                        data: formData,
                        dataType: 'JSON',
                        success: function (response) {
                            $('#code-1').val('');
                            $('#code-2').val('');
                            $('#code-3').val('');
                            $('#code-4').val('');
                            $('#code-1').focus();
                            displaySuccess(response.response.message);
                            $('#sent-phone-number').html(phoneNumber);
                            $('.phone-next-button').click();
                            $('#preloader').addClass('d-none');

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

                $('#verify-phone-number').on('click', function (e) {
                    e.preventDefault();
                    var finalCode = '';
                    var code1 = $('#code-1').val();
                    var code2 = $('#code-2').val();
                    var code3 = $('#code-3').val();
                    var code4 = $('#code-4').val();
                    if (code1 == '' || code1 == undefined || code2 == '' || code2 == undefined || code3 == '' || code3 == undefined || code4 == '' || code4 == undefined ) {
                        displayError('Please enter code correctly!');
                        return false;
                    }
                    finalCode = code1+code2+code3+code4;

                    var email = $('#user-email').val();
                    $('#preloader').removeClass('d-none');
                    var formData = new FormData();
                    formData.append('code', finalCode);
                    formData.append('email', email);
                    formData.append('_token', "{{csrf_token()}}");

                    $.ajax({
                        url: '{{ route("VerifyPhone") }}',
                        type: 'POST',
                        data: formData,
                        dataType: 'JSON',
                        success: function (response) {
                         $('#preloader').addClass('d-none');
                            displaySuccess(response.response.message);
                            setTimeout(function(){ window.location.href = response.response.detail.dashboard_url; }, 3000);

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

                $('.password-hide').on('click', function () {
                    $(this).parent().find('input').attr('type', 'password');
                    $(this).hide();
                    $('.password-display').show();
                });

                $('.password-display').on('click', function () {
                    $(this).parent().find('input').attr('type', 'text');
                    $(this).hide();
                    $('.password-hide').show();
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
        </script>
        <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/615c205dd326717cb684cfda/1fh7tsroc';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
        </script>