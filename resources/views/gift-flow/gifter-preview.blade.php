@include('head')
    <link rel="stylesheet" href="{{asset('/public')}}/assets/css/style-dashboard.css?ver=<?php echo VER; ?>">
    <title>Event Preview | CryptoGifting</title>
    <style>
        body{
            background: url({{asset('/public')}}/assets/images/web/banner-bg.png) no-repeat !important;
            background-size: cover !important;
            background-position: right center !important;
        }
        body .website-header,
        body header,
        .join-wrapper,
        footer{
            background: unset !important;
        }
        .copyrights p{
            margin: 0 auto !important;
            padding: 15px 0 !important;
        }
    </style>
    <body>
    @include('home-header')
    <main>
            <section class="join-wrapper event-preview gifter-preview">
                <div class="overlay"></div>
                <div class="main-container">
                <a href="{{route('Index')}}" class="heading-anchor ">
                    <h1>CryptoGifting</h1>
                </a>
                    <div class="event-box">
                        <div class="column column-theme">
                            <div class="theme-wrapper">
                                <img src="<?php echo $event->event_theme->cover_image_url; ?>" class="img-fluid">
                                <div class="data gift-flow-data">
                                    <h3 class="greetings-msg" style="color: <?php echo $event->event_theme->color_code; ?> !important;"><?php echo $event->event_theme->title; ?></h3>
                                    <h2 class="event-heading text-center" style="color: <?php echo $event->event_theme->color_code; ?> !important;"><?php echo  $event->sender_name; ?></h2>
                                    <p class="para">Here is a gift of <span class="gift-amount">{{number_format($event->gift_btc_amount, 10)}}</span> Bitcoin from</p>
                                    <h2 class="event-heading text-center" style="color: <?php echo $event->event_theme->color_code; ?> !important;"><?php echo  $event->recipient_name; ?></h2>
                                    <small>Sender's note</small>
                                    <p class="p3">
                                        <!--<span id="message1" class="txt_blue">Your Message</span>-->
                                        {!! $event->message !!}
                                    </p>
                                    <small>Login to receive your gift</small>
                                </div>
                            </div>
                        </div>
                        <div class="column column-details">
                            <form action="" class="special-form">
                                <h2 class="txt_blue">Preview Details</h2>
                                <hr class="underline">
                                <div class="txt">
                                    <div class="wrap">
                                        <h4 class="txt_blue text-center">{{ $event->sender_name}}</h4>
                                        <h4 id="name1"></h4>
                                    </div>
                                </div>
                                <hr class="underline">
                                <div class="txt">
                                    <div class="wrap">
                                        <h4 class="txt_blue text-center">{{ $event->recipient_name }}</h4>
                                        <h4 id="recipient_name1"></h4>
                                    </div>
                                    <hr class="underline">
                                </div>
                                <div class="txt">
                                    <h5 class="txt_blue text-center">Gift Amount
                                        <span id="gift_amount">ZAR {{$event->gift_zar_amount}}</span>
                                    </h5>
                                </div>
                                <hr class="underline">
                                <div class="txt">
                                    <h5 class="txt_blue text-center">Gift Amount in BTC
                                        <span id="gift_amount"><?php echo number_format($event->gift_btc_amount, 10);?> BTC</span>
                                    </h5>
                                </div>
                                <hr class="underline">
                                <p class="p3">
                                    <span id="message" class="txt_blue">Your Message</span>
                                    {!! $event->message !!}
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </main>
@include('footer')