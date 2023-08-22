@include('head')
    <link rel="stylesheet" href="{{asset('/public')}}/assets/css/style-dashboard.css?ver=<?php echo VER; ?>">
    <title>Event Preview | Crypto Gifting</title>
    <body>
    @include('home-header')
    <style>
        body{
            background: url({{asset('/public')}}/assets/images/web/banner-bg.png) no-repeat;
            background-size: cover;
            background-position: right center;
        }
        body .web-header,
        body header,
        .join-wrapper,
        footer{
            background: transparent !important;
        }
        .copyrights p{
            margin: 0 auto;
            padding: 15px 0;
        }
        .flow_inner{
            margin-bottom: -10px !important;
        }

        @media(max-width: 500px){
            .flow_inner{
                margin-bottom: -30px !important;
            }
            .flow_inner .converion_wrapper img{
                margin: 5px 0;
                max-width: 20px;
            }
            .flow_inner .checkboxes{
                font-size: 12px
            }
        }

    </style>
        <main>
            <section class="join-wrapper event-preview">
                <div class="overlay"></div>
                <div class="main-container">
                <a href="{{route('Index')}}" class="heading-anchor ">
                    <h1>CryptoGifting</h1>
                </a>
                    <div class="event-box">
                        <div class="column column-theme">
                            <div class="theme-wrapper">
                                <img src="{{$event->event_theme->cover_image_url}}" class="img-fluid">
                                <div class="data">
                                <h1 class="event-heading" style="color: <?php echo $event->event_theme->color_code; ?> !important;">{{$event->name}}</h1>
                                <h4 class="event-date" style="color: <?php echo $event->event_theme->color_code; ?> !important;">event date: {{$event->event_date}}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="column column-details">
                            <form action="{{route('ContactEventPay', [$event->event_id])}}" method="post" class="form-style event-details-form">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" id="topic-field" name="rsvp" value="">
                                <h3 class="form-heading mt-0">{{$event->name}}</h3>
                                <hr class="underline">

                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center justify-content-start me-3">
                                        <h5 class="heading-5 title me-2">Hosted By</h5>
                                        <h5 class="heading-5 value">{{$event->hosted_by}}</h5>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-start">
                                        <h5 class="heading-5 title me-2">Date</h5>
                                        <h5 class="heading-5 value">{{$event->event_date}}</h5>
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
                                <div class="text-center">
                                        <h5 class="heading-5 value">Attire</h5>
                                        <p>{{$event->attire}}</p>
                                </div>
                                <hr class="underline">
                                <div class="rsvp new">
                                    <div class="div-2">
                                        <input type="text" class="form-control ps-3" placeholder="Name *"  name="contact_name">
                                    </div>
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
                                                RSVP *
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rsvp new">
                                    <div>
                                        <input type="email" class="form-control ps-3" placeholder="Your Email *" name="contact_email" id="" required="">
                                    </div>
                                </div>
                                <div class="text-center mt-4 mv-3">
                                    <button type="submit" style="margin: 0 auto;" class="blue-button btn">Click here to Gift</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        @include('footer')
     