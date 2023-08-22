@include('admin.head')
    <title>Withdrawal Requests | Dashboard</title>
    <body>
        @include('admin.header-sidebar')
            <!-- Main Content Starts -->
            <div class="main-content">
                <div class="overlay">
                    <form id="transaction-form" action="{{route('WithdrawalRequestAdmin')}}" method="get">
                        <input type="hidden" id="export" name="export" value="0">
                        <input type="hidden" id="status" name="status" value="">
                        <input type="hidden" id="attire_name" name="filter_status" value="">
                        <div class="main-heading-box flex">
                            <h3>Withdrawal History</h3>
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
                                        <div class="selected"><?php if (isset($_GET['status']) && !empty($_GET['status'])) echo $_GET['status']; else echo 'STC Status'; ?></div>
                                    </div>
                                </div>
                                <button type="button" id="status-button" class="btn submit-button ">Update STC Status</button>

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
                                        <div class="selected"><?php if (isset($_GET['filter_status']) && !empty($_GET['filter_status'])) echo $_GET['filter_status']; else echo 'STC Status'; ?></div>
                                    </div>
                                </div>
                                <div class="date-field-special me-2" style="margin-left: 10px;">
                                    <input class="form-control" type="text" required onfocus="(this.type='date')" name="start_date" value="<?php if (isset($_GET['start_date']) && !empty($_GET['start_date'])) echo $_GET['start_date']; ?>" placeholder="Start Date">
                                </div>
                                <div class="date-field-special me-2">
                                    <input class="form-control" type="text" required onfocus="(this.type='date')" name="end_date" value="<?php if (isset($_GET['end_date']) && !empty($_GET['end_date'])) echo $_GET['end_date']; ?>" placeholder="End Date">
                                </div>
                                <button type="submit" class="btn submit-button">Submit</button>
                                <button type="button" id="export-button" class="btn submit-button">Export</button>
                                <a href="{{route('WithdrawalRequestAdmin')}}" class="btn submit-button">Clear</a>
                            </div>
                        </div>
                        <div class="table-responsive data-table-wrapper mt-3 users-table">
                            <table class="table">
                                <thead class="heading-box">
                                    <tr>
                                        <th><input type="checkbox" name="select_all" id="select-all" value="123"></th>
                                        <th>User Name</th>
                                        <th class="email">Baneficiary Name</th>
                                        <th>Currency</th>
                                        <th>Requested Amount</th>
                                        <th>Final Amount</th>
                                        <th>Withdrawal Date</th>
                                        <th>Status</th>
                                        <th>Sent To Client</th>
                                        <th class="action-td">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($withdrawals as $key => $value) { ?>
                                        <tr>
                                            <td>@if($value->completed)<input type="checkbox" class="transaction-list-checks" name="transactions_list[]" value="{{$value->withdrawal_id}}"> @else - @endif</td>
                                            <td>{{get_user_name($value->user_id)}}</td>
                                            <td>@if($value->user_id == $value->beneficiary_id) <span class="green">Self</span> @else {{get_user_name($value->beneficiary_id)}}@endif</td>
                                            <td>{{$value->currency}}</td>
                                            <td><?php echo number_format($value->requested_amount, 10); ?></td>
                                            <?php if(isset($value->response)) {
                                                $total_amount = json_decode($value->response)->receivedAmount;     
                                            } else {
                                                $total_amount = 0;
                                            }
                                            ?>
                                            <td>R{{number_format($value->requested_amount_by_user_in_zar-($value->all_charged_fees_in_zar+$value->valr_taker_share+$value->valr_withdrawal_fees_share), 2)}}</td>
                                            <td><?php echo $value->created_at->format('d-M-Y H:i:s'); ?></td>
                                            @if($value->in_progress)
                                                <td class="orange">In Progress</td>
                                                @elseif($value->completed)
                                                <td class="green">Completed</td>
                                                @else
                                                <td class="red">Failed</td>
                                            @endif
                                            <td>@if($value->completed) @if($value->sent_to_client) <span class="green">Yes</span> @else <span class="red">No</span>@endif @else - @endif</td>
                                            <td><a href="{{route('withdrawInfoAdmin', [$value->withdrawal_id])}}" class="btn edit-button">View</a>
                                            </td>
                                            
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

                                    if (isset($_GET['filter_status']) && !empty($_GET['filter_status'])) {
                                        $array_to_send['filter_status'] = $_GET['filter_status'];

                                    }
                                ?>
                                {{$withdrawals->appends($array_to_send)->links("pagination::bootstrap-4")}}
                            </nav>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Main Content Ends -->
        </section>
        <!-- Dashboard Main Content Ends -->
    </main>
    <script>
        jQuery(document).ready(function ($) {
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
                $('#export').val('1');
                $('#transaction-form').submit();
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