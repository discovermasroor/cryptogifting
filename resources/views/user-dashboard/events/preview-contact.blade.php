@include('user-dashboard.head')
    <title>Event Preview | Dashboard</title>
    <body>
        <div id="preloader" class="d-none"></div>
            @include('user-dashboard.user-dashboard-header')
            <div class="main-content event-preview-page">
                <div class="overlay">
                    <div class="main-heading-box ">
                        <h3>Event Preview</h3>
                    </div>
                    <div class="event-box">
                        <div class="column column-theme">
                            <div class="theme-wrapper">
                                <img src="{{$event->event_theme->cover_image_url}}" class="img-fluid">
                                <div class="data">
                                    <h1 class="event-heading" style="color: <?php echo $event->event_theme->color_code; ?> !important;">{{$event->name}}</h1>
                                    <h4 class="event-date" style="color: <?php echo $event->event_theme->color_code; ?> !important;">event date: {{date('d-M-Y', strtotime($event->event_date))}}</h4>

                                </div>
                            </div>
                        </div>
                        <div class="column column-details">
                            <form action="{{route('GiveGift', [$event->event_id])}}" method="post" class="form-style event-details-form">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="rsvp" id="topic-field" value="">
                                <h3 class="form-heading mt-0">{{$event->name}}</h3>
                                <hr class="underline">

                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center justify-content-start me-3">
                                        <h5 class="heading-5 title me-2">Hosted By</h5>
                                        <h5 class="heading-5 value">{{$event->hosted_by}}</h5>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-start">
                                        <h5 class="heading-5 title me-2">Date</h5>
                                        <h5 class="heading-5 value">{{date('d-M-Y', strtotime($event->event_date))}}</h5>
                                    </div>
                                </div>

                                <hr class="underline">

                                <div class="text-center">
                                    <h5 class="heading-5 title">Summary</h5>
                                    <p class="p1">{{$event->description}}</p>
                                </div>

                                <hr class="underline">

                                <div class="text-center">
                                    <h5 class="heading-5 value">Share</h5>
                                    <p class="social-p text-center mt-3">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo route('EventPreviewForGuest', [$event->event_id]); ?>"><i class="fab fa-facebook-f"></i></a>
                                        <a href="https://wa.me/?text=<?php echo route('EventPreviewForGuest', [$event->event_id]); ?>"><i class="fab fa-whatsapp"></i></a>
                                    </p>
                                </div>

                                <hr class="underline">

                                <div class="text-center">
                                    <h5 class="heading-5 value">Location</h5>
                                    <p class="p1 mt-2">{{$event->location}}</p>
                                </div>

                                <hr class="underline">

                                <div class="rsvp">
                                    <div class="div-1">
                                        <label for="" class="form-label sr-only">RSVP</label>
                                        <div class="select-box">
                                            <div class="options-container">
                                                <div class="option">
                                                    <input type="radio" class="radio" id="rsvp-1"
                                                        name="category-events" />
                                                    <label for="rsvp-1" class="text-bold">Yes</label>
                                                </div>
                                                <div class="option">
                                                    <input type="radio" class="radio" id="rsvp-2"
                                                        name="category-events" />
                                                    <label for="rsvp-2" class="text-bold">No</label>
                                                </div>
                                                <div class="option">
                                                    <input type="radio" class="radio" id="rsvp-3"
                                                        name="category-events" />
                                                    <label for="rsvp-3" class="text-bold">Maybe</label>
                                                </div>
                                            </div>

                                            <div class="selected">
                                                RSVP
                                            </div>
                                        </div>
                                    </div>
                                    <div class="div-2">
                                        <h5 class="heading-5 value">Attire</h5>
                                        <p>{{$event->attire}}</p>
                                    </div>
                                </div>
                                <div class="text-center mt-4 mv-3">
                                    <button class="blue-button btn" type="submit">Click here to Gift</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@include('user-dashboard.footer')