@include('admin.head')
    <title>Event Info | Dashboard</title>
    <body>
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
                                    <span class="title">Event Creator : </span> <span class="value">{{get_user_name($event->creator_id)}}</span>
                                </p>
                                <p class="p2">
                                    <span class="title">Hosted By :</span> <span class="value">{{$event->hosted_by}}</span>
                                </p>
                                <p class="p3">
                                    <span class="title">Event Type : </span> <span class="value"><?php if ($event->type == 'no_event') echo 'No Event'; else echo ucfirst($event->type); ?></span>
                                </p>
                                <p class="p4">
                                    <span class="title">Event Date : </span> <span class="value">{{date('d-M-Y', strtotime($event->event_date))}}</span>
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
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if ($gifts) {
                                        foreach ($gifts as $key => $value) { ?>
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{get_user_name($value->gifter_id)}}</td>
                                                <td><?php echo date('d-M-Y', strtotime($value->created_at)); ?></td>
                                                <?php if ($value->own_gift) { ?>
                                                    <td class="cancelled">Will give his/her own gift!</td>

                                                <?php } else if ($value->no_gift) { ?>
                                                    <td class="cancelled">Will give no gift!</td>

                                                <?php } else { ?>
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

                    <div class="modal fade popup-style transaction-info-popup" id="transaction-info-popup" tabindex="-1"
                        aria-labelledby="acc-confirm-popupLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mt-0">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"><i class="fas fa-times"></i></button>
                                    <h4 class="heading">Transaction Info</h4>
                                    <div class="amount-wrapper">
                                        <h1 class="amount">R100</h1>
                                        <p>(CG Fee 5% Include)</p>
                                    </div>

                                    <div class="details">
                                        <div class="date">
                                            <Span class="title">Date:</Span>
                                            <span class="value">23/12/2021</span>
                                        </div>
                                        <div class="time">
                                            <span class="title">Time:</span>
                                            <span class="value">11:00 Pm</span>
                                        </div>
                                    </div>
                                    <div class="payment-method">
                                        <span class="title">Payment Method:</span>
                                        <span class="value">Peachpayment</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@include('admin.footer')