@include('user-dashboard.head')
    <title>Bitcoin Wallet | Crypto Gifting</title>
    <body>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content">
                <div class="overlay">
                    <h1 class="main-heading">Bitcoin</h1>
                    <h1 class="currency-heading"><img src="{{asset('public/')}}/assets/images/dashboard/currency-bitcoin.png" alt="">btc 0</h1>
                    <h6 class="small-heading pb-4 pb-md-0">BTC wallet</h6>

                    {{--<div class="butttons-wrapper">
                        <a href="{{route('BitcoinWalletYield')}}" class="btn blue-button">yield</a>
                        <a class="btn blue-button" href="{{route('BitcoinWithdrawWithAddBank')}}">withdraw</a>
                    </div>--}}

                    <div class="wallet-transactions-wrapper">
                        <div class="amount">
                            <h4>balance</h4>
                            <h2>btc 0</h2>
                        </div>
                        <hr>
                        <h6 class="t-heading">transactions</h6>
                        <div class="transactions">
                            <?php foreach ($transactions as $key => $value) { ?>
                                <div class="transaction">
                                    <div class="trans-type">
                                        <h6><?php if ($value->topup) echo 'Gift'; else echo 'withdrawal'; ?></h6>
                                        <small>{{$value->created_at()->format('d M, Y | h:i A') }}</small>
                                    </div>
                                    <h5 class="transaction-amount"><?php if ($value->topup) echo '+'; else echo '-'; ?>{{$value->currency}} {{$value->amount}}</h5>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
@include('user-dashboard.footer')