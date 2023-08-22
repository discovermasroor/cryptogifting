<?php
    $unread_notifications_counter = \App\Models\NotificationUser::where('user_id', request()->admin->user_id)->whereRaw('`flags` & ? != ?', [\App\Models\NotificationUser::FLAG_READ, \App\Models\NotificationUser::FLAG_READ])->count();
?>
<body>
    <header class="website-header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="{{route('Index')}}">
                    <h1 class="ps-0 ps-xl-3">CryptoGifting</h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#web-menu"
                    aria-controls="web-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="collapse navbar-collapse" id="web-menu">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('Help')}}">Help</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('ContactUs')}}">Contact Us</a>
                        </li>
                        <?php if(request()->user) { ?>
                            <li class="nav-item signup-btn">
                                <a class="nav-link" href="{{route('UserDashboard')}}">dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('Logout')}}">logout</a>
                            </li>
                        <?php } else if(request()->admin) { ?>
                            <li class="nav-item signup-btn">
                                <a class="nav-link" href="{{route('AdminDashboard')}}">dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('Logout')}}">logout</a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('SignIn')}}">sign in</a>
                            </li>
                            <li class="nav-item signup-btn">
                                <a class="nav-link" href="{{route('SignUp')}}">sign up</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="dashboard">
    <aside>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php if (Route::current()->getName() == 'AdminDashboard') echo 'active'; ?>" href="{{route('AdminDashboard')}}">
                    <div class="icon-box">
                        <img src="{{asset('public/')}}/assets/images/dashboard/icons/dashboard.png" class="img-fluid"
                            style="width: 25px;">
                    </div>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if (Route::current()->getName() == 'AllUsersAdmin' || Route::current()->getName() == 'UserInfoAdmin') echo 'active'; ?>" href="{{route('AllUsersAdmin')}}">
                    <div class="icon-box">
                        <img src="{{asset('public/')}}/assets/images/dashboard/icons/users.png" class="img-fluid" style="width: 25px;">
                    </div>
                    Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if (Route::current()->getName() == 'AllBeneficiarysAdmin' || Route::current()->getName() == 'BeneficiaryInfoAdmin') echo 'active'; ?>" href="{{route('AllBeneficiarysAdmin')}}">
                    <div class="icon-box">
                        <img src="{{asset('public/')}}/assets/images/dashboard/icons/users.png" class="img-fluid" style="width: 25px;">
                    </div>
                    Beneficiary
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if (Route::current()->getName() == 'AllEventsAdmin') echo 'active'; ?>" href="{{route('AllEventsAdmin')}}">
                    <div class="icon-box">
                        <img src="{{asset('public/')}}/assets/images/dashboard/icons/event.png" class="img-fluid" style="width: 25px;">
                    </div>
                    Events
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('Themes')}}">
                    <div class="icon-box">
                        <img src="{{asset('public/')}}/assets/images/dashboard/icons/event.png" class="img-fluid" style="width: 25px;">
                    </div>
                    Themes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if (Route::current()->getName() == 'WithdrawalRequestAdmin' || Route::current()->getName() == 'EventsTransactionsAdmin' || Route::current()->getName() == 'PublicLinkGiftsAdmin' || Route::current()->getName() == 'AllGetGfitCryptoAdmin') echo 'active'; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseReports">
                    <div class="icon-box">
                        <img src="{{asset('public/')}}/assets/images/dashboard/icons/reports.png" class="img-fluid" style="width: 23px;">
                    </div>
                    Reports <i class="uil uil-angle-down"></i>
                </a>
                <div class="collapse sub-menu <?php if (Route::current()->getName() == 'WithdrawalRequestAdmin' || Route::current()->getName() == 'EventsTransactionsAdmin' || Route::current()->getName() == 'PublicLinkGiftsAdmin' || Route::current()->getName() == 'AllSmileKYCRecordsAdmin') echo 'show'; ?>" id="collapseReports">
                    <a class="<?php if (Route::current()->getName() == 'EventsTransactionsAdmin') echo 'active'; ?>" href="{{route('EventsTransactionsAdmin')}}">Transactions History</a>
                    <a class="<?php if (Route::current()->getName() == 'WithdrawalRequestAdmin') echo 'active'; ?>" href="{{route('WithdrawalRequestAdmin')}}">Withdrawal request</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if (Route::current()->getName() == 'ContactUsAdmin' || Route::current()->getName() == 'ContactUsInfoAdmin' || Route::current()->getName() == 'AffiliatesAdmin' || Route::current()->getName() == 'AffiliateInfoAdmin' || Route::current()->getName() == 'LoyaltyAdmin' || Route::current()->getName() == 'LoyaltyProgramInfoAdmin'  || Route::current()->getName() == 'FeedbacksAdmin' || Route::current()->getName() == 'FeedbackInfoAdmin') echo 'active'; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#websiteForms">
                    <div class="icon-box">
                        <img src="{{asset('public/')}}/assets/images/dashboard/icons/reports.png" class="img-fluid" style="width: 23px;">
                    </div>
                    Website Forms <i class="uil uil-angle-down"></i>
                </a>
                <div class="collapse sub-menu <?php if (Route::current()->getName() == 'ContactUsAdmin' || Route::current()->getName() == 'ContactUsInfoAdmin' || Route::current()->getName() == 'AffiliatesAdmin' || Route::current()->getName() == 'AffiliateInfoAdmin' || Route::current()->getName() == 'LoyaltyAdmin' || Route::current()->getName() == 'LoyaltyProgramInfoAdmin'  || Route::current()->getName() == 'FeedbacksAdmin' || Route::current()->getName() == 'FeedbackInfoAdmin') echo 'show'; ?>" id="websiteForms">
                    <a class="<?php if (Route::current()->getName() == 'ContactUsAdmin' || Route::current()->getName() == 'ContactUsInfoAdmin') echo 'active'; ?>" href="{{route('ContactUsAdmin')}}">Contact Us</a>
                    <a class="<?php if (Route::current()->getName() == 'AffiliatesAdmin' || Route::current()->getName() == 'AffiliateInfoAdmin') echo 'active'; ?>" href="{{route('AffiliatesAdmin')}}">Affiliates</a>
                    <a class="<?php if (Route::current()->getName() == 'LoyaltyAdmin' || Route::current()->getName() == 'LoyaltyProgramInfoAdmin') echo 'active'; ?>" href="{{route('LoyaltyAdmin')}}">Loyalty Program</a>
                    <a class="<?php if (Route::current()->getName() == 'FeedbacksAdmin' || Route::current()->getName() == 'FeedbackInfoAdmin') echo 'active'; ?>" href="{{route('FeedbacksAdmin')}}">Feedbacks</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if (Route::current()->getName() == 'AdminNotifications') echo 'active'; ?>" href="{{route('AdminNotifications')}}">
                    <div class="icon-box">
                        <img src="{{asset('public/')}}/assets/images/dashboard/icons/notification.png" class="img-fluid" style="width: 25px;">
                    </div>
                    Notifications
                    <?php if ($unread_notifications_counter > 0) { ?>
                        <span id="notif-counter" class="badge rounded-pill">
                            {{$unread_notifications_counter}}
                            <span class="visually-hidden">unread notification</span>
                        </span>
                    <?php } ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link  <?php if (Route::current()->getName() == 'adminSettings' || Route::current()->getName() == 'ValrSetting') echo 'active'; ?>"  href="#" data-bs-toggle="collapse" data-bs-target="#collapseSetting">
                    <div class="icon-box">
                        <img src="{{asset('public/')}}/assets/images/dashboard/icons/setting.png" class="img-fluid" style="width: 25px;">
                    </div>
                    Settings <i class="uil uil-angle-down"></i>
                </a>
                <div class="collapse sub-menu <?php if (Route::current()->getName() == 'adminSettings' || Route::current()->getName() == 'ValrSetting' ) echo 'show'; ?>" id="collapseSetting">
                    <a class="<?php if (Route::current()->getName() == 'adminSettings') echo 'active'; ?>" href="{{route('adminSettings')}}">System Setting</a>
                    <a class="<?php if (Route::current()->getName() == 'ValrSetting') echo 'active'; ?>" href="{{route('ValrSetting')}}">VALR Setting</a>
                    
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('Logout')}}">
                    <div class="icon-box">
                        <img src="{{asset('public/')}}/assets/images/dashboard/icons/logout.png" class="img-fluid" style="width: 25px;">
                    </div>
                    Logout
                </a>
            </li>
        </ul>
    </aside>
    <section class="dashboard-content">
        <header class="dashboard-header">
            <div class="class">
                <form action="{{route('AdminSearch')}}" id="search-form" method="GET">
                    <div class="input-group">
                        <button class="btn" type="button" id="button-addon1"><i class="uil uil-search"></i></button>
                        <input type="text" class="form-control" placeholder="Search" name="search" value="<?php if (isset($_GET['search']) && !empty($_GET['search'])) echo $_GET['search']; ?>" aria-label="Example text with button addon" aria-describedby="button-addon1">
                    </div>
                </form>
                <div class="action-buttons">
                    <p class="user">Welcome Back! <span class="user-name">Admin</span></p>
                    <a href="{{route('Help')}}" class="btn">
                        <img src="{{asset('public/')}}/assets/images/dashboard/icons/settings-w.png" class="img-fluid front">
                        <img src="{{asset('public/')}}/assets/images/dashboard/icons/settings-b.png" class="img-fluid back">
                    </a>
                    
                </div>
                <a href="#" class="btn sidebar-trigger">
                    <span></span>
                    <span></span>
                    <span></span>
                </a>
            </div>
        </header>
        <!-- HEader Ends -->
        
        <script>
            AOS.init();
            $(document).ready(function () {
                $('.sidebar-trigger').click(function () {
                    $('aside').toggleClass('show');
                })
            });
        </script>