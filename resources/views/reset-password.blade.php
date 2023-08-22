@include('head')
    <title>Reset Password | Crypto Gifting</title>
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
                            <h1>CryptoGifting</h1>
                        <div class="form-wrapper">
                            <form class="multi-step-form" action="{{route('UpdatePassword', [$token])}}" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <fieldset>
                                    <div class="form-card">
                                        <h2>Update your password</h2>
                                        <p class="p1">Please use a password that you will remember, but no one else knows.</p>
                                        <div class="input-group mb-4" style="position:relative;">
                                            <label for="password" class="form-label sr-only">Password</label>
                                            <input type="password" name="password" style="border-radius:16px;" class="form-control" id="user-password" placeholder="Password" required="">
                                            <i class="signin-uil uil uil-eye password-display"></i>
                                            <i class="signin-uil uil uil-eye-slash password-hide" style="display: none;"></i>
                                        </div>
                                        <div class="input-group mb-4" style="position:relative;">
                                            <label for="password" class="form-label sr-only">Password</label>
                                            <input type="password" name="confirm_password" style="border-radius:16px;" class="form-control" id="new-user-password" placeholder="Confirm Password" required="">
                                            <i class="signin-uil uil uil-eye new-password-display"></i>
                                                <i class="signin-uil uil uil-eye-slash new-password-hide" style="display: none;"></i>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn orange-button">Update</button>
                                </fieldset>
                            </form>
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
                $('.password-display').on('click', function () {
                        $('#user-password').attr('type', 'text');
                        $(this).hide();
                        $('.password-hide').show();
                      
                    });

                     $('.password-hide').on('click', function () {
                        $("#user-password").attr('type', 'password');
                        $(this).hide();
                        $('.password-display').show();
                    });

                    $('.new-password-display').on('click', function () {
                        $('#new-user-password').attr('type', 'text');
                        $(this).hide();
                        $('.new-password-hide').show();
                    });

                    $('.new-password-hide').on('click', function () {
                        $("#new-user-password").attr('type', 'password');
                        $(this).hide();
                        $('.new-password-display').show();
                    });
            });
        </script>
        @include('footer')