@include('admin.head')
    <title>Feedbacks Form Submissions | Dashboard</title>
    <body>
        @include('admin.header-sidebar')
            <!-- Main Content Starts -->
            <div class="main-content">
                <div class="overlay">

                    <form action="{{route('FeedbacksAdmin')}}" method="get">
                        <input type="hidden" name="status" id="topic-field" value="<?php if (isset($_GET['status'])) echo $_GET['status']; ?>">
                        <div class="main-heading-box flex">
                            <h3>Feedbacks Form Submission</h3>
                            <div class="filters mt-0">
                                <div class="filter">
                                    <label for="subject" class="sr-only">Status</label>
                                    <div class="select-box">
                                        <div class="options-container">
                                            <div class="option">
                                                <input type="radio" class="radio" id="status-1"/>
                                                <label for="status-1" class="text-bold">Read</label>
                                            </div>
                                            <div class="option">
                                                <input type="radio" class="radio" id="status-2"/>
                                                <label for="status-2" class="text-bold">Not Read</label>
                                            </div>
                                        </div>
                                        <div class="selected">
                                            <?php if (isset($_GET['status']) && !empty($_GET['status'])) echo $_GET['status']; else echo 'Status'; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="search-bar">
                                    <input class="form-control" name="search" type="search" placeholder="Search" aria-label="Search" value="<?php if (isset($_GET['search'])) echo $_GET['search']; ?>">
                                    <button class="btn" type="button"><i class="fas fa-search"></i></button>
                                </div>
                                <button type="submit" class="btn submit-button">Submit</button>
                                <a href="{{route('FeedbacksAdmin')}}" class="btn submit-button">Clear</a>
                            </div>
                        </div>

                        <div class="table-responsive data-table-wrapper mt-3 users-table">
                            <table class="table">
                                <thead class="heading-box">
                                    <tr>
                                        <th class="email">Email</th>
                                        <th>Topic</th>
                                        <th>Subject</th>
                                        <th class="dob">Date</th>
                                        <th>Status</th>
                                        <th class="action-td">View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contact_us as $key => $value) { ?>
                                        <tr>
                                            <td>{{$value->email}}</td>
                                            <td><?php echo $value->topic; ?></td>
                                            <td>{{$value->subject}}</td>
                                            <td>{{$value->created_at->format('d-M-Y')}}</td>
                                            <?php if ($value->read) { ?>
                                                <td class="active">Read</td>

                                            <?php } else { ?>
                                                <td class="pending">Not read yet</td>

                                            <?php } ?>
                                            <td><a href="{{route('FeedbackInfoAdmin', [$value->contact_us_id])}}" class="btn edit-button">View</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <nav class="d-flex justify-content-end pagination-box">
                                <?php 
                                    $array_to_send = array();

                                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                                        $array_to_send['search'] = $_GET['search'];

                                    }
                                    
                                    if (isset($_GET['status']) && !empty($_GET['status'])) {
                                        $array_to_send['status'] = $_GET['status'];

                                    }
                                ?>
                                {{$contact_us->appends($array_to_send)->links("pagination::bootstrap-4")}}
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