@include('user-dashboard.head')
    <title>Quick Share Links | Dashboard</title>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content create-event-page">
                <div class="overlay">
                    <div class="main-heading-box ">
                        <h3 class="ps-4">Quick Share Links</h3>
                    </div>
                    <form action="" class="event-link-form form-style">
                        <div class="input-group mb-3">
                            <input type="text" id="copy-field" class="form-control" value="{{route('PayUser', [$user_id])}}">
                            <button class="btn" type="button" id="copy-button"><i class="far fa-copy"></i></button>
                        </div>
                        <p>
                        Copy and paste this link on Facebook, Whatsapp, on your email and other social media platforms that you would like. Note that spamming is against our <a href="{{route('PrivacyPolicy')}}">Privacy Policy</a> and <a href="{{route('TermOfUSe')}}">Terms of Service</a>
                        </p>

                        <div class="social-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo route('PayUser', [$user_id]); ?>" class="btn fb">
                                <i class="fab fa-facebook"></i> Facebook
                            </a>
                            <a href="https://wa.me/?text=<?php echo route('PayUser', [$user_id]); ?>" class="btn wa">
                                <i class="fab fa-whatsapp"></i> Whatsapp
                            </a>
                        </div>
                        <div class="mt-5 d-flex align-items-center justify-content-center">
                                <button  type="button"  onclick="goBack()"class="btn blue-button mx-2">Back</button>
                            </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
    <script>
        jQuery(document).ready(function ($) {
            $('#copy-button').on('click', function () {
                var copyText = document.getElementById("copy-field");
                copyText.select();
                copyText.setSelectionRange(0, 99999); 
                if(navigator.clipboard.writeText(copyText.value)) {
                    var html = ''
                    html += '<div class="alert custom-alert alert-success d-flex align-items-center" role="alert">';
                    html += '<ul>';
                    html += '<li><i class="uil uil-check-circle"></i>Event link copied!</li>';
                    html += '</ul>';
                    html += '</div>';
                    $('body').append(html);
                    setTimeout(function(){ $('body').find('div.alert.custom-alert').remove(); }, 5000);
                    return false;
                }
            });
        });
        function goBack()
        {
        window.history.back()
        }
    </script>
@include('user-dashboard.footer')