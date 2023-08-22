@include('user-dashboard.head')
    <title>My Beneficiary | Dashboard</title>
    
    <body>
    <div id="preloader" class="d-none"></div>
        @include('user-dashboard.user-dashboard-header')
            <!-- Main Content Starts -->
            <div class="main-content my-beneficiaries">
                <div class="overlay">
                    <div class="main-heading-box flex">
                        <h3>My Beneficiaries</h3>
                        <a href="{{route('AddBeneficiary')}}" class="btn blue-button">Add New Beneficiary</a>
                    </div>

                    <form action="" class="beneficiary-selection-form">
                        <div class="table-responsive data-table-wrapper mt-3">
                        <?php
                         $check = $beneficiaries->toArray();
                        
                         
                        if(count($check['data']) > 1){?>
                            <table class="table">
                                <thead class="heading-box">
                                    <tr>
                                        <th>Beneficiary ID</th>
                                        <th>First Name</th>
                                        <th>Surname</th>
                                        <th>Relationship</th>
                                        <th class="dob">Date of Birth</th>
                                        <th>Email Address</th>
                                        <th class="action-td">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($beneficiaries as $key => $value) { if ($value->beneficiary_id == request()->user->user_id) continue; ?>
                                        <tr>
                                            <td>{{$value->beneficiary_id}}</td>
                                            <td>{{$value->name}}</td>
                                            <td>{{$value->surname}}</td>
                                            <td>{{ucfirst($value->relation)}}</td>
                                            <td>@if ($value->dob) {{date('d-M-Y', strtotime($value->dob))}} @else - @endif</td>
                                            <td>{{$value->email}}</td>
                                            <td><a href="{{route('EditBeneficiary', [$value->beneficiary_id])}}" class="btn edit-button">Edit</a></td>
                                        </tr>
                                    <?php } ?>
                              
                                </tbody>
                                
                            </table>
                            <nav class="d-flex justify-content-end pagination-box">
                                {{$beneficiaries->links("pagination::bootstrap-4")}}
                            </nav>
                        <?php } else{
                                ?>
                                <div class="no-beneficiaries">
                                    <h5>You have not created a beneificary yet. <br> No problem, just click on <br> "Add New Beneficiary </h5>
                                </div>
                            <?php } ?>
                        </div>
                        
                    </form>
                    
                    
                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
@include('user-dashboard.footer')