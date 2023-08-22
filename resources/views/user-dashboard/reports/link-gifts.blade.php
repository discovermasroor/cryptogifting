@include('user-dashboard.head')
    <title>All Funds Withdrawan | Dashboard</title>
    <body>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content my-beneficiaries">
                <div class="overlay">
                    <form action="" method="get">
                        <input type="hidden" name="month" id="beneficiar" value="<?php if (isset($_GET['month'])) echo $_GET['month']; ?>">
                        <input type="hidden" name="event_type" id="gender" value="<?php if (isset($_GET['event_type'])) echo $_GET['event_type']; ?>">
                        <div class="main-heading-box flex">
                            <h3>Funds Withdrawn</h3>
                            <div class="filters mt-0">
                            
                                
                                <div class="filter">
                                    <label for="subject" class="sr-only">Topics</label>
                                    <div class="select-box">
                                        <div class="options-container">
                                            <?php foreach ($beneficiaries as $benef_key => $benef_value) { ?>
                                                <div class="option beneficiar-option">
                                                    <input type="radio" class="radio" id="{{$benef_key}}" value="{{$benef_value->beneficiary_id}}"/>
                                                    <label for="{{$benef_key}}" data-user-id="{{$benef_value->beneficiary_id}}" class="text-bold">@if (request()->user->user_id == $benef_value->beneficiary_id) Self @else {{$benef_value->name}} {{$benef_value->surname}} @endif</label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="selected">
                                            beneficiaries
                                        </div>
                                    </div>
                                </div>
                                <div class="filter">
                                    <label for="subject" class="sr-only">Month</label>
                                    <div class="select-box">
                                        <div class="options-container">
                                            <div class="option beneficiar-option">
                                                <input type="radio" class="radio" id="month-1"/>
                                                <label for="month-1" class="text-bold" data-user-id="01">January</label>
                                            </div>
                                            <div class="option beneficiar-option">
                                                <input type="radio" class="radio" id="month-2"/>
                                                <label for="month-2" class="text-bold" data-user-id="02">February</label>
                                            </div>
                                            <div class="option beneficiar-option">
                                                <input type="radio" class="radio" id="month-3"/>
                                                <label for="month-3" class="text-bold" data-user-id="03">March</label>
                                            </div>
                                            <div class="option beneficiar-option">
                                                <input type="radio" class="radio" id="month-4"/>
                                                <label for="month-4" class="text-bold" data-user-id="04">April</label>
                                            </div>
                                            <div class="option beneficiar-option">
                                                <input type="radio" class="radio" id="month-5"/>
                                                <label for="month-5" class="text-bold" data-user-id="05">May</label>
                                            </div>
                                            <div class="option beneficiar-option">
                                                <input type="radio" class="radio" id="month-6"/>
                                                <label for="month-6" class="text-bold" data-user-id="06">June</label>
                                            </div>
                                            <div class="option beneficiar-option">
                                                <input type="radio" class="radio" id="month-7"/>
                                                <label for="month-7" class="text-bold" data-user-id="07">July</label>
                                            </div>
                                            <div class="option beneficiar-option">
                                                <input type="radio" class="radio" id="month-8"/>
                                                <label for="month-8" class="text-bold" data-user-id="08">August</label>
                                            </div>
                                            <div class="option beneficiar-option">
                                                <input type="radio" class="radio" id="month-9"/>
                                                <label for="month-9" class="text-bold" data-user-id="09">September</label>
                                            </div>
                                            <div class="option beneficiar-option">
                                                <input type="radio" class="radio" id="month-10"/>
                                                <label for="month-10" class="text-bold" data-user-id="10">October</label>
                                            </div>
                                            <div class="option beneficiar-option">
                                                <input type="radio" class="radio" id="month-11"/>
                                                <label for="month-11" class="text-bold" data-user-id="11">November</label>
                                            </div>
                                            <div class="option beneficiar-option">
                                                <input type="radio" class="radio" id="month-12"/>
                                                <label for="month-12" class="text-bold" data-user-id="12">December</label>
                                            </div>
                                        </div>

                                        <div class="selected">
                                            <?php if (isset($_GET['month']) && !empty($_GET['month']) && $_GET['month'] == '01') {
                                                echo 'January';

                                            } elseif (isset($_GET['month']) && !empty($_GET['month']) && $_GET['month'] == '02') {
                                                echo 'February';

                                            } elseif (isset($_GET['month']) && !empty($_GET['month']) && $_GET['month'] == '03') {
                                                echo 'March';

                                            } elseif (isset($_GET['month']) && !empty($_GET['month']) && $_GET['month'] == '04') {
                                                echo 'April';

                                            } elseif (isset($_GET['month']) && !empty($_GET['month']) && $_GET['month'] == '05') {
                                                echo 'May';

                                            } elseif (isset($_GET['month']) && !empty($_GET['month']) && $_GET['month'] == '06') {
                                                echo 'June';

                                            } elseif (isset($_GET['month']) && !empty($_GET['month']) && $_GET['month'] == '07') {
                                                echo 'July';

                                            } elseif (isset($_GET['month']) && !empty($_GET['month']) && $_GET['month'] == '08') {
                                                echo 'August';

                                            } elseif (isset($_GET['month']) && !empty($_GET['month']) && $_GET['month'] == '09') {
                                                echo 'September';

                                            } elseif (isset($_GET['month']) && !empty($_GET['month']) && $_GET['month'] == '10') {
                                                echo 'October';

                                            } elseif (isset($_GET['month']) && !empty($_GET['month']) && $_GET['month'] == '11') {
                                                echo 'November';

                                            } elseif (isset($_GET['month']) && !empty($_GET['month']) && $_GET['month'] == '12') {
                                                echo 'December';

                                            } else {
                                                echo 'Month';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive data-table-wrapper mt-2">
                        <table class="table">
                            <thead class="heading-box">
                                <tr>
                                    <th>#</th>
                                    <th>Pay to</th>
                                    <th>Gifter</th>
                                    <th class="dob">Date</th>
                                    <th class="amount">Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($gifts) {
                                    foreach ($gifts as $key => $value) { ?>
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{get_user_name($value->beneficiary_id)}}</td>
                                            <td>@if ($value->gifter_id) {{get_user_name($value->gifter_id)}} @else Anonymous @endif</td>
                                            <td><?php echo date('d-M-Y', strtotime($value->created_at)); ?></td>
                                            <td>@if ($value->amount > 0) ZAR {{$value->amount}} @else - @endif</td>
                                            <td>@if (!$value->paid) <span class="red">Failed</span> @else <span class="green">Success</span> @endif</td>
                                        </tr>
                                    <?php }
                                } ?>
                            </tbody>
                        </table>
                        <?php if ($gifts) { ?>
                            <nav class="d-flex justify-content-end pagination-box">
                                {{$gifts->links("pagination::bootstrap-4")}}
                            </nav>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
@include('user-dashboard.footer')