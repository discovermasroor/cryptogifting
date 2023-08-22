@include('user-dashboard.head')
    <title>Select Beneficiaries | Dashboard</title>
    <body>
        <div id="preloader" class="d-none"></div>
            @include('user-dashboard.user-dashboard-header')
            <div class="main-content">
                <div class="overlay">
                @include('user-dashboard.events.event-steps')    
                 <div class="main-heading-box flex align-items-start">
                        <h3 class="ps-4 mt-0">Who is this event for?</h3>
                        <a href="{{route('AddBeneficiary')}}" class="btn blue-button">Add New Beneficiary</a>
                    </div>
                    
                    <form action="{{route('AddBeneficiariesForEventNew')}}" method="post" class="beneficiary-selection-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" id="user" name="user" value="1" >
                        <input type="hidden" id="user" name="user" value="{{$req_guestlist}}" >
                        <div class="table-responsive data-table-wrapper mt-4">
                            <table class="table">
                                <thead class="heading-box">
                                    <tr>
                                        <th>Select</th>
                                        <th>Name</th>
                                        <th>Surname</th>
                                        <th>Relationship</th>
                                        <th>Date of Birth </th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($beneficiaries as $key => $value) { ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <input class="form-check-input select-benef" <?php if ($value->beneficiary_id == request()->user->user_id) echo 'checked'; ?> data-type="benef" type="radio" id="{{$key}}" name="users" value="{{$value->beneficiary_id}}">
                                                </div>
                                            </td>
                                            @if ($value->beneficiary_id == request()->user->user_id)
                                                <td><span class="green">Yourself</span></td> <td>-</td>
                                            @else 
                                                <td>{{$value->name}}</td> <td>{{$value->surname}}</td>
                                            @endif
                                            <td>@if ($value->relation) {{ucfirst($value->relation)}} @else - @endif</td>
                                            <td>@if ($value->dob) {{date('d-M-Y', strtotime($value->dob))}} @else - @endif</td>
                                            <td>{{$value->email}}</td>
                                            
                                        </tr>
                                    <?php } ?>
                                  
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center my-4 pt-2">
                             <div class="two-button-box mx-auto" style="width: 100%; max-width: 450px;">
                                <button type="button" onclick="goBack()" class="btn common-button">Back</button> 
                                @if($check_contact == '1')
                                <a href="{{route('Contacts')}}" class="btn blue-button">Next</a>
                                @elseif( $req_guestlist == '0')
                                <a href="{{route('AddGuestList')}}" class="btn blue-button">Next</a>
                                @else
                                <button type="submit" class="btn blue-button">Next</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

     @if ( $check_contact == '1') 
        <div id="add-guest" class="alert alert-danger custom-alert-button d-flex align-items-center flex-column" role="alert">
            <div class="content-box">
                <p style="color: var(--blue);">Please, Add the contact or guest list.</p>
                <div class="buttons">
                    <a href="{{route('Contacts')}}?model=add-guest" class="btn action-button blue">Now</a>
                    <a href="#" id="close-guestlist" class="btn action-button">Later</a>
                </div>
            </div>
        </div>
    @elseif($req_guestlist == '0')
        <div id="add-guest" class="alert alert-danger custom-alert-button d-flex align-items-center flex-column" role="alert">
            <div class="content-box">
                <p style="color: var(--blue);">Please, Add the contact or guest list.</p>
                <div class="buttons">
                    <a href="{{route('AddGuestList')}}?model=add-guest" class="btn action-button blue">Now</a>
                    <a href="#" id="close-guestlist" class="btn action-button">Later</a>
                </div>
            </div>
        </div>
    @endif
    <script type="text/javascript">
        function goBack()
        {
            window.history.back()
        }
        jQuery(document).ready(function ($) {
            $('#close-guestlist').on('click', function (e) {
                e.preventDefault();
                $('#add-guest').remove();
            })
        });
    </script>
@include('user-dashboard.footer')