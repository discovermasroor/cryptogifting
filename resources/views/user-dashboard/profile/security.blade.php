@include('user-dashboard.head')
<script src="https://cdn.smileidentity.com/js/v1.0.0-beta.7/smart-camera-web.js"></script>    
<title>Security | Crypto Gifting</title>

<style>

    /* .alag-popup .modal-body{
        height: 100%;
        max-height: 583px;
        overflow-y: scroll;
    }
    .alag-popup .modal-body::-webkit-scrollbar{
        display: none;
    } */


</style>
    <body>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content profile-page security-page">
                <div class="overlay" id="overlay-div" data-open-modal="<?php if (isset($_GET['model']) && !empty($_GET['model'])) echo '1'; else echo '0'; ?>">
                    <h1 class="heading">Security</h1>

                    <a href="#" class="btn profile-btn security" data-bs-toggle="modal"
                        data-bs-target="#password-popup">
                        <div class="icon-box">
                            <img src="{{asset('/public')}}/assets/images/dashboard/icon-password.png" class="img-fluid">
                        </div>
                        <h5 class="profile-option">Password</h5>
                        <i class="uil uil-angle-right-b"></i>
                    </a>

                    <a href="#" class="btn profile-btn" data-bs-toggle="modal" data-bs-target="#TwoFA-popup">
                        <div class="icon-box">
                            <img src="{{asset('/public')}}/assets/images/dashboard/icon-two-f.png" class="img-fluid">
                        </div>
                        <h5 class="profile-option">Two-Factor Authentication</h5>
                        <i class="uil uil-angle-right-b"></i>
                    </a>
                    <a href="#<?php if(request()->user->approved_selfie) echo 'complete-kyc-modal'; else if (request()->user->provisional_approval) echo 'privisonal-kyc-modal'; else echo 'selfie-modal'; ?>" class="btn profile-btn" data-bs-toggle="modal">
                        <div class="icon-box">
                            <img src="{{asset('/public')}}/assets/images/dashboard/smile-lock.png" class="img-fluid">
                        </div>
                        <h5 class="profile-option">Complete KYC for Withdrawals</h5>
                        <i class="uil uil-angle-right-b"></i>
                    </a>

                    <div class="text-center my-4 pt-2">
                        <div class="two-button-box mx-auto" style="width: 100%; max-width: 450px;">
                            <a href="{{route('Profile')}}"  class="btn common-button">Back</a> 
                          
                        </div>
                    </div>
                    <!-- Password Popup -->
                    <div class="modal fade popup-style" id="password-popup" tabindex="-1"
                        aria-labelledby="password-popupLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button> -->
                                <div class="modal-body">
                                    <img src="{{asset('/public')}}/assets/images/dashboard/password-key.png" class="img-fluid key-img">
                                    <h5 class="popup-heading">Lets Create a New Secure Password</h5>
                                    <form action="{{route('UpdateProfile')}}" method="post" class="form-style password-update">
                                        <input type="hidden" name="page" value="security">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="input-group my-3">
                                            <input type="password" id="current_password" name="current_password" required class="form-control" placeholder="Current Password">
                                            
                                            <span class="input-group-text">
                                                <i class="signin-uil uil uil-eye password-display"></i>
                                                <i class="signin-uil uil uil-eye-slash password-hide" style="display: none;"></i>
                                            </span>
                                            
                                        </div>
                                        <span class = "input-correct"><p class="alert p-2 m-0"></p></span>
                                        <div class="input-group mt-3">
                                            <input type="password" name="new_password" id="new_password" required class="form-control" placeholder="New Password">
                                            <span class="input-group-text">
                                                <i class="signin-uil uil uil-eye new-password-display"></i>
                                                <i class="signin-uil uil uil-eye-slash new-password-hide" style="display: none;"></i>
                                            </span>
                                        </div>
                                        <!-- <p class="hint-text">Use Alteast 8 Characters, 1 Number, 1 Uppercase & 1 Lowercase</p> -->
                                        <button class="btn orange-button new-password-save-button" disabled>Save</button>
                                       
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image Popup -->
                    <div class="modal fade popup-style" id="image-popup" tabindex="-1"
                        aria-labelledby="password-popupLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <img src="{{asset('/public')}}/assets/images/dashboard/password-key.png" class="img-fluid key-img">
                                    <h5 class="popup-heading">Lets Create a New Selfie For Small Indetity</h5>
                                    <form action="{{route('smileKyc')}}" method="post" enctype="multipart/form-data" class="form-style">
                                       
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="input-group">
                                            <input type="file" name="image_selfie" required class="form-control">
                                            <span class="input-group-text">
                                                <img src="{{asset('/public')}}/assets/images/dashboard/eye-icon.png" class="img-fluid">
                                            </span>
                                        </div>
                                        <!-- <p class="hint-text">Use Alteast 8 Characters, 1 Number, 1 Uppercase & 1 Lowercase</p> -->
                                        <button class="btn orange-button">Save</button>
                                        <a href="#" class="forgot-password">Forgot Password?</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade popup-style" id="TwoFA-popup" tabindex="-1"
                        aria-labelledby="TwoFA-popupLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="two-fa">
                                        <form id="myForm" action="{{ route('generate2faSecret') }}" method = "post" class="form-style" style="margin-top: 0 !important">
                                        @csrf 
                                        <?php  if ($authentication == true){ ?>
                                            <h2 class="main-heading mt-0 mb-2">Disable 2FA</h2>
                                            <?php } else {  ?>                                           
                                            <h2 class="main-heading mt-0 mb-2">Enable 2FA</h2>
                                            <?php } ?>
                                            <p>
                                                Two-factor authentication keeps your wallet safer by using both your
                                                password
                                                and an authentication app to sign in
                                            </p>
                                            <p>
                                                Before enabling two-factor authentication install the Google
                                                Authenticator
                                                mobile app from one of these trusted sources
                                            </p>
                                            
                                        
                                            <ul>
                                                <li>
                                                    <img src="{{asset('/public')}}/assets/images/dashboard/circle.png" class="img-fluid">
                                                    <span>Android <a href="#">Install Google Authenticator</a> from the
                                                        Google Play
                                                        Store</span>
                                                </li>
                                                <li>
                                                    <img src="{{asset('/public')}}/assets/images/dashboard/circle.png" class="img-fluid">
                                                    <span>iPhone, iPod Touch, iPad: <a href="#">Google Authenticator</a>
                                                        from the App
                                                        Store</span>
                                                </li>
                                                <li>
                                                    <img src="{{asset('/public')}}/assets/images/dashboard/circle.png" class="img-fluid">
                                                    <span>BlackBerry: <a href="#">m.google.com/authenticator</a> in the
                                                        Blackberry web
                                                        browser</span>
                                                </li>
                                            </ul>

                                            <a href="#" onClick='submitDetailsForm()' class="btn orange-button close"><?php echo ($authentication== true ?  'Disable 2FA' : 'Setup 2FA' );?></a>
                                            <?php if($authentication) { ?>
                                            <P class="text-center mt-3 mb-0">
                                                <a href="#" class="text-bold text-decoration-none" style="font-weight: 700; font-size: 14px;">LEARN MORE</a>
                                            </P>
                                            <?php } ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                   
                    
                <input type="hidden" name="show_qr_model" id = "show_qr_model" value = "<?php if( session()->has('data') ) echo '1'; else '0'; ?>">
                    <?php if( session()->has('data') && session()->get('data') == '1'){ ?>
                        <div class="modal fade popup-style" id="QR-popup" tabindex="-1" aria-labelledby="QR-popupLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="two-fa">
                                            <form action="{{ route('enable2fa') }}" method="post"  class="form-style" style="margin-top: 0 !important">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="secret1" value="<?php echo $secret;?>">
                                                <input type="hidden" name="enable_disable" value="<?php echo $authentication;?>">
                                                <h2 class="main-heading mt-0 mb-2">Scan QR Code</h2>
                                                
                                                <p class="text-center">Enter 6-digit code from your two-factor authenticator app  to disable 2FA</p>
                                                <input id="secret"  type="text" name="secret" class="form-control my-4" placeholder="6-Digit Code">
                                                <button type="submit" class="btn orange-button"> Disable 2FA</button>
                                                <P class="text-center mt-3 mb-0">
                                                    <a href="#" class="text-bold text-decoration-none" style="font-weight: 700; font-size: 14px;">HAVING TROUBLES?</a>
                                                </P>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?> 
                        <div class="modal fade popup-style alag-popup" id="QR-popup" tabindex="-1" aria-labelledby="QR-popupLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="two-fa">
                                            <form action="{{ route('enable2fa') }}" method="post"  class="form-style"  style="margin-top: 0 !important">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="secret1" value="<?php echo $secret;?>">
                                                
                                                <h2 class="main-heading mt-0 mb-2">Scan QR Code</h2>
                                                <div class="text-center">
                                                <?php echo $google2fa_url;?>
                                                </div>
                                                <h6 class="mb-2">Setup Key</h6>
                                                <a href="#" class="setup-key"><?php echo $secret;?>
                                                    <img src="{{asset('/public')}}/assets/images/dashboard/icon-copy.png" class="img-fluid">
                                                </a>
                                                <p>
                                                    Use this key to setup your preferred authentication app you can either scan the key or copy and enter it manually
                                                </p>
                                                <p>Enter 6-digit code from your authentication app below to  enable 2FA </p>
                                                <input id="secret"  type="text" name="secret" class="form-control my-4" placeholder="6-Digit Code">
                                                <button type="submit" class="btn orange-button">Enable 2FA</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="modal fade popup-style" id="selfie-modal" tabindex="-1" aria-labelledby="QR-popupLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <img src="{{asset('/public')}}/assets/images/dashboard/selfie.png" class="img-fluid key-img" style="max-width: 150px; display:inline-block; margin-bottom: 20px;">
                                    <smart-camera-web></smart-camera-web>
                                </div>
                            </div>
                        </div>
                     </div>
                     <div class="modal fade popup-style" id="two-fa-enabled" tabindex="-1" aria-labelledby="QR-popupLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <img src="{{asset('/public')}}/assets/images/dashboard/two-fa-icon.png" class="img-fluid key-img" style="max-width: 150px; display:inline-block; margin-bottom: 20px;">
                                    <form class="form-style">
                                        <h2 class="popup-heading">You have already setup a Two Factor Authentication for this account. Are you sure that you would like to recreate one?</h2>
                                        <div class="two-button-box">
                                            <a href="#" data-bs-dismiss="modal" class="btn common-button close-btn">Cancel</a>
                                            <button class="btn blue-button my-3" type="submit">Yes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                     </div>
                     <div class="modal fade popup-style" id="complete-kyc-modal" tabindex="-1" aria-labelledby="QR-popupLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <img src="{{asset('/public')}}/assets/images/dashboard/selfie.png" class="img-fluid key-img" style="max-width: 150px; display:inline-block; margin-bottom: 20px;">
                                    <form class="form-style">
                                        <h2 class="main-heading">You have Been Successfully Authenticated.</h2>
                                    </form>
                                </div>
                            </div>
                        </div>
                     </div>
                     
                     <div class="modal fade popup-style" id="privisonal-kyc-modal" tabindex="-1" aria-labelledby="QR-popupLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <img src="{{asset('/public')}}/assets/images/dashboard/selfie.png" class="img-fluid key-img" style="max-width: 150px; display:inline-block; margin-bottom: 20px;">
                                    <form class="form-style">
                                        <h2 class="main-heading">Your Request Is In Process Right Now.</h2>
                                    </form>
                                </div>
                            </div>
                        </div>
                     </div>
                    <div class="modal fade popup-style" id="smile-popup" tabindex="-1" aria-labelledby="smile-popupLabel" aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <img src="{{asset('public')}}/assets/images/dashboard/selfie.png" class="img-fluid image"  style="max-width: 150px;">
                                    <h5 class="popup-heading">Verify your identity</h5>
                                    <form action="{{route('UploadOtherInfo')}}" method="post" class="form-style text-center review-selfie form" id="smile-final-form" enctype='multipart/form-data'>
                                        @csrf
                                        
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
                                                <label for="id-number" class="form-label" style="width: 100%;text-align: left;">National ID Number</label>
                                                <input type="text" class="form-control" name="national_id_number" id="" required placeholder="0000000000000">
                                            </div>
                                            <div class="col-md-12 ">
                                                <label for="documents-verifications" class="form-label" style="width: 100%;text-align: left;">ID Card</label>
                                                <div class="input-group file-input">
                                                    <input type="file" accept="image/*" class="form-control" id="upload-file2" name = "id_document">
                                                    <label class="input-group-text" for="upload-file2"><i class="uil uil-image-upload"></i></label>
                                                </div>
                                                <div class="col-md-12">
                                                <label for="address-verifications" class="form-label" style="width: 100%;text-align: left;">Address Document</label>
                                                <div class="input-group file-input">
                                                    <input type="file" accept="image/*" required class="form-control" id="upload-address" name = "address_document">
                                                </div>
                                        </div>
                                        <div class="col-md-12">
                                        <label for="bank-verifications" class="form-label" style="width: 100%;text-align: left;">Bank Account Document</label>
                                            <div class="input-group file-input">
                                                <input type="file" accept="image/*" required class="form-control" id="upload-file4" name = "bank_account">
                                               
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
                                            </div>
                                            <div class="col-md-12">
                                                <button class="orange-button btn mb-0">Submit</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <script>
                        function previewSelfie() {
                            frame1.src = URL.createObjectURL(event.target.files[0]);
                        }
                    </script>
                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
    <style>
        #complete-kyc-modal .main-heading {
            font-size: 24px;
        }
    </style>
    <script>
        function submitDetailsForm() {
            $("#myForm").submit();
        }

        if ($('#show_qr_model').val() == 1) {
            jQuery(window).load(function() {
                jQuery("#QR-popup").modal('show');
            });
        }else if($('#overlay-div').attr('data-open-modal') == 1) {
            jQuery(window).load(function() {
                $('#selfie-modal').modal('show');
            });

        }

        jQuery(document).ready(function($) {
            $("#current_password").on('focusout',function(){
                $('#preloader').removeClass('d-none');
                var formData = new FormData();
                formData.append('_token', "{{csrf_token()}}");
                formData.append('current_pass', $(this).val());
                $.ajax({
                    url: '{{ route("currentPasswordCheck") }}',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        $('#preloader').addClass('d-none');
                        if(response == true) {
                            $('.input-correct').find('p').removeClass("alert-danger").addClass("alert-success").html("Password Match");
                            //$('.new-password-save-button').show();
                            $('.new-password-save-button').prop('disabled', false);
                        }else{
                            $('.input-correct').find('p').removeClass("alert-success").addClass("alert-danger").html("Your password is wrong kindly try again");
                            $('.new-password-save-button').prop('disabled', true);
                        }
                    },
                    error: function (err) {

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
                    if( value.image_type_id == 2 ){
                        formData.append('images', value.image);
                    }
                });    
                $.ajax({
                    url: '{{ route("UploadSelfieUser") }}',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        $('#preloader').addClass('d-none');
                        displaySuccess('Selfie has been successfully added! Now provide some further info kindly');
                        $('#selfie-modal').modal('hide');
                        $('#smile-popup').modal('show');
                    },
                    error: function (err) {
                        $('#selfie-modal').modal('hide');
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

            $('.password-hide').on('click', function () {
                $('#current_password').attr('type', 'password');
                $(this).hide();
                $('.password-display').show();
            });

            $('.password-display').on('click', function () {
                $("#current_password").attr('type', 'text');
                $(this).hide();
                $('.password-hide').show();
            });

            $('.new-password-hide').on('click', function () {
                $('#new_password').attr('type', 'password');
                $(this).hide();
                $('.new-password-display').show();
            });

            $('.new-password-display').on('click', function () {
                $("#new_password").attr('type', 'text');
                $(this).hide();
                $('.new-password-hide').show();
            });
        });
    </script>

<script>
        function goBack()
        {
            window.history.back()
        }
    </script>

@include('user-dashboard.footer')
