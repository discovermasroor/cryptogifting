@include('admin.head')
    <title>Transactions | Crypto Gifting</title>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('admin.header-sidebar')
            <div class="main-content my-beneficiaries">
                <div class="overlay">
                    <div class="card person-detail-card mt-0 event-page">
                        <div class="card-body">
                            <div class="card-title-wrapper">
                                <h1 class="card-title">{{$event->name}}</h1>
                                <?php if ($event->live) { ?>
                                    <span class="px-5 py-2 rounded-pill bg-green">Live</span>

                                <?php } else if ($event->unpublished) { ?>
                                    <span class="px-5 py-2 rounded-pill bg-orange">Unpublished</span>

                                <?php } else if ($event->cancelled) { ?>
                                    <span class="px-5 py-2 rounded-pill bg-red">Cancelled</span>

                                <?php } else { ?>
                                    <span class="px-5 py-2 rounded-pill bg-orange">Past</span>

                                <?php } ?>
                            </div>
                            <div class="other-info">
                                <p class="p1">
                                    <span class="title">Hosted By :</span> <span class="value">{{ucfirst($event->hosted_by)}}</span>
                                </p>
                                <p class="p2">
                                    <span class="title">Event Type : </span> <span class="value"><?php if ($event->type == 'no_event') echo 'No Event'; else echo ucfirst($event->type); ?></span>
                                </p>
                                <p class="p3">
                                    <span class="title">Event Date : </span> <span class="value"><?php echo date('d-M-Y', strtotime($event->event_date)); ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <form action="" class="beneficiary-selection-form">
                        <div class="table-responsive data-table-wrapper mt-2">
                            <table class="table">
                                <thead class="heading-box">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th class="dob">Date</th>
                                        <th>Gift</th>
                                        <th>RSVP</th>
                                        <th class="amount">Amount</th>
                                        <th class="amount">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($gifts) {
                                        foreach ($gifts as $key => $value) { $paid_gift = false; ?>
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{get_user_name($value->gifter_id)}}</td>
                                                <td><?php echo date('d-M-Y', strtotime($value->created_at)); ?></td>
                                                <?php if ($value->own_gift) { ?>
                                                    <td class="cancelled">Will give his/her own gift!</td>

                                                <?php } else if ($value->no_gift) { ?>
                                                    <td class="cancelled">Will give no gift!</td>

                                                <?php } else { $paid_gift = true; ?>
                                                    <td class="active">Paid Gift</td>

                                                <?php } ?>

                                                <?php if ($value->rsvp == 'yes') { ?>
                                                    <td class="active">Accepted</td>

                                                <?php } else if ($value->rsvp == 'no') { ?>
                                                    <td class="cancelled">Declined</td>

                                                <?php } else { ?>
                                                    <td class="pending">May be</td>

                                                <?php } ?>
                                                <td>@if ($value->amount > 0) ZAR {{$value->amount}} @else - @endif</td>
                                                <td>@if ($paid_gift) <a href="{{route('GiftDetailsAdmin', [$value->event_acceptance_id])}}" class="btn edit-button">View</a> @else - @endif</td>
                                            </tr>
                                        <?php }
                                    } ?>
                                </tbody>
                            </table>
                            <?php if ($gifts) { ?>
                                <nav class="d-flex justify-content-end pagination-box">
                                    {{$gifts->links("pagination::bootstrap-4")}}
                                </nav>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
@include('admin.footer')