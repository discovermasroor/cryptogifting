<?php define('VER', '5.0.2'); ?>
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
    <link rel="stylesheet" href="{{asset('/public')}}/assets/css/style-dashboard.css?ver=<?php echo VER; ?>">
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
    <link rel="stylesheet" href="{{asset('/public')}}/assets/css/datepicker.css?ver=<?php echo VER; ?>">
    <script type="text/javascript" src="{{asset('/public')}}/assets/js/datepicker.min.js?ver=<?php echo VER; ?>"></script>
    <!-- AOS Animation -->
    <link rel="stylesheet" href="{{asset('/public')}}/assets/css/aos.css?ver=<?php echo VER; ?>">
    <script src="{{asset('/public')}}/assets/js/aos.js"></script>
</head>