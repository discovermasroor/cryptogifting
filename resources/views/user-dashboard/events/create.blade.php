@include('user-dashboard.head')
    <title>Would you like to | Dashboard</title>
    <body>
        <div id="preloader" class="d-none"></div>
            @include('user-dashboard.user-dashboard-header')
            <div class="main-content create-event-page">
                <div class="overlay">
                @include('user-dashboard.events.event-steps')
                    <div class="main-heading-box ">
                        <h3 class="ps-4">Would you like to..</h3>
                    </div>
                    
                   

                     <form action="{{route('CreateEventSelect')}}" method="post">
                         @csrf
                        <div class="btn-group action-buttons" role="group">
                            
                        <input type="radio" class="btn-check" name="create_event" id="btnradio2" value="2" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio2">
                                <div class="img-box">
                                    <img src="{{asset('public/')}}/assets/images/dashboard/create-event.png" class="img-fluid">
                                </div>
                                Create Your Own Event    
                            </label>
                            <input type="radio" class="btn-check" name="create_event" id="btnradio1" value="1" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio1">
                                <div class="img-box">
                                    <img src="{{asset('public/')}}/assets/images/dashboard/permalink.png" class="img-fluid">
                                </div>
                                Use Your Unique Public Link
                            </label>
                        </div>

                        <div class="two-button-box mx-auto mt-5">
                            <button type="button" onclick="goBack()" class="btn common-button close-btn">Back</button>
                            <button type="submit" class="blue-button btn mt-0">Next</button>
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