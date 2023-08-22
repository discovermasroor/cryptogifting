<?php
    $valr_branch_code = \App\Models\Setting::where('keys', 'valr_branch_code')->first();
    $valr_account_number = \App\Models\Setting::where('keys', 'valr_account_number')->first();
?>
@include('admin.head')
    <title>Setting | Dashboard</title>
    <body>
        @include('admin.header-sidebar')
            <div class="main-content">
                <div class="overlay">
                    <div class="main-heading-box flex">
                        <h3>VALR Setting</h3>
                    </div>
                    <form action="{{route('valrSettingStore')}}" method="POST" enctype="application/x-www-form-urlencoded" class="notifications-form form-style add-beneficiary-form edit-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                    
                            <div class="col-md-6">
                                <label for="branch-code" class="form-label">VALR Branch Code</label>
                                <input type="text" class="form-control" id="branch-code" placeholder="00000" value="{{$valr_branch_code->values}}" name="branch_code">
                            </div>
                            <div class="col-md-6">
                                <label for="account-number" class="form-label">VALR Account Number</label>
                                <input type="text" class="form-control" id="account-number" placeholder="00000000000" value="{{$valr_account_number->values}}"  name="account_number">
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn blue-button">Update Setting</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <style>
        .notifications-form {
            max-width: 60%; 
        }
    </style>
@include('admin.footer')