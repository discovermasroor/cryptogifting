<header class="website-header">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{route('Index')}}">
                <h1>CryptoGifting</h1>
            </a>
            <button class="navbar-toggler sidebar-trigger" type="button" data-bs-toggle="collapse" data-bs-target="#web-menu"
                aria-controls="web-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <div class="collapse navbar-collapse" id="web-menu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item <?php if(Route::current()->getName() == 'Help') echo 'signup-btn';?>">
                        <a class="nav-link " href="{{route('Help')}}">Help</a>
                    </li>
                    <li class="nav-item <?php if(Route::current()->getName() == 'ContactUs') echo 'signup-btn';?>">
                        <a class="nav-link" href="{{route('ContactUs')}}">Contact Us</a>
                    </li>
                    <?php if(request()->user) { ?>
                        <li class="nav-item  <?php if(Route::current()->getName() == 'UserDashboard') echo 'signup-btn';?>">
                            <a class="nav-link" href="{{route('UserDashboard')}}">dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('Logout')}}">logout</a>
                        </li>
                    <?php } else if(request()->admin) { ?>
                        <li class="nav-item  <?php if(Route::current()->getName() == 'AdminDashboard') echo 'signup-btn';?>">
                            <a class="nav-link" href="{{route('AdminDashboard')}}">dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('Logout')}}">logout</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item <?php if(Route::current()->getName() == 'SignIn') echo 'signup-btn';?>">
                            <a class="nav-link" href="{{route('SignIn')}}">sign in</a>
                        </li>
                        <li class="nav-item <?php if(Route::current()->getName() == 'SignUp') echo 'signup-btn';?>">
                            <a class="nav-link" href="{{route('SignUp')}}">sign up</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <?php if (Route::current()->getName() == 'Index') { ?>
            <section class="get-gift-flow">
                <div class="container banner home-banner get-flow">
                    <div class="column column-content pe-0 pe-sm-3">
                        <h2>The Gift of Wealth</h2>
                        <h4>Who is the lucky crypto recipient?</h4>
                        <form action="{{route('getNewCrypto')}}" class="email-form">
                            <div>
                                <label for="" class="form-label sr-only">Email</label>
                                <input type="email" required name="email" class="form-control" placeholder="Email Address">
                            </div>
                            <div class="buttons-box">
                                <button type="submit" name="gift_crypto" value="gift_crypto" class="btn orange-button">Gift Crypto</button>
                                <button type="submit" name="get_crypto" value="get_crypto" class="btn orange-button">Get Crypto</button>
                            </div>
                        </form>
                    </div>
                    <div class="column column-img">
                        <img src="{{asset('/public')}}/assets/images/web/home-banner-art.png" class="img-fluid">
                    </div>
                </div>
            </section>

        <?php } else if (Route::current()->getName() == 'ContactUs') { ?>
        <section class="container banner">
            <div class="column column-content pe-0 pe-sm-3">
                <h1>Got any questions or suggestions?</h1>
                <h3>Feel free to drop us a line below</h3>
            </div>
            <div class="column column-img contact-banner-image">
                <img src="{{asset('/public')}}/assets/images/web/contact-banner-art.png" class="img-fluid">
            </div>
        </section>
    <?php } else if (Route::current()->getName() == 'LoyaltyProgram') { ?>
        <section class="container banner">
            <div class="column column-content pe-0 pe-sm-3">
                <h1>Get In Touch</h1>
                <h3>Feel free to drop us a line below</h3>
            </div>
            <div class="column column-img" style="padding-bottom: 40px;">
                <img src="{{asset('/public')}}/assets/images/web/loyality-program.png" class="img-fluid loyalty-banner-img">
            </div>
        </section>
    <?php } else if (Route::current()->getName() == 'GiveUsFeedback') { ?>
        <section class="container banner">
            <div class="column column-content pe-0 pe-sm-3">
                <h1>Get In Touch</h1>
                <h3>Feel free to drop us a line below</h3>
            </div>
            <div class="column column-img pb-4">
                <img src="{{asset('/public')}}/assets/images/web/Feedback@2x.png" class="img-fluid">
            </div>
        </section>
    <?php } else if (Route::current()->getName() == 'Affiliates') { ?>
        <section class="container banner">
            <div class="column column-content pe-0 pe-sm-3">
                <h1>Get In Touch</h1>
                <h3>Feel free to drop us a line below</h3>
            </div>
            <div class="column column-img">
                <img src="{{asset('/public')}}/assets/images/web/Affiliate@2x.png" class="img-fluid">
            </div>
        </section>
    <?php } else if (Route::current()->getName() == 'PrivacyPolicy') { ?>
        <section class="container banner">
            <div class="column column-content pe-0 pe-sm-3">
                <h1>Get In Touch</h1>
                <h3>Feel free to drop us a line below</h3>
            </div>
            <div class="column column-img">
                <img src="{{asset('/public')}}/assets/images/web/privacy-policy-img.png" class="img-fluid">
            </div>
        </section>
    <?php } else if (Route::current()->getName() == 'OurFees') { ?>
        <section class="container banner">
            <div class="column column-content pe-0 pe-sm-3">
                <h1>Our Fees</h1>
                <h3>Is CryptoGifting completely free? <br> Are there any costs?</h3>
            </div>
            <div class="column column-img">
                <img src="{{asset('/public')}}/assets/images/web/cost-art.png" class="img-fluid">
            </div>
        </section>
    <?php } else if (Route::current()->getName() == 'TermOfUSe') { ?>
        <section class="container banner">
            <div class="column column-content pe-0 pe-sm-3">
                <h1>Get In Touch</h1>
                <h3>Feel free to drop us a line below</h3>
            </div>
            <div class="column column-img">
                <img src="{{asset('/public')}}/assets/images/web/terms-of-service-banner.png" class="img-fluid">
            </div>
        </section>
    <?php } else if (Route::current()->getName() == 'EarnInterest') { ?>
        <section class="container banner">
            <div class="column column-content pe-0 pe-sm-3">
                <h1>Earn Yield</h1>
                <h3>Is CryptoGifting completely free? <br> Are there any costs?</h3>
            </div>
            <div class="column column-img pb-0">
                <img src="{{asset('/public')}}/assets/images/web/earn-interest.png" class="img-fluid" style="max-width: 430px">
            </div>
        </section>
    <?php } else if (Route::current()->getName() == 'CookiesSettings') { ?>
        <section class="container banner">
            <div class="column column-content pe-0 pe-sm-3">
                <h1>CryptoGifting</h1>
            </div>
            <div class="column column-img">
                <img src="{{asset('/public')}}/assets/images/web/Cookie-policy.png" class="img-fluid">
            </div>
        </section>
    <?php } else if (Route::current()->getName() == 'Help') { ?>
        <section class="container banner">
            <div class="column column-content pe-0 pe-sm-3">
                <h1>Hello. How can we help you?</h1>
            </div>
            <div class="column column-img pb-3">
                <img src="{{asset('/public')}}/assets/images/web/help-banner.png" class="img-fluid">
            </div>
        </section>
    <?php } ?>
</header>