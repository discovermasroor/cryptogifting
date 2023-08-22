@include('head')
    <title>Forgot Password | CryptoGifting.com</title>
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
                     @if ( !session()->has('send_email') )
                        <a href="{{route('Index')}}" class="heading-anchor">
                            <h1>CryptoGifting</h1>
                        </a>
                        <div class="form-wrapper">
                            <form class="multi-step-form" action="{{route('VerifyEmailForForgetPassword')}}" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <fieldset>
                                    <div class="form-card">
                                        <h2>Forgot Password</h2>
                                        <p class="p1">Enter the email that you used to sign up with CryptoGifting.com. We will send you</p>
                                        <div class="input-wrapper my-4">
                                            <label for="emai" class="form-label sr-only">Email address</label>
                                            <input type="email" name="email" class="form-control" id="user-email" placeholder="Email Address"
                                                required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn orange-button">Next</button>
                                </fieldset>
                            </form>
                        </div>
                        @else
                            <div class="form-wrapper">
                                <a href="{{route('Index')}}" class="heading-anchor">
                                    <h1>CryptoGifting</h1>
                                </a>
                                <h2>CHECK YOUR EMAIL FOR DETAILS</h2>
                                <p class="w-75 text-center mx-auto">Please use the link in the email that we just sent you in order to verify your email address.</p> 
                                <div class="text-center">
                                    <a href="{{route('Index')}}" class="btn resend">Understood, take me to the Home Page</a>
                                </div>
                            </div>
                        @endif
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

        <?php if (session()->has('req_error')) { ?>
            <div class="alert custom-alert alert-danger d-flex align-items-center" role="alert">
                <ul>
                    <li><i class="uis uis-exclamation-triangle"></i>{{session()->get('req_error')}}</li>
                </ul>
            </div>
            <?php session()->flush('req_error');
        } else if (session()->has('req_success')) { ?>
            <div class="alert custom-alert alert-success d-flex align-items-center" role="alert">
                <ul>
                    <li><i class="uil uil-check-circle"></i>{{session()->get('req_success')}}</li>
                </ul>
            </div>
            <?php session()->flush('req_success');
        } else if ($errors->any()) { ?>
            <div class="alert custom-alert alert-danger d-flex align-items-center" role="alert">
                <ul>
                    <?php foreach ($errors->all() as $key => $value) { ?>
                        <li><i class="uis uis-exclamation-triangle"></i>{{$value}}</li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>

        <script src="{{asset('/public')}}/assets/js/custom-js.js"></script>
        <script src="{{asset('/public')}}/assets/js/custom-select.js"></script>
        <script src="{{asset('/public')}}/assets/js/multi-step-form.js"></script>

        <script>
            jQuery(document).ready(function ($) {
                $('form').on('submit', function () {
                    $('#preloader').removeClass('d-none');
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
            });
        </script>
        @include('footer')