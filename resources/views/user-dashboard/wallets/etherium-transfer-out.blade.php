@include('user-dashboard.head')
    <title>Etherium Transfer Out | Crypto Gifting</title>
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
                    </div>

                    <div class="wallet-transactions-wrapper">
                        <h6 class="t-heading">transactions</h6>
                        <div class="transactions">
                            <div class="transaction">
                                <div class="trans-type">
                                    <h6>In</h6>
                                    <small>12 AUG, 2021 | 12:23</small>
                                </div>
                                <h5 class="transaction-amount in">-eth 0.01000000</h5>
                            </div>
                            <div class="transaction">
                                <div class="trans-type">
                                    <h6>Out</h6>
                                    <small>12 sep, 2021 | 10:02</small>
                                </div>
                                <h5 class="transaction-amount out">-eth 0.01000000</h5>
                            </div>
                            <div class="transaction">
                                <div class="trans-type">
                                    <h6>In</h6>
                                    <small>12 AUG, 2021 | 12:23</small>
                                </div>
                                <h5 class="transaction-amount in">-eth 0.01000000</h5>
                            </div>
                            <div class="transaction">
                                <div class="trans-type">
                                    <h6>Out</h6>
                                    <small>12 sep, 2021 | 10:02</small>
                                </div>
                                <h5 class="transaction-amount out">-eth 0.01000000</h5>
                            </div>
                            <div class="transaction">
                                <div class="trans-type">
                                    <h6>In</h6>
                                    <small>12 AUG, 2021 | 12:23</small>
                                </div>
                                <h5 class="transaction-amount in">-eth 0.01000000</h5>
                            </div>
                            <div class="transaction">
                                <div class="trans-type">
                                    <h6>Out</h6>
                                    <small>12 sep, 2021 | 10:02</small>
                                </div>
                                <h5 class="transaction-amount out">-eth 0.01000000</h5>
                            </div>
                            <div class="transaction">
                                <div class="trans-type">
                                    <h6>In</h6>
                                    <small>12 AUG, 2021 | 12:23</small>
                                </div>
                                <h5 class="transaction-amount in">-eth 0.01000000</h5>
                            </div>
                            <div class="transaction">
                                <div class="trans-type">
                                    <h6>Out</h6>
                                    <small>12 sep, 2021 | 10:02</small>
                                </div>
                                <h5 class="transaction-amount out">-eth 0.01000000</h5>
                            </div>
                            <div class="transaction">
                                <div class="trans-type">
                                    <h6>In</h6>
                                    <small>12 AUG, 2021 | 12:23</small>
                                </div>
                                <h5 class="transaction-amount in">-eth 0.01000000</h5>
                            </div>
                            <div class="transaction">
                                <div class="trans-type">
                                    <h6>Out</h6>
                                    <small>12 sep, 2021 | 10:02</small>
                                </div>
                                <h5 class="transaction-amount out">-eth 0.01000000</h5>
                            </div>
                        </div>
                    </div>


                    <div class="centered-div">
                        <a href="#" class="btn blue-button">Transfer ETH Out</a>
                    </div>

                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
@include('user-dashboard.footer')