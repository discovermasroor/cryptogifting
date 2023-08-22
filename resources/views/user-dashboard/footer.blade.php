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
    <?php if (session()->has('req_name')) { ?>
        <div id="kyc-modal" class="alert alert-danger custom-alert-button d-flex align-items-center flex-column" role="alert">
            <div class="content-box">
                <p style="color: var(--blue);">Hello, what should we call you?</p>
                <div class="buttons">
                    <a href="{{route('Settings')}}?model=name-modal" class="btn action-button blue">Add Details</a>
                    <a href="#" id="close-kyc" class="btn action-button">Later</a>
                </div>
            </div>
        </div>
    <?php session()->forget('req_name');
    } else if (session()->has('req_kyc')) { ?>
        <div id="kyc-modal" class="alert alert-danger custom-alert-button d-flex align-items-center flex-column" role="alert">
            <div class="content-box">
                <p style="color: var(--blue);">Would you like to complete your KYC now or leave it for later?</p>
                <div class="buttons">
                    <a href="{{route('Security')}}?model=kyc-modal" class="btn action-button blue">Now</a>
                    <a href="#" id="close-kyc" class="btn action-button">Later</a>
                </div>
            </div>
        </div>
    <?php session()->forget('req_kyc');
    } else if (session()->has('req_error')) { ?>
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
    <!-- <div id="preloader" class="d-none"></div> -->
    <script src="{{asset('/public')}}/assets/js/custom-js.js?ver=<?php echo VER; ?>"></script>
    <script src="{{asset('/public')}}/assets/js/custom-select.js?ver=<?php echo VER; ?>"></script>
    <script src="{{asset('/public')}}/assets/js/multi-step-form.js?ver=<?php echo VER; ?>"></script>
    <script src="{{asset('/public')}}/assets/build/js/intlTelInput.min.js?ver=<?php echo VER; ?>"></script>

    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('#close-kyc').on('click', function (e) {
                e.preventDefault();
                $('#kyc-modal').remove();
            })
        });
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
    <script>
        AOS.init();
        $(document).ready(function () {
            $('.sidebar-trigger').click(function () {
                $('aside').toggleClass('show');
            })
        });
    </script>
</body>
</html>