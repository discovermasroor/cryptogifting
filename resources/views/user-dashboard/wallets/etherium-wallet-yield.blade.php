@include('user-dashboard.head')
    <title>Etherium Yield Wallet | Crypto Gifting</title>
    <body>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content">
                <div class="overlay">
                    <h1 class="main-heading">yield wallet</h1>

                    <div id="yield-wallet-slider" class="carousel slide yield-slider" data-bs-ride="false">
                        <div class="carousel-indicators">
                            <button id="ind-1" type="button" data-bs-target="#yield-wallet-slider" data-bs-slide-to="0"
                                class="active" aria-label="Slide 1"></button>
                            <button id="ind-2" type="button" data-bs-target="#yield-wallet-slider" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                            <button id="ind-3" type="button" data-bs-target="#yield-wallet-slider" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active" id="c1">
                                <div class="img-box">
                                    <img src="{{asset('/public')}}/assets/images/dashboard/yield-ethereum-rafiki.png" class="img-fluid">
                                </div>
                                <h3 class="medium-heading">Earn up to 3% interest with your ETH Saving wallet</h3>
                                <p>Saving Ethereum is smart. <span>Earning interest</span> on your Ethereum savings is
                                    brilliant.</p>
                                <p>
                                    Create your ETH Savings wallet and transfer Ethereum in to earn <span>up to
                                        3%</span>
                                    interest per <span>annum</span>. We'll pay the interest into your ETH Savings wallet
                                    on the Ist of each month.
                                </p>
                                <a href="#c2" class="btn blue-button" id="next-btn1">next</a>
                            </div>
                            <div class="carousel-item" id="c2">
                                <div class="img-box">
                                    <img src="{{asset('/public')}}/assets/images/dashboard/yield-coins-rafiki.png" class="img-fluid">
                                </div>
                                <h3 class="medium-heading">How you earn interest</h3>
                                <p>
                                    When you transfer Ethereum into your ETH Savings wallet, it is then lent to our
                                    <span>trusted lending partner</span> who enters into individual loans with third
                                    parties. There is some risk, so please familiarize yourself with our ETH Savings
                                    wallet terms and conditions.
                                </p>
                                <p class="mb-0">
                                    Interest varies depending on <span>market conditions</span>, so the interest rate
                                    changes over time.
                                </p>
                                <a href="#c3" class="btn blue-button" id="next-btn2">next</a>
                            </div>
                            <div class="carousel-item" id="c3">
                                <div class="img-box">
                                    <img src="{{asset('/public')}}/assets/images/dashboard/yield-banknote-rafiki.png" class="img-fluid">
                                </div>
                                <h3 class="medium-heading">You're in control</h3>
                                <p>
                                    While your ETH Savings wallet is for long-term investing, you can transfer your
                                    Ethereum out at any time at <span>no charge</span>. The transfer out to your
                                    Ethereum
                                    wallet is <span>usually instant</span> but can take up to <span>7 business
                                        days</span>.
                                </p>
                                <p class="mb-0">
                                    You'll first have to agree to the Savings wallet terms, then transfer Ethereum in to
                                    start earning interest
                                </p>
                                <a href="{{route('SavingWalletTermsEtherium')}}" class="btn blue-button">next</a>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
    
    <script>
        $(document).ready(function () {
            $('#next-btn1').click(function () {
                $('#c1').removeClass('active');
                $('#ind-1').removeClass('active');

                $('#ind-2').addClass('active');
                $('#c2').addClass('active');

            })
            $('#next-btn2').click(function () {
                $('#c2').removeClass('active');
                $('#ind-2').removeClass('active');

                $('#ind-3').addClass('active');
                $('#c3').addClass('active');

            })
        });
    </script>
@include('user-dashboard.footer')