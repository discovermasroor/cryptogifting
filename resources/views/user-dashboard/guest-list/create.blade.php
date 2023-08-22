@include('user-dashboard.head')
    <title>User Add Guest List | Dashboard</title>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('user-dashboard.user-dashboard-header')
            <!-- Main Content Starts -->
            <div class="main-content withdraw-page">
                <div class="overlay">
                    <h1 class="main-heading">Create Guest List</h1>
                    <form action="{{route('StoreGuestList')}}" method="POST" class="form-style add-beneficiary-form edit-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="event" id="event" value="">
                        <input type="hidden" name="beneficiary" id="beneficiar" value="">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Guest List Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Guest List Name *" name="event_description">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="" class="form-label">Beneficiaries <small>(Leave empty for yourself)</small></label>
                                <div class="select-box">
                                    <div class="options-container">
                                        <?php foreach ($all_beneficiaries as $key => $value) { ?>
                                            <div class="option beneficiar-option">
                                                <input type="radio" class="radio" id="{{$key}}" name="beneficiar" value="{{$value->beneficiary_id}}"/>
                                                <label for="{{$key}}" data-user-id="{{$value->beneficiary_id}}" class="text-bold">{{ get_user_name($value->beneficiary_id) }} {{$value->surname}}</label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="selected">Beneficiaries</span>
                                    </div>
                                </div>
                                <!--<p style="margin: 20px 0px 0px;" for="" class=""><small>Leave empty to create your own!</small></p>-->

                            </div>
                            <div class="col-md-12 text-center">
                                <div class="two-button-box">
                                <button type="button" onclick="goBack()" class="btn common-button">Back</button>
                                    <button type="submit" class="btn blue-button mt-0">Create Guest List</button>
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
        function goBack()
        {
            window.history.back()
        }
    </script>
@include('user-dashboard.footer')