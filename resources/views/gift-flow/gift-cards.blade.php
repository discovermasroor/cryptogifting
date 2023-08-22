@include('head')
    <title>Gift Crypto | Crypto Gifting</title>
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
        <section class="get-gift-flow">
        <div class="gift_flow">
            <div class="container theme-card-conrtainer">
                <div class="row">
                    <div class="col-12">
                        <div class="sec_hd">
                            Select a Theme Card
                        </div>
                    </div>
                </div>
                <div class="row mt-4 mt-md-5">
                    <div class="col-12">
                    <form action="{{route('giftCardSelected')}}" method="post">
                    @csrf
                        <div class="cards_flex">
                        <?php foreach ($themes as $key => $value) { ?>
                                <div class="radio_btn">
                                    <div class="input_wrapper">
                                        <input type="radio" name="theme" id="theme-{{$key}}" value="{{$value->theme_id}}">
                                        <label for="theme-{{$key}}">{{$value->title}}</label>
                                    </div>
                                    <label for="theme-{{$key}}" class="theme-card">
                                        <img src="<?php echo $value->gifter_image_url; ?>" alt=""
                                            class="img-fluid">
                                            
                                    </label>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <button type="button"  onclick="goBack()"class="btn white_btn mx-2">Back</button>
                                <button type="submit" class="btn white_btn mx-2">Next</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        var card_inputs = document.querySelectorAll(".radio_btn .input_wrapper input")
        var card_img = document.querySelectorAll(".radio_btn img")
        for (let i = 0; i < card_inputs.length; i++) {
            let img = card_img[i];
            card_inputs[i].addEventListener('change', () => {
                for (let j = 0; j < card_img.length; j++) {
                    card_img[j].classList.remove('selected');
                }
                if (card_inputs[i].checked) {
                    img.classList.add("selected")
                }
            })
        }

        function goBack()
        {
        window.history.back()
        }
    </script>
@include('footer')