@include('user-dashboard.head')
    <title>Invited Events | Dashboard</title>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content ">
                <div class="overlay">
                    <h1 class="main-heading">Invited Events</h1>
                    <div class="events-tabs-wrapper mt-0 mt-md-4">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="live-events">
                                <form action="" class="">
                                    <div class="table-responsive data-table-wrapper">
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
                                                <?php if (!empty($live_events)) {
                                                    foreach ($live_events as $live_key => $live_value) { ?>
                                                        <tr>
                                                            <td>{{$live_key+1}}.</td>
                                                            <td>{{$live_value->name}}</td>
                                                            <td>{{$live_value->event_date}}</td>
                                                            <td>{{$live_value->hosted_by}}</td>
                                                            <td>{{$live_value->location}}</td>
                                                            <td><?php if ($live_value->type == 'no_event') echo 'No Event'; else echo ucfirst($live_value->type); ?></td>
                                                            <td><a href="{{route('EventPreview', [$live_value->event_id])}}"
                                                                    class="btn edit-button">Preview</a></td>
                                                        </tr>
                                                    <?php }
                                                } ?>
                                            </tbody>
                                        </table>
                                        <?php if (!empty($live_events)) { ?>
                                            <nav class="d-flex justify-content-end pagination-box">
                                                {{$live_events->links("pagination::bootstrap-4")}}
                                            </nav>
                                        <?php } else { ?>
                                            <div class="coming-soon-img">
                                                <img src="{{asset('public/')}}/assets/images/dashboard/coming-soon.png" class="img-fluid">
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