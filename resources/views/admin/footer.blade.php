<footer>
        <div class="container">
            <div class="column logo-column">
                <a href="{{route('Index')}}">
                    <h1>CryptoGifting</h1>
                </a>
            </div>
            <div class="column links-column">
                <h5 class="sub-heading">Recieve a Gift</h5>
                <a href="{{route('OurFees')}}">Our Fees</a>
                <a href="{{route('EarnInterest')}}">Earn Interest</a>
            </div>
            <div class="column links-column">
                <h5 class="sub-heading">Send a Gift</h5>
                <a href="{{route('OurFees')}}">Our Fees</a>
            </div>
            <div class="column links-column">
                <h5 class="sub-heading">Quick Links</h5>
                <a href="{{route('LoyaltyProgram')}}">Loyalty Program</a>
                <a href="{{route('GiveUsFeedback')}}">Give us Feedback</a>
            </div>
            <div class="column links-column">
                <h5 class="sub-heading">Company</h5>
                <a href="{{route('ContactUs')}}">Contact Us</a>
                <!-- <a href="#">Our Partners</a> -->
                <a href="{{route('Affiliates')}}">Affiliates</a>
                <a href="{{route('TermOfUSe')}}">Terms of Use</a>
                <a href="{{route('PrivacyPolicy')}}">Privacy Policy</a>
                <a href="{{route('CookiesSettings')}}">Cookie Settings</a>
            </div>
            <div class="column payments-column">
                <div class="wrapper">
                    
                    <div class="">
                        <a href="#"><img src="{{asset('/public')}}/assets/images/web/payment-icon-bitcoin.png" class="img-fluid bitcoin-logo"></a>
                        <a href="#"><img src="{{asset('/public')}}/assets/images/web/payment-icon-peachpay.png" class="img-fluid"></a>
                        <a href="#"><img src="{{asset('/public')}}/assets/images/web/zapper.png" class="img-fluid"></a>
                        <a href="#"><img src="{{asset('/public')}}/assets/images/web/payment-icon-visa.png" class="img-fluid"></a>
                        <a href="#"><img src="{{asset('/public')}}/assets/images/web/payment-icon-mastercard.png" class="img-fluid"></a>
                        <a href="#"><img src="{{asset('/public')}}/assets/images/web/snap-scan.png" class="img-fluid"></a>
                        <a href="#"><img src="{{asset('/public')}}/assets/images/web/payment-icon-Eft.png" class="img-fluid eft-img"></a>
                    </div>
                    
                    <p class="social-links">
                        <a target="_blank" href="https://www.facebook.com/CryptoGifting"><i class="fab fa-facebook-f"></i></a>
                        <a target="_blank" href="https://twitter.com/GiftingCrypto"><i class="fab fa-twitter"></i></a>
                        <a target="_blank" href="https://www.instagram.com/cryptogifting/"><i class="fab fa-instagram"></i></a>
                        <a target="_blank" href="https://www.linkedin.com/company/cryptogifting/"><i class="fab fa-linkedin-in"></i></a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <div class="copyrights bg-white px-3">
        <p>Copyright &copy; {{date('Y')}} CryptoGifting</p>
    </div>

    <?php if (session()->has('req_error')) { ?>

        
         <div class="alert custom-alert alert-danger d-flex align-items-center" role="alert">
            <ul>
                <li><i class="uis uis-exclamation-triangle"></i>{{session()->get('req_error')}}</li>
            </ul>
        </div> 
        <?php session()->forget('req_error');
    } else if (session()->has('req_success')) { ?>
        <div class="alert custom-alert alert-success d-flex align-items-center" role="alert">
            <ul>
                <li><i class="uil uil-check-circle"></i>{{session()->get('req_success')}}</li>
            </ul>
        </div>
        <?php session()->forget('req_success');
    } else if ($errors->any()) { ?>
        <div class="alert custom-alert alert-danger d-flex align-items-center" role="alert">
            <ul>
                <?php foreach ($errors->all() as $key => $value) { ?>
                    <li><i class="uis uis-exclamation-triangle"></i>{{$value}}</li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
    <div id="preloader" class="d-none"></div>
    <script type="text/javascript">
    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    (function () {
        var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/615c205dd326717cb684cfda/1fh7tsroc';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
    </script>
    <script src="{{asset('/public')}}/assets/js/custom-js.js?ver=<?php echo VER; ?>"></script>
    <script src="{{asset('/public')}}/assets/js/custom-select.js?ver=<?php echo VER; ?>"></script>
    <script src="{{asset('/public')}}/assets/js/multi-step-form.js?ver=<?php echo VER; ?>"></script>
    <script src="{{asset('/public')}}/assets/build/js/intlTelInput.min.js?ver=<?php echo VER; ?>"></script>

    <script>
        AOS.init();
        jQuery(document).ready(function ($) {
            jQuery("#gifter-flow-tab").click(function () {
                jQuery("#security-para1").addClass('d-none');
                jQuery("#security-para2").removeClass('d-none');
            });
            jQuery("#event-flow-tab").click(function () {
                jQuery("#security-para1").removeClass('d-none');
                jQuery("#security-para2").addClass('d-none');
            });
        });

        
    </script>
</body>
</html>