@include('user-dashboard.head')
    <title>Edit Guest List | Dashboard</title>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('user-dashboard.user-dashboard-header')
        <div class="main-content withdraw-page">
                <div class="overlay">
                    <div class="main-heading-box flex">
                        <h1 class="main-heading mb-0">Edit Guest List</h1>
                        <a href="{{route('DeleteGuestList', [$guest_list->guest_list_id])}}" onclick="return confirm('Are you sure that you would like to delete this guest list?')" class="btn common-button delete">Delete List</a>
                    </div>

                    <div class="card person-detail-card">
                        <div class="card-body">
                            <h1 class="card-title">{{$guest_list->title}}</h1>

                            <div class="other-info">
                                <p class="p1">
                                    <span class="title">List ID :</span> <span class="value">{{$guest_list->guest_list_id}}</span>
                                </p>
                                <p class="p2">
                                    <span class="title">Status : </span> <span class="value "><?php if ($guest_list->active) echo 'Published'; else if ($guest_list->pending) echo 'Pending'; else echo 'Cancelled';  ?></span>
                                </p>
                                <p class="p3">
                                    <span class="title">Date Created : </span> <span class="value">{{$guest_list->created_at->format('d-F-Y')}}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('UpdateGuestList', [$guest_list->guest_list_id])}}" method="POST"  class="form-style add-beneficiary-form edit-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="event" id="event" value="<?php if ($guest_list->event_type == 'no_event') echo 'No Event'; else echo ucfirst($guest_list->event_type); ?>">
                        <?php if ($guest_list->beneficiary) { ?>
                            <input type="hidden" name="beneficiary" id="beneficiar" value="{{$guest_list->beneficiary_id}}">
                        <?php } ?>
                        <input type="hidden" name="status" id="status" value="<?php if ($guest_list->active) echo 'Published'; else if ($guest_list->pending) echo 'Pending'; else echo 'Cancelled';  ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Guest List Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Name Your Guest List*" name="title" value="{{$guest_list->title}}">
                            </div>
                            <?php if ($guest_list->beneficiary) { ?>
                                <div class="col-md-6">
                                    <label for="" class="form-label">Beneficiaries <small>(Who is this event for?)</small></label>
                                    <div class="select-box">
                                        <div class="options-container">
                                            <?php foreach ($all_beneficiaries as $key => $value) {  if ($value->beneficiary_id == request()->user->user_id) continue; ?>
                                                <div class="option beneficiar-option">
                                                    <input type="radio" class="radio" id="{{$key}}" name="beneficiar" value="{{$value->beneficiary_id}}"/>
                                                    <label for="{{$key}}" data-user-id="{{$value->beneficiary_id}}" class="text-bold">{{$value->name}} {{$value->surname}}</label>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <div class="selected"><?php echo $guest_list->beneficiary->name.' '.$guest_list->beneficiary->surname; ?></div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-md-6">
                                <label for="" class="form-label">Status</label>
                                <div class="select-box">
                                    <div class="options-container">
                                        <div class="option status-option">
                                            <input type="radio" class="radio" id="status-1"  value="active"/>
                                            <label for="status-1" class="text-bold">Published</label>
                                        </div>
                                        <div class="option status-option">
                                            <input type="radio" class="radio" id="status-2"  value="pending"/>
                                            <label for="status-2" class="text-bold">Pending</label>
                                        </div>
                                        <div class="option status-option">
                                            <input type="radio" class="radio" id="status-3"  value="cancelled"/>
                                            <label for="status-3" class="text-bold">Cancelled</label>
                                        </div>
                                    </div>
                                    <div class="selected"><?php if ($guest_list->active) echo 'Published'; else if ($guest_list->pending) echo 'Pending'; else echo 'Cancelled';  ?></div>
                                </div>
                            </div>

                            <div class="col-md-12 text-center">
                                <div class="two-button-box">
                                <button type="button" onclick="goBack()" class="btn common-button">Back</button>
                                    <button type="submit" class="btn blue-button my-0">Save Changes</button>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
    <script>
        function goBack()
        {
            window.history.back()
        }
    </script>
@include('user-dashboard.footer')