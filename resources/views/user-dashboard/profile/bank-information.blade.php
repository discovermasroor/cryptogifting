@include('user-dashboard.head')
    <title>Bank detail | CryptoGifting</title>
    <body>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content withdraw-page">
                <div class="overlay" style="position: relative;">
                    <div class="main-heading-box flex">
                        <h3>Add or Update your Bank Details</h3>
                        <?php if ($bank_found) { ?>
                            <a href="#" id="add-new-one" class="btn blue-button d-none">Add new one</a>
                        <?php } ?>
                    </div>
                    <form action="{{route('StoreBankDetail')}}" id="parent-form" method="post" class="form-style widthdraw-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="bank" id="relation" value="<?php if ($bank_found) echo $bank_details->bank; ?>">
                        <input type="hidden" name="account_type" id="attire_name" value="<?php if ($bank_found) echo $bank_details->account_type; ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="" class="form-label">Bank Name *</label>
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
                                    <div class="selected" id="bank-selected"><?php if ($bank_found) echo $bank_details->bank; else echo 'Bank Name<span class="necessary">*</span>'; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="accountNumber" class="form-label">Bank Account Number *</label>
                                <input type="text" name="account_number" value="<?php if ($bank_found) echo $bank_details->account_number; ?>" class="form-control" id="accountNumber" placeholder="Bank Account Number*" name="accountNumber">
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label">Account Type *</label>
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
                                    <div class="selected" id="account-type-selected"><?php if ($bank_found) echo $bank_details->account_type; else echo 'Account Type <span class="necessary">*</span>'; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="branchCode" class="form-label">Branch Code *</label>
                                <input type="number" name="branch_code" value="<?php if ($bank_found) echo $bank_details->branch_code; ?>" class="form-control" id="branchCode" placeholder="Branch Code*">
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="text-center my-4 pt-2">
                                    <div class="two-button-box mx-auto" style="width: 100%; max-width: 450px;">
                                        <button type="button" onclick="goBack()" class="btn common-button">Back</button> 
                                        <button type="submit" class="btn blue-button my-0" id="bank-details-button">Update</button>
                                    </div>
                                </div>
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
                    
                    <p class="compulsory">* Compulsory Fields</p>
                   
                  
                </div>
            </div>
            <script>

                function charLimit(input, maxChar) {
                    var len = $(input).val().length;

                    if (len >= maxChar) {
                        $(input).val($(input).val().substring(0, maxChar));
                        $('#accountNumber').preventDefault();
                    }
                }
                jQuery(document).ready(function ($) {

                    $("#accountNumber").on('keyup', function() {
                        charLimit(this, 12); 
                    });
                    $("#branchCode").on('keyup', function() {
                        charLimit(this, 6); 
                    });
                    $('#add-new-one').on('click', function (e) {
                        e.preventDefault();
                        $('#relation').val('');
                        $('#branchCode').val('');
                        $('#accountNumber').val('');
                        $('#attire_name').val('');
                        $('#account-type-selected').html('Account Type <span class="necessary">*</span>');
                        $('#bank-selected').html('Bank Name<span class="necessary">*</span>');
                        
                    });
                    $('#bank-details-button').on('click', function (e) {
                        e.preventDefault();
                        var relation = $('#relation').val();
                        var accountType = $('#attire_name').val();
                        var accountNumber = $('#accountNumber').val();
                        var branchCode = $('#branchCode').val();
                        if (relation == undefined || relation == ''  || accountType == undefined || accountType == ''  || accountNumber == undefined || accountNumber == ''  || branchCode == undefined || branchCode == '') {
                            displayError('Kindly fill your form appropriately!');
                            return false;
                        }

                        $("#acc-confirm-popup").modal('show');
                    });
                    $('#acc-confirm-popup .blue-button').on('click', function (e) {
                        $('#parent-form').submit();
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
    <script>
        function goBack()
        {
            window.history.back()
        }
    </script>
@include('user-dashboard.footer')