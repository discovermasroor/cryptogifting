@include('user-dashboard.head')
    <title>Events List | Dashboard</title>
    <body>
        @include('user-dashboard.user-dashboard-header')
        <div class="main-content my-beneficiaries">
                <div class="overlay">
                    <h1 class="main-heading">Gifts Received</h1>

                    <div class="dashboard-home-cards transactions-card">

                        <div class="card area-chart-card card-style">
                            <div class="card-body">
                                <h5 class="sub-heading text-white text-center" style="margin: 10px auto;">Transactional History</h5>
                                <hr class="underline white">

                                <div class="chart">
                                    <canvas id="myChart"></canvas>
                                </div>
                                
                                <p class="chart-value">{{$zar_sum}} (ZAR)</p>
                            </div>
                        </div>

                        <div class="card gifted-amount card-style">
                            <div class="card-header">
                                <h5 class="sub-heading">Total Gifts Received to Date</h5>
                                <hr class="underline white">
                            </div>
                            <div class="card-body">
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
                            </div>
                        </div>
                       
                        <div class="pachis-percent">
                            <div class="card portfolio-card card-style">
                                <div class="card-header">
                                    <h5 class="sub-heading">Your Historical Portfolio (ZAR)</h5>
                                    <hr class="underline white">
                                </div>
                                <div class="card-body">
                                    <div class="portfolio">
                                        <div class="left">
                                            <h1>{{number_format($user_wallet_zar, 2)}} ZAR</h1>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card portfolio-card card-style">
                                <div class="card-header">
                                    <h5 class="sub-heading">Your Historical Portfolio (BTC)</h5>
                                    <hr class="underline white">
                                </div>
                                <div class="card-body">
                                    <div class="portfolio">
                                        <div class="left">
                                            <h1>{{number_format($user_wallet_btc, 10)}} BTC</h1>
                                           
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>    
                    </div>
                    
                    <form action="" method="get">
                        <input type="hidden" name="month" id="beneficiar" value="<?php if (isset($_GET['month'])) echo $_GET['month']; ?>">
                        <input type="hidden" name="gift_type" id="gender" value="<?php if (isset($_GET['gift_type'])) echo $_GET['gift_type']; ?>">

                        <div class="main-heading-box flex">
                            <h3>History</h3>

                            <div class="filters mt-0">
                                
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
                            <div class="search-bar">
                                <input class="form-control" name="search" value="<?php if (isset($_GET['search']) && !empty($_GET['search'])) echo $_GET['search'];?>" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn " type="button"><i class="fas fa-search"></i></button>
                            </div>

                                <!-- <div class="filter">
                                    <label for="subject" class="sr-only">Event Type</label>
                                    <div class="select-box">
                                        <div class="options-container">
                                            <div class="option gender-option">
                                                <input type="radio" class="radio" id="event-type-1" />
                                                <label for="event-type-1" class="text-bold">Physical</label>
                                            </div>
                                            <div class="option gender-option">
                                                <input type="radio" class="radio" id="event-type-2" />
                                                <label for="event-type-2" class="text-bold">Virtual</label>
                                            </div>
                                            <div class="option gender-option">
                                                <input type="radio" class="radio" id="event-type-3" />
                                                <label for="event-type-3" class="text-bold">No Event</label>
                                            </div>
                                        </div>
                                        <div class="selected">
                                            <?php //if (isset($_GET['event_type']) && !empty($_GET['event_type']) && $_GET['event_type'] == 'No Event') { echo 'No Event'; } else if (isset($_GET['event_type']) && !empty($_GET['event_type'])) { echo ucfirst($_GET['event_type']); } else { echo 'Event Type'; } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="filter">
                                    <label for="subject" class="sr-only">Status</label>
                                    <div class="select-box">
                                        <div class="options-container">
                                            <div class="option status-option">
                                                <input type="radio" class="radio" id="status-1"/>
                                                <label for="status-1" class="text-bold">Current Event</label>
                                            </div>
                                            <div class="option status-option">
                                                <input type="radio" class="radio" id="status-2"/>
                                                <label for="status-2" class="text-bold">Unpublished</label>
                                            </div>
                                            <div class="option status-option">
                                                <input type="radio" class="radio" id="status-3"/>
                                                <label for="status-3" class="text-bold">Cancelled</label>
                                            </div>
                                            <div class="option status-option">
                                                <input type="radio" class="radio" id="status-4"/>
                                                <label for="status-4" class="text-bold">Past Events</label>
                                            </div>
                                        </div>

                                        <div class="selected">
                                            <?php //if (isset($_GET['status']) && !empty($_GET['status'])) { echo ucfirst($_GET['status']); } else { echo 'Status'; } ?>
                                        </div>

                                    </div>
                                </div> -->

                                <!-- <div class="search-bar">
                                <input class="form-control" name="search" value="<?php //if (isset($_GET['search']) && !empty($_GET['search'])) echo urldecode($_GET['search']); ?>" type="search" placeholder="Search" aria-label="Search">
                                    <button class="btn " type="button"><i class="fas fa-search"></i></button>
                                </div> -->

                                <button type="submit" class="btn submit-button">Submit</button>
                                <a href="{{route('EventsTransactions')}}" class="btn submit-button">Clear</a>

                            </div>
                        </div>

                        <div class="table-responsive data-table-wrapper mt-2">
                            <table class="table">
                                <thead class="heading-box">

                                    <tr> 
                                        <th>Transaction ID</th>
                                        <th>Gifter Name</th>
                                        <th>Gift Date Range</th>
                                        <th>Gift Type</th>
                                        <th>Event Type</th>
                                        <th>Event Name</th>
                                        <th>Beneficiary Name</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($events as $key => $value) { ?>
                                        <tr>
                                            <td>{{$value->event_acceptance_id}}</td>
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
                                            <td>{{$value->created_at->format('d-M-Y')}}</td>
                                            <td><?php if ($value->event_id) echo 'Create Event'; else if (isset($value->gift_event_info) && $value->gift_event_info->get_crypto=='1') echo 'Public Link'; else if(isset($value->gift_event_info) && $value->gift_event_info->gift_crypto =='1') echo 'Email To Email'; else if ($value->event_id == NULL && $value->gifter_event_id == NULL ) echo 'Public Link'; ?></td>
                                            <?php if ($value->event_id) { ?>

                                                <?php if ($value->event_info->live) { ?>
                                                    <td class="active">Live Event</td>

                                                <?php } else if ($value->event_info->unpublished) { ?>
                                                    <td class="pending">Unpublished Event</td>

                                                <?php } else if ($value->event_info->cancelled) { ?>
                                                    <td class="cancelled">Cancelled Event</td>

                                                <?php } else if ($value->event_info->past) { ?>
                                                    <td class="pending">Past Event</td>

                                                <?php } ?>
                                            <?php } else { ?>
                                                <td class="pending">-</td>

                                            <?php } ?>

                                            <?php if ($value->event_id) { ?>
                                                <td class="active">{{$value->event_info->name}}</td>
                                            <?php } else { ?>
                                            <td class="pending">-</td>
                                            
                                            <?php } ?></td>
                                            <td>{{get_user_name($value->beneficiary_id)}}</td>
                                            <td class="pending">R{{number_format($value->amount, 2)}}</td>
                                             <?php if ($value->event_id) { ?>
                                                <td><a href="{{route('EventsDetails', [$value->event_id])}}" class="btn edit-button">View</a></td>
                                            <?php } else { ?>
                                                <td><a href="{{route('GiftDetails', [$value->event_acceptance_id])}}" class="btn edit-button">View</a></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
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
                                {{$events->appends($array_to_send)->links("pagination::bootstrap-4")}}
                            </nav>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <script src="{{asset('/public')}}/assets/js/chart.min.js?ver=<?php echo VER; ?>"></script>
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
                            label: 'Wallet Value', // Name the series
                            data: jQuery.parseJSON("{{$graph_data}}"), // Specify the data values array
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
@include('user-dashboard.footer')