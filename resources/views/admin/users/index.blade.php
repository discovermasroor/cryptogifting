@include('admin.head')
    <title>All Users | Dashboard</title>
    <body>
        @include('admin.header-sidebar')
            <!-- Main Content Starts -->
            <div class="main-content">
                <div class="overlay">

                    <form action="{{route('AllUsersAdmin')}}" method="get">
                        <input type="hidden" name="status" id="topic-field" value="<?php if (isset($_GET['status'])) echo $_GET['status']; ?>">
                        
                        <div class="main-heading-box flex">
                            <h3>Users</h3>

                            <div class="filters mt-0">

                                <div class="filter">
                                    <label for="subject" class="sr-only">Status</label>
                                    <div class="select-box">
                                        <div class="options-container">
                                            <div class="option">
                                                <input type="radio" class="radio" id="status-1"/>
                                                <label for="status-1" class="text-bold">Active</label>
                                            </div>
                                            <div class="option">
                                                <input type="radio" class="radio" id="status-2"/>
                                                <label for="status-2" class="text-bold">Pending</label>
                                            </div>
                                        </div>

                                        <div class="selected">
                                            <?php if (isset($_GET['status']) && !empty($_GET['status'])) echo $_GET['status']; else echo 'Status'; ?>
                                        </div>

                                    </div>
                                </div>

                                <div class="search-bar">
                                    <input class="form-control" name="search" value="<?php if (isset($_GET['search'])) echo $_GET['search']; ?>" type="search" placeholder="Search" aria-label="Search">
                                    <button class="btn " type="button"><i class="fas fa-search"></i></button>
                                </div>

                                <button type="submit" class="btn submit-button">Submit</button>
                                <a href="{{route('AllUsersAdmin')}}" class="btn submit-button">Clear</a>

                            </div>
                        </div>

                        <div class="table-responsive data-table-wrapper mt-3 users-table">
                            <table class="table">
                                <thead class="heading-box">
                                    <tr>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>User Surname</th>
                                        <th class="dob">Date Joined</th>
                                        <th class="email">User Email Address</th>
                                        <th>Status</th>
                                        <th class="action-td">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $key => $value) { ?>
                                        <tr>
                                            <td>{{$value->user_id}}</td>
                                            <td>{{get_user_name($value->user_id)}}</td>
                                            <td>{{$value->last_name}}</td>
                                            <td>{{$value->created_at->format('d-M-Y')}}</td>
                                            <td>{{$value->email}}</td>
                                           
                                            <?php if ($value->active) { ?>
                                                <td class="active">Active</td>

                                            <?php } else { ?>
                                                <td class="pending">Pending</td>

                                            <?php } ?>
                                            <td>
                                                <a href="{{route('UserInfoAdmin', [$value->user_id])}}" class="btn edit-button">View Profile</a>
                                                <?php if( $value->loginSecurity != NULL && $value->loginSecurity) { 
                                                        if($value->loginSecurity->google2fa_enable == '1') { ?>
                                                            <a href="{{route('disable2fa', [$value->user_id])}}" class="btn edit-button">2FA Disable</a>
                                                    <?php } ?>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <nav class="d-flex justify-content-end pagination-box">
                                <?php 
                                    $array_to_send = array();

                                    if (isset($_GET['status']) && !empty($_GET['status'])) {
                                        $array_to_send['status'] = $_GET['status'];

                                    }

                                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                                        $array_to_send['search'] = $_GET['search'];

                                    }
                                ?>
                                {{$users->appends($array_to_send)->links("pagination::bootstrap-4")}}
                            </nav>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Main Content Ends -->
        </section>
        <!-- Dashboard Main Content Ends -->
    </main>
@include('admin.footer')