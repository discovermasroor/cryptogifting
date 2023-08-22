@include('head')
    <title>Sign Up | Crypto Gifting</title>
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
                                <!-- fieldsets -->
                                <fieldset>
                                    <div class="form-card">
                                        <h2>SIGN UP USING YOUR DETAILS</h2>
                                        <p class="p1">Sign up to organize your first occasion and receive the gift of wealth!</p>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="input-wrapper m-0">
                                                    <label for="first_name" class="form-label sr-only">First Name</label>
                                                    <input type="text" name="first_name" class=" m-0 form-control" id="first_name" placeholder="First Name"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-wrapper m-0">
                                                    <label for="last_name"  class="form-label sr-only">Last Name</label>
                                                    <input type="text" name="last_name" class=" m-0 form-control" id="last_name" placeholder="Last Name"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-wrapper mt-4 mb-0">
                                            <label for="emai" class="form-label sr-only">Email address</label>
                                            <input type="email" class=" m-0 form-control" id="user-email" placeholder="Email Address"
                                                required>
                                        </div>
                                        
                                        <div class="password-fieldset my-4">
                                            <div class="form-card">
                                                <div class="input-group m-0" style="position:relative;">
                                                    <label for="password" class="form-label sr-only">Password</label>
                                                    <input type="password" class="form-control" id="user-password" placeholder="Password"
                                                    required>
                                                    <i class="signin-uil uil uil-eye password-display"></i>
                                                    <i class="signin-uil uil uil-eye-slash password-hide" style="display: none;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-check p-0 mb-5">
                                        <input type="checkbox" class="form-check-input m-0" id="termOfService">
                                        <label class="form-check-label" for="termOfService">I Have Read And I Accept
                                            CryptoGifting's <a href="{{route('TermOfUSe')}}">Terms of
                                                Service</a> And <a href="{{route('PrivacyPolicy')}}">Privacy
                                                Policy</a></label>
                                    </div>
                                    
                                    <button type="button" class="btn orange-button" id="signup">Sign up</button>
                                    <button type="button" class="btn next orange-button signup-next-button" style="display:none !important;"></button>
                                    
                                    <p class="p2">Already have an account? <a href="{{route('SignIn')}}">Sign In</a></p>
                                </fieldset>
                                <!-- Step 1 End -->

                                <fieldset>
                                    <div class="form-card text-center">
                                        <!--<img src="{{asset('/public')}}/assets/images/dashboard/email.png" class="img-fluid w-25 mb-3">-->
                                        <!--<h3 class="new-heading">Check Your Email</h3>-->
                                        <h2>CHECK YOUR EMAIL FOR DETAILS</h2>
                                        <p class="p1 text-center">Click the link that we sent to <a id="user-sent-email" href="#"></a></p>
                                        <div class="password-fieldset mb-4">
                                            <div class="form-card">
                                                <div class="input-group" style="position:relative;">
                                                   {{-- <label for="password" class="form-label sr-only">One Time Password</label>
                                                    <input type="number" name="password" class="form-control number-input" id="user-password" placeholder="4-digit code" required>
                                                   --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-wrapper my-2">
                                            <p class="w-74 mx-auto text-center">Check your spam folder if you do not receive the email in the next minute or so.</p>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <a href="#" id="resend-email" class="resend">Click here to resend email</a>
                                    </div>
                                    <p class="p2">Having issues, <a href="{{route('ContactUs')}}">click here to get help</a></p>
                                </fieldset>
                            </form>
                            
                        </div>
                    </div>

                </div>
            </section>
        </main>
        <style>
            header {
                background: linear-gradient(to right, #1D2D81, #1A47A2) !important;
            }
        </style>
        <div id="preloader" class="d-none"></div>
        <script src="{{asset('/public')}}/assets/js/custom-js.js?ver=<?php echo VER; ?>"></script>
        <script src="{{asset('/public')}}/assets/js/custom-select.js?ver=<?php echo VER; ?>"></script>
        <script src="{{asset('/public')}}/assets/js/multi-step-form.js?ver=<?php echo VER; ?>"></script>
        <script>
            // function movetoNext(current, nextFieldID) {
            //     if (current.value.length >= current.maxLength) {
            //         document.getElementById(nextFieldID).focus();
            //     }
            // }
            jQuery(document).ready(function ($) {
                // var input = document.querySelector("#user-phone");
                // window.intlTelInput(input);

                $('#signup').on('click', function (e) {
                    e.preventDefault();
                    var email = $('#user-email').val();
                    var password = $('#user-password').val();
                    var first_name = $('#first_name').val();
                    var last_name = $('#last_name').val();
                    
                    var tos = $('#termOfService').prop('checked');
                    if (!tos) {
                        displayError('Kindly mark check before proceeding further');
                        return false;
                    } else if (email == undefined || email == '') {
                        displayError('Enter email first!');
                        return false;

                    } else if (password == undefined || password == '') {
                        displayError('Enter password first!');
                        return false;

                    }
                    else if (first_name == undefined || first_name == '') {
                        displayError('Enter the first name!');
                        return false;

                    }
                    else if (last_name == undefined || last_name == '') {
                        displayError('Enter the last name!');
                        return false;

                    }
                    $('#preloader').removeClass('d-none');
                    var formData = new FormData();
                    formData.append('email', email);
                    formData.append('password', password);
                    formData.append('first_name', first_name);
                    formData.append('last_name', last_name);
                    formData.append('_token', "{{csrf_token()}}");

                    $.ajax({
                        url: '{{ route("StoreSignUp") }}',
                        type: 'POST',
                        data: formData,
                        dataType: 'JSON',
                        success: function (response) {
                            displaySuccess(response.response.message);
                            $('#user-sent-email').html(email);
                            $('.signup-next-button').click();
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

                $('#resend-email').on('click', function (e) {
                    e.preventDefault();
                    var email = $('#user-email').val();
                    $('#preloader').removeClass('d-none');
                    var formData = new FormData();
                    formData.append('email', email);
                    formData.append('_token', "{{csrf_token()}}");

                    $.ajax({
                        url: '{{ route("ResendEmailToken") }}',
                        type: 'POST',
                        data: formData,
                        dataType: 'JSON',
                        success: function (response) {
                            $('#preloader').addClass('d-none');
                            displaySuccess(response.response.message);
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
    </body>
</html>
@include('footer')