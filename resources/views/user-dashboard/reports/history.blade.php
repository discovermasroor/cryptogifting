@include('user-dashboard.head')
    <title>Topup and Withdrawal History | Dashboard</title>
    <body>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content ">
                <div class="overlay">

                    <div class="main-heading-box flex mt-0">
                        <h3>History</h3>

                        <form action="">
                            <input type="hidden" name="event_id" id="event-filter" value="<?php if (isset($_GET['event_id']) && !empty($_GET['event_id'])) echo $_GET['event_id']; ?>">
                            <input type="hidden" name="beneficiary_id" id="beneficiar" value="<?php if (isset($_GET['beneficiary_id']) && !empty($_GET['beneficiary_id'])) echo $_GET['beneficiary_id']; ?>">
                            <div class="filters mt-0">

                                <div class="filter">
                                    <label for="subject" class="sr-only">Event</label>
                                    <div class="select-box">
                                        <div class="options-container">
                                            <?php foreach ($events_list as $event_key => $event_value) { ?>
                                                <div class="option event-filter-option">
                                                    <input type="radio" class="radio" id="{{$event_key}}"/>
                                                    <label for="{{$event_key}}" class="text-bold" data-event-id="{{$event_value->event_id}}">{{$event_value->name}}</label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="selected">
                                            Event
                                        </div>

                                    </div>
                                </div>

                                <div class="filter">
                                    <label for="subject" class="sr-only">All Beneficiaries</label>
                                    <div class="select-box">
                                        <div class="options-container">
                                            <?php foreach ($beneficiars as $benef_key => $benef_value) { ?>
                                                <div class="option beneficiar-option">
                                                    <input type="radio" class="radio" id="{{$benef_key}}" value="{{$benef_value->beneficiary_id}}"/>
                                                    <label for="{{$benef_key}}" data-user-id="{{$benef_value->beneficiary_id}}" class="text-bold">{{$benef_value->name}} {{$benef_value->surname}}</label>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <div class="selected">
                                            All Beneficiaries
                                        </div>

                                    </div>
                                </div>

                                <button type="submit" class="btn submit-button">Submit</button>

                            </div>
                    </div>


                    <div class="events-tabs-wrapper">
                        <ul class="nav nav-pills events-tabs mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="topup-history-tab" data-bs-toggle="pill"
                                    data-bs-target="#topup-history" type="button">Top Up History</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="withdrawal-history-tab" data-bs-toggle="pill"
                                    data-bs-target="#withdrawal-history" type="button">Withdrawal
                                    History</button>
                            </li>
                        </ul>

                        <hr class="underline">

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="topup-history">
                                <form action="" class="">
                                    <div class="table-responsive data-table-wrapper">
                                        <table class="table">
                                            <thead class="heading-box">
                                                <tr>
                                                    <th>Gifter Name</th>
                                                    <th >Surname</th>
                                                    <th >Relationship</th>
                                                    <th class="dob">Date</th>
                                                    <th class="amount">Amount</th>
                                                    <th>Currency</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($topups as $key => $value) { ?>
                                                    <tr>
                                                        <td>{{get_user_name($value->sender_id)}}</td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                        <td>$value->created_at->format('d-M-Y')}}</td>
                                                        <td>{{$value->amount}}</td>
                                                        <td>{{$value->currency}}</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="withdrawal-history">
                                <form action="" class="">
                                    <div class="table-responsive data-table-wrapper">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="dob">Date</th>
                                                    <th class="amount">Amount</th>
                                                    <th>Bank Details</th>
                                                    <th>Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($withdraws as $key => $value) { ?>
                                                    <tr>
                                                        <td>{{$value->created_at->format('d-M-Y')}}</td>
                                                        <td>{{$value->amount}} {{$value->currency}}</td>
                                                        <td>-</td>
                                                        <td>{{$value->created_at->format('h:i A')}}</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
@include('user-dashboard.footer')