@include('user-dashboard.head')
    <title>Guest Lists | Dashboard</title>
    <body>
        <div id="preloader" class="d-none"></div>
            @include('user-dashboard.user-dashboard-header')
            <div class="main-content">
                <div class="overlay">
                @include('user-dashboard.events.event-steps')    
                    <div class="main-heading-box flex my-2">
                        <h3>Select your Guest List</h3>
                    </div>
                    <form action="{{route('StoreGuestListForEventNew', [$event_id])}}" method="post" class=" event-link-form beneficiary-selection-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="table-responsive data-table-wrapper akhri-table">
                            <table class="table">
                                <thead class="heading-box">
                                    <tr>
                                        <th>Select</th>
                                        <th>Guest List Name</th>
                                        <th>Date Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($guest_lists as $key => $value) { ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <input class="form-check-input" type="checkbox" id="{{$key}}" name="guest_lists[]" value="{{$value->guest_list_id}}">
                                                </div>
                                            </td>
                                            <td>{{$value->title}}</td>
                                            <td>{{$value->created_at->format('d-M-Y')}}</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="input-group mb-3 copy-link">
                            <input type="text" id="copy-field" class="form-control" value="{{route('EventPreviewForGuest', [$event_id])}}">
                            <button class="btn" id="copy-button" type="button"><i class="far fa-copy"></i></button>
                        </div>

                        <p>
                            Copy this link and paste it to your invite privately or publicly on Instagram, Tik Tok,
                            Twitter and all other social media platforms that you use, for maximum exposure. Note that
                            spamming is against our <a href="{{route('PrivacyPolicy')}}">Privacy Policy</a> and <a href="{{route('TermOfUSe')}}">Terms of Service</a>
                        </p>

                        <div class="social-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo route('EventPreviewForGuest', [$event_id]); ?>" class="btn fb">
                                <i class="fab fa-facebook"></i> Facebook
                            </a>
                            <a href="https://wa.me/?text=<?php echo route('EventPreviewForGuest', [$event_id]); ?>" class="btn wa">
                                <i class="fab fa-whatsapp"></i> Whatsapp
                            </a>
                        </div>
                        <div class="two-button-box" style="max-width:450px;">
                        <button type="button" onclick="goBack()" class="btn common-button close-btn">Back</button>
                            <button class="blue-button btn" type="submit">Save</button>
                        </div>
                    </form>
                
                  
                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
    <style>
        p {
            width: 50%;
            margin: 0 auto;
        }
        .event-link-form{
            max-width: unset;
        }
        .event-link-form .input-group{
            margin: 50px auto !important;
        }
    </style>
    <script>
        function goBack()
        {
        window.history.back()
        }
        jQuery(document).ready(function ($) {
            $('#copy-button').on('click', function () {
                var copyText = document.getElementById("copy-field");
                copyText.select();
                copyText.setSelectionRange(0, 99999); 
                if(navigator.clipboard.writeText(copyText.value)) {
                    var html = ''
                    html += '<div class="alert custom-alert alert-success d-flex align-items-center" role="alert">';
                    html += '<ul>';
                    html += '<li><i class="uil uil-check-circle"></i>Public Link successfuly copied</li>';
                    html += '</ul>';
                    html += '</div>';
                    $('body').append(html);
                    setTimeout(function(){ $('body').find('div.alert.custom-alert').remove(); }, 5000);
                    return false;
                }
            });
        });
    </script>
@include('user-dashboard.footer')