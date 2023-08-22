@include('user-dashboard.head')
    <title>Fail Payment! | Dashboard</title>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content">
                <div class="overlay">

                    <div class="thankyou">
                        <img src="{{asset('public/')}}/assets/images/dashboard/fail-payment.png" class="img-fluid">
                        <div class="card card-style">
                            <div class="card-body">
                                <h6>Hello {{get_user_name(request()->user->user_id)}}</h6>
                                <p>
                                    We are sorry! We couldn't complete your request. Please check your payment Information or Try again Later
                                </p>
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