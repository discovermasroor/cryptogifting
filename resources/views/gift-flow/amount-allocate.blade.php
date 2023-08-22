@include('head')
<?php
    $fees = \App\Models\Setting::where('keys', 'platform_fee')->first();
    $second_fees = \App\Models\Setting::where('keys', 'other_platform_fee')->first();
?>
    <title>Get Crypto | CryptoGifting</title>
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
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="sec_hd">
                                How much would you like to Gift?
                                <small class="mt-0 mt-md-2">* Summary of Fees is displayed on checkout</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <form action="{{route('giftCard')}}" method="post">
                                @csrf
                                <div class="flow_2">
                                    <img src="{{asset('public')}}/assets/images/flow/crypto-gift.png" class="img-fluid for_large_screen"
                                        alt="">
                                    <img src="{{asset('public')}}/assets/images/flow/gift-box-1.png" class="img-fluid for_small_screen"
                                        alt="">
                                    <div class="flow_inner">
                                        <div class="input_wrapper">
                                            <p> Popular Amounts</p>
                                            <div class="radio_btn_wrapper">
                                                <div class="wrap">
                                                    <input type="radio" class="popular-amount" name="gift-amounts" id="R1000" value="1000">
                                                    <label for="R1000">R1000</label>
                                                </div>
                                                <div class="wrap">
                                                    <input type="radio" class="popular-amount" name="gift-amounts" id="R500" value="500">
                                                    <label for="R500">R500</label>
                                                </div>
                                                <div class="wrap">
                                                    <input type="radio" class="popular-amount" name="gift-amounts" id="R250" value="250">
                                                    <label for="R250">R250</label>
                                                </div>
                                                <div class="wrap">
                                                    <input type="radio" class="popular-amount" name="gift-amounts" id="R100" value="100">
                                                    <label for="R100">R100</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="converion_wrapper mt-4">
                                            <div>
                                                <label><span>R</span>
                                                <font>ZAR</font>
                                                </label>
                                                <div>
                                                    <input type="number" required step="any" name="gift_zar_amount" id="gift_amount" placeholder="0" min="0">
                                                    <div class="img_wrapper">
                                                        <img src="{{asset('public')}}/assets/images/flow/exchange.svg" alt=""
                                                            class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <label><span class="fab fa-btc"></span>
                                                    <font>Bitcoin</font>
                                                </label>
                                                <div>
                                                    <input type="text" maxlength="10" disabled name="gift_btc_amount" id="gift_btc_amount" placeholder="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="extra-center">
                                    <button type="submit" class="btn white_btn">Next</button>
                                </div> -->
                            <div class="d-flex align-items-center justify-content-center">
                                <button type="button" onclick="goBack()" class="btn white_btn mx-2">Back</button>
                                <button type="submit" class="btn white_btn mx-2">Next</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <style>
        
        #gift_btc_amount{
            background-color: white !important;
            opacity: 1 !important;
        }
        .flow_inner .converion_wrapper>div label{
            width: 22%;
        }
    </style>
    <script>
     jQuery(document).ready(function($){
        var btcRate = "{{$btc_rate}}";
        $('#gift_amount').on('change keyup', function () {
            var givenAmount = $(this).val();
           // if(givenAmount > 0) {
                var result = givenAmount/btcRate;
                result = result.toFixed(10)
                $('#gift_btc_amount').val(result);
            //}
            
            
            
        });

        $('.popular-amount').on('click', function () {
            $('#gift_amount').val($(this).val());
            var result = $(this).val()/btcRate;

            result = result.toFixed(10)
            $('#gift_btc_amount').val(result);
        });
     });
    </script>

            <script>
                 function goBack()
                    {
                        window.history.back()
                    }
            </script>
@include('footer')