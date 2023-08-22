@include('user-dashboard.head')
    <title>Event Preview | Dashboard</title>
    <body>
        <div id="preloader" class="d-none"></div>
            @include('user-dashboard.user-dashboard-header')
            <div class="main-content event-preview-page">
                <input type="hidden" id="topic-field" value="">
                <div class="overlay">
                @include('user-dashboard.events.event-steps')   
                    <div class="main-heading-box mb-4">
                        <h3 class="ps-4">Event Preview</h3>
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
                            <form action="" class="form-style event-details-form">
                             
                            <h3 class="form-heading mt-0">{{$event->name}}</h3>
                                <hr class="underline">
                                <input type="hidden" name="id" id="event_id" value="{{$id}}">
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
                                <div class="two-button-box mt-5">
                                    <button type="button" onclick="goBack()" class="btn common-button">Back</button> 
                                    <button type="button" id="send_gift" class="btn blue-button">Share</button>
                                </div>
                            </form>
                            <div class="modal fade popup-style success-popup" id="gift-success-popup" tabindex="-1"
                                aria-labelledby="gift-success-popupLabel" aria-hidden="true">
                                <div class="modal-dialog  modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <img src="{{asset('public/')}}/assets/images/dashboard/gift-sent-success.png"
                                                class="img-fluid art-img">
                                            <h1>success</h1>
                                            <h4 class="mb-4">Your invitation has been sent to your friends, Enjoy!</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
    <script>
        
        jQuery(document).ready(function() {
            $('#send_gift').on('click', function (e) {
                $('#preloader').removeClass('d-none');
                
                var formData = new FormData();
                formData.append('id', $('#event_id').val());
                formData.append('_token', "{{csrf_token()}}");
                $.ajax({
                    url: '{{ route("SaveEvent") }}',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                      $('#send_gift').attr('disabled','disabled');
                        $('#gift-success-popup').modal('show');
                        $('#preloader').addClass('d-none');
                       
                        window.setTimeout( function(){
                            window.location = "{{route('SelectBeneficiariesForEvent')}}";
                        }, 8000 );



                    },
                    error: function (err) {
                        $('#preloader').addClass('d-none');
                        if (err.status == 422) {
                            displayError(err.responseJSON.errors, false);
                        } else {
                            displayError(err.responseJSON.error.message);
                        }
                    },
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 60000
                });
              
               // $('#gift-success-popup').modal('show');
            });

            
        });

        function goBack()
        {
            window.history.back()
        }
    </script>
@include('user-dashboard.footer')