@include('user-dashboard.head')
    <title>Manage Events | Dashboard</title>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content ">
                <div class="overlay">
                    <!--<h1 class="main-heading">Manage Events</h1>-->
                    <div class="main-heading-box flex">
                        <h3>My Events</h3>
                        <a href="{{route('SelectBeneficiariesForEvent')}}" class="btn blue-button">Create Event</a>
                    </div>
                    <div class="events-tabs-wrapper mt-0 mt-md-4">
                        <ul class="nav nav-pills events-tabs mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="live-events-tab" data-bs-toggle="pill"
                                    data-bs-target="#live-events" type="button">Current Events</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="unpublished-events-tab" data-bs-toggle="pill"
                                    data-bs-target="#unpublished-events" type="button">Unpublished Events</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="cancelled-events-tab" data-bs-toggle="pill"
                                    data-bs-target="#cancelled-events" type="button">Cancelled Events</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="past-events-tab" data-bs-toggle="pill"
                                    data-bs-target="#past-events" type="button">Past Events</button>
                            </li>
                        </ul>

                        <hr class="underline">

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="live-events">
                                <form action="" class="">
                                    <div class="table-responsive data-table-wrapper">
                                    <?php if(!$live_events->isEmpty()){?>
                                        <table class="table">
                                            <thead class="heading-box">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th class="dob">Date</th>
                                                    <th>Hosted By</th>
                                                    <th>Location</th>
                                                    <th>Event Type</th>
                                                    <th class="action-td">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($live_events as $live_key => $live_value) { ?>
                                                    <tr>
                                                        <td>{{$live_key+1}}.</td>
                                                        <td>{{$live_value->name}}</td>
                                                        <td>{{date('d-M-Y', strtotime($live_value->event_date))}}</td>
                                                        <td>{{$live_value->hosted_by}}</td>
                                                        <td>{{$live_value->location}}</td>
                                                        <td><?php if ($live_value->type == 'no_event') echo 'No Event'; else echo ucfirst($live_value->type); ?></td>
                                                        <td><a href="{{route('EditEvent', [$live_value->event_id])}}"
                                                                class="btn edit-button">Edit</a></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <nav class="d-flex justify-content-end pagination-box">
                                            {{$live_events->links("pagination::bootstrap-4")}}
                                        </nav>
                                        <?php }else{
                                                ?>
                                                <div class="no-beneficiaries">
                                                    <h5>You have not created an event yet. </h5>
                                                </div>
                                            <?php } ?>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="unpublished-events">
                                <form action="" class="">
                                    <div class="table-responsive data-table-wrapper">
                                    <?php if(!$unpublished_events->isEmpty()){?>
                                        <table class="table">
                                            <thead class="heading-box">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th class="dob">Date</th>
                                                    <th>Hosted By</th>
                                                    <th>Location</th>
                                                    <th>Event Type</th>
                                                    <th class="action-td">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($unpublished_events as $unpublished_key => $unpublished_value) { ?>
                                                    <tr>
                                                        <td>{{$unpublished_key+1}}.</td>
                                                        <td>{{$unpublished_value->name}}</td>
                                                        <td>{{date('d-M-Y', strtotime($unpublished_value->event_date))}}</td>
                                                        <td>{{$unpublished_value->hosted_by}}</td>
                                                        <td>{{$unpublished_value->location}}</td>
                                                        <td><?php if ($unpublished_value->type == 'no_event') echo 'No Event'; else echo ucfirst($unpublished_value->type); ?></td>
                                                        <td><a href="{{route('EditEvent', [$unpublished_value->event_id])}}"
                                                                class="btn edit-button">Edit</a></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <nav class="d-flex justify-content-end pagination-box">
                                            {{$unpublished_events->links("pagination::bootstrap-4")}}
                                        </nav>
                                        <?php }else{
                                                ?>
                                                <div class="no-beneficiaries">
                                                    <h5>You do not have any unpublish events yet. </h5>
                                                </div>
                                            <?php } ?>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="cancelled-events">
                                <form action="" class="">
                                    <div class="table-responsive data-table-wrapper">
                                    <?php if(!$cancelled_events->isEmpty()){?>
                                        <table class="table">
                                            <thead class="heading-box">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th class="dob">Date</th>
                                                    <th>Hosted By</th>
                                                    <th>Location</th>
                                                    <th>Event Type</th>
                                                    <th class="action-td">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($cancelled_events as $cancelled_key => $cancelled_value) { ?>
                                                    <tr>
                                                        <td>{{$cancelled_key+1}}.</td>
                                                        <td>{{$cancelled_value->name}}</td>
                                                        <td>{{date('d-M-Y', strtotime($cancelled_value->event_date))}}</td>
                                                        <td>{{$cancelled_value->hosted_by}}</td>
                                                        <td>{{$cancelled_value->location}}</td>
                                                        <td><?php if ($cancelled_value->type == 'no_event') echo 'No Event'; else echo ucfirst($cancelled_value->type); ?></td>
                                                        <td><a href="{{route('EditEvent', [$cancelled_value->event_id])}}"
                                                                class="btn edit-button">Edit</a></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <nav class="d-flex justify-content-end pagination-box">
                                            {{$cancelled_events->links("pagination::bootstrap-4")}}
                                        </nav>
                                        <?php }else{
                                                ?>
                                                <div class="no-beneficiaries">
                                                    <h5>You do not have any cancelled events yet. </h5>
                                                </div>
                                            <?php } ?>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="past-events">
                                <form action="" class="">
                                    <div class="table-responsive data-table-wrapper">
                                    <?php if(!$past_events->isEmpty()){?>
                                        <table class="table">
                                            <thead class="heading-box">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th class="dob">Date</th>
                                                    <th>Hosted By</th>
                                                    <th>Location</th>
                                                    <th>Event Type</th>
                                                    <th class="action-td">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($past_events as $past_key => $past_value) { ?>
                                                    <tr>
                                                        <td>{{$past_key+1}}.</td>
                                                        <td>{{$past_value->name}}</td>
                                                        <td>{{date('d-M-Y', strtotime($past_value->event_date))}}</td>
                                                        <td>{{$past_value->hosted_by}}</td>
                                                        <td>{{$past_value->location}}</td>
                                                        <td><?php if ($past_value->type == 'no_event') echo 'No Event'; else echo ucfirst($past_value->type); ?></td>
                                                        <td><a href="{{route('EditEvent', [$past_value->event_id])}}"
                                                                class="btn edit-button">View</a></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <nav class="d-flex justify-content-end pagination-box">
                                            {{$past_events->links("pagination::bootstrap-4")}}
                                        </nav>
                                        <?php }else{
                                                ?>
                                                <div class="no-beneficiaries">
                                                    <h5>You do not have any past event yet. </h5>
                                                </div>
                                            <?php } ?>
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