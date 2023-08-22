@include('head')
    <title>Thank you so much! | Crypto Gifting</title>
    <link rel="stylesheet" href="{{asset('/public')}}/assets/css/style-dashboard.css?ver=<?php echo VER; ?>">
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
    <body>
    @include('home-header')
        <main>
            <section class="join-wrapper">
                <div class="overlay"></div>
                <div class="white-wrapper">
                    <a href="{{route('Index')}}" class="back-to-home btn"><i class="fas fa-long-arrow-alt-left"></i> Back to Home</a>
                    <div class="thankyou my-0">
                        <img src="{{asset('public/')}}/assets/images/dashboard/thankyou.png" class="img-fluid">

                        <div class="card card-style">
                            <div class="card-body">
                                <h6>Hello @if (request()->user) {{get_user_name(request()->user->user_id)}} @else {{session()->get('contact_name')}} @endif</h6>
                                <p>
                                    Thank you for responding to your Friend.
                                </p>
                                <p class="bold">Team CryptoGifting <br> Making Gifting Crypto Easy</p>
                            </div>
                        </div>

                        <p>
                            CryptoGifting makes inviting guests and receiving gifts easy with just a few clicks. <br>
                            Want to know more? <a href="{{route('Index')}}">Click here</a>
                            <br><br>
                            Questions? <a href="{{route('Help')}}">Click here</a> to visit our Help Page
                        </p>
                    </div>
                </div>
            </section>
        </main>
        <style>
            .white-wrapper {
                overflow: hidden;
                background-color: #fff;
                position: relative;
                z-index: 1;
                width: 90%;
                max-width: 1200px;
                border-radius: 30px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
                padding: 40px 20px 20px;
            }

            @media (max-width: 450px) {
                .white-wrapper img {
                    max-width: 70%;
                }

                .white-wrapper .card-body {
                    padding: 20px 15px 0;
                }
            }
            .back-to-home {
                position: absolute;
                top: 20px;
                left: 20px;
                background: linear-gradient(to right, #1F2374, #1A47A2);
                color: #fff !important;
                border-radius: 30px;
                font-size: 12px;
                z-index: 11;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5) !important;
            }

            .back-to-home i {
                margin-right: 5px;
            }
        </style>
        @include('footer')