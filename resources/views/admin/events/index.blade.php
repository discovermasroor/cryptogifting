@include('admin.head')
    <title>All Events | Dashboard</title>
    <body>
        @include('admin.header-sidebar')
            <!-- Main Content Starts -->
            <div class="main-content">
                <div class="overlay">

                    <form action="{{route('AllEventsAdmin')}}" method="get">
                        <input type="hidden" name="month" id="beneficiar" value="<?php if (isset($_GET['month'])) echo $_GET['month']; ?>">
                        <input type="hidden" name="event_type" id="gender" value="<?php if (isset($_GET['event_type'])) echo $_GET['event_type']; ?>">
                        <input type="hidden" name="status" id="status" value="<?php if (isset($_GET['status'])) echo $_GET['status']; ?>">

                        <div class="main-heading-box flex">
                            <h3>Events</h3>

                            <div class="filters mt-0">

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

                                <div class="filter">
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
                                            <?php if (isset($_GET['event_type']) && !empty($_GET['event_type']) && $_GET['event_type'] == 'No Event') { echo 'No Event'; } else if (isset($_GET['event_type']) && !empty($_GET['event_type'])) { echo ucfirst($_GET['event_type']); } else { echo 'Event Type'; } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="filter">
                                    <label for="subject" class="sr-only">Status</label>
                                    <div class="select-box">
                                        <div class="options-container">
                                            <div class="option status-option">
                                                <input type="radio" class="radio" id="status-1"/>
                                                <label for="status-1" class="text-bold">Live</label>
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
                                                <label for="status-4" class="text-bold">Past</label>
                                            </div>
                                        </div>

                                        <div class="selected">
                                            <?php if (isset($_GET['status']) && !empty($_GET['status'])) { echo ucfirst($_GET['status']); } else { echo 'Status'; } ?>
                                        </div>

                                    </div>
                                </div>

                                <div class="search-bar">
                                    <input class="form-control" name="search" value="<?php if (isset($_GET['search']) && !empty($_GET['search'])) echo urldecode($_GET['search']); ?>" type="search" placeholder="Search" aria-label="Search">
                                    <button class="btn " type="button"><i class="fas fa-search"></i></button>
                                </div>

                                <button type="submit" class="btn submit-button">Submit</button>
                                <a href="{{route('AllEventsAdmin')}}" class="btn submit-button">Clear</a>

                            </div>
                        </div>

                        <div class="table-responsive data-table-wrapper mt-3 users-table">
                            <table class="table">
                                <thead class="heading-box">
                                    <tr>
                                        <th>Created By</th>
                                        <th>Host</th>
                                        <th>Event Type</th>
                                        <th class="dob">Date</th>
                                        <th>Status</th>
                                        <th class="action-td">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($events as $key => $value) { ?>
                                        <tr>
                                            <td>{{get_user_name($value->creator_id)}}</td>
                                            <td>{{$value->hosted_by}}</td>
                                            <td><?php if ($value->type == 'no_event') echo 'No Event'; else echo ucfirst($value->type); ?> </td>
                                            <td>{{date('d-M-Y', strtotime($value->event_date))}}</td>
                                            <?php if ($value->live) { ?>
                                                <td class="active">Live</td>

                                            <?php } else if ($value->unpublished) { ?>
                                                <td class="pending">Unpublished</td>

                                            <?php } else if ($value->cancelled) { ?>
                                                <td class="cancelled">Cancelled</td>

                                            <?php } else if ($value->past) { ?>
                                                <td class="pending">Past</td>

                                            <?php } ?>
                                            <td><a href="{{route('EventInfoAdmin', [$value->event_id])}}" class="btn edit-button">View Event</a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <nav class="d-flex justify-content-end pagination-box">
                                <?php 
                                    $array_to_send = array();

                                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                                        $array_to_send['search'] = $_GET['search'];

                                    }

                                    if (isset($_GET['event_type']) && !empty($_GET['event_type'])) {
                                        $array_to_send['event_type'] = $_GET['event_type'];

                                    }
                                    
                                    if (isset($_GET['status']) && !empty($_GET['status'])) {
                                        $array_to_send['status'] = $_GET['status'];

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
            <!-- Main Content Ends -->
        </section>
        <!-- Dashboard Main Content Ends -->
    </main>
@include('admin.footer')