@include('head')
    <title>Give Us Feedback | Crypto Gifting</title>
    <body>
        @include('home-header')
        <main class="contact-page">
            <section class="contact-us">
                <div class="container">
                    <h1 class="second-heading">Give Us Feedback</h1>

                    <div class="form-wrapper">
                        <form action="{{route('StoreFeedback')}}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="topic" id="topic-field" value="">
                            
                            <div class="row mb-0">
                                <div class="col-sm-6">
                                    <div>
                                        <label for="email" class="sr-only">Email Address</label>
                                        <input type="email" class="form-control" placeholder="Email Address" id="email"
                                            name="email">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label for="subject" class="sr-only">Topics</label>
                                        <div class="select-box">
                                            <div class="options-container">
                                                <div class="option">
                                                    <input type="radio" class="radio" id="event-org100" value="I have a cool idea" />
                                                    <label for="event-org" class="text-bold">I have a cool idea</label>
                                                </div>
                                                <div class="option">
                                                    <input type="radio" class="radio" id="event-org200" value="I found a bug or a problem with the site" />
                                                    <label for="event-org" class="text-bold">I found a bug or a problem with the site</label>
                                                </div>
                                                <div class="option">
                                                    <input type="radio" class="radio" id="event-org300" value="I have a question for you" />
                                                    <label for="event-org" class="text-bold">I have a question for you</label>
                                                </div>
                                                <div class="option">
                                                    <input type="radio" class="radio" id="event-org400" value="I would like to praise you" />
                                                    <label for="event-org" class="text-bold">I would like to praise you</label>
                                                </div>
                                                <div class="option">
                                                    <input type="radio" class="radio" id="event-org500" value="I have a complain" />
                                                    <label for="event-org" class="text-bold">I have a complaint</label>
                                                </div>
                                            </div>
                                            <div class="selected">
                                                Topic
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label for="subject" class="sr-only">Subject</label>
                                        <input type="text" class="form-control" placeholder="Subject" id="subject" name="subject">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label for="" class="form-label sr-only">Location</label>
                                        <div class="input-group file-input">
                                            <input name="attachement" type="file" class="form-control" id="upload-file" placeholder="Your File">
                                            <label class="input-group-text" for="upload-file">
                                                <img src="{{asset('/public')}}/assets/images/dashboard/icon-upload.png" class="img-fluid">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            <div>
                                <label for="description" class="sr-only">Message</label>
                                <textarea name="description" id="description" class="form-control"
                                    placeholder="Message"></textarea>
                            </div>
                            
                            <div class="buttons-wrapper">
                                <button type="submit" class="btn orange-button">Submit</button>
                                <!-- <button type="button" class="btn blue-button">Send me a copy of this email</button> -->
                            </div>
                            <div class="form-check p-0">
                                <input type="checkbox" name="send_me_too" class="form-check-input m-0" id="email-copy">
                                <label class="form-check-label" for="email-copy">Send Me a Copy of This Email</label>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

        </main>
@include('footer')