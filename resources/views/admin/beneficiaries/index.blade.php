@include('admin.head')
    <title>All Beneficiaries | Dashboard</title>
    <body>
        @include('admin.header-sidebar')
            <!-- Main Content Starts -->
            <div class="main-content">
                <div class="overlay">

                    <form action="{{route('AllBeneficiarysAdmin')}}" method="get">
                    <input type="hidden" name="status" id="gender" value="<?php if (isset($_GET['status'])) echo $_GET['status']; ?>">
                        <div class="main-heading-box flex">
                            <h3>Beneficiaries</h3>

                            <div class="filters mt-0">

                            <div class="filter">
                                    <label for="subject" class="sr-only">Status</label>
                                    <div class="select-box">
                                        <div class="options-container">
                                            <div class="option gender-option">
                                                <input type="radio" class="radio" id="all-users-1"
                                                    />
                                                <label for="all-users-1" class="text-bold">Empty</label>
                                            </div>
                                            <div class="option gender-option">
                                                <input type="radio" class="radio" id="all-users-2"
                                                    />
                                                <label for="all-users-2" class="text-bold">Filled</label>
                                            </div>
                                        </div>

                                        <div class="selected">
                                        <?php if (isset($_GET['status']) && !empty($_GET['status'])) { echo ucfirst($_GET['status']); } else { echo 'Search Reference'; } ?>
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
                                        <th>Beneficiary ID</th>
                                        <th>VALR Sub-Account ID</th>
                                        <th>User Name</th>
                                        <th class="email">Email</th>
                                        <th class="email">Relationship</th>
                                        <th class="dob">Date Joined</th>
                                        <th class="dob">Reference ID</th>
                                        <th class="action-td">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($beneficiaries as $key => $value) { ?>
                                        <tr>
                                            <td> {{$value->beneficiary_id}}</td>
                                            <td> {{$value->valr_account_name}}</td>
                                            <td>{{get_user_name($value->beneficiary_id)}}</td>
                                            <td>{{$value->email}}</td>
                                            <td>@if ($value->relation) {{$value->relation}} @else <span class="green">Self</span> @endif</td>
                                            <td>{{$value->created_at->format('d-M-Y H:i:s')}}</td>
                                            <td>@if ($value->reference_id) {{$value->reference_id}} @else <span class="red">Empty</span> @endif </td>
                                            <td><a href="{{route('BeneficiaryInfoAdmin', [$value->beneficiary_id])}}" class="btn edit-button">View Profile</a>
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
                                {{$beneficiaries->appends($array_to_send)->links("pagination::bootstrap-4")}}
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