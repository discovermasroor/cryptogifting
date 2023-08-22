@include('user-dashboard.head')
    <title>Edit Guest List | Dashboard</title>
    <style>
            .smallll-btn{
                font-size: 11px;
                max-width: 100px !important;
                padding: 5px !important;
                margin-top: 0px;
            }
        </style>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content withdraw-page">
                <div class="overlay">
                    <div class="main-heading-box flex">
                        <h1 class="main-heading">Add Contacts To Guest List</h1>
                       {{-- <div class="text-center">
                            <a href="{{asset('/public/')}}/assets/files/demo-file.csv" class="btn blue-button big">
                                <i class="uil uil-import"></i> Demo.csv file

                            </a><br>
                            <small>Demo CSV File For Contacts</small>
                        </div>--}}
                    </div>

                    <!-- <h1 class="main-heading">Add Contacts To Guest List</h1> -->
                    <div class="create-event-page create-guest-list">
                        <div class="action-buttons">
                            <a href="{{route('AddContact')}}" class="btn">
                                <div class="img-box">
                                    <img src="{{asset('public/')}}/assets/images/dashboard/contacts.png" class="img-fluid one-contact-img">
                                </div>
                                Add Single Contact
                            </a>
                            <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#upload-contact-popup">
                                <div class="img-box">
                                    <img src="{{asset('public/')}}/assets/images/dashboard/multiple-contacts.png" class="img-fluid">
                                </div>
                                Add Bulk Contacts
                            </a>
                        </div>

                        <!-- Bulk Upload Contact Popup -->
                        <div class="modal fade popup-style upload-popup" id="upload-contact-popup" tabindex="-1"
                            aria-labelledby="upload-contact-popupLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered mt-0">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form action="{{route('AddContactsUsingCsv')}}" method="post" enctype="multipart/form-data" class="form-style mx-0">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="guest_list" value="{{$guest_list->guest_list_id}}">
                                            <h2 class="main-heading">Bulk Upload</h2>
                                            <p class="my-4 my-md-5">
                                                You are about to upload multiple contacts. By doing so, it indicates that
                                                you have gained permission to use them
                                            </p>

                                            <label for="" class="form-label sr-only">Location</label>
                                            <div style="width: 100%; max-width: 450px;" class="mx-auto text-start">
                                                <div class="input-group mb-3 file-input" style="margin-bottom: 10px !important;">
                                                    <input required type="file" name="contact_csv" class="form-control" id="upload-file" placeholder="Your File"  accept=".csv">
                                                    <label class="input-group-text" for="upload-file">
                                                        <img src="{{asset('public/')}}/assets/images/dashboard/icon-upload.png" class="img-fluid">
                                                    </label>
                                                </div>
                                                <p class="mb-3 text-start mt-0 "><small>upload files i.e. xls, xlsx, .csv</small></p>
                                                <a href="{{asset('/public/')}}/assets/files/demo-file.csv" class="btn blue-button smallll-btn mt-0" data-bs-placement="top" title="Demo csv file">Demo CSV File</a>
                                            </div>

                                            <div class="two-button-box mx-auto mt-0 mt-md-4" style="width: 100%; max-width: 450px;">
                                                <a href="#" data-bs-dismiss="modal" class="btn common-button close-btn">Cancel</a>
                                                <button class="blue-button btn close mt-0" type="submit">Upload</button>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="upload-existing-contact">
                                                <label class="form-check-label" for="upload-existing-contact">
                                                    Upload existing contacts
                                                </label>
                                            </div>

                                            <p>
                                                If any imported contacts are already in your audience, we will automatically
                                                replace them with the data from your import. This option may make the import
                                                process take longer
                                            </p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{route('DeleteContactsInGuestList', [$guest_list->guest_list_id])}}" method="post" class="beneficiary-selection-form mt-4">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="main-heading-box flex">
                            <h3>Added Contacts</h3>
                            <div class="filters">
                                <button type="submit" class="btn submit-button">Delete Contacts</button>
                            </div>
                        </div>
                        <div class="table-responsive data-table-wrapper" style="min-height: 150px;">
                            <table class="table">
                                <thead class="heading-box">
                                    <tr>
                                        <th>Select</th>
                                        <th>Gifter ID</th>
                                        <th>GifterName</th>
                                        <th>Email Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($existing_users as $key => $value) { ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <input class="form-check-input" type="checkbox" name="contacts[]" value="{{$value->contact_guest_list_id}}" id="{{$key}}">
                                                </div>
                                            </td>
                                            <td>{{$value->contact_user->contact_id}}</td>
                                            <td>{{$value->contact_user->name}} {{$value->contact_user->surname}}</td>
                                            <td>{{$value->contact_user->email}}</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </form>

                    
                    <form onSubmit="return confirm('Are you sure you wish to add contacts?');" action="{{route('AddContactsInGuestList', [$guest_list->guest_list_id])}}" method="post" class="beneficiary-selection-form mt-4">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="main-heading-box flex">
                            <h3>My Contacts</h3>
                            <div class="filters">
                                <button type="submit" class="btn submit-button">Add these Contacts</button>
                            </div>
                        </div>
                        <div class="table-responsive data-table-wrapper" style="min-height: 150px;">
                            <table class="table">
                                <thead class="heading-box">
                                    <tr>
                                        <th>Select</th>
                                        <th>Gifter ID</th>
                                        <th>GifterName</th>
                                        <th>Email Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($all_contacts as $key => $value) { ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <input class="form-check-input" type="checkbox" name="contacts[]" value="{{$value->contact_id}}" id="{{$key}}">
                                                </div>
                                            </td>
                                            <td>{{$value->contact_id}}</td>
                                            <td>{{$value->name}} {{$value->surname}}</td>
                                            <td>{{$value->email}}</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div class="col-md-12 text-center">
                                <div class="two-button-box mx-auto">
                                    <button type="button" onclick="goBack()" class="btn common-button close-btn">Back</button>
                                  
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
    <script>
         function goBack()
        {
            window.history.back()
        }
    </script>
@include('user-dashboard.footer')