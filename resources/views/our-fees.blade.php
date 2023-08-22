@include('head')
    <title>Our Fees | Crypto Gifting</title>
    <body>
        @include('home-header')
        <main class="textual-page">
            <section>
                <div class="container">
                    <h1 class="second-heading">What does it cost to use CryptoGifting?</h1>

                    <p>
                        * fees exclude vat <br>
                        CryptoGifting strives to be an affordable place to gift, buy, sell, trade, store and use
                        cryptocurrency. We have a transparent fee structure, without hiding any costs from our customers.
                        The following fees and service charges may apply when using our products.
                    </p>

                    <h4 class="sub-heading">As an Event Organiser.</h4>
                    <p>
                        Setting up a profile, creating an event and sharing it with your friends, family and loved ones so
                        that you can receive various cryptocurrencies, will cost you nothing. We only levy withdrawal fees
                        at the time you decide to withdraw your currencies, which means that you can leave your funds to
                        grow in our special interest account for as long as you want, without spending a dime
                    </p>

                    <ul>
                        <li class="mb-0">CryptoGifting Handling Fee: 5%</li>
                        <li>3rd Party Transaction Fees: calculated at the time of checkout and added to the gifted amount</li>
                    </ul>

                    <h4 class="sub-heading">As a Gifter.</h4>

                    <p>
                        When you are gifting cryptocurrencies to your friends, family and loved ones, they will not have to
                        pay any fees for receiving your gift. We will only charge you the admin fee as levied by our
                        financial partners and a deposit fee that keeps our lights on so that we can keep providing you with
                        this awesome service.
                    </p>


                    <ul class="mb-4">
                        <li class="mb-0">CryptoGifting Handling Fee: 5%</li>
                        <li>3rd Party Transaction Fees: calculated at the time of checkout and added to the gifted amount</li>
                    </ul>
                    
                    <p class="mb-5">
                        Do you have any questions? <a href="{{route('ContactUs')}}">Click here</a> to send us an email.
                    </p>

                    <div class="thanks-heading">
                        <h5 class="dark mb-1">Thanks</h5>
                        <h5 class="dark mb-0">Team CryptoGifting</h5>
                    </div>
                </div>
            </section>
        </main>
@include('footer')
