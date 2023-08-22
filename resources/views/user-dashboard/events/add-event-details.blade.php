@include('user-dashboard.head')
    <title>Add Event Details | Dashboard</title>
    <body>
        <div id="preloader" class="d-none"></div>
            @include('user-dashboard.user-dashboard-header')
            <div class="main-content create-event-page">
                <div class="overlay">
                @include('user-dashboard.events.event-steps')
                    <div class="main-heading-box mb-4 ">
                        <h3 class="ps-4">Tell us More About Your Special Occassion</h3>
                    </div>
                   
                    <div class="event-box">
                        <div class="column column-theme">
                            <div class="theme-wrapper">
                                <img src="<?php echo $theme->cover_image_url; ?>" class="img-fluid">
                                <div class="data">
                                    <h1 class="event-heading" id="event-heading" style="color: <?php echo $theme->color_code; ?> !important;"><?php echo $theme->title; ?></h1>
                                    <h4 class="event-date" id="event-date-show" style="color: <?php echo $theme->color_code; ?> !important;">event date: <span><?php echo date('d-M-y', time()); ?></span></h4>

                                </div>
                            </div>
                        </div>
                        <div class="column column-details">
                            <form action="{{route('StoreDetailsForEvent')}}" method="post" class="form-style event-details-form">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="attire_name" id="attire_name" value="">
                                <input type="hidden" name="event_theme" value="{{$theme->theme_id}}">
                                <h3 class="form-heading mt-0">Join us to Celebrate</h3>
                                <hr class="underline">

                                <label for="" class="form-label sr-only">Event Name</label>
                                <input type="text" class="form-control" id="event-name" name="event_name" placeholder="Event Name" required>

                                <label for="" class="form-label sr-only">Hosted By</label>
                                <input type="text" class="form-control" id="" name="hosted_by" placeholder="Hosted By" required>

                                <label for="" class="form-label sr-only">Event Date</label>
                                <div class="input-group mb-3 input-calander">
                                    <input type="text" name="event_date"  data-toggle="datepicker" id="event_date" placeholder="Event Date" 
                                        class="form-control input-date"  required >  
                                    <button class="btn" type="button">
                                        <img src="{{asset('public/')}}/assets/images/dashboard/icon-calendar.png" class="img-fluid">
                                    </button>
                                    
                                </div>


                                <div class="textarea-box">
                                    <label for="" class="form-label sr-only">Event Details</label>
                                    <textarea class="form-control" name="event_details" id="event-details"
                                        placeholder="Your event details come here..." required></textarea>
                                    <small id="character">280 Character Only</small>
                                </div>

                                <label for="" class="form-label sr-only">Attire</label>
                                <div class="select-box">
                                    <div class="options-container">
                                        <div class="option attire-option">
                                            <input type="radio" class="radio" id="attire-1" name="attire" />
                                            <label for="attire-1" class="text-bold">White Tie</label>
                                        </div>
                                        <div class="option attire-option">
                                            <input type="radio" class="radio" id="attire-2" name="attire" />
                                            <label for="attire-2" class="text-bold">Black Tie</label>
                                        </div>
                                        <div class="option attire-option">
                                            <input type="radio" class="radio" id="attire-3" name="attire" />
                                            <label for="attire-3" class="text-bold">Semiformal</label>
                                        </div>
                                        <div class="option attire-option">
                                            <input type="radio" class="radio" id="attire-4" name="attire" />
                                            <label for="attire-4" class="text-bold">Festive on Holiday</label>
                                        </div>
                                        <div class="option attire-option">
                                            <input type="radio" class="radio" id="attire-5" name="attire" />
                                            <label for="attire-5" class="text-bold">Smart Or Business Casual</label>
                                        </div>
                                        <div class="option attire-option">
                                            <input type="radio" class="radio" id="attire-6" name="attire" />
                                            <label for="attire-6" class="text-bold">Sporty Casual Or Casual</label>
                                        </div>
                                    </div>

                                    <div class="selected">
                                        Attire
                                    </div>
                                </div>

                                <label for="" class="form-label sr-only">Location</label>
                                <div class="input-group mb-3 input-location">
                                    <input type="text" class="form-control" placeholder="Location" id="location-input" name="location">
                                    <button class="btn" type="button">
                                        <img src="{{asset('public/')}}/assets/images/dashboard/icon-location.png" class="img-fluid">
                                    </button>
                                    <div class="addressList d-none">
                                        <ul>
                                            <li></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="checkbox-wrapper">
                                    <h5>Event is:</h5>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" required name="event_type" id="virtual"
                                                value="virtual">
                                            <label class="form-check-label" for="virtual">Virtual</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" required name="event_type" id="physical"
                                                value="physical">
                                            <label class="form-check-label" for="physical">Physical</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" required name="event_type" id="no-event"
                                                value="no_event">
                                            <label class="form-check-label" for="no-event">No Event</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="two-button-box mt-3">
                                    <!-- <button class="common-button btn">Save</button> -->
                                    
                                    <button type="button" onclick="goBack()" class="btn common-button close-btn">Back</button>
                                    <button type="submit" class="blue-button btn mt-0">Save</button>
                                </div>

                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
    <script>

function goBack()
{
    window.history.back()
}

    function charLimit(input, maxChar) {
        var len = $(input).val().length;
        if (len > 0 ) {
            $('#character').text(len+'/'+maxChar);
        }
        if (len >= maxChar) {
            $(input).val($(input).val().substring(0, maxChar));
            alert('The message in your invite is longer than 280 characters. Please edit it so that it can be no longer than 280 charcaters');
        }
    }
        jQuery(document).ready(function ($) {
           

            jQuery('#event_date').keypress(
            function(event){
                event.preventDefault();
            });

            var minDate = new Date('2050-01-01'); 
                var endDate = new Date();
               
               $('[data-toggle="datepicker"]').datepicker({
                   autoHide:true,
                   format:'yyyy-mm-dd',
                   inline:true,
                   minDate:endDate,
                   startDate:endDate,
                    endDate:minDate,

               });

            

           
           
            $('#event-name').on('keyup', function () {
                $('#event-heading').html($(this).val());

            });
            $('#event_date').on('change', function () {
                var dateFormat = moment($(this).val(), 'YYYY-MM-DD').format('DD-MMM-YY');
                $('#event-date-show span').html(dateFormat);

            });

            $("#event-details").on('keyup', function() {
                charLimit(this, 280); 
            });



            $(document).on('click', '.addressList ul li', function () {
                $('#location-input').val($(this).html());
                $('.addressList').addClass('d-none');
            });

            $('#location-input').on('keyup', function(e){
                var fd = new FormData();
                fd.append('address_key', $(this).val());
                fd.append('_token', $("meta[name=csrf-token]").attr("content"));
               
                $.ajax({
                    url: "{{route('GetAddress')}}",
                    type: "post",
                    data: fd,
                    success: function (data) {
                        if (data.length > 0) {
                            var html = '';
                            $.each(data, function(index, value){
                                html += '<li data-cityId="'+value.place_id+'">';
                                html += value.name;
                                html += '</li>';
                            });
                            $('.addressList').removeClass('d-none');
                            $('.addressList ul').html(html);
                        } else {
                            $('.addressList ul').html('');
                        }
                    },
                    error: function (err) {
                        alert('There is some error!');

                    },
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 60000
                });
            });
        });
        var dateToday = new Date(); 
        $(function() {
            $( "#datepicker" ).datepicker({
                showButtonPanel: true,
                minDate: dateToday
            });
        });

       
    </script>
@include('user-dashboard.footer')