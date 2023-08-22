@include('user-dashboard.head')
    <title>Add Withdraw Request | CryptoGifting</title>
    <body>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content withdraw-page">
                <div class="overlay">
                    <h1 class="main-heading">Withdraw Request</h1>
                    <form action="{{route('StoreWithdrawalRequest')}}" id="parent-form" method="post" class="form-style widthdraw-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="beneficiary" id="beneficiar" value="">
                        <input type="hidden" name="bank" id="relation" value="">
                        <input type="hidden" name="currency" id="status" value="">
                        <input type="hidden" name="account_type" id="attire_name" value="">
                        <input type="hidden" name="amount" id="final-amount" value="">
                        <input type="hidden" name="smile_id" value="{{$sid}}">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="form-heading">Add new bank details</h3>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="sr-only">Beneficiary Full Name</label>
                                <div class="select-box">
                                    <div class="options-container">
                                        <?php foreach ($benefs as $key => $value) { ?>
                                            <div class="option beneficiar-option">
                                                <input type="radio" class="radio" id="{{$value->beneficiary_id}}" />
                                                <label for="{{$value->beneficiary_id}}" class="text-bold" data-user-id="{{$value->beneficiary_id}}" >{{get_user_name($value->beneficiary_id)}}</label>
                                            </div>
                                        <?php } ?>
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
                                        <div class="relation-option option">
                                            <input type="radio" class="radio" id="bank-name-option-1" />
                                            <label for="bank-name-option-1" class="text-bold">ABSA</label>
                                        </div>
                                        <div class="relation-option option">
                                            <input type="radio" class="radio" id="bank-name-option-2" />
                                            <label for="bank-name-option-2" class="text-bold">Standard Bank</label>
                                        </div>
                                        <div class="relation-option option">
                                            <input type="radio" class="radio" id="bank-name-option-3" />
                                            <label for="bank-name-option-3" class="text-bold">First National Bank</label>
                                        </div>
                                        <div class="relation-option option">
                                            <input type="radio" class="radio" id="bank-name-option-4" />
                                            <label for="bank-name-option-4" class="text-bold">NEDBANK</label>
                                        </div>
                                        <div class="relation-option option">
                                            <input type="radio" class="radio" id="bank-name-option-5" />
                                            <label for="bank-name-option-5" class="text-bold">CAPITEC</label>
                                        </div>
                                        <div class="relation-option option">
                                            <input type="radio" class="radio" id="bank-name-option-6" />
                                            <label for="bank-name-option-6" class="text-bold">INVESTEC</label>
                                        </div>
                                        <div class="relation-option option">
                                            <input type="radio" class="radio" id="bank-name-option-7" />
                                            <label for="bank-name-option-7" class="text-bold">TYME BANK</label>
                                        </div>
                                        <div class="relation-option option">
                                            <input type="radio" class="radio" id="bank-name-option-8" />
                                            <label for="bank-name-option-8" class="text-bold">AFRICAN BANK</label>
                                        </div>
                                        <div class="relation-option option">
                                            <input type="radio" class="radio" id="bank-name-option-9" />
                                            <label for="bank-name-option-9" class="text-bold">BIDVEST BANK</label>
                                        </div>
                                        <div class="relation-option option">
                                            <input type="radio" class="radio" id="bank-name-option-10" />
                                            <label for="bank-name-option-10" class="text-bold">OLD MUTUAL BANK</label>
                                        </div>
                                    </div>
                                    <div class="selected">Bank Name*<span class="necessary">*</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="accountNumber" class="form-label sr-only">Bank Account Number</label>
                                <input type="text" name="account_number" class="form-control" id="accountNumber" placeholder="Bank Account Number*" name="accountNumber">
                            </div>
                            <div class="col-md-6">
                                <label for="" class="sr-only">Account Type</label>
                                <div class="select-box">
                                    <div class="options-container">
                                        <div class="attire-option option">
                                            <input type="radio" class="radio" id="account-type-option-1" />
                                            <label for="account-type-option-1" class="text-bold">Current (cheque/bond) Account</label>
                                        </div>
                                        <div class="attire-option option">
                                            <input type="radio" class="radio" id="account-type-option-2" />
                                            <label for="account-type-option-2" class="text-bold">Savings Account</label>
                                        </div>
                                        <div class="attire-option option">
                                            <input type="radio" class="radio" id="account-type-option-3" />
                                            <label for="account-type-option-3" class="text-bold">Transmission Account</label>
                                        </div>
                                        <div class="attire-option option">
                                            <input type="radio" class="radio" id="account-type-option-4" />
                                            <label for="account-type-option-4" class="text-bold">Bond Account</label>
                                        </div>
                                        <div class="attire-option option">
                                            <input type="radio" class="radio" id="account-type-option-5" />
                                            <label for="account-type-option-5" class="text-bold">Subscription Share Account</label>
                                        </div>
                                        <div class="attire-option option">
                                            <input type="radio" class="radio" id="account-type-option-6" />
                                            <label for="account-type-option-6" class="text-bold">Fnbcard Account</label>
                                        </div>
                                        <div class="attire-option option">
                                            <input type="radio" class="radio" id="account-type-option-7" />
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
                                <input type="number" name="branch_code" class="form-control" id="branchCode" placeholder="Branch Code*">
                            </div>
                            <div class="col-md-12 text-center">
                                <a href="#" class="btn blue-button" id="bank-details-button">Next</a>
                            </div>
                        </div>
                    </form>
                    <div class="modal fade popup-style" id="acc-confirm-popup" tabindex="-1"
                        aria-labelledby="acc-confirm-popupLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mt-0">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h5 class="popup-heading">Is this your bank account?</h5>
                                    <p>
                                        For your security you can only withdraw money to your own bank account. Please
                                        use your full name shown on your bank statements otherwise the withdrawal may be
                                        cancelled.
                                    </p>
                                    <div class="button-wrapper">
                                        <button class="common-button btn close" data-bs-dismiss="modal">No</button>
                                        <button class="blue-button btn close" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#withdraw-final--popup">Yes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade popup-style" id="withdraw-final--popup" tabindex="-1"
                        aria-labelledby="withdraw-final--popupLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mt-0 modal-dialog-big">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h5 class="popup-heading">
                                        How much do you want to withdraw <br> to FNB/RMB X9623?
                                    </h5>
                                    <form action="" class="form-style">
                                        <div class="row">
                                            <div class="col-md-5 px-0 px-md-2">
                                                <label for="" class="sr-only">Currency</label>
                                                <div class="select-box">
                                                    <div class="options-container">
                                                        <div class="status-option option">
                                                            <input type="radio" class="radio" id="currency-1"/>
                                                            <label for="currency-1" class="text-bold">Rand (ZAR)</label>
                                                        </div>
                                                    </div>
                                                    <div class="selected">
                                                        Currency
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7 px-0 px-md-2">
                                                <div class="input-group">
                                                    <input type="number" id="amount" class="form-control" placeholder="Amount">
                                                    <span class="input-group-text">Max</span>
                                                </div>
                                            </div>
                                        </div>
                                        <h6 class="sub-heading">
                                            Currently You Have ZAR <span class="amount">0.0100000</span>
                                        </h6>
                                        <button type="button" id="complete-withdrawal-request" class="close btn blue-button mt-3">Next</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade popup-style success-popup" id="withdraw-success-popup" tabindex="-1"
                        aria-labelledby="withdraw-success-popupLabel" aria-hidden="true">
                        <div class="modal-dialog  modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <img src="{{asset('/public')}}/assets/images/dashboard/bitcoin-amico.png" class="img-fluid art-img">
                                    <h1>success</h1>
                                    <h4 class="mb-4">Your withdraw request has been completed! We will let you know shortly about its status.</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                jQuery(document).ready(function ($) {
                    $('#bank-details-button').on('click', function (e) {
                        e.preventDefault();
                        var benef = $('#beneficiar').val();
                        var relation = $('#relation').val();
                        var accountType = $('#attire_name').val();
                        var accountNumber = $('#accountNumber').val();
                        var branchCode = $('#branchCode').val();
                        if (benef == undefined || benef == '' || relation == undefined || relation == ''  || accountType == undefined || accountType == ''  || accountNumber == undefined || accountNumber == ''  || branchCode == undefined || branchCode == '') {
                            displayError('Kindly fill your form appropriately!');
                            return false;
                        }

                        $("#acc-confirm-popup").modal('show');
                    });
                    $('#complete-withdrawal-request').on('click', function (e) {
                        var amount = $('#amount').val();
                        var currency = $('#status').val();

                        if (amount == undefined || amount == '' || currency == undefined || currency == '') {
                            displayError('Enter your amount and choose currency correctly!');
                            return false;

                        }
                        $('#final-amount').val(amount);
                        $("#withdraw-success-popup").modal('show');
                        setTimeout(function(){ $('form#parent-form').submit(); }, 5000);

                    });
                    function displayError(message, single = true) {
                        var html = ''
                        html += '<div class="alert custom-alert alert-danger d-flex align-items-center" role="alert">';
                        html += '<ul>';

                        if (single) {
                            html += '<li><i class="uis uis-exclamation-triangle"></i>'+message+'</li>';

                        } else {
                            $.each(message, function(index, value){
                                html += '<li><i class="uis uis-exclamation-triangle"></i>'+value+'</li>';
                            });

                        }

                        html += '</ul>';
                        html += '</div>';
                        $('body').append(html);
                        setTimeout(function(){ $('body').find('div.alert.custom-alert').remove(); }, 5000);
                    }

                    function displaySuccess(message) {
                        var html = ''
                        html += '<div class="alert custom-alert alert-success d-flex align-items-center" role="alert">';
                        html += '<ul>';
                        html += '<li><i class="uil uil-check-circle"></i>'+message+'</li>';
                        html += '</ul>';
                        html += '</div>';
                        $('body').append(html);
                        setTimeout(function(){ $('body').find('div.alert.custom-alert').remove(); }, 5000);
                    }
                });
            </script>
        </section>
    </main>
@include('user-dashboard.footer')