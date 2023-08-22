@include('admin.head')
    <title>Edit Theme | Dashboard</title>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('admin.header-sidebar')
            <!-- Main Content Starts -->
            <div class="main-content withdraw-page">
                <div class="overlay">
                    <h1 class="main-heading">Edit Theme</h1>
                    <form action="{{route('UpdateTheme', [$theme->theme_id])}}" enctype="multipart/form-data" method="POST" class="form-style add-beneficiary-form edit-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="status" id="gender" value="<?php if ($theme->active) echo 'Active'; else echo 'Not Active'; ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" placeholder="Title *" name="title" value="{{$theme->title}}">
                            </div>
                            <div class="col-md-6">
                                <label for="color_code" class="form-label">Color Code</label>
                                <input type="color" class="form-control" id="color_code" required placeholder="Color Code*" value="{{$theme->color_code}}" name="color_code">
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label">Cover Image</label>
                                <div class="input-group file-input">
                                    <input type="file" class="form-control" id="upload-file" accept="image/*" name="cover_image" placeholder="Your File">
                                    <label class="input-group-text" for="upload-file">
                                        <img src="{{asset('/public')}}/assets/images/dashboard/icon-upload.png" class="img-fluid">
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label">Gifter Event Image </label>
                                <div class="input-group file-input">
                                    <input type="file" class="form-control" id="upload-file1"  accept="image/*" name="gifter_event_image" placeholder="Your File">
                                    <label class="input-group-text" for="upload-file1">
                                        <img src="{{asset('/public')}}/assets/images/dashboard/icon-upload.png" class="img-fluid">
                                    </label>
                                </div>
                            </div>
                           
                            <div class="col-md-6">
                                <label for="">Status</label>
                                <div class="select-box">
                                    <div class="options-container">
                                        <div class="option gender-option">
                                            <input type="radio" class="radio" id="gender-1" name="status" value="active"/>
                                            <label for="gender-1" class="text-bold">Active</label>
                                        </div>
                                        <div class="option gender-option">
                                            <input type="radio" class="radio" id="gender-2" name="status" value="not-active"/>
                                            <label for="gender-2" class="text-bold">Not Active</label>
                                        </div>
                                    </div>

                                    <div class="selected">
                                        <?php if ($theme->active) echo 'Active'; else echo 'Not Active'; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn blue-button">Update Theme</button>
                            </div>
                        </div>
                    </form>
                    <p class="compulsory">* Compulsory Fields</p>
                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
    <style>
        .form-style .file-input{
            margin: 0 !important;
        }
    </style>
@include('admin.footer')