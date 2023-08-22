@include('user-dashboard.head')
    <title>Add Bank Account | Crypto Gifting</title>
    <body>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content withdraw-page">
                <div class="overlay">
                    <h1 class="main-heading">Withdraw</h1>
                    <form action="" class="form-style widthdraw-form">
                        <div class="row">

                            <div class="col-md-12">
                                <h3 class="form-heading">Add new bank details</h3>
                            </div>

                            <div class="col-md-6">
                                <label for="" class="sr-only">Beneficiary Full Name</label>
                                <div class="select-box">
                                    <div class="options-container">
                                        <div class="option">
                                            <input type="radio" class="radio" id="bank-region-option-1"
                                                name="bank-region" />
                                            <label for="bank-region-option-1" class="text-bold">Eastern Cape</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="bank-region-option-2"
                                                name="bank-region" />
                                            <label for="bank-region-option-2" class="text-bold">Free State</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="bank-region-option-3"
                                                name="bank-region" />
                                            <label for="bank-region-option-3" class="text-bold">Gauteng</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="bank-region-option-4"
                                                name="bank-region" />
                                            <label for="bank-region-option-4" class="text-bold">KwaZulu-Natal</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="bank-region-option-5"
                                                name="bank-region" />
                                            <label for="bank-region-option-5" class="text-bold">Limpopo</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="bank-region-option-6"
                                                name="bank-region" />
                                            <label for="bank-region-option-6" class="text-bold">Mpumalanga</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="bank-region-option-7"
                                                name="bank-region" />
                                            <label for="bank-region-option-7" class="text-bold">Northern Cape</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="bank-region-option-8"
                                                name="bank-region" />
                                            <label for="bank-region-option-8" class="text-bold">North-West</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="bank-region-option-9"
                                                name="bank-region" />
                                            <label for="bank-region-option-9" class="text-bold">Western Cape</label>
                                        </div>
                                    </div>

                                    <div class="selected">
                                        Beneficiary Full Name <span class="necessary">*</span>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="" class="sr-only">Bank Name</label>
                                <div class="select-box bank-type">
                                    <div class="options-container">
                                        <div class="option">
                                            <input type="radio" class="radio" id="bank-name-option-1"
                                                name="category-events" />
                                            <label for="bank-name-option-1" class="text-bold">ABSA</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="bank-name-option-2"
                                                name="category-events" />
                                            <label for="bank-name-option-2" class="text-bold">Standard Bank</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="bank-name-option-3"
                                                name="category-events" />
                                            <label for="bank-name-option-3" class="text-bold">First National
                                                Bank</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="bank-name-option-4"
                                                name="category-events" />
                                            <label for="bank-name-option-4" class="text-bold">NEDBANK</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="bank-name-option-5"
                                                name="category-events" />
                                            <label for="bank-name-option-5" class="text-bold">CAPITEC</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="bank-name-option-6"
                                                name="category-events" />
                                            <label for="bank-name-option-6" class="text-bold">INVESTEC</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="bank-name-option-7"
                                                name="category-events" />
                                            <label for="bank-name-option-7" class="text-bold">TYME BANK</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="bank-name-option-8"
                                                name="category-events" />
                                            <label for="bank-name-option-8" class="text-bold">AFRICAN BANK</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="bank-name-option-9"
                                                name="category-events" />
                                            <label for="bank-name-option-9" class="text-bold">BIDVEST BANK</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="bank-name-option-10"
                                                name="category-events" />
                                            <label for="bank-name-option-10" class="text-bold">OLD MUTUAL BANK</label>
                                        </div>
                                    </div>

                                    <div class="selected">
                                        Bank Name <span class="necessary">*</span>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="accountNumber" class="form-label sr-only">Bank Account Number</label>
                                <input type="num" class="form-control" id="accountNumber"
                                    placeholder="Bank Account Number *" name="accountNumber">
                            </div>

                            <!--<div class="col-md-6">-->
                            <!--    <label for="bank" class="form-label sr-only">Account Type *</label>-->
                            <!--    <input type="text" class="form-control" id="bank" placeholder="Account Type *">-->
                            <!--</div>-->



                            <div class="col-md-6">
                                <label for="" class="sr-only">Account Type</label>
                                <div class="select-box">
                                    <div class="options-container">
                                        <div class="option">
                                            <input type="radio" class="radio" id="account-type-option-1"
                                                name="account-type" />
                                            <label for="account-type-option-1" class="text-bold">Current (cheque/bond)
                                                Account</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="account-type-option-2"
                                                name="account-type" />
                                            <label for="account-type-option-2" class="text-bold">Savings Account</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="account-type-option-3"
                                                name="account-type" />
                                            <label for="account-type-option-3" class="text-bold">Transmission
                                                Account</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="account-type-option-4"
                                                name="account-type" />
                                            <label for="account-type-option-4" class="text-bold">Bond Account</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="account-type-option-5"
                                                name="account-type" />
                                            <label for="account-type-option-5" class="text-bold">Subscription Share
                                                Account</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="account-type-option-6"
                                                name="account-type" />
                                            <label for="account-type-option-6" class="text-bold">Fnbcard Account</label>
                                        </div>
                                        <div class="option">
                                            <input type="radio" class="radio" id="account-type-option-7"
                                                name="account-type" />
                                            <label for="account-type-option-7" class="text-bold">WesBank</label>
                                        </div>
                                    </div>

                                    <div class="selected">
                                        Account Type <span class="necessary">*</span>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="branchCode" class="form-label sr-only">Branch Code *</label>
                                <input type="num" class="form-control" id="branchCode" placeholder="Branch Code *">
                            </div>

                            <div class="col-md-12 text-center">
                                <a href="#" class="btn blue-button" data-bs-toggle="modal" data-bs-target="#acc-confirm-popup">Next</a>
                            </div>

                        </div>
                    </form>

                    <!-- Account Connfirmation Popup -->
                    <div class="modal fade popup-style" id="acc-confirm-popup" tabindex="-1"
                        aria-labelledby="acc-confirm-popupLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mt-0">
                            <div class="modal-content">
                                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button> -->
                                <div class="modal-body">
                                    <h5 class="popup-heading">Is this your bank account?</h5>
                                    <p>
                                        For your security you can only withdraw money to your own bank account. Please
                                        use your full name shown on your bank statements otherwise the withdrawal may be
                                        cancelled.
                                    </p>
                                    <div class="button-wrapper">
                                        <button class="common-button btn close" data-bs-dismiss="modal">No</button>
                                        <button class="blue-button btn close" data-bs-dismiss="modal"
                                            data-bs-toggle="modal" data-bs-target="#withdraw-amount-popup">Yes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Withdraw Option Popup -->
                    <!-- <div class="modal fade popup-style" id="withdraw-option-popup" tabindex="-1"
                        aria-labelledby="withdraw-option-popupLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mt-0 modal-dialog-big">
                            <div class="modal-content"> -->
                                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button> -->
                                <!-- <div class="modal-body">
                                    <div class="button-wrapper">
                                        <button class="btn">
                                            <img src="{{asset('/public')}}/assets/images/dashboard/exchange.png" class="img-fluid">
                                            Liquidate Crypto To ZAR
                                        </button>
                                        <button class="btn close" data-bs-dismiss="modal" data-bs-toggle="modal"
                                            data-bs-target="#withdraw-amount-popup">
                                            <img src="{{asset('/public')}}/assets/images/dashboard/wallet.png" class="img-fluid">
                                            Withdraw Wallet
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Withdraw Amount Popup -->
                    <div class="modal fade popup-style" id="withdraw-amount-popup" tabindex="-1"
                        aria-labelledby="withdraw-amount-popupLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mt-0 modal-dialog-big">
                            <div class="modal-content">
                                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button> -->
                                <div class="modal-body">
                                    <h5 class="popup-heading">
                                        How much do you want to withdraw <br> to FNB/RMB X9623?
                                    </h5>
                                    <form action="" class="form-style">
                                        <div class="row">
                                            <div class="col-md-3 px-0 px-md-2">
                                                <label for="" class="sr-only">Currency</label>
                                                <div class="select-box">
                                                    <div class="options-container">
                                                        <div class="option">
                                                            <input type="radio" class="radio" id="currency-1"
                                                                name="currency-type" />
                                                            <label for="currency-1" class="text-bold">Rand (ZAR)</label>
                                                        </div>
                                                    </div>
                                                    <div class="selected">
                                                        Currency
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-9 px-0 px-md-2">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Amount">
                                                    <span class="input-group-text">Max</span>
                                                </div>
                                            </div>
                                        </div>
                                        <h6 class="sub-heading">
                                            Currently You Have BTC <span class="amount">0.0100000</span>
                                        </h6>
                                        <button type="button" class="close btn blue-button mt-3" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#withdraw-success-popup">Next</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Withdraw Success Popup -->
                    <div class="modal fade popup-style success-popup" id="withdraw-success-popup" tabindex="-1"
                        aria-labelledby="withdraw-success-popupLabel" aria-hidden="true">
                        <div class="modal-dialog  modal-dialog-centered">
                            <div class="modal-content">
                                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button> -->
                                <div class="modal-body">
                                    <img src="{{asset('/public')}}/assets/images/dashboard/bitcoin-amico.png" class="img-fluid art-img">
                                    <h1>success</h1>
                                    <h4 class="mb-4">Your withdraw request has been completed!</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
@include('user-dashboard.footer')