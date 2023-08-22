@include('head')
    <title>Get Crypto | Crypto Gifting</title>
    <body>
        @include('home-header')
        <section class="get-gift-flow">
        <div class="container home-banner">
            <div>
                <h2>You are about to Gift Crypto and change someone's life</h2>

                <div class="yellow-gift-box">
                    <img src="{{asset('/public')}}/assets/images/flow/gift-box.png" class="img-fluid">
                    <form action="{{route('getCryptoEmail')}}" method = "post">
                        @csrf
                        <div>
                            <label for="" class="form-label sr-only">Message</label>
                            <textarea name="message" id="" class="form-control"
                                placeholder="Joe,&#10; Welcome To Bitcoin!&#10; Ann"></textarea>
                            <small>25 words only</small>
                        </div>
                        <div>
                            <label for="" class="form-label sr-only">Name</label>
                            <input type="text" name = "name" class="form-control" placeholder="Your recipient name">

                        </div>
                        <div>
                            <label for="" class="form-label sr-only">Email</label>
                            <input type="text" name = "email" class="form-control" placeholder="Your recipient Email">
                        </div>
                        <button type = "sumbit" class="btn">Next</button>
                    </form>

                </div>


            </div>

        </div>
    </section>
@include('footer')