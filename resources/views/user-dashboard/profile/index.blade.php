@include('user-dashboard.head')
    <title>Profile | Crypto Gifting</title>
    <body>
        @include('user-dashboard.user-dashboard-header')
        <div class="main-content profile-page">
            <div class="overlay">
               
                <h1 class="heading">Profile</h1>

                <a href="{{route('Settings')}}" class="btn profile-btn">
                    <div class="icon-box">
                        <img src="{{asset('/public')}}/assets/images/dashboard/icon-settings.png" class="img-fluid">
                    </div>
                    <h5 class="profile-option">Settings</h5>
                    <i class="uil uil-angle-right-b"></i>

                </a>
                
                <a href="{{route('Security')}}" class="btn profile-btn security">
                    <div class="icon-box">
                        <img src="{{asset('/public')}}/assets/images/dashboard/icon-security.png" class="img-fluid">
                    </div>
                    <h5 class="profile-option">Security</h5>
                    <i class="uil uil-angle-right-b"></i>
                </a>
                
                <a href="{{route('Help')}}" class="btn profile-btn" target="_blank">
                    <div class="icon-box">
                        <img src="{{asset('/public')}}/assets/images/dashboard/icon-help.png" class="img-fluid">
                    </div>
                    <h5 class="profile-option">Help</h5>
                    <i class="uil uil-angle-right-b"></i>
                </a>

                <div class="text-center my-4 pt-2">
                        <div class="two-button-box mx-auto" style="width: 100%; max-width: 450px;">
                            <button type="button" onclick="goBack()" class="btn common-button">Back</button> 
                          
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
    </script>
@include('user-dashboard.footer')