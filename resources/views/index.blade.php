@include('head')
    <title>Home | Crypto Gifting</title>
    <body>
        @include('home-header')
        <main>
            <!-- <section class="gift-get-tabs how-it-works">
                <div class="container">
                    <h1 class="main-heading mb-4">How it Works</h1>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="event-flow-tab" data-bs-toggle="pill"
                                data-bs-target="#event-flow" type="button" role="tab" aria-controls="event-flow"
                                aria-selected="true">Gift Crypto</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="gifter-flow-tab" data-bs-toggle="pill"
                                data-bs-target="#gifter-flow" type="button" role="tab" aria-controls="gifter-flow"
                                aria-selected="false">Get Crypto</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="event-flow" role="tabpanel"
                            aria-labelledby="event-flow-tab">
                            <div class="columns-wrapper">
                                <div class="column">
                                    <div class="tag">
                                        <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                        <h2>1</h2>
                                    </div>
                                    <div class="img-wrapper">
                                        <img src="{{asset('/public')}}/assets/images/web/icon-envelop.png" class="img-fluid">
                                    </div>
                                    <h6>Enter Recipient Email</h6>
                                </div>
                                <div class="column">
                                    <div class="tag">
                                        <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                        <h2>2</h2>
                                    </div>
                                    <div class="img-wrapper">
                                        <img src="{{asset('/public')}}/assets/images/web/icon-budget.png" class="img-fluid">
                                    </div>
                                    <h6>Select Budget</h6>
                                </div>
                                <div class="column">
                                    <div class="tag">
                                        <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                        <h2>3</h2>
                                    </div>
                                    <div class="img-wrapper">
                                        <img src="{{asset('/public')}}/assets/images/web/icon-card.png" class="img-fluid">
                                    </div>
                                    <h6>Select Card</h6>
                                </div>
                                <div class="column">
                                    <div class="tag">
                                        <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                        <h2>4</h2>
                                    </div>
                                    <div class="img-wrapper">
                                        <img src="{{asset('/public')}}/assets/images/web/icon-enter-details.png" class="img-fluid">
                                    </div>
                                    <h6>Enter Details</h6>
                                </div>
                                <div class="column">
                                    <div class="tag">
                                        <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                        <h2>5</h2>
                                    </div>
                                    <div class="img-wrapper">
                                        <img src="{{asset('/public')}}/assets/images/web/icon-preview-details.png" class="img-fluid">
                                    </div>
                                    <h6>Preview Details</h6>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="gifter-flow" role="tabpanel" aria-labelledby="gifter-flow-tab">
                            <div class="columns-wrapper">
                                <div class="column">
                                    <div class="tag">
                                        <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                        <h2>1</h2>
                                    </div>
                                    <div class="img-wrapper">
                                        <img src="{{asset('/public')}}/assets/images/web/icon-envelop.png" class="img-fluid">
                                    </div>
                                    <h6>Enter Recipient Email</h6>
                                </div>
                                <div class="column">
                                    <div class="tag">
                                        <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                        <h2>2</h2>
                                    </div>
                                    <div class="img-wrapper">
                                        <img src="{{asset('/public')}}/assets/images/web/icon-method.png" class="img-fluid">
                                    </div>
                                    <h6>Select Method</h6>
                                </div>
                                <div class="column">
                                    <div class="tag">
                                        <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                        <h2>3</h2>
                                    </div>
                                    <div class="img-wrapper">
                                        <img src="{{asset('/public')}}/assets/images/web/icon-link.png" class="img-fluid">
                                    </div>
                                    <h6>Copy Link</h6>
                                </div>
                                <div class="column">
                                    <div class="tag">
                                        <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                        <h2>4</h2>
                                    </div>
                                    <div class="img-wrapper">
                                        <img src="{{asset('/public')}}/assets/images/web/icon-friends.png" class="img-fluid">
                                    </div>
                                    <h6>Share With Friends</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->

            <!-- <section class="how-it-works">
                <div class="container">
                    <h1 class="main-heading">How it Works</h1>
                    <div class="columns-wrapper">
                        <div class="column">
                            <div class="tag">
                                <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                <h2>1</h2>
                            </div>
                            <div class="img-wrapper">
                                <img src="{{asset('/public')}}/assets/images/web/how-it-works-1.png" class="img-fluid">
                            </div>
                            <h6>Create an Event</h6>
                        </div>
                        <div class="column">
                            <div class="tag">
                                <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                <h2>2</h2>
                            </div>
                            <div class="img-wrapper">
                                <img src="{{asset('/public')}}/assets/images/web/how-it-works-2.png" class="img-fluid">
                            </div>
                            <h6>Choose a Theme Card</h6>
                        </div>
                        <div class="column">
                            <div class="tag">
                                <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                <h2>3</h2>
                            </div>
                            <div class="img-wrapper">
                                <img src="{{asset('/public')}}/assets/images/web/how-it-works-3.png" class="img-fluid">
                            </div>
                            <h6>Decide on your Gift</h6>
                        </div>
                        <div class="column">
                            <div class="tag">
                                <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                <h2>4</h2>
                            </div>
                            <div class="img-wrapper">
                                <img src="{{asset('/public')}}/assets/images/web/how-it-works-4.png" class="img-fluid">
                            </div>
                            <h6>Share with Friends</h6>
                        </div>
                    </div>
                </div>
            </section> -->
            <section class="gift-get-tabs how-it-works">
                <div class="container">
                    <!-- <h1 class="main-heading mb-4">How it Works</h1> -->
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="event-flow-tab" data-bs-toggle="pill"
                                data-bs-target="#event-flow" type="button" role="tab" aria-controls="event-flow"
                                aria-selected="true">Gift Crypto steps</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="gifter-flow-tab" data-bs-toggle="pill"
                                data-bs-target="#gifter-flow" type="button" role="tab" aria-controls="gifter-flow"
                                aria-selected="false">Get Crypto steps</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="event-flow" role="tabpanel"
                            aria-labelledby="event-flow-tab">
                            <div class="columns-wrapper">
                                <div class="column">
                                    <div class="tag">
                                        <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                        <h2>1</h2>
                                    </div>
                                    <div class="img-wrapper">
                                        <img src="{{asset('/public')}}/assets/images/web/icon-envelop.png" class="img-fluid">
                                    </div>
                                    <h6>Enter Recipient Email</h6>
                                </div>
                                <div class="column">
                                    <div class="tag">
                                        <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                        <h2>2</h2>
                                    </div>
                                    <div class="img-wrapper">
                                        <img src="{{asset('/public')}}/assets/images/web/icon-budget.png" class="img-fluid">
                                    </div>
                                    <h6>Select Gift Value</h6>
                                </div>
                                <div class="column">
                                    <div class="tag">
                                        <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                        <h2>3</h2>
                                    </div>
                                    <div class="img-wrapper">
                                        <img src="{{asset('/public')}}/assets/images/web/icon-card.png" class="img-fluid">
                                    </div>
                                    <h6>Select Theme Card</h6>
                                </div>
                                <div class="column">
                                    <div class="tag">
                                        <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                        <h2>4</h2>
                                    </div>
                                    <div class="img-wrapper">
                                        <img src="{{asset('/public')}}/assets/images/web/icon-enter-details.png" class="img-fluid">
                                    </div>
                                    <h6>Enter Recipient Details</h6>
                                </div>
                                <!--<div class="column">-->
                                <!--    <div class="tag">-->
                                <!--        <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">-->
                                <!--        <h2>5</h2>-->
                                <!--    </div>-->
                                <!--    <div class="img-wrapper">-->
                                <!--        <img src="{{asset('/public')}}/assets/images/web/icon-preview-details.png" class="img-fluid">-->
                                <!--    </div>-->
                                <!--    <h6>Preview Details</h6>-->
                                <!--</div>-->
                                <div class="column">
                                    <div class="tag">
                                        <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                        <h2>5</h2>
                                    </div>
                                    <div class="img-wrapper">
                                        <img src="{{asset('/public')}}/assets/images/web/icon-fund-gift.png" class="img-fluid">
                                    </div>
                                    <h6>Fund Gift</h6>
                                </div>
                                <!--<div class="column">-->
                                <!--    <div class="tag">-->
                                <!--        <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">-->
                                <!--        <h2>6</h2>-->
                                <!--    </div>-->
                                <!--    <div class="img-wrapper">-->
                                <!--        <img src="{{asset('/public')}}/assets/images/web/icon-thankyou.png" class="img-fluid">-->
                                <!--    </div>-->
                                <!--    <h6>Thank you</h6>-->
                                <!--</div>-->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="gifter-flow" role="tabpanel" aria-labelledby="gifter-flow-tab">

                            <ul class="nav nav-pills mb-3" id="pills-inner-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="payment-link-tab" data-bs-toggle="pill"
                                        data-bs-target="#payment-link" type="button" role="tab" aria-controls="payment-link"
                                        aria-selected="true">Public Link</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="create-event-tab" data-bs-toggle="pill"
                                        data-bs-target="#create-event" type="button" role="tab" aria-controls="create-event"
                                        aria-selected="false">Create Event</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="payment-link" role="tabpanel"
                                    aria-labelledby="payment-link-tab">
                                    <div class="columns-wrapper">
                                        <div class="column">
                                            <div class="tag">
                                                <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                                <h2>1</h2>
                                            </div>
                                            <div class="img-wrapper">
                                                <img src="{{asset('/public')}}/assets/images/web/icon-envelop.png" class="img-fluid">
                                            </div>
                                            <h6>Enter Recipient Email</h6>
                                        </div>
                                        <div class="column">
                                            <div class="tag">
                                                <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                                <h2>2</h2>
                                            </div>
                                            <div class="img-wrapper">
                                                <img src="{{asset('/public')}}/assets/images/web/icon-method.png" class="img-fluid">
                                            </div>
                                            <h6>Copy Public Link</h6>
                                        </div>
                                        <!--<div class="column">-->
                                        <!--    <div class="tag">-->
                                        <!--        <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">-->
                                        <!--        <h2>3</h2>-->
                                        <!--    </div>-->
                                        <!--    <div class="img-wrapper">-->
                                        <!--        <img src="{{asset('/public')}}/assets/images/web/icon-link.png" class="img-fluid">-->
                                        <!--    </div>-->
                                        <!--    <h6>Copy the Link</h6>-->
                                        <!--</div>-->
                                        <div class="column">
                                            <div class="tag">
                                                <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                                <h2>3</h2>
                                            </div>
                                            <div class="img-wrapper">
                                                <img src="{{asset('/public')}}/assets/images/web/icon-friends.png" class="img-fluid">
                                            </div>
                                            <h6>Share With Friends & Family</h6>
                                        </div>
                                        <div class="column">
                                            <div class="tag">
                                                <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                                <h2>4</h2>
                                            </div>
                                            <div class="img-wrapper">
                                                <img src="{{asset('/public')}}/assets/images/web/icon-fund-gift.png" class="img-fluid">
                                            </div>
                                            <h6>Friends Fund the Gift</h6>
                                        </div>
                                        <!--<div class="column">-->
                                        <!--    <div class="tag">-->
                                        <!--        <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">-->
                                        <!--        <h2>6</h2>-->
                                        <!--    </div>-->
                                        <!--    <div class="img-wrapper">-->
                                        <!--        <img src="{{asset('/public')}}/assets/images/web/icon-thankyou.png" class="img-fluid">-->
                                        <!--    </div>-->
                                        <!--    <h6>Thank you</h6>-->
                                        <!--</div>-->
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="create-event" role="tabpanel"
                                    aria-labelledby="create-event-tab">
                                    <div class="columns-wrapper">
                                        <div class="column">
                                            <div class="tag">
                                                <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                                <h2>1</h2>
                                            </div>
                                            <div class="img-wrapper">
                                                <img src="{{asset('/public')}}/assets/images/web/icon-envelop.png" class="img-fluid">
                                            </div>
                                            <h6>Enter Recipient Email</h6>
                                        </div>
                                        <div class="column">
                                            <div class="tag">
                                                <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                                <h2>2</h2>
                                            </div>
                                            <div class="img-wrapper">
                                                <img src="{{asset('/public')}}/assets/images/web/icon-beneciciaries.png" class="img-fluid">
                                            </div>
                                            <h6>Choose Beneficiary</h6>
                                        </div>
                                        <div class="column">
                                            <div class="tag">
                                                <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                                <h2>3</h2>
                                            </div>
                                            <div class="img-wrapper">
                                                <img src="{{asset('/public')}}/assets/images/web/icon-create-event.png" class="img-fluid">
                                            </div>
                                            <h6>Choose Create Event</h6>
                                        </div>
                                        <div class="column">
                                            <div class="tag">
                                                <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                                <h2>4</h2>
                                            </div>
                                            <div class="img-wrapper">
                                                <img src="{{asset('/public')}}/assets/images/web/how-it-works-2.png" class="img-fluid">
                                            </div>
                                            <h6>Choose Theme Card</h6>
                                        </div>
                                        <div class="column">
                                            <div class="tag">
                                                <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                                <h2>5</h2>
                                            </div>
                                            <div class="img-wrapper">
                                                <img src="{{asset('/public')}}/assets/images/web/icon-enter-details.png" class="img-fluid">
                                            </div>
                                            <h6>Add Event Info</h6>
                                        </div>
                                        <div class="column">
                                            <div class="tag">
                                                <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                                <h2>6</h2>
                                            </div>
                                            <div class="img-wrapper">
                                                <img src="{{asset('/public')}}/assets/images/web/icon-friends.png" class="img-fluid">
                                            </div>
                                            <h6>Share Event</h6>
                                        </div>
                                        <div class="column">
                                            <div class="tag">
                                                <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                                <h2>7</h2>
                                            </div>
                                            <div class="img-wrapper">
                                                <img src="{{asset('/public')}}/assets/images/web/icon-guest-list.png" class="img-fluid">
                                            </div>
                                            <h6>Select Guest List & Send</h6>
                                        </div>
                                        <div class="column">
                                            <div class="tag">
                                                <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">
                                                <h2>8</h2>
                                            </div>
                                            <div class="img-wrapper">
                                                <img src="{{asset('/public')}}/assets/images/web/icon-fund-gift.png" class="img-fluid">
                                            </div>
                                            <h6>Friends Fund the Gift</h6>
                                        </div>
                                        <!--<div class="column">-->
                                        <!--    <div class="tag">-->
                                        <!--        <img src="{{asset('/public')}}/assets/images/web/tag.png" class="img-fluid">-->
                                        <!--        <h2>8</h2>-->
                                        <!--    </div>-->
                                        <!--    <div class="img-wrapper">-->
                                        <!--        <img src="{{asset('/public')}}/assets/images/web/icon-thankyou.png" class="img-fluid">-->
                                        <!--    </div>-->
                                        <!--    <h6>Thank you</h6>-->
                                        <!--</div>-->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <section class="security">
                <div class="container">
                    <div class="column column-img">
                        <img src="{{asset('/public')}}/assets/images/web/security-art.png" class="img-fluid">
                    </div>
                    <div class="column column-content">
                        <h1 class="main-heading">Security & Custody</h1>
                        <p id="security-para1">
                            CryptoGifting takes security exceptionally seriously. We have therefore partnered with key
                            industry leaders to bring to you nothing less than the most secure solutions. We do not store
                            private key or credit card details on our servers. Instead, we pass this obligation to our
                            partners who will ensure that all sensitive information, as well as cryptocurrencies are held
                            and managed.
                        </p>
                        <p id="security-para2" class="d-none">
                            CryptoGifting takes security exceptionally seriously. We
                            have therefore partnered with key industry leaders to bring
                            to you nothing less than the most secure solutions. We do
                            not store private keys or credit card details on our servers.
                            Instead, we utilise partners which are certified and
                            specialise in security practises to ensure that all sensitive
                            information as well as cryptocurrencies are held and
                            managed securely
                        </p>

                        <div class="partners">
                            <img src="{{asset('/public')}}/assets/images/web/logo-peachpay.png" class="img-fluid">
                            <img src="{{asset('/public')}}/assets/images/web/logo-smileidentity-new.png" class="img-fluid">
                            <img src="{{asset('/public')}}/assets/images/web/logo-valr.png" class="img-fluid">
                            <img src="{{asset('/public')}}/assets/images/web/logo-aws.png" class="img-fluid">
                            <img src="{{asset('/public')}}/assets/images/web/logo-sendgrid.png" class="img-fluid">
                        </div>
                    </div>
                </div>
            </section>

            <!-- <section class="gift-of-wealth">
                <div class="container">

                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="event-flow-tab" data-bs-toggle="pill"
                                data-bs-target="#event-flow" type="button" role="tab" aria-controls="event-flow"
                                aria-selected="true">Event Flow</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="gifter-flow-tab" data-bs-toggle="pill"
                                data-bs-target="#gifter-flow" type="button" role="tab" aria-controls="gifter-flow"
                                aria-selected="false">Gifter Flow</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="event-flow" role="tabpanel"
                            aria-labelledby="event-flow-tab">
                            <div class="custom-row">
                                <div class="column column-img">
                                    <div class="inner-wrapper">
                                        <div class="blue-gradient"></div>
                                        <iframe src="https://www.youtube.com/embed/8NgVGnX4KOw" title="YouTube video player"
                                            frameborder="0" allow="accelerometer; autoplay;" allowfullscreen></iframe>
                                    </div>
                                </div>
                                <div class="column column-content">
                                    <div class="inner-wrapper">
                                        <h1 class="main-heading">The Gift of Wealth in 2mins</h1>
                                        <p>
                                            At CryptoGifting, we embarked on a journey to create the simplest, most secure
                                            and most
                                            convenient wat for anyone to build generational wealth in just a few steps.
                                        </p>
                                        <ul class="mt-4 p-0">
                                            <li>
                                                <span class="step">Step 1 </span> Click on Create Event
                                            </li>
                                            <li>
                                                <span class="step">Step 4 </span> Populate Guest List
                                            </li>
                                            <li>
                                                <span class="step">Step 2 </span> Choose Theme & Customize Invite
                                            </li>
                                            <li>
                                                <span class="step">Step 5 </span> Confirm Event & Share with Friends
                                            </li>
                                            <li>
                                                <span class="step">Step 3 </span> Decide on your Gift
                                            </li>
                                            <li>
                                            <?php if(request()->user) { ?>
                                                <a href="{{route('UserDashboard')}}" class="btn blue-button">Let's Get Started</a>
                                            <?php } else if(request()->admin) { ?>
                                                <a href="{{route('AdminDashboard')}}" class="btn blue-button">Let's Get Started</a>
                                            <?php } else { ?>
                                                <a href="{{route('SignUp')}}" class="btn blue-button">Let's Get Started</a>
                                            <?php } ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="gifter-flow" role="tabpanel" aria-labelledby="gifter-flow-tab">
                            <div class="custom-row">
                                <div class="column column-img">
                                    <div class="inner-wrapper">
                                        <div class="blue-gradient"></div>
                                        <iframe src="https://www.youtube.com/embed/8NgVGnX4KOw" title="YouTube video player"
                                            frameborder="0" allow="accelerometer; autoplay;" allowfullscreen></iframe>
                                    </div>
                                </div>
                                <div class="column column-content">
                                    <div class="inner-wrapper">
                                        <h1 class="main-heading">Send your gift in 2min</h1>
                                        <p>
                                            At CryptoGifting, we embarked on a journey to create the simplest, most secure
                                            and most convenient way for anyone to build generational wealth in just a few
                                            steps.
                                        </p>
                                        <ul class="mt-5 p-0">
                                            <li>
                                                <span class="step">Step 1 </span> Receive an invite
                                            </li>
                                            <li>
                                                <span class="step">Step 4 </span> Confirm your gift!
                                            </li>
                                            <li>
                                                <span class="step">Step 3 </span> Select your preferred payment method from
                                                FT, Card, Snapscan, Zapper
                                            </li>
                                            <li>
                                                <span class="step">Step 2 </span> Choose the and value the you would like to
                                                gift
                                            </li>
                                            <li>
                                                <a href="{{route('SignUp')}}" class="btn blue-button">Let's Get Started</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                </div>
            </section> -->

            <section class="gift-of-wealth video-sec">
                <div class="container">
                    <div class="custom-row">
                        <div class="column column-img">
                            <div class="inner-wrapper">
                                <div class="blue-gradient"></div>
                                <iframe src="https://www.youtube.com/embed/8NgVGnX4KOw" title="YouTube video player"
                                    frameborder="0" allow="accelerometer; autoplay;" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div 
                            class="column special-column-content column-content img-col">
                            <img src="{{asset('/public')}}/assets/images/web/video-art.png" class="img-fluid">
                            
                            <div class="started-button-box">
                                <?php if(request()->user) { ?>
                                    <a href="{{route('UserDashboard')}}" class="btn lets-started">Let's Get Started</a>
                                <?php } else if(request()->admin) { ?>
                                    <a href="{{route('AdminDashboard')}}" class="btn lets-started">Let's Get Started</a>
                                <?php } else { ?>
                                    <a href="{{route('SignUp')}}" class="btn lets-started">Let's Get Started</a>
                                <?php } ?>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </section>

        </main>
        <style>
            .get-gift-flow {
                background: unset !important;
            }
        </style>
@include('footer')