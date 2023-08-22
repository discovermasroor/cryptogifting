@include('head')
    <title>Email Verification | Crypto Gifting</title>
    <body>
        <!-- @include('home-header') -->
        <main>
            <section class="join-wrapper">
                <div class="overlay"></div>
                <div class="main-container signup">
                    <div class="column column-img">
                        <div class="inner-wrapper">
                            <img src="{{asset('/public')}}/assets/images/web/signup-img.png" class="img-fluid signup-img">
                            <div class="slider-wrapper">
                                <img src="{{asset('/public')}}/assets/images/web/triangle.png" class="img-fluid triangle">
                                <div class="owl-carousel owl-theme signup-slider">
                                    <div class="item">
                                        <img src="{{asset('/public')}}/assets/images/web/Quote-icon-1.png" class="img-fluid quote-1">
                                        <h5>Anastasia Kondratyeva</h5>
                                        <p>
                                            This is the easiest and most user friendly crypto platform I have ever come across
                                        </p>
                                        <img src="{{asset('/public')}}/assets/images/web/Quote-icon-2.png" class="img-fluid quote-2">
                                    </div>
                                    <div class="item">
                                        <img src="{{asset('/public')}}/assets/images/web/Quote-icon-1.png" class="img-fluid quote-1">
                                        <h5>Joao Henriques</h5>
                                        <p>
                                            In just a few steps I setup an event and received Bitcoin for my birthday
                                        </p>
                                        <img src="{{asset('/public')}}/assets/images/web/Quote-icon-2.png" class="img-fluid quote-2">
                                    </div>
                                    <div class="item">
                                        <img src="{{asset('/public')}}/assets/images/web/Quote-icon-1.png" class="img-fluid quote-1">
                                        <h5>Sevi Spanoudi</h5>
                                        <p>
                                            sending or receiving crypto without complicating processes...super straigh forward
                                        </p>
                                        <img src="{{asset('/public')}}/assets/images/web/Quote-icon-2.png" class="img-fluid quote-2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column column-form">
                        <a href="{{route('Index')}}" class="heading-anchor">
                            <h1>CryptoGifting</h1>
                        </a>
                        <div class="form-wrapper">
                            <fieldset>
                                <div class="form-card">
                                    <div class="input-wrapper">
                                        <?php if (isset($success) && !empty($success)) { ?>
                                            <h6>{{$success}}</h6>
                                        <?php } else { ?>
                                            <h6>{{$error}}</h6>
                                        <?php } ?>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <script src="{{asset('/public')}}/assets/js/custom-js.js"></script>
        <style>
            h6 {
                color: var(--orange) !important;
                text-align: center;
            }
        </style>