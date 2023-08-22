@include('user-dashboard.head')
    <title>User Add Beneficiary | Dashboard</title>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('user-dashboard.user-dashboard-header')
            <!-- Main Content Starts -->
            <div class="main-content withdraw-page">
                <div class="overlay">
                    <h1 class="main-heading">Add Beneficiary</h1>
                    <form name="form1" action="{{route('StoreBeneficiary')}}" method="POST" enctype="application/x-www-form-urlencoded" class="form-style add-beneficiary-form edit-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="relation" id="relation" value="">
                        <div class="row">

                            <div class="col-md-6">
                                <label for="name" class="form-label">Name *</label>
                                <input type="text" class="form-control" id="name" placeholder="Name *" name="name" required>
                            </div>

                            <div class="col-md-6">
                                <label for="surname" class="form-label">Surname *</label>
                                <input type="text" class="form-control" id="surname" placeholder="Surname *" name="surname" required>
                            </div>

                            <div class="col-md-6">
                                <label for="emailAddress" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="emailAddress" placeholder="Email Address *" name="email" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <div class="input-group input-calander">
                                    <input type="text"  data-toggle="datepicker" placeholder="Date of birth" class="form-control input-date" id="event_date" name="dob">
                                    <button class="btn" type="button">
                                        <img src="{{asset('/public')}}/assets/images/dashboard/icon-calendar.png" class="img-fluid">
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="" class="form-label">Relationship *</label>
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
                                         <div class="option relation-option">
                                            <input type="radio" class="radio" id="relation-1" name="relation" value="Friend" checked/>
                                            <label for="relation-1" class="text-bold">Friend</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 text-center">
                                <div class="two-button-box mx-auto" style="width: 100%; max-width: 450px;">
                                    <a href="{{url()->previous()}}" class="btn common-button">Back</a>
                                    <button class="blue-button btn close mt-0" type="submit">Add Beneficiary</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <p class="compulsory">* Compulsory Fields</p>
                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
    <script>
       
        $(document).ready(function() { 
           
            jQuery('#event_date').keypress(
               function(event){
                   event.preventDefault();
               });
               var minDate = new Date('1900-01-01'); 
                var endDate = new Date();
               
               $('[data-toggle="datepicker"]').datepicker({
                   autoHide:true,
                   format:'yyyy-mm-dd',
                   inline:true,
                   minDate:minDate,
                   startDate:minDate,
                    endDate:endDate,

               });
    
           });

    
    </script>
@include('user-dashboard.footer')