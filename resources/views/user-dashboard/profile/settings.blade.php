@include('user-dashboard.head')
    <title>Settings | Crypto Gifting</title>
    <body>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content profile-page settings-page">
                <div class="overlay" id="overlay-div" data-open-modal="<?php if (isset($_GET['model']) && !empty($_GET['model'])) echo '1'; else echo '0'; ?>">
                    <h1 class="heading mb-5">Settings</h1>

                    <button class="btn setting-button" data-bs-toggle="modal" data-bs-target="#name-popup">Profile Name</button>
                    <button class="btn setting-button" data-bs-toggle="modal" data-bs-target="#date-of-birth-popup">Date of Birth</button>
                    <button class="btn setting-button" data-bs-toggle="modal" data-bs-target="#email-popup">Email Address</button>
                    <a href="{{route('BankInformation')}}" class="btn setting-button" >Bank Details</a>

                    <div class="text-center my-4 pt-2">
                        <div class="two-button-box mx-auto" style="width: 100%; max-width: 450px;">
                            <button type="button" onclick="goBack()" class="btn common-button">Back</button> 
                          
                        </div>
                    </div>

                    <!-- <button class="btn setting-button" data-bs-toggle="modal" data-bs-target="#number-popup">
                        Mobile Number
                    </button> -->

                    <!-- Name Popup -->
                    <div class="modal fade popup-style settings-popup" id="name-popup" tabindex="-1"
                        aria-labelledby="name-popupLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button> -->
                                <div class="modal-body">
                                    <img src="{{asset('/public')}}/assets/images/dashboard/id-card.png" class="img-fluid ">
                                    <form action="{{route('UpdateProfile')}}" method="post" class="form-style">
                                        <input type="hidden" name="page" value="settings">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <h3 class="label">First Name</h3>
                                        <input type="text" required class="form-control" name="first_name" value="{{request()->user->first_name}}" id="first-name">
                                        <h3 class="label mt-4">Last Name</h3>
                                        <input type="text" required class="form-control" name="last_name" value="{{request()->user->last_name}}" id="last-name">
                                        <button class="btn orange-button">Save</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email Popup -->
                    <div class="modal fade popup-style settings-popup" id="email-popup" tabindex="-1"
                        aria-labelledby="email-popupLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button> -->
                                <div class="modal-body">
                                    <img src="{{asset('/public')}}/assets/images/dashboard/email.png" class="img-fluid ">
                                    <form action="" class="form-style">
                                        <h3 class="label">Your Email Address</h3>
                                        <h5>Primary</h5>
                                        <input type="email" disabled class="form-control" value="{{request()->user->email}}" id="email">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Number Popup -->
                    <div class="modal fade popup-style settings-popup" id="date-of-birth-popup" tabindex="-1"
                        aria-labelledby="email-popupLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <img src="{{asset('/public')}}/assets/images/dashboard/mobile.png" class="img-fluid mobile-img">
                                    <form action="{{route('UpdateProfile')}}" method="post" class="form-style">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="page" value="settings">
                                        <h3 class="label">Date of Birth</h3>
                                        <input type="text" data-toggle="datepicker" required class="form-control" name="date_of_birth" placeholder="click here to update your date of birth" value="<?php if (request()->user->date_of_birth) echo request()->user->date_of_birth; ?>">
                                        <button class="btn orange-button">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
    <script>
        $(window).load(function() {
            $('[data-toggle="datepicker"]').datepicker({
                   autoHide:true,
                   format:'yyyy-mm-dd',
                   inline:true,
               });
            var showModel = $('#overlay-div').attr('data-open-modal');
            if (showModel == '1') {
                $('#name-popup').modal('show');

            }
        });
    </script>
    <script>
        function goBack()
        {
            window.history.back()
        }
    </script>
    
@include('user-dashboard.footer')
