<?php define('VER', '5.1.5'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('/public')}}/assets/images/favicon.png" type="image/png" rel="icon">
    <!-- Bootstrap Stylesheet -->
    <link rel="stylesheet" href="{{asset('/public')}}/assets/css/bootstrap.min.css?ver=<?php echo VER; ?>">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="{{asset('/public')}}/assets/css/holding-style.css?ver=<?php echo VER; ?>">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{asset('/public')}}/assets/css/owl.carousel.css?ver=<?php echo VER; ?>">
    <link rel="stylesheet" href="{{asset('/public')}}/assets/css/owl.theme.default.min.css?ver=<?php echo VER; ?>">
    <!-- jQuery Files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="{{asset('/public')}}/assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('/public')}}/assets/js/owl.carousel.js"></script>
    <script src="{{asset('/public')}}/assets/js/moment.js"></script>
    <!-- Custom Fonts -->
    <link href="{{asset('/public')}}/assets/css/euclid-fonts.css?family=euclid:300,400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Fonts Icons -->
    <link rel="stylesheet" href="{{asset('/public')}}/assets/css/fontawesome.min.css?ver=<?php echo VER; ?>">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.3/css/line.css?ver=<?php echo VER; ?>">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.3/css/solid.css?ver=<?php echo VER; ?>">
    <link rel="stylesheet" href="{{asset('/public')}}/assets/build/css/intlTelInput.css?ver=<?php echo VER; ?>">
    <!-- <script src="{{asset('/public')}}/assets/build/js/intlTelInput.min.js"></script>
    <script src="{{asset('/public')}}/assets/build/js/utils.js"></script> -->
    <!-- AOS Animation -->
    <link rel="stylesheet" href="{{asset('/public')}}/assets/css/aos.css?ver=<?php echo VER; ?>">
    <script src="{{asset('/public')}}/assets/js/aos.js"></script>
    <style>
        .inputWrap_l30a8{
            display:none !important;
        }
        #force_css .form_15iP5 {
            border: 0 !important;
            margin: 0 !important;
            background: red !important;
        }
    </style>
</head>

<body class="jani">

    <main class="holdingpage-wrapper">
        <div class="overlay">
            <div class="custom-row">
                <div class="column column-1 text-center">
                    <h1 class="logo"><a href="#">CryptoGifting</a></h1>
                    <h3 class="sub-heading">if i had bought you bitcoin in 2010,  for what i spent on a birthday card today, you'd be a millionaire now</h3>
                    <img src="{{asset('/public')}}/assets/images/web/holdingpage-art.png" class="img-fluid">
                </div>
                <div class="column column-2">
                    <div class="holding_page_form">
                        <div class="header_text">
                            <h2>COMING DECEMBER 2021</h2>
                            <p>
                            CryptoGiftnig makes Gifting Crypto Easy! <br>
                            Be one of the first to experience the magic of gifting crypto by entering your email below and we will notify you as soon as we are live.
                            </p>
                            <h4>
                            Let's do this!
                            </h4>
                        </div>
                        <div class="our-links">
                            <div class="link_wrapper">
                                <a href="https://www.facebook.com/CryptoGifting"><i class="fab fa-facebook-f"></i></a>
                            </div>
                            <div class="link_wrapper">
                                <a href="https://twitter.com/GiftingCrypto"><i class="fab fa-twitter"></i></a>
                            </div>
                            <div class="link_wrapper">
                                <a href="https://www.instagram.com/cryptogifting/"><i class="fab fa-instagram"></i></a>
                            </div>
                            <div class="link_wrapper">
                                <a href="https://www.linkedin.com/company/cryptogifting"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                        <div class="form_wrapper">
                            <iframe width="100%" height="100%" id="force_css" src="https://cdn.forms-content.sg-form.com/69fc0384-4929-11ec-9c0b-92d0da59c5cc"></iframe>
                        </div>                                                
                    </div>                
                </div>
            </div>

            <p class="copyrights">Copyrights &copy; 2021 CryptoGifting</p>
        </div>
                                
    </main>

    <script>
        var head = jQuery("#force_css").contents().find("head");
        var css = '<style type="text/css"> .inputWrap_l30a8 .input_3Dy0L{height: 70px !important; background-color: fff !important; border: none !important;box-shadow: rgba(0, 0, 0, 0.45) 0px 25px 20px -20px !important;margin-bottom: 20px !important;border-radius: 16px !important;padding-left: 30px !important;transition:  all 0.5s ease-in-out !important;}; </style>';
        
        jQuery(document).ready(function($){
            $(head).append(css);
            $("#force_css").on('load',function(){
                let head = $(this).contents().find("head");
            });
        });
    </script>
</body>
</html>