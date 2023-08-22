@include('user-dashboard.head')
    <title>All Funds Withdrawan | Dashboard</title>
    <body>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content my-beneficiaries">
                <div class="overlay">
                    <form action="" method="get">
                        <input type="hidden" name="filter_beneficiary" id="beneficiar" value="<?php if (isset($_GET['filter_beneficiary'])) echo $_GET['filter_beneficiary']; ?>">
                        <input type="hidden" name="status" id="gender" value="<?php if (isset($_GET['status'])) echo $_GET['status']; ?>">
                        <input type="hidden" name="end_date" id="end_date" value="<?php if (isset($_GET['end_date'])) echo $_GET['end_date']; ?>">
                        <!--<div class="main-heading-box flex">-->
                        <!--    <h3>Funds Withdrawn</h3>-->
                        <!--    <a href="#" class="btn blue-button">Withdraw</a>-->
                        <!--</div>-->
                        <div class="main-heading-box flex">
                            <h3>Funds Withdrawn</h3>
                            <div class="filters mt-0">
                            
                            <div class="filter">
                                    <label for="subject" class="sr-only">All Beneficiaries</label>
                                    <div class="select-box">
                                        <div class="options-container">
                                            @foreach ($beneficiaries as $benef_key => $benef_value) 
                                            <div class="option beneficiar-option">
                                                <input type="radio" class="radio" id="{{$benef_key}}" value="{{$benef_value->beneficiary_id}}"/>
                                                <label for="{{$benef_key}}" data-user-id="{{$benef_value->beneficiary_id}}" class="text-bold">{{get_user_name($benef_value->beneficiary_id)}}</label>
                                            </div>
                                            @endforeach
                                        </div>

                                        <div class="selected">
                                        @foreach ($beneficiaries as $benef_key => $benef_value) 
                                             @if(isset($_GET['filter_beneficiary'])  && !empty($_GET['filter_beneficiary']) && $_GET['filter_beneficiary'] == $benef_value->beneficiary_id)
                                                {{get_user_name($benef_value->beneficiary_id)}}   
                                            @endif  
                                        @endforeach
                                        <?php if (!isset($_GET['filter_beneficiary']) && empty($_GET['filter_beneficiary'])) { echo 'Beneficiaries'; } else if(isset($_GET['filter_beneficiary']) && empty($_GET['filter_beneficiary'])){  echo 'Beneficiaries'; } ?>
                                      
                                      
                                        </div>

                                    </div>
                                </div>
                                <div class="filter">
                                    <label for="subject" class="sr-only">Status</label>
                                    <div class="select-box">
                                        <div class="options-container">
                                            <div class="option gender-option">
                                                <input type="radio" class="radio" id="all-users-1"
                                                    />
                                                <label for="all-users-1" class="text-bold">In Progress</label>
                                            </div>
                                            <div class="option gender-option">
                                                <input type="radio" class="radio" id="all-users-2"
                                                    />
                                                <label for="all-users-2" class="text-bold">Completed </label>
                                            </div>
                                            <div class="option gender-option">
                                                <input type="radio" class="radio" id="all-users-3"
                                                    />
                                                <label for="all-users-3" class="text-bold">Failed</label>
                                            </div>
                                        </div>

                                        <div class="selected">
                                        <?php if (isset($_GET['status']) && !empty($_GET['status'])) { echo ucfirst($_GET['status']); } else { echo 'Status'; } ?>
                                        </div>

                                    </div>
                                </div>
                                <div class="date-field-special me-2">
                                    <input class="form-control" type="text" placeholder='Withdrwan Date' data-toggle="datepicker" name="end_date" value="<?php if (isset($_GET['end_date']) && !empty($_GET['end_date'])) echo $_GET['end_date']; ?>" >
                                </div>
                            
                            <div class="search-bar">
                                <input class="form-control" name="search" value="<?php if (isset($_GET['search']) && !empty($_GET['search'])) echo $_GET['search'];?>" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn " type="button"><i class="fas fa-search"></i></button>
                            </div>
                            <button type="submit" class="btn submit-button">Search</button>
                            <button type="submit" id="export-button" value="export" name="export" class="btn submit-button">Export</button>
                            <a href="{{route('LinkGifts')}}" class="btn submit-button">Clear</a> 
                            </div>
                        </div>
                   
                    <div class="table-responsive data-table-wrapper mt-2">
                        <table class="table">
                            <thead class="heading-box">
                                <tr>
                                <th>
                                            <!--<input type="checkbox" name="select_all" id="select-all" value="123" class="">-->
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="select_all" id="select-all" value="123">
                                                <label class="form-check-label" for="select-all">Select All </label>
                                            </div>
                                        </th>
                                    <th>Transaction ID</th>
                                    <th>Beneficiary Name</th>
                                    <th>Withdrawal Date</th>
                                    <th class="amount">Requested Amount (BTC)</th>
                                    <th class="amount">Amount Received (ZAR)</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($withdrawal) {
                                    foreach ($withdrawal as $key => $value) { ?>
                                        <tr>
                                            <td>
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" class="form-check-input contact-list-checks" name="withdrawal_list[]" value="{{$value->withdrawal_id}}">
                                                    <label class="form-check-label sr-only" for="" ></label>
                                                </div>
                                            </td>
                                            <td>{{$value->withdrawal_id}}</td>
                                            <td>{{get_user_name($value->beneficiary_id)}}</td>
                                            <td><?php echo date('d-M-Y', strtotime($value->created_at)); ?></td>
                                            <td>@if ($value->requested_amount) {{$value->currency}} {{number_format($value->requested_amount, 10)}} @else - @endif</td>
                                            <td>R{{number_format($value->requested_amount_by_user_in_zar-($value->all_charged_fees_in_zar+$value->valr_taker_share+$value->valr_withdrawal_fees_share), 2)}}</td>
                                            <td>
                                                @if ($value->failed)
                                                 <span class="red">Failed</span>
                                                 @elseif ($value->in_progress =='1' || $value->sent_to_client !='1')
                                                 <span class="orange">In Progress</span>
                                                  @else <span class="green">Success</span> @endif
                                            </td>
                                            <td><a href="{{route('withdrawInfoUser', [$value->withdrawal_id])}}" class="btn edit-button">View</a>

                                        </tr>
                                    <?php }
                                } ?>
                            </tbody>
                        </table>
                         </form>
                        <?php if (!empty($withdrawal)) { ?>
                            <nav class="d-flex justify-content-end pagination-box">
                            <?php 
                                    $array_to_send = array();

                                    if (isset($_GET['filter_beneficiary']) && !empty($_GET['filter_beneficiary'])) {
                                        $array_to_send['filter_beneficiary'] = $_GET['filter_beneficiary'];

                                    }

                                    if (isset($_GET['status']) && !empty($_GET['status'])) {
                                        $array_to_send['status'] = $_GET['status'];

                                    }
                                ?>
                                {{$withdrawal->links("pagination::bootstrap-4")}}
                            </nav>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
@include('user-dashboard.footer')
<script>
        jQuery(document).ready(function () {
            $('[data-toggle="datepicker"]').datepicker({
                autoHide:true,
                format:'yyyy-mm-dd',
                inline:true,
            });

                $('#select-all').change(function () {
                    $('.contact-list-checks').prop('checked',this.checked);
                });

                $('.contact-list-checks').change(function () {
                    if ($('.contact-list-checks:checked').length == $('.contact-list-checks').length){
                        $('#select-all').prop('checked',true);
                    }
                    else {
                        $('#select-all').prop('checked',false);
                    }
                });
        });
</script>