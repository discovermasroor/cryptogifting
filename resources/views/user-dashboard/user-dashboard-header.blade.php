<?php
    $unread_notifications_counter = \App\Models\NotificationUser::where('user_id', request()->user->user_id)->whereRaw('`flags` & ? != ?', [\App\Models\NotificationUser::FLAG_READ, \App\Models\NotificationUser::FLAG_READ])->count();
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

        <!-- Menu Sidebar Starts -->
        <aside class="pt-3">
            <!--<div class="logo-box">-->
            <!--    <h1 class="my-0">-->
            <!--        <a href="{{route('Index')}}">CryptoGifting</a>-->
            <!--    </h1>-->
            <!--</div>-->
            <a href="{{route('SelectBeneficiariesForEvent')}}" class="btn create-event-btn">Create Event</a>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('UserDashboard')}}">
                        <div class="icon-box">
                            <img src="{{asset('/public')}}/assets/images/dashboard/icons/dashboard.png" class="img-fluid"
                                style="width: 25px;">
                        </div>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (Route::current()->getName() == 'EditBeneficiary' || Route::current()->getName() == 'Beneficiaries' || Route::current()->getName() == 'AddBeneficiary') echo 'active'; ?>" href="{{route('Beneficiaries')}}">
                        <div class="icon-box">
                            <img src="{{asset('/public')}}/assets/images/dashboard/icons/beneficiaries.png" class="img-fluid"
                                style="width: 25px;">
                        </div>
                        My Beneficiaries
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (Route::current()->getName() == 'Events' || Route::current()->getName() == 'EditEvent' || Route::current()->getName() == 'AddDetailsForEvent' || Route::current()->getName() == 'AllocateAmountView' || Route::current()->getName() == 'ShareEventView' || Route::current()->getName() == 'EventPreviewSelf' || Route::current()->getName() == 'EventLink' || Route::current()->getName() == 'SelectBeneficiariesForEventNew' || Route::current()->getName() == 'InvitedEvents') echo 'active'; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseEvents">
                        <div class="icon-box">
                            <img src="{{asset('/public')}}/assets/images/dashboard/icons/event.png" class="img-fluid" style="width: 25px;">
                        </div>
                        Manage Events <i class="uil uil-angle-down"></i>
                    </a>
                    <div class="collapse sub-menu <?php if (Route::current()->getName() == 'Events' || Route::current()->getName() == 'EditEvent' || Route::current()->getName() == 'AddDetailsForEvent' || Route::current()->getName() == 'AllocateAmountView' || Route::current()->getName() == 'ShareEventView' || Route::current()->getName() == 'EventPreviewSelf' || Route::current()->getName() == 'EventLink' || Route::current()->getName() == 'SelectBeneficiariesForEventNew' || Route::current()->getName() == 'InvitedEvents') echo 'show'; ?>" id="collapseEvents">
                        <div>
                            <a class="<?php if (Route::current()->getName() == 'Events') echo 'active'; ?>" href="{{route('Events')}}">My Events</a>
                        </div>
                        <div>
                            <a class="<?php if (Route::current()->getName() == 'InvitedEvents') echo 'active'; ?>" href="{{route('InvitedEvents')}}">Invited events</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (Route::current()->getName() == 'Contacts' || Route::current()->getName() == 'Contacts' || Route::current()->getName() == 'AddContact' || Route::current()->getName() == 'EditContact' || Route::current()->getName() == 'GuestLists' || Route::current()->getName() == 'AddGuestList' || Route::current()->getName() == 'EditGuestList' || Route::current()->getName() == 'AddContactsInGuestListView') echo 'active'; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseContacts">
                        <div class="icon-box">
                            <img src="{{asset('/public')}}/assets/images/dashboard/icons/contact.png" class="img-fluid" style="width: 25px;">
                        </div>
                        My Contacts <i class="uil uil-angle-down"></i>
                    </a>
                    <div class="collapse sub-menu <?php if (Route::current()->getName() == 'Contacts' || Route::current()->getName() == 'Contacts' || Route::current()->getName() == 'AddContact' || Route::current()->getName() == 'EditContact' || Route::current()->getName() == 'GuestLists' || Route::current()->getName() == 'AddGuestList' || Route::current()->getName() == 'EditGuestList' || Route::current()->getName() == 'AddContactsInGuestListView') echo 'show'; ?>" id="collapseContacts">
                        <a href="{{route('Contacts')}}" class="<?php if (Route::current()->getName() == 'Contacts' || Route::current()->getName() == 'Contacts' || Route::current()->getName() == 'AddContact' || Route::current()->getName() == 'EditContact') echo 'active'; ?>">Add Contacts</a>
                        <a href="{{route('GuestLists')}}"  class="<?php if (Route::current()->getName() == 'GuestLists' || Route::current()->getName() == 'AddGuestList' || Route::current()->getName() == 'EditGuestList' || Route::current()->getName() == 'AddContactsInGuestListView') echo 'active'; ?>">Create Guest list</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (Route::current()->getName() == 'LinkGifts' || Route::current()->getName() == 'EventsTransactions' || Route::current()->getName() == 'ShowHistory') echo 'active'; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseReports">
                        <div class="icon-box">
                            <img src="{{asset('/public')}}/assets/images/dashboard/icons/reports.png" class="img-fluid" style="width: 23px;">
                        </div>
                        Reports <i class="uil uil-angle-down"></i>
                    </a>
                    <div class="collapse sub-menu <?php if (Route::current()->getName() == 'LinkGifts' || Route::current()->getName() == 'EventsTransactions' || Route::current()->getName() == 'ShowHistory') echo 'show'; ?>" id="collapseReports">
                        <a class="<?php if (Route::current()->getName() == 'EventsTransactions') echo 'active'; ?>" href="{{route('EventsTransactions')}}">Gifts Received</a>
                        <a class="<?php if (Route::current()->getName() == 'LinkGifts') echo 'active'; ?>" href="{{route('LinkGifts')}}">Funds Withdrawn</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (Route::current()->getName() == 'GetNotifications' || Route::current()->getName() == 'Notifications') echo 'active'; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseNotifications">
                        <div class="icon-box">
                            <img src="{{asset('/public')}}/assets/images/dashboard/icons/notification.png" class="img-fluid"
                                style="width: 25px;">
                        </div>
                        Notifications
                        <?php if ($unread_notifications_counter > 0) { ?>
                            <span id="notif-counter" class="badge rounded-pill">
                                {{$unread_notifications_counter}}
                                <span class="visually-hidden">unread notification</span>
                            </span>
                        <?php } ?>
                    </a>
                    <div class="collapse sub-menu <?php if (Route::current()->getName() == 'GetNotifications' || Route::current()->getName() == 'Notifications') echo 'show'; ?>" id="collapseNotifications">
                        <a href="{{route('GetNotifications')}}" class="<?php if (Route::current()->getName() == 'GetNotifications') echo 'active'; ?>">Unread Notifications</a>
                        <a href="{{route('Notifications')}}" class='<?php if (Route::current()->getName() == 'Notifications') echo 'active'; ?>'>Notification Settings</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('Logout')}}">
                        <div class="icon-box">
                            <img src="{{asset('/public')}}/assets/images/dashboard/icons/logout.png" class="img-fluid" style="width: 25px;">
                        </div>
                        Logout
                    </a>
                </li>
            </ul>
        </aside>
        <section class="dashboard-content">
            <header class="dashboard-header">
                <!--<div class="logo-bar">-->
                <!--    <h1><a href="{{route('Index')}}">CryptoGifting</a></h1>-->
                <!--    <a href="#" class="btn sidebar-trigger">-->
                <!--        <span></span>-->
                <!--        <span></span>-->
                <!--        <span></span>-->
                <!--    </a>-->
                <!--</div>-->
                <div class="class">
                    <form action="{{route('UserSearch')}}" id="search-form" method="GET">
                        <div class="input-group">
                            <button class="btn" type="button" id="button-addon1"><i class="uil uil-search"></i></button>
                            <input type="text" class="form-control" placeholder="Search" name="search" value="<?php if (isset($_GET['search']) && !empty($_GET['search'])) echo $_GET['search']; ?>" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        </div>
                    </form>
                    <div class="action-buttons">
                        <?php if (!empty(request()->user->first_name) && !empty(request()->user->last_name)) { ?>
                            <p class="user">Welcome Back! <span class="user-name">{{request()->user->first_name}} {{request()->user->last_name}}</span></p>

                        <?php } else { ?>
                            <p class="user">Welcome Back! <span class="user-name">{{request()->user->username}}</span></p>

                        <?php } ?>
                        <a href="{{route('UserWallet')}}" class="btn <?php if (Route::current()->getName() == 'UserWallet') echo 'active'; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Wallet">
                            <img src="{{asset('/public')}}/assets/images/dashboard/icons/wallet-w.png" class="img-fluid front">
                            <img src="{{asset('/public')}}/assets/images/dashboard/icons/wallet-b.png" class="img-fluid back">
                        </a>
                        <a href="{{route('Profile')}}" class="btn <?php if (Route::current()->getName() == 'Profile') echo 'active'; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Profile">
                            <img src="{{asset('/public')}}/assets/images/dashboard/icons/user-w.png" class="img-fluid front">
                            <img src="{{asset('/public')}}/assets/images/dashboard/icons/user-b.png" class="img-fluid back">
                        </a>
                        <a href="{{route('Help')}}" target="_blank" class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Help">
                            <img src="{{asset('/public')}}/assets/images/dashboard/icons/settings-w.png" class="img-fluid front">
                            <img src="{{asset('/public')}}/assets/images/dashboard/icons/settings-b.png" class="img-fluid back">
                        </a>
                    </div>
                    <a href="#" class="btn sidebar-trigger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                </div>
            </header>
            
            <script>
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                  return new bootstrap.Tooltip(tooltipTriggerEl)
                });
                
                AOS.init();
                $(document).ready(function () {
                    $('.sidebar-trigger').click(function () {
                        $('aside').toggleClass('show');
                    })
                });
            </script>
            
            
            