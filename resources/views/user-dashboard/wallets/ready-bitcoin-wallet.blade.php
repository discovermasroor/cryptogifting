@include('user-dashboard.head')
    <title>Ready Etherium Wallet | Crypto Gifting</title>
    <body>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content">
                <div class="overlay">
                    <h1 class="main-heading">Bitcoin Wallet</h1>

                    <div class="centered-div">
                        <img src="{{asset('/public')}}/assets/images/dashboard/create-btc-wallet.png" class="img-fluid">
                        <h3 class="medium-heading">Your BTC Savings wallet is ready</h3>
                        <p class="my-4">
                            You'll need to buy BTC before you can transfer it into your BTC Savings wallet to
                            <span>Start earning interest</span>
                        </p>
                        <a href="{{route('BitcoinTransferInView')}}" class="btn blue-button">Go to BTC Savings Wallet</a>
                    </div>

                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
@include('user-dashboard.footer')
