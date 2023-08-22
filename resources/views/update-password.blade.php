@include('head')
    <title>Complete Your Account| CryptoGifting</title>
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
                            <form class="multi-step-form" action="{{route('RegisterGiftUser2', [$user->user_id])}}" id="email-form" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <fieldset>
                                    <div class="form-card">
                                        <h2>Complete your account to proceed further</h2>
                                        <p class="p1">Welcome to CryptoGifting where we make gifting crypto easy</p>
                                        
                                        <div class="password-fieldset mb-4">
                                            <div class="form-card">
                                                <div class="input-group" style="position:relative;">
                                                    <label for="password" class="form-label sr-only">Password</label>
                                                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                                                    <i class="signin-uil uil uil-eye password-display"></i>
                                                    <i class="signin-uil uil uil-eye-slash password-hide" style="display: none;"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="password-fieldset mb-4">
                                            <div class="form-card">
                                                <div class="input-group" style="position:relative;">
                                                    <label for="password" class="form-label sr-only">Password</label>
                                                    <input type="password" name="confirm_password" class="form-control" id="confirm-password" placeholder="Confirm Password" required>
                                                    <i class="signin-uil uil uil-eye password-display"></i>
                                                    <i class="signin-uil uil uil-eye-slash password-hide" style="display: none;"></i>
                                                </div>
                                            </div>
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
        <script>
            jQuery(document).ready(function ($) {
                $('.password-hide').on('click', function () {
                    $(this).parent().find('input').attr('type', 'password');
                    $(this).hide();
                    $(this).parent().find('.password-display').show();
                });

                $('.password-display').on('click', function () {
                    $(this).parent().find('input').attr('type', 'text');
                    $(this).hide();
                    $(this).parent().find('.password-hide').show();
                });

                $('#email-form').on('submit', function (e) {
                    var cpass = $('#confirm-password').val();
                    var pass = $('#password').val();
                    if (pass != cpass) {
                        e.preventDefault();
                        displayError('Password and Confirm Password should be same!');
                        return false;
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
            });
        </script>
    </body>
</html>

@include('footer')