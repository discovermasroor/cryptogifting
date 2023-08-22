@include('user-dashboard.head')
    <title>Create Bitcoin Wallet | Crypto Gifting</title>
    <body>
        @include('user-dashboard.user-dashboard-header')
        <div class="main-content">
            <div class="overlay">
                <h1 class="main-heading">Create Wallet</h1>

                <div class="centered-div">
                    <img src="{{asset('/public')}}/assets/images/dashboard/create-btc-wallet.png" class="img-fluid">
                    <h3 class="medium-heading">Let's create your BTC Savings wallet</h3>
                    <p class="my-4">Then transfer Bitcoin into it from your Bitcoin wallet to start earning
                        interest.</p>
                    <a href="{{route('ReadyBitcoinWallet')}}" class="btn blue-button">Create Wallet</a>

                    <a href="{{route('BitcoinWallet')}}" class="not-now">Not Now</a>

                    <div class="alert alert-primary">
                        <p>
                            You previously agreed to the <a href="#">Savings wallet terms</a> when you added your
                            first Savings wallet
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>
@include('user-dashboard.footer')