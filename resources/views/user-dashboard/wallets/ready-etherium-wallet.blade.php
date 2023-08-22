@include('user-dashboard.head')
    <title>Ready Etherium Wallet | Crypto Gifting</title>
    <body>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content">
                <div class="overlay">
                    <h1 class="main-heading">Ethereum Wallet</h1>

                    <div class="centered-div">
                        <img src="{{asset('/public')}}/assets/images/dashboard/create-eth-wallet.png" class="img-fluid">
                        <h3 class="medium-heading">Your ETH Savings wallet is ready</h3>
                        <p class="my-4">
                            You'll need to buy ETH before you can transfer it into your ETH Savings wallet to
                            <span>Start earning interest</span>
                        </p>
                        <a href="{{route('EtheriumTransferInView')}}" class="btn blue-button">Go to ETH Savings Wallet</a>
                    </div>

                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
@include('user-dashboard.footer')
