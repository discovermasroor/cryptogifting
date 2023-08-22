@include('user-dashboard.head')
    <title>Edit Event | Dashboard</title>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content withdraw-page">
                <div class="overlay">
                    <div class="main-heading-box flex">
                        <h3><?php if ($event->unpublished) echo 'Edit Unpublished'; else if ($event->live) echo 'Edit Current'; else if ($event->cancelled) echo 'Edit Cancelled'; else echo 'View Past'; ?> Event</h3>
                        <?php if ($event->live) { ?>
                            <a href="{{route('CancelEvent', [$event->event_id])}}" class="btn common-button delete">Cancel Event</a>

                        <?php } else if ($event->unpublished) { ?>
                            <div class="two-button-box m-0">
                                <a href="{{route('PublishEvent', [$event->event_id])}}" class="btn blue-button">Published</a>
                                <a href="{{route('CancelEvent', [$event->event_id])}}" class="btn common-button delete">Cancel Event</a>
                            </div>

                        <?php } else if ($event->cancelled) { ?>
                                <a href="{{route('PublishEvent', [$event->event_id])}}" class="btn blue-button">Republish</a>
                        <?php } ?>
                    </div>
                    <div class="card person-detail-card">
                        <div class="card-body">
                            <h1 class="card-title">{{$event->name}}</h1>

                            <div class="other-info">
                                <p class="p1">
                                    <span class="title">Hosted By :</span> <span class="value">{{$event->hosted_by}}</span>
                                </p>
                                <p class="p2">
                                    <span class="title">Event Type : </span> <span class="value"><?php if ($event->type == 'no_event') echo 'No Event'; else echo ucfirst($event->type); ?></span>
                                </p>
                                <p class="p3">
                                    <span class="title">Event Date : </span> <span class="value">{{$event->event_date}}</span>
                                </p>
                                <?php if ($event->live) { ?>
                                    <p class="p4">
                                        <span class="title" id="copy-link" data-event-link="{{route('EventPreviewForGuest', [$event->event_id])}}" style="text-decoration: underline;cursor:pointer;"><a>Copy Event Link</a></span>
                                    </p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('UpdateEvent', [$event->event_id])}}" method="post" class="form-style add-beneficiary-form edit-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="event_type" id="attire" value="<?php if ($event->type == 'no_event') echo 'No Event'; else echo ucfirst($event->type); ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="event-name" class="form-label sr-only">Event Name</label>
                                <input type="text" class="form-control" id="event-name" placeholder="Event Name"
                                    name="event_name" value="{{$event->name}}">
                            </div>
                            <div class="col-md-6">
                                <label for="" class="sr-only">Event Type</label>
                                <div class="select-box">
                                    <div class="options-container">
                                        <div class="option attire-option">
                                            <input type="radio" class="radio" id="event-type-1" name="event-type" />
                                            <label for="event-type-1" class="text-bold">Virtual</label>
                                        </div>
                                        <div class="option attire-option">
                                            <input type="radio" class="radio" id="event-type-2" name="event-type" />
                                            <label for="event-type-2" class="text-bold">Physical</label>
                                        </div>
                                        <div class="option attire-option">
                                            <input type="radio" class="radio" id="event-type-3" name="event-type" />
                                            <label for="event-type-3" class="text-bold">No Event</label>
                                        </div>
                                    </div>

                                    <div class="selected">
                                        <?php if ($event->type == 'no_event') echo 'No Event'; else echo ucfirst($event->type); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="hosted-by" class="form-label sr-only">Hosted By </label>
                                <input type="text" class="form-control" name="hosted_by" value="{{$event->hosted_by}}" id="hosted-by" placeholder="Hosted By">
                            </div>
                           
                                <div class="col-md-12 text-center">
                                    <div class="two-button-box">
                                        <button type="button" onclick="goBack()" class="btn common-button">Back</button> 
                                        <?php if (!$event->past) { ?>
                                            <button type="submit" class="btn blue-button mt-0">Save Changes</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            

                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <script>
        jQuery(document).ready(function ($) {
            $('#copy-link').on('click', function (e) {
                e.preventDefault();
                navigator.clipboard.writeText($(this).attr('data-event-link'));
                var html = ''
                html += '<div class="alert custom-alert alert-success d-flex align-items-center" role="alert">';
                html += '<ul>';
                html += '<li><i class="uil uil-check-circle"></i>Event link copied!</li>';
                html += '</ul>';
                html += '</div>';
                $('body').append(html);
                setTimeout(function(){ $('body').find('div.alert.custom-alert').remove(); }, 5000);
                return false;
            });
        })
        function goBack()
        {
            window.history.back()
        }
    </script>
@include('user-dashboard.footer')