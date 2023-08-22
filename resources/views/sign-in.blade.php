@include('head')
<?php $two_factor = Cookie::get('two_factor'); ?>
    <title>Sign In | Crypto Gifting</title>
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
                <div class="main-container">
                    <div class="column column-img">
                        <img src="{{asset('/public')}}/assets/images/web/signin-img.png" class="img-fluid">
                    </div>
                    <div class="column column-form">
                        <a href="{{route('Index')}}" class="heading-anchor">
                            <h1>CryptoGifting</h1>
                        </a>
                        <div class="form-wrapper">
                            <form class="multi-step-form" action="{{route('StoreSignIn')}}" id="email-form" method="POST" <?php //if (!empty($two_factor)) echo 'style="display:none !important;"'; ?>>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="browser" id="browser" value="">
                                <input type="hidden" name="system" id="system" value="">
                                <fieldset>
                                    <div class="form-card">
                                        <h2>sign in with your email</h2>
                                        <p class="p1">Welcome back to CryptoGifting where we make Gifting Crypto easy!</p>
                                        <div class="input-wrapper my-4">
                                            <label for="emai" class="form-label sr-only">Email address</label>
                                            <input type="email" name="email" class="form-control" id="user-email" placeholder="Email Address"
                                                required>
                                        </div>
                                        <div class="password-fieldset mb-4">
                                            <div class="form-card">
                                                <div class="input-group" style="position:relative;">
                                                    <label for="password" class="form-label sr-only">Password</label>
                                                    <input type="password" name="password" class="form-control" id="user-password" placeholder="Password" required>
                                                    <i class="signin-uil uil uil-eye password-display"></i>
                                                    <i class="signin-uil uil uil-eye-slash password-hide" style="display: none;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn orange-button">Login</button>
                                </fieldset>
                            </form>
                            {{--<form class="multi-step-form" action="{{route('2faVerify')}}" method="POST" id="2fa-form"  <?php if (empty($two_factor)) echo 'style="display:none !important;"'; ?>>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <fieldset>
                                    <div class="form-card">
                                        <h2>sign in with your google authenticator</h2>
                                        <p class="p1">Welcome back to CryptoGifting where we make gifting crypto easy</p>
                                        <div class="password-fieldset mb-4">
                                            <div class="form-card">
                                                <div class="input-group" style="position:relative;">
                                                    <label for="password" class="form-label sr-only">One Time Password</label>
                                                    <input type="number" name="password" class="form-control" id="user-password" placeholder="One Time Password" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn orange-button">Login</button>
                                </fieldset>
                            </form>--}}
                            <?php //if (!empty($two_factor)) { ?>
                                {{--<p class="p2">Don't have app right now? <a href="#" id="show-email-form">Sign In with Email & Password!</a></p>--}}

                            <?php //} ?>
                            <p class="p2">Don't have an account? <a href="{{route('SignUp')}}">Sign Up</a></p>
                            <a href="{{route('ForgetPassword')}}" class="anchor d-block">Forgot Password?</a>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <?php if (session()->has('req_error')) { ?>
            <div class="alert custom-alert alert-danger d-flex align-items-center" role="alert">
                <ul>
                    <li><i class="uis uis-exclamation-triangle"></i>{{session()->get('req_error')}}</li>
                </ul>
            </div>
            <?php session()->forget('req_error');
        } else if (session()->has('req_success')) { ?>
            <div class="alert custom-alert alert-success d-flex align-items-center" role="alert">
                <ul>
                    <li><i class="uil uil-check-circle"></i>{{session()->get('req_success')}}</li>
                </ul>
            </div>
            <?php session()->forget('req_success');
        } else if ($errors->any()) { ?>
            <div class="alert custom-alert alert-danger d-flex align-items-center" role="alert">
                <ul>
                    <?php foreach ($errors->all() as $key => $value) { ?>
                        <li><i class="uis uis-exclamation-triangle"></i>{{$value}}</li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
        <style>
            header {
                background: linear-gradient(to right, #1D2D81, #1A47A2) !important;
            }
        </style>
        <script src="{{asset('/public')}}/assets/js/custom-js.js?ver=<?php echo VER; ?>"></script>
        <script src="{{asset('/public')}}/assets/js/custom-select.js?ver=<?php echo VER; ?>"></script>
        <script src="{{asset('/public')}}/assets/js/multi-step-form.js?ver=<?php echo VER; ?>"></script>

        <script>
            jQuery(document).ready(function ($) {
                var OSName = "Unknown";
                if (window.navigator.userAgent.indexOf("Windows NT 10.0")!= -1) OSName="Windows 10";
                else if (window.navigator.userAgent.indexOf("Windows NT 6.3") != -1) OSName="Windows 8.1";
                else if (window.navigator.userAgent.indexOf("Windows NT 6.2") != -1) OSName="Windows 8";
                else if (window.navigator.userAgent.indexOf("Windows NT 6.1") != -1) OSName="Windows 7";
                else if (window.navigator.userAgent.indexOf("Windows NT 6.0") != -1) OSName="Windows Vista";
                else if (window.navigator.userAgent.indexOf("Windows NT 5.1") != -1) OSName="Windows XP";
                else if (window.navigator.userAgent.indexOf("Windows NT 5.0") != -1) OSName="Windows 2000";
                else if (window.navigator.userAgent.indexOf("Mac")            != -1) OSName="Mac/iOS";
                else if (window.navigator.userAgent.indexOf("X11")            != -1) OSName="UNIX";
                else if (window.navigator.userAgent.indexOf("Linux")          != -1) OSName="Linux";
                $('#system').val(OSName);

                var userAgent = navigator.userAgent;
                var browserr = "Unknown";;

                if (userAgent.match(/chrome|chromium|crios/i)) {
                    browserr = "Chrome";

                } else if (userAgent.match(/firefox|fxios/i)) {
                    browserr = "Firefox";

                } else if (userAgent.match(/safari/i)) {
                    browserr = "Safari";

                } else if (userAgent.match(/opr\//i)) {
                    browserr = "Opera";

                }  else if (userAgent.match(/edg/i)) {
                    browserr = "Edge";

                }
                $('#browser').val(browserr);
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
                $('#show-email-form').on('click', function (e){
                    e.preventDefault();
                    $(this).parent().hide();
                    $('#email-form').show();  
                    $('#2fa-form').hide();  
                })
            });
        </script>
    </body>
</html>

@include('footer')