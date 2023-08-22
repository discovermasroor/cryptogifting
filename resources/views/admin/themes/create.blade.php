@include('admin.head')
    <title>Add Theme | Dashboard</title>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('admin.header-sidebar')
            <!-- Main Content Starts -->
            <div class="main-content withdraw-page">
                <div class="overlay">
                    <h1 class="main-heading">Add Theme</h1>
                    <form action="{{route('StoreTheme')}}" enctype="multipart/form-data" method="POST" class="form-style add-beneficiary-form edit-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="card_for" id="gender" value="">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Title *</label>
                                <input type="text" class="form-control" id="title" placeholder="Title *" name="title">
                            </div>
                            <div class="col-md-6">
                                <label for="color_code" class="form-label">Theme Color Code *</label>
                                <input type="color" class="form-control" id="color_code" required placeholder="Color Code*" name="color_code">
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label">Create Event Image</label>
                                <div class="input-group file-input">
                                    <input type="file" class="form-control" id="upload-file" required accept="image/*" name="create_event_image" placeholder="Your File">
                                    <label class="input-group-text" for="upload-file">
                                        <img src="{{asset('/public')}}/assets/images/dashboard/icon-upload.png" class="img-fluid">
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label">Gifter Event Image </label>
                                <div class="input-group file-input">
                                    <input type="file" class="form-control" id="upload-file" required accept="image/*" name="gifter_event_image" placeholder="Your File">
                                    <label class="input-group-text" for="upload-file">
                                        <img src="{{asset('/public')}}/assets/images/dashboard/icon-upload.png" class="img-fluid">
                                    </label>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn blue-button">Add Theme</button>
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