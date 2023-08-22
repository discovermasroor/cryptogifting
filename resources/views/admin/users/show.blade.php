@include('admin.head')
    <title>User's Info | Dashboard</title>
    <body>
        @include('admin.header-sidebar')
            <div class="main-content">
                <div class="overlay">
                    <div class="main-heading-box">
                        <h3>User Profile</h3>
                    </div>
                    <div class="user-profile">
                        <div class="card person-detail-card mt-0">
                            <div class="card-body">
                                <div class="card-title-wrapper">
                                    <h1 class="card-title">{{get_user_name($user->user_id)}}</h1>
                                    <span class="status">
                                        <?php if (!$user->email_verified) { ?>
                                            <span class="not-verified"> <i class="uis uis-times-circle"></i>Email verified</span>

                                        <?php } else { ?>
                                            <span class="verified"><i class="uis uis-check-circle"></i>Email verified</span>

                                        <?php } ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <hr class="underline my-5">
                        <form action="" class="form-style">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="fName" class="">First Name</label>
                                    <input type="text" name="fName" id="fName" value="{{$user->first_name}}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="lName" class="">Last Name</label>
                                    <input type="text" name="lName" id="lName"  value="{{$user->last_name}}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="">Email</label>
                                    <input type="email" name="email" id="email"  value="{{$user->email}}" class="form-control">
                                </div>
                                <div class="text-center">
                                    <a href="{{route('AllUsersAdmin')}}" class="btn blue-button mt-4">Back</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@include('admin.footer')