@include('head')
    <title>Gift Crypto | Crypto Gifting</title>
    <body>
        @include('home-header')
        <section class="get-gift-flow">
        <div class="gift_flow">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="sec_hd">
                            What value would you like to Gift?
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <form action="">
                            <div class="flow_2">
                                <img src="{{asset('/public')}}/assets/images/flow/crypto-gift.png" class="img-fluid for_large_screen"
                                    alt="">
                                <img src="{{asset('/public')}}/assets/images/flow/gift-box-1.png" class="img-fluid for_small_screen"
                                    alt="">
                                <div class="flow_inner">
                                    <div class="input_wrapper">
                                        <p>Most Popular Gift Amounts</p>
                                        <div class="radio_btn_wrapper">
                                            <div class="wrap">
                                                <input type="radio" name="gift-amounts" id="R100">
                                                <label for="R100">R100</label>
                                            </div>
                                            <div class="wrap">
                                                <input type="radio" name="gift-amounts" id="R250">
                                                <label for="R250">R250</label>
                                            </div>
                                            <div class="wrap">
                                                <input type="radio" name="gift-amounts" id="R500">
                                                <label for="R500">R500</label>
                                            </div>
                                            <div class="wrap">
                                                <input type="radio" name="gift-amounts" id="R1000">
                                                <label for="R1000">R1000</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="converion_wrapper">
                                        <div>
                                            <label><span>R</span>
                                                <font>ZAR</font>
                                            </label>
                                            <div>
                                                <input type="text" placeholder="0">
                                                <div class="img_wrapper">
                                                    <img src="{{asset('/public')}}/assets/images/flow/exchange.svg" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label><span class="fab fa-btc"></span>
                                                <font>Bitcoin</font>
                                            </label>
                                            <div>
                                                <input type="text" placeholder="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{route('giftCard')}}" class="btn white_btn">Next</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@include('footer')