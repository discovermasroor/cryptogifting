@include('head')
    <title>Get Crypto | Crypto Gifting</title>
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
    </style>
        <section class="get-gift-flow">
        <div class="container home-banner">
            <div>
                <h2>Get Crypto</h2>
                
                <form action="" method="post" class="radio-button-form">
                        
                    <div class="btn-group action-buttons" role="group">
                        
                        <input type="radio" class="btn-check" name="create_event" id="btnradio2" value="2" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio2">
                            <div class="img-box">
                                <img src="{{asset('public/')}}/assets/images/dashboard/create-event.png" class="img-fluid">
                            </div>
                            Click here to create an event and share your invite
                        </label>
                        
                        <input type="radio" class="btn-check" name="create_event" id="btnradio1" value="1" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio1" data-bs-toggle="modal" data-bs-target="#event-link-popup">
                            <div class="img-box">
                                <img src="{{asset('public/')}}/assets/images/dashboard/permalink.png" class="img-fluid">
                            </div>
                            Click here to get a public link for your invite
                        </label>
                    </div>

                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" onclick="goBack()" class="btn white_btn mx-2">Back</button>
                        <a type="button" class="btn white_btn mx-2" href="<?php if( request()->user ) echo route('SelectBeneficiariesForEvent'); else echo route('SignUp');  ?>">Next</a>
                    </div>
                </form> 

                <!--<div class="action-buttons">-->
                
                <!--    <a href="<?php if( request()->user ) echo route('SelectBeneficiariesForEvent'); else echo route('SignUp');  ?>" class="btn">-->
                <!--        <div class="img-box">-->
                <!--            <img src="{{asset('/public')}}/assets/images/dashboard/create-event.png" class="img-fluid">-->
                <!--        </div>-->
                <!--        <span>Click here to create an event and share your invite</span>-->
                <!--    </a>-->

                <!--    <a href="#event-link-popup" class="btn" data-bs-toggle="modal">-->
                <!--        <div class="img-box">-->
                <!--            <img src="{{asset('/public')}}/assets/images/dashboard/permalink.png" class="img-fluid">-->
                <!--        </div>-->
                <!--        <span>Click here to get a public link for your invite</span>-->
                <!--    </a>-->
                <!--</div>-->

            </div>

            <div class="modal popup-style" id="event-link-popup">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <a href="https://discoveritech.org/cryptogifting" class="heading-anchor popup">
                                <h1>CryptoGifting</h1>
                            </a>
                            <h2 class="popup heading-two">Copy and Paste this link</h2>
                            <form action="" class="event-link-form form-style">
                                <div class="input-group mb-3">
                                    <?php $email = session()->get('email');
                                        $encodedEmail = urlencode($email);
                                        $route = route('Allocate', [$encodedEmail]);
                                    ?>
                                    <input type="text"  id="copy-field" class="form-control" value="<?php echo $route; ?>">
                                    <button class="btn" type="button" id = "copy-button"><i class="far fa-copy"></i></button>
                                </div>
                                <p>
                                    Copy this link and paste it to your invite privately or publicly on Instagram, Linkedin, Twitter and all other social media platforms that you use, for maximum exposure.
                                    Note that spamming is against our <a href="#">Privacy Policy</a> and <a href="#">Terms of Service</a>
                                </p>

                                <div class="social-buttons">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $route; ?>" class="btn fb">
                                        <i class="fab fa-facebook"></i> Facebook
                                    </a>
                                    <a href="https://wa.me/?text=<?php echo $route; ?>" class="btn wa">
                                        <i class="fab fa-whatsapp"></i> Whatsapp
                                    </a>
                                </div>
                            </form>
                            
                            <a href="{{route('Index')}}" class="btn close-btn blue-button popup">Back</a>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
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
@include('footer')