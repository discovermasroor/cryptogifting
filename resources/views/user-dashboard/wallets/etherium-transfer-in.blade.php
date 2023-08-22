@include('user-dashboard.head')
    <title>Etherium Transfer In | Crypto Gifting</title>
    <body>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content">
                <div class="overlay">
                    <h1 class="main-heading">Ethereum</h1>
                    <h1 class="currency-heading"><img src="{{asset('/public')}}/assets/images/dashboard/currency-ethereum.png" alt=""> ETH
                        0.0100000</h1>
                    <div class="centered-div">
                        <div class="rate-status">
                            <span class="up">0.01000000 <i class="uil uil-arrow-down-left green"></i></span>
                            <span class="down">0.01000000 <i class="uil uil-arrow-up-right red"></i></span>
                        </div>
                        <img src="{{asset('/public')}}/assets/images/dashboard/empty.png" class="img-fluid empty-img">
                        <p>
                            Transfer ETH into your ETH Savings wallet to start earning <br><span>up to 3%
                                interest</span>
                        </p>
                        <a href="{{route('EtheriumTransferOutView')}}" class="btn blue-button">Transfer ETH in</a>
                    </div>


                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
@include('user-dashboard.footer')