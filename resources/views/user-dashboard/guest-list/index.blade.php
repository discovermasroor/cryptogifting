@include('user-dashboard.head')
    <title>My Guest List | Dashboard</title>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content my-beneficiaries">
                <div class="overlay">
                    <div class="main-heading-box flex">
                        <h3>My Guest Lists</h3>
                        <a href="{{route('AddGuestList')}}" class="btn blue-button">Create Guest List</a>
                        {{--<a href="{{route('Beneficiaries')}}" class="btn blue-button">Beneficiary</a>--}}
                    </div>
                    <form action="" class="beneficiary-selection-form">
                        <input type="hidden" name="status" id="status" value="<?php if (isset($_GET['status']) && !empty($_GET['status'])) echo $_GET['status']; ?>">
                        <div class="filters">
                            <div class="filter">
                                <label for="subject" class="sr-only">Status</label>
                                <div class="select-box">
                                    <div class="options-container">
                                        <div class="option status-option">
                                            <input type="radio" class="radio" id="status-1"/>
                                            <label for="status-1" class="text-bold">Published</label>
                                        </div>
                                        <div class="option status-option">
                                            <input type="radio" class="radio" id="status-2"/>
                                            <label for="status-2" class="text-bold">Pending</label>
                                        </div>
                                        <div class="option status-option">
                                            <input type="radio" class="radio" id="status-3"/>
                                            <label for="status-3" class="text-bold">Cancelled</label>
                                        </div>
                                       
                                    </div>
                                    <div class="selected">
                                        <?php if (isset($_GET['status']) && !empty($_GET['status'])) echo $_GET['status']; else echo 'Status'; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="search-bar">
                                <input class="form-control" name="search" value="<?php if (isset($_GET['search']) && !empty($_GET['search'])) echo $_GET['search'];?>" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn " type="button"><i class="fas fa-search"></i></button>
                            </div>
                            <button type="submit" class="btn submit-button">Search</button>
                            <a href="{{route('GuestLists')}}" class="btn submit-button">Clear</a>
                        </div>
                        
                        <div class="table-responsive data-table-wrapper mt-2">
                             <?php if(!$guest_lists->isEmpty()){?>
                            <table class="table">
                                <thead class="heading-box">
                                    <tr>
                                        <th>Guest List ID</th>
                                        <th>Guest List Name</th>
                                        <th>Beneficiary Name</th>
                                        <th class="dob">Date Created</th>
                                        <th>Status</th>
                                        <th class="action-td">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($guest_lists as $key => $value) { ?>
                                        <tr>
                                            <td>{{$key+1}}.</td>
                                            <td>{{$value->title}}</td>
                                            <td>{{get_user_name($value->beneficiary_id)}}</td>
                                            <td>{{$value->created_at->format('d-M-Y')}}</td>
                                            <?php if ($value->active) { ?>
                                                <td class="active">Published</td>

                                            <?php } else if ($value->pending) { ?>
                                                <td class="pending">Pending</td>

                                            <?php } else { ?>
                                                <td class="cancelled">Cancelled</td>

                                            <?php } ?>
                                            <td>
                                                <a href="{{route('EditGuestList', [$value->guest_list_id])}}" class="btn edit-button mb-1 mb-lg-0">Edit</a> 
                                                <a href="{{route('AddContactsInGuestListView', [$value->guest_list_id])}}" class="btn edit-button  mb-1 mb-lg-0">Add Guests</a>
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
                                ?>
                                {{$guest_lists->appends($array_to_send)->links("pagination::bootstrap-4")}}
                            </nav> 
                            <?php }else{
                                ?>
                                <div class="no-beneficiaries">
                                    <h5>You have not created a guest list yet. <br> No problem, just click on <br> "Create Guest List"</h5>
                                </div>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>

    @if (session()->get('guest_list')) 
    <?php  $check = session()->get('guest_list')->guest_list_id; ?>
        <div id="add-guest" class="alert alert-danger custom-alert-button d-flex align-items-center flex-column" role="alert">
            <div class="content-box">
                <p style="color: var(--blue);">You have now created your guest list.</p>
                <div class="buttons">
                    <a href="{{route('AddContactsInGuestListView', [$check])}}?model=add-guest" class="btn action-button blue">Add guest</a>
                    <a href="#" id="close-guestlist" class="btn action-button">Later</a>
                </div>
            </div>
        </div>
    @endif
@include('user-dashboard.footer')