@include('admin.head')
    <title>Transactions | Crypto Gifting</title>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('admin.header-sidebar')
        <div class="main-content my-beneficiaries">
                <div class="overlay">
                    <form id="transaction-form" action="{{route('EventsTransactionsAdmin')}}" method="get">
                        <input type="hidden" id="export" name="export" value="0">
                        <input type="hidden" id="status" name="status" value="">
                        <input type="hidden" id="attire_name" name="filter_status" value="">
                        <div class="main-heading-box flex">
                            <h3>Incoming Transactions</h3>
                            <div class="filters mt-0">
                                <div class="filter">
                                    <label for="subject" class="sr-only">Update Status</label>
                                    <div class="select-box">
                                        <div class="options-container">
                                            <div class="option status-option">
                                                <input type="radio" class="radio" id="status-1"/>
                                                <label for="status-1" class="text-bold">Yes</label>
                                            </div>
                                            <div class="option status-option">
                                                <input type="radio" class="radio" id="status-2"/>
                                                <label for="status-2" class="text-bold">No</label>
                                            </div>
                                        </div>
                                        <div class="selected">STE Status</div>
                                    </div>
                                </div>

                                <button type="button" id="status-button" class="btn submit-button ">Update STE Status</button>

                                <div class="filter" style="margin-left: 10px;">
                                    <label for="subject" class="sr-only">Status</label>
                                    <div class="select-box">
                                        <div class="options-container">
                                            <div class="option attire-option">
                                                <input type="radio" class="radio" id="filter-status-1"/>
                                                <label for="filter-status-1" class="text-bold">Yes</label>
                                            </div>
                                            <div class="option attire-option">
                                                <input type="radio" class="radio" id="filter-status-2"/>
                                                <label for="filter-status-2" class="text-bold">No</label>
                                            </div>
                                        </div>
                                        <div class="selected"><?php if (isset($_GET['filter_status']) && !empty($_GET['filter_status'])) echo $_GET['filter_status']; else echo 'STE Status'; ?></div>
                                    </div>
                                </div>
                                <div class="date-field-special me-2" style="margin-left: 10px;">
                                    <input class="form-control" type="text" onfocus="(this.type='date')" name="start_date" value="<?php if (isset($_GET['start_date']) && !empty($_GET['start_date'])) echo $_GET['start_date']; ?>" placeholder="Start Date">
                                </div>
                                <div class="date-field-special me-2">
                                    <input class="form-control" type="text" onfocus="(this.type='date')" name="end_date" value="<?php if (isset($_GET['end_date']) && !empty($_GET['end_date'])) echo $_GET['end_date']; ?>" placeholder="End Date">
                                </div>
                                <div class="search-bar">
                                    <input class="form-control" name="transaction_id" value="<?php if (isset($_GET['transaction_id']) && !empty($_GET['transaction_id'])) echo $_GET['transaction_id']; ?>" type="search" placeholder="Transaction ID" aria-label="Search">
                                    <button class="btn " type="button"><i class="fas fa-search"></i></button>
                                </div>
                                <button type="submit" class="btn submit-button">Submit</button>
                                <button type="button" id="export-button" class="btn submit-button">Export</button>
                                <a href="{{route('EventsTransactionsAdmin')}}" class="btn submit-button">Clear</a>
                            </div>
                        </div>

                        <div class="table-responsive data-table-wrapper mt-2">
                            <table class="table">
                                <thead class="heading-box">
                                    <tr>
                                        <th><input type="checkbox" name="select_all" id="select-all" value="123"></th>
                                        <th>Transaction ID</th>
                                        <th>Beneficiary ID</th>
                                        <th>Beneficiary Name</th>
                                        <th>Beneficiary Surname</th>
                                        <th>Beneficiary VALR Name</th>
                                        <th>Gifter Name</th>
                                        <th>Gift Type</th>
                                        <th class="dob">Gift Date</th>
                                        <th>Gift Amount (ZAR)</th>
                                        <th>Gift Amount (BTC)</th>
                                        <th>Sent to Exchange</th>
                                        <th>Marked Completed</th>
                                        <th>Paid</th>
                                        <th class="action-td">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transactions as $key => $value) { ?>
                                        <tr>
                                            <td>@if ($value->paid && !$value->complete_transaction)<input type="checkbox" class="transaction-list-checks" name="transactions_list[]" value="{{$value->event_acceptance_id}}"> @else - @endif</td>
                                            <td>{{$value->event_acceptance_id}}</td>
                                            <td>{{$value->beneficiary_id}}</td>
                                            <td><?php if ($value->beneficiary && isset($value->beneficiary->name)) echo $value->beneficiary->name; else get_user_name($value->beneficiary_id) ?></td>
                                            <td>{{$value->beneficiary->surname}}</td>
                                            <td>{{$value->beneficiary->valr_account_name}}</td>

                                            <td><?php if ( !empty($value->gifter_id) && $value->gifter_id){   
                                                            if(!empty($value->gift_event_info  && !empty($value->gift_event_info->sender_name))) 
                                                                echo $value->gift_event_info->sender_name; 
                                                                else 
                                                                 echo get_user_name($value->gifter_id);
                                                        }else if ($value->contact_id){ 
                                                            echo get_user_name($value->contact_id);
                                                        } else if($value->event_id) {
                                                            echo $value->name;
                                                        
                                                        } 
                                                         else { ?> 
                                                          <span class="red">Anonymous</span>
                                                        <?php } ?></td>

                                            <td><?php if ($value->event_id) echo 'Event Gift'; else if (isset($value->gift_event_info) && $value->gift_event_info->get_crypto=='1') echo 'Public Link Gift'; else if(isset($value->gift_event_info) && $value->gift_event_info->gift_crypto =='1') echo 'E2E Gift'; else if ($value->event_id == NULL && $value->gifter_event_id == NULL ) echo 'Public Link Gift'; ?></td>
                                            <td><?php echo $value->created_at->format('d-M-Y h:i:s'); ?></td>
                                            
                                            <td>R{{number_format($value->amount, 2)}}</td>
                                            <td class="pending">@if ($value->transaction_details->btc_rate > 0) {{number_format($value->amount/$value->transaction_details->btc_rate, 10)}} BTC @else - @endif</td>



                                            {{--<td>@if ($value->event_id) {{$value->event_info->name}} @else - @endif</td>
                                            <td>@if ($value->event_id) {{get_user_name($value->event_info->beneficiary_id)}} @else - @endif</td> --}}
                                           
                                            
                                            <td><?php if ($value->paid) { if ($value->sent_to_exchange) echo '<span class="green">Yes</span>'; else echo '<span class="red">No</span>'; } else { echo '-'; } ?></td>
                                            <td><?php if ($value->paid) { if ($value->complete_transaction) echo '<span class="green">Yes</span>'; else echo '<span class="red">No</span>'; } else { echo '-'; } ?></td>
                                            <td><?php if ($value->paid) echo '<span class="green">Success</span>'; else echo '<span class="red">Failed</span>'; ?></td>
                                            <td><a href="{{route('GiftDetailsAdmin', [$value->event_acceptance_id])}}" class="btn edit-button">View</a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <nav class="d-flex justify-content-end pagination-box">
                                <?php 
                                    $array_to_send = array();

                                    if (isset($_GET['start_date']) && !empty($_GET['start_date'])) {
                                        $array_to_send['start_date'] = $_GET['start_date'];

                                    }

                                    if (isset($_GET['end_date']) && !empty($_GET['end_date'])) {
                                        $array_to_send['end_date'] = $_GET['end_date'];

                                    }

                                    if (isset($_GET['transaction_id']) && !empty($_GET['transaction_id'])) {
                                        $array_to_send['transaction_id'] = $_GET['transaction_id'];

                                    }

                                    if (isset($_GET['filter_status']) && !empty($_GET['filter_status'])) {
                                        $array_to_send['filter_status'] = $_GET['filter_status'];

                                    }
                                ?>
                                {{$transactions->appends($array_to_send)->links("pagination::bootstrap-4")}}
                            </nav>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <script>
        jQuery(document).ready(function () {
            $('#status-button').on('click', function (e) {
                e.preventDefault();
                var numberOfChecked = $('.transaction-list-checks:checked').length;
                var currentStatus = $('#status').val();
                if (numberOfChecked < 1) {
                    displayError('First check some records to update!');
                    return false;

                } else if (currentStatus == '' || currentStatus == undefined) {
                    displayError('Select status first!');
                    return false;
                }

                $('#export').val('0');
                $('#transaction-form').submit();
            });

            $('#export-button').on('click', function (e) {
                var allTransactions = [];
                var formData = new FormData();
                formData.append('_token', "{{csrf_token()}}");
                $('.transaction-list-checks:checked').each(function(i){
                    allTransactions[i] = $(this).val();
                    formData.append('transactions[]', $(this).val());

                });
                if (allTransactions.length > 0) {
                    $('#preloader').removeClass('d-none');
                    $.ajax({
                        url: '{{ route("CheckTransactionsBenef") }}',
                        type: 'POST',
                        data: formData,
                        dataType: 'JSON',
                        success: function (response) {
                            $('#preloader').addClass('d-none');
                            $('#export').val('1');
                            $('#transaction-form').submit();
                        },
                        error: function (err) {
                            $('#preloader').addClass('d-none');
                            if (err.status == 422) {
                                displayError(err.responseJSON.errors, false);
                            } else {
                                displayError(err.responseJSON.error.message);
                            }
                        },
                        async: true,
                        cache: false,
                        contentType: false,
                        processData: false,
                        timeout: 60000
                    });
                } else {
                    displayError('Select transactions first!');
                    return false;
                }
            });

            $('#select-all').on('change', function () {
                if ($(this).prop('checked')) {
                    $('.transaction-list-checks').prop('checked', true);

                } else {
                    $('.transaction-list-checks').prop('checked', false);

                }
            });

            $('.transaction-list-checks').on('change', function () {
                if (!$(this).prop('checked')) {
                    $('#select-all').prop('checked', false);

                }
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
            
        });
    </script>
@include('admin.footer')