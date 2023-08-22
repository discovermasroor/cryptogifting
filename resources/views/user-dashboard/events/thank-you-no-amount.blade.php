@include('user-dashboard.head')
    <title>Thank You So Much | Dashboard</title>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content">
                <div class="overlay">

                    <div class="thankyou">
                        <img src="{{asset('public/')}}/assets/images/dashboard/thankyou.png" class="img-fluid">

                        <div class="card card-style">
                            <div class="card-body">
                                <h6>Hello {{get_user_name(request()->user->user_id)}}</h6>

                                <?php //if ($event_acc->amount_gift && $event_acc->paid) { ?>
                                <?php if ($event_acc->amount_gift) { ?>
                                <p>
                                    Thank you for responding to your RSVP using CryptoGifting on the event of <a href="#">{{get_user_name($event_acc->event_info->event_creator)}}</a> an opportunity to earn the Gift of Wealth.
                                </p>
                                <?php } else { ?>
                                <p>

                                    Thank you for responding to your RSVP using CryptoGifting on the event of <a href="#">{{get_user_name($event_acc->event_info->event_creator)}}</a>.
                                </p>

                                <?php } ?>

                                <p class="bold">Team CryptoGifting <br> Making Gifting Crypto Easy</p>
                            </div>
                        </div>
                        <p>
                            CryptoGifting makes inviting guests and receiving gifts easy with just a few clicks. <br>
                            Want to know more? <a href="{{route('EarnInterest')}}">Click here</a>
                            <br><br>
                            Questions? <a href="{{route('Help')}}">Click here</a> to visit our Help Page
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
@include('user-dashboard.footer')