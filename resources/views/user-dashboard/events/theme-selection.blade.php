@include('user-dashboard.head')
    <title>Select Event Theme | Dashboard</title>
    <body>
        <div id="preloader" class="d-none"></div>
            @include('user-dashboard.user-dashboard-header')
            <div class="main-content create-event-page">
                <div class="overlay">
                @include('user-dashboard.events.event-steps')
                    <div class="main-heading-box ">
                        <h3>Select a Theme Card</h3>
                    </div>
                   

                    
                    <form action="{{route('SelectThemeForEvent')}}" method="post" class="theme-selection-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="user_id" value="{{$user_id}}">
                        <div class="themes-wrapper">
                            <?php foreach ($themes as $key => $value) { ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="theme" id="theme-{{$key}}" value="{{$value->theme_id}}">
                                    <label class="form-check-label" for="theme-{{$key}}">
                                        {{$value->title}} <br>
                                        <img src="<?php echo $value->cover_image_url; ?>" for="theme-{{$key}}" class="img-fluid">
                                    </label>
                                    
                                </div>
                            <?php } ?>
                        </div>
                        <div class="text-center">
                       
                               
                        <div class="two-button-box mx-auto mt-5" style="width: 100%; max-width: 450px;">
                                <button type="button" onclick="goBack()" class="btn common-button">Back</button> 
                                <button type="submit" class="btn blue-button">Next</button>
                            </div>
                       
                        </div>
                    </form>
                   
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
    </script>
@include('user-dashboard.footer')