@include('admin.head')
    <title>Beneficiary's Info | Dashboard</title>
    <body>
        @include('admin.header-sidebar')
            <div class="main-content">
                <div class="overlay">
                    <div class="main-heading-box">
                        <h3>Beneficiary Profile</h3>
                    </div>
                    <div class="user-profile">
                       
                        <form action="{{route('UpdateBeneficiaryInfoAdmin', [$beneficiary->beneficiary_id])}}" method="post" class="form-style">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="fName" class="">Name</label>
                                    <input type="text" disabled id="fName" value="{{$beneficiary->name}}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="lName" class="">Surname</label>
                                    <input type="text" disabled disabled id="lName"  value="{{$beneficiary->surname}}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="">Email</label>
                                    <input type="email" disabled id="email"  value="{{$beneficiary->email}}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="dob" class="">DOB</label>
                                    <input type="date" disabled id="dob" value="{{$beneficiary->date_of_birth}}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="relation" class="">Relation</label>
                                    <input type="text" disabled id="relation" value="{{ucfirst($beneficiary->relation)}}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="">Valr Reference ID</label>
                                    <input type="text" required name="reference_id" id="email" value="{{$beneficiary->reference_id}}" class="form-control">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn blue-button mt-4">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <style>
        .form-style .row>div {
            margin-bottom: 50px;
        }
    </style>
@include('admin.footer')