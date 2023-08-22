@include('user-dashboard.head')
    <title>My Contacts | Dashboard</title>
    <body>
        <style>
            .smallll-btn{
                font-size: 11px;
                padding: 5px !important;
                margin-top: 0px;
                overflow-wrap: break-word;
            }
        </style>
    <div id="preloader" class="d-none"></div>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content my-beneficiaries">
                <div class="overlay">
                    <div class="main-heading-box flex">
                        <h3>My Contacts</h3>
                        <div class="two-button-box m-0" style="max-width: 450px; justify-content: flex-end;">
                            <a href="{{route('AddContact')}}" class="btn blue-button">Add Single Contact</a>
                            <a href="#" class="btn blue-button" data-bs-toggle="modal" data-bs-target="#upload-contact-popup" data-bs-placement="top" title="Please upload .csv files only">Bulk Contacts</a>
                        </div>
                    </div>
                    <form action="" class="beneficiary-selection-form">
                        <input type="hidden" name="relation" id="relation" value="<?php if (isset($_GET['relation']) && !empty($_GET['relation'])) echo $_GET['relation']; ?>">
                        <div class="filters">
                            
                            <div class="date-field-special me-2" style="margin-left: 10px;">
                               
                            </div>
                            <div class="date-field-special me-2">
                                <input class="form-control" type="text" placeholder='Added Date' data-toggle="datepicker" name="end_date" value="<?php if (isset($_GET['end_date']) && !empty($_GET['end_date'])) echo $_GET['end_date']; ?>" placeholder="Added Date">
                            </div>
                            <div class="filter">
                                <label for="subject" class="sr-only">Relationship</label>
                                <div class="select-box">
                                    <div class="options-container">
                                         <div class="option relation-option">
                                            <input type="radio" class="radio" id="relation-1" name="relation" value="Friend" />
                                            <label for="relation-1" class="text-bold">Friend</label>
                                        </div>
                                        
                                        <div class="option relation-option">
                                            <input type="radio" class="radio" id="relation-2" name="relation" value="Family" />
                                            <label for="relation-2" class="text-bold">Family</label>
                                        </div>
                                    
                                        <div class="option relation-option">
                                            <input type="radio" class="radio" id="relation-3" name="relation" value="Husband" />
                                            <label for="relation-3" class="text-bold">Husband</label>
                                        </div>

                                        <div class="option relation-option">
                                            <input type="radio" class="radio" id="relation-4" name="relation" value="Wife" />
                                            <label for="relation-4" class="text-bold">Wife</label>
                                        </div>

                                        <div class="option relation-option">
                                            <input type="radio" class="radio" id="relation-5" name="relation" value="Father" />
                                            <label for="relation-5" class="text-bold">Father</label>
                                        </div>

                                        <div class="option relation-option">
                                            <input type="radio" class="radio" id="relation-6" name="relation" value="Mother" />
                                            <label for="relation-6" class="text-bold">Mother</label>
                                        </div>

                                        <div class="option relation-option">
                                            <input type="radio" class="radio" id="relation-7" name="relation" value="Son" />
                                            <label for="relation-7" class="text-bold">Son</label>
                                        </div>

                                        <div class="option relation-option">
                                            <input type="radio" class="radio" id="relation-8" name="relation" value="Daughter" />
                                            <label for="relation-8" class="text-bold">Daughter</label>
                                        </div>

                                        <div class="option relation-option">
                                            <input type="radio" class="radio" id="relation-9" name="relation" value="Brother" />
                                            <label for="relation-9" class="text-bold">Brother</label>
                                        </div>

                                        <div class="option relation-option">
                                            <input type="radio" class="radio" id="relation-10" name="relation" value="Sister" />
                                            <label for="relation-10" class="text-bold">Sister</label>
                                        </div>
                                        <div class="option relation-option">
                                            <input type="radio" class="radio" id="relation-11" name="relation" value="Cousin" />
                                            <label for="relation-11" class="text-bold">Cousin</label>
                                        </div>
                                    </div>
                                    <div class="selected">
                                        <?php if (isset($_GET['relation']) && !empty($_GET['relation'])) echo $_GET['relation']; else echo 'Relationship'; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="search-bar">
                                <input class="form-control" name="search" value="<?php if (isset($_GET['search']) && !empty($_GET['search'])) echo $_GET['search'];?>" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn " type="button"><i class="fas fa-search"></i></button>
                            </div>
                            <button type="submit" class="btn submit-button">Search</button>
                            <button type="submit" id="export-button" value="export" name="export" class="btn submit-button">Export</button>
                            <a href="{{route('Contacts')}}" class="btn submit-button">Clear</a>
                        </div>
                        <div class="table-responsive data-table-wrapper mt-2">
                            <?php if(!$contacts->isEmpty()){?>
                            <table class="table">
                                <thead class="heading-box">
                                    <tr>
                                        <th>
                                            <!--<input type="checkbox" name="select_all" id="select-all" value="123" class="">-->
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="select_all" id="select-all" value="123">
                                                <label class="form-check-label" for="select-all">Select All </label>
                                            </div>
                                        </th>
                                        <th>Contact ID</th>
                                        <th>First Name</th>
                                        <th>Surname</th>
                                        <th>Email</th>
                                        {{--<th class="dob">Date of Birth</th>--}}
                                        <th>Relationship</th>
                                        <th class="action-td">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contacts as $key => $value) { ?>
                                        <tr>
                                            <td>
                                                <!--<input type="checkbox" class="contact-list-checks" name="contact_list[]" value="{{$value->contact_id}}">-->
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" class="form-check-input contact-list-checks" name="contact_list[]" value="{{$value->contact_id}}">
                                                    <label class="form-check-label sr-only" for="" ></label>
                                                </div>
                                            </td>
                                            <td>{{$value->contact_id}}</td>
                                            <td>{{$value->name}} </td>
                                            <td>{{$value->surname}}</td>
                                            <td>{{$value->email}}</td>
                                            {{--<td>@if ($value->dob) {{date('d-M-Y', strtotime($value->dob))}} @else - @endif</td>--}}
                                            <td>{{ucfirst($value->relation)}}</td>
                                            <td><a href="{{route('EditContact', [$value->contact_id])}}" class="btn edit-button">Edit</a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <nav class="d-flex justify-content-end pagination-box">
                                <?php 
                                    $array_to_send = array();

                                    if (isset($_GET['relation']) && !empty($_GET['relation'])) {
                                        $array_to_send['relation'] = $_GET['relation'];

                                    }
                                ?>
                                {{$contacts->appends($array_to_send)->links("pagination::bootstrap-4")}}
                            </nav>
                              <?php }else{
                                ?>
                                <div class="no-beneficiaries">
                                    <h5>You have not created a contacts yet. <br> No problem, just click on <br> Add Contacts</h5>
                                </div>
                            <?php } ?>
                        </div>
                    </form>

                    <!-- Bulk Upload Contact Popup -->
            <div class="modal fade popup-style upload-popup" id="upload-contact-popup" tabindex="-1" aria-labelledby="upload-contact-popupLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mt-0">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form action="{{route('AddContactsUsingCsvOnlyContacts')}}" method="post" enctype="multipart/form-data" class="form-style mx-0">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <h2 class="main-heading">Bulk Upload</h2>
                                <p class="my-4 my-md-5">
                                    You are about to upload multiple contacts. By doing so, it indicates that
                                    you have gained permission to use them
                                </p>
                                <label for="" class="form-label sr-only">Location</label>
                                <div style="width: 100%; max-width: 450px;" class="mx-auto text-start">
                                    <div class="input-group mb-1 file-input" style="margin-bottom: 10px !important;">
                                        <input type="file" name="contact_csv" required class="form-control" id="upload-file" placeholder="Your File"  accept=".csv">
                                        <label class="input-group-text" for="upload-file">
                                            <img src="{{asset('public/')}}/assets/images/dashboard/icon-upload.png" class="img-fluid">
                                        </label>
                                    </div>
                                    <p class="my-4 text-start">
                                        <a href="{{asset('/public/')}}/assets/files/demo-file.csv" class="btn blue-button smallll-btn mt-0" style="width: auto; text-transform: unset !important;">
                                            Demo.csv file
                                        </a>
                                        <small><i class="uil uil-info-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Please upload .csv and excel files only"></i></small>
                                    </p>
                                </div>

                                <div class="two-button-box mx-auto mt-0" style="width: 100%; max-width: 450px;">
                                    <a href="#" data-bs-dismiss="modal" class="btn common-button close-btn">Cancel</a>
                                    <button class="blue-button btn close mt-0" type="submit">Upload</button>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="upload-existing-contact">
                                    <label class="form-check-label" for="upload-existing-contact">
                                        Update Existing Contacts
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
            </div>
            
        </section>
        
        
        <script>
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
              return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            jQuery(document).ready(function() {

               
               $('[data-toggle="datepicker"]').datepicker({
                   autoHide:true,
                   format:'yyyy-mm-dd',
                   inline:true,
               });

                $('#select-all').change(function () {
                    $('.contact-list-checks').prop('checked',this.checked);
                });

                $('.contact-list-checks').change(function () {
                    if ($('.contact-list-checks:checked').length == $('.contact-list-checks').length){
                        $('#select-all').prop('checked',true);
                    }
                    else {
                        $('#select-all').prop('checked',false);
                    }
                });
            });
        </script>
    </main>
@include('user-dashboard.footer')