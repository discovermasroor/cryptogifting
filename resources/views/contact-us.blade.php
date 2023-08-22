@include('head')
    <title>Contact Us | Crypto Gifting</title>
    <body>
        @include('home-header')
        <main class="contact-page">
            <section class="contact-us">
                <div class="container">
                    <h1 class="second-heading">Contact us</h1>

                    <div class="form-wrapper">
                        <form action="{{route('StoreContactUs')}}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="topic" id="topic-field" value="">
                            
                            <div class="row mb-0">
                                <div class="col-sm-6">
                                    <div>
                                        <label for="email" class="sr-only">Email Address</label>
                                        <input type="email" class="form-control" placeholder="Email Address" id="email" name="email" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label for="subject" class="sr-only">Topics</label>
                                        <div class="select-box">
                                            <div class="options-container">
                                                <?php foreach ($topics as $key => $value) { ?>
                                                    <div class="option">
                                                        <input type="radio" class="radio" id="event-org{{$key}}" value="{{$value}}" />
                                                        <label for="event-org" class="text-bold">{{$value}}</label>
                                                    </div>
                                                <?php } ?>
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
                                        <input type="text" class="form-control" placeholder="Subject" id="subject" name="subject" required>
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
                                    placeholder="Message" required></textarea>
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
