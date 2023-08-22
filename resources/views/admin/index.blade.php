@include('admin.head')
    <title>Dashboard | Crypto Gifting</title>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('admin.header-sidebar')
        <!-- Main Content Starts -->
            <div class="main-content">
                <div class="overlay">
                    <div class="heading-wrapper">
                        <h1 class="main-heading">Dashboard</h1>
                    </div>


                    <div class="dashboard-home-cards">

                    <div class="card area-chart-card card-style">
                            <div class="card-body">
                                <h5 class="sub-heading text-white text-center" style="margin: 10px auto;">Transactional History</h5>
                                <hr class="underline white">

                                <div class="chart">
                                    <canvas id="myChart" height="100"></canvas>
                                </div>
                                <p class="chart-value">{{number_format($zar_sum, 0)}} (ZAR)</p>
                            </div>
                        </div>
                        <div class="card gifted-amount card-style">
                        <div class="card-header">
                            <h5 class="sub-heading">Total Gifts Received to Date</h5>
                            <hr class="underline white">
                        </div>
                        <div class="card-body">
                            <!-- <h2 class="green">ZAR 10,000.00</h2>
                            <small>Available</small> -->
                            <h5 class="sub-heading smaall text-start">Value Received to Date</h5>
                            <div class="currencies-values my-2">
                                <div class="currency">
                                    <div class="title">ZAR</div>
                                    <div class="value">R{{number_format($recieved_till_date_zar_sum, 2)}}</div>
                                </div>
                                <div class="currency">
                                    <div class="title">BTC</div>
                                    <div class="value">{{number_format($recieved_till_date_btc_sum, 10)}}</div>
                                </div>
                            </div>

                            <h5 class="sub-heading smaall text-start">Number of Gifts Received to Date</h5>
                            <div class="currencies-values my-2">
                                <div class="currency">
                                    <div class="title">Gifts</div>
                                    <div class="value">{{$total_gifts}}</div>
                                </div>
                            </div>

                            <h5 class="sub-heading smaall text-start">Average Gift Value</h5>
                            <div class="currencies-values my-2">
                                <div class="currency">
                                    <div class="title">ZAR</div>
                                    <div class="value">R{{number_format($average_amount_per_gift, 2)}}</div>
                                </div>
                            </div>

                            <!-- <h1 class="orange">{{$total_gifts}} Gifts</h1> -->
                        </div>
                    </div>
                        <div class="pachis-percent">
                            <div class="card portfolio-card card-style">
                                <div class="card-header">
                                    <h5 class="sub-heading">Your Current Portfolio (ZAR) </h5>
                                    <hr class="underline white">
                                </div>
                                <div class="card-body">
                                    <div class="portfolio">
                                        <div class="left">
                                            <h1>{{number_format($account_balance_zar,2)}} ZAR</h1>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card portfolio-card card-style">
                                <div class="card-header">
                                    <h5 class="sub-heading">Your Current Portfolio (BTC)</h5>
                                    <hr class="underline white">
                                </div>
                                <div class="card-body">
                                    <div class="portfolio">
                                        <div class="left">
                                            <h1>{{number_format($account_balance_btc, 10)}} BTC</h1>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-style">
                        <div class="card-body">
                            <form action="">
                                <input type="hidden" name="month" id="beneficiar" value="<?php if (isset($_GET['month'])) echo $_GET['month']; ?>">
                                <input type="hidden" name="gift_type" id="gender" value="<?php if (isset($_GET['gift_type'])) echo $_GET['gift_type']; ?>">
                                <div class="filters">
                                    <!-- <div class="date-field-special me-2">
                                        <input class="form-control" type="text" data-toggle="datepicker" name="" value="" placeholder="Gift Date">
                                    </div> -->
                                <div class="date-field-special me-2">
                                    <input class="form-control" type="text" data-toggle="datepicker" name="month" value="<?php if (isset($_GET['month']) && !empty($_GET['month'])) echo $_GET['month']; ?>" placeholder="Transaction Date">
                                </div>

                                    <div class="filter">
                                        <label for="subject" class="sr-only">Gift Type</label>
                                        <div class="select-box ms-0">
                                            <div class="options-container">
                                                <div class="option gender-option">
                                                    <input type="radio" class="radio" id="gift-type-1"/>
                                                    <label for="gift-type-1" class="text-bold">Create Event</label>
                                                </div>
                                                <div class="option gender-option">
                                                    <input type="radio" class="radio" id="gift-type-2"/>
                                                    <label for="gift-type-2" class="text-bold">Email to Email</label>
                                                </div>
                                                <div class="option gender-option">
                                                    <input type="radio" class="radio" id="gift-type-3"/>
                                                    <label for="gift-type-3" class="text-bold">Public Link</label>
                                                </div>
                                            </div>

                                            <div class="selected">
                                                <?php if (isset($_GET['gift_type']) && !empty($_GET['gift_type'])) echo urldecode($_GET['gift_type']); else echo 'Gift Type'; ?>
                                            </div>

                                        </div>
                                    </div>

                                    <button type="submit" class="btn submit-button">Search</button>
                                    <a href="{{route('AdminDashboard')}}" class="btn submit-button">Clear</a>
                                </div>
                            </form>
                            <div class="table-responsive data-table-wrapper mt-2">
                                <table class="table">
                                    <thead class="heading-box">
                                        <tr>
                                            <th>Transaction ID</th>
                                            <th>Beneficiary ID</th>
                                            <th>Beneficiary Name</th>
                                            <th>Beneficiary Surname</th>
                                            <th>Gifter Name</th>
                                            <th>Gift Type</th>
                                            <th>Gift Date</th>
                                            <!-- <th>Event Type</th>
                                            <th>Event Name</th> -->
                                            <th>Amount In (ZAR)</th>
                                            <th>Amount In (BTC)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if ($event_gifts) {
                                        foreach ($event_gifts as $key => $value) { ?>
                                            <tr>
                                                <td>{{$value->event_acceptance_id}}</td>
                                                <td>{{$value->beneficiary_id}}</td>
                                                <td>{{$value->beneficiary->name}}</td>
                                                <td>{{$value->beneficiary->surname}}</td>
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
                                                <td>{{$value->created_at->format('d-M-Y')}}</td>
                                               
                                                <td class="pending">R{{number_format($value->amount, 2)}}</td>
                                                <td class="pending">@if ($value->transaction_details->btc_rate > 0) {{number_format($value->amount/$value->transaction_details->btc_rate, 10)}} BTC @else - @endif</td>
                                                <td><a href="{{route('GiftDetailsAdmin', [$value->event_acceptance_id])}}" class="btn edit-button">View</a></td>
                                            </tr>
                                        <?php }
                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php if ($event_gifts) { ?>
                                <nav class="d-flex justify-content-end pagination-box">
                                    <?php
                                        $array_to_send = array();

                                        if (isset($_GET['gift_type']) && !empty($_GET['gift_type'])) {
                                            $array_to_send['gift_type'] = $_GET['gift_type'];

                                        }

                                        if (isset($_GET['month']) && !empty($_GET['month'])) {
                                            $array_to_send['month'] = $_GET['month'];

                                        }
                                    ?>
                                    {{$event_gifts->appends($array_to_send)->links("pagination::bootstrap-4")}}
                                </nav>
                            <?php } ?>
                        </div>
                    </div>


                </div>
            </div>
            <!-- Main Content Ends -->
        </section>
        <!-- Dashboard Main Content Ends -->
    </main>
    <script src="/assets/js/chart.min.js?ver=<?php echo VER; ?>"></script>
<script>
    jQuery(document).ready(function () {

        $('[data-toggle="datepicker"]').datepicker({
            autoHide:true,
            format:'yyyy-mm-dd',
            inline:true,
        });
        var obj = <?php echo json_encode($month_data)?>;
        parsedTest = JSON.parse(obj);
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: parsedTest,
                datasets: [
                    {
                        // label: 'Wallet Value', // Name the series
                        data: jQuery.parseJSON("{{$graph_data}}"),
                        fill: true,
                        borderColor: '#EDA31E', // Add custom color border (Line)
                        backgroundColor: 'rgba(0,0,0,0.1)', // Add custom color background (Points and Fill)
                        borderWidth: 2 // Specify bar border width
                    }]
            },
            options: {
                responsive: true, // Instruct chart js to respond nicely.
                maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: "#fff"
                        }
                    },
                    y: {
                        ticks: {
                            color: "#fff"
                        }
                    }
                }

            }
        });
    });
</script>

@include('admin.footer')
