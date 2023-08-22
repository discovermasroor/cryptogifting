@include('admin.head')
    <title>Contact Form Info | Dashboard</title>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('admin.header-sidebar')
            <!-- Main Content Starts -->
            <div class="main-content withdraw-page">
                <div class="overlay">
                    <h1 class="main-heading"><?php if ($contact_us->contact_us) echo 'Contact From Info'; else if ($contact_us->loyalty_program) echo 'Loyalty program From Info'; else if ($contact_us->feedback) echo 'Feedback From Info'; else echo 'Affiliate Form Info'; ?></h1>
                    <form action="{{route('ContactUsInfoUpdateAdmin', [$contact_us->contact_us_id])}}" method="POST" class="form-style add-beneficiary-form edit-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="status" id="gender" value="<?php if ($contact_us->read) echo 'Read'; else echo 'not_read';?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Email</label>
                                <input type="text" class="form-control" disabled value="<?php echo $contact_us->email; ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Topic</label>
                                <input type="text" class="form-control" disabled value="<?php echo $contact_us->topic; ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Subject</label>
                                <input type="text" class="form-control" disabled value="<?php echo $contact_us->subject; ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Description</label>
                                <textarea class="form-control" disabled><?php echo $contact_us->description; ?></textarea>
                            </div>
                            <?php if ($contact_us->file) { ?>
                                <div class="col-md-6">
                                    <label for="name" class="form-label">File</label>
                                    <p><a class="orange" target="_blank" href="{{$contact_us->file_url}}">Click Here!</a></p>
                                </div>
                            <?php } ?>
                            <div class="col-md-6">
                                <label for="">Status</label>
                                <div class="select-box">
                                    <div class="options-container">
                                        <div class="option gender-option">
                                            <input type="radio" class="radio" id="gender-1" name="status" value="active"/>
                                            <label for="gender-1" class="text-bold">Read</label>
                                        </div>
                                        <div class="option gender-option">
                                            <input type="radio" class="radio" id="gender-2" name="status" value="not-active"/>
                                            <label for="gender-2" class="text-bold">Not Read Yet!</label>
                                        </div>
                                    </div>

                                    <div class="selected">
                                        <?php if ($contact_us->read) echo 'Read'; else echo 'Not Read Yet!'; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn blue-button">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
@include('admin.footer')