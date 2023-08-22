@include('admin.head')
    <title>SmileKYC Authentication Requests | Dashboard</title>
    <body>
        @include('admin.header-sidebar')
            <!-- Main Content Starts -->
            <div class="main-content">
                <div class="overlay">

                    <form action="{{route('AllUsersAdmin')}}" method="get">
                        <input type="hidden" name="status" id="topic-field" value="<?php if (isset($_GET['status'])) echo $_GET['status']; ?>">
                        <div class="main-heading-box flex">
                            <h3>SmileKYC Authentication Requests</h3>

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
                                            <?php if (isset($_GET['status'])) echo $_GET['status']; else echo 'Status'; ?>
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
                                        <th>#</th>
                                        <th>User Name</th>
                                        <th>Address Document</th>
                                        <th>Bank Account Document</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Availed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($records as $key => $value) { ?>
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{get_user_name($value->user_id)}}</td>
                                            <td><a href="{{$value->address_doc_url}}" target="_blank" class="btn edit-button">View</a></td>
                                            <td><a href="{{$value->bank_doc_url}}" target="_blank" class="btn edit-button">View</a></td>
                                            <td>{{$value->created_at->format('d-M-Y')}}</td>
                                            @if($value->pass)
                                                <td class="green">Pass</td>
                                            @else
                                                <td class="red">Fail</td>
                                            @endif

                                            @if($value->availed)
                                                <td class="green">Pass</td>
                                            @else
                                                <td class="red">Fail</td>
                                            @endif
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
                                {{$records->appends($array_to_send)->links("pagination::bootstrap-4")}}
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