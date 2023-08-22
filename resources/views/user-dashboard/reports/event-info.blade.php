@include('user-dashboard.head')
    <title>Events Details | Dashboard</title>
    <body>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content my-beneficiaries">
                <div class="overlay">
                    <div class="card person-detail-card mt-0 event-page">
                        <div class="card-body">
                            <div class="card-title-wrapper">
                                <h1 class="card-title">{{$event->name}}</h1>
                                <?php if ($event->live) { ?>
                                    <span class="px-5 py-2 rounded-pill bg-green">Current Event</span>

                                <?php } else if ($event->unpublished) { ?>
                                    <span class="px-5 py-2 rounded-pill bg-orange">Unpublished Event</span>

                                <?php } else if ($event->cancelled) { ?>
                                    <span class="px-5 py-2 rounded-pill bg-red">Cancelled Event</span>

                                <?php } else { ?>
                                    <span class="px-5 py-2 rounded-pill bg-orange">Past Event</span>

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
                                <?php if ($event->live) { ?>
                                    <p class="p4">
                                        <span class="title" id="copy-link" data-event-link="{{route('EventPreviewForGuest', [$event->event_id])}}" style="text-decoration: underline;cursor:pointer;"><a>Copy Event Link</a></span>
                                    </p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <form action="" class="beneficiary-selection-form">
                        <div class="table-responsive data-table-wrapper mt-2">
                            <table class="table">
                                <thead class="heading-box">
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>Gifter Name</th>
                                        <th class="dob">Gift Date</th>
                                        <th>Beneficiary</th>
                                        <th class="amount">Amount</th>
                                        <th>Gift</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($gifts) {
                                        foreach ($gifts as $key => $value) { $paid_gift = false; ?>
                                            <tr>
                                               
                                                <td>@if($value->transaction_details) {{$value->transaction_details->transaction_id}} @else - @endif</td>
                                                <td>{{get_user_name($value->gifter_id)}}</td>
                                                <td><?php echo date('d-M-Y', strtotime($value->created_at)); ?></td>
                                                <td>{{get_user_name($value->beneficiary_id)}}</td>
                                                <td>@if ($value->amount > 0) ZAR {{$value->amount}} @else - @endif</td>
                                                <?php if ($value->own_gift) { ?>
                                                    <td class="cancelled">Will give his/her own gift!</td>

                                                <?php } else if ($value->no_gift) { ?>
                                                    <td class="cancelled">Will give no gift!</td>

                                                <?php } else { $paid_gift = true; ?>
                                                    <td class="active">Paid Gift</td>

                                                <?php } ?>
                                                <td>@if ($paid_gift) @if (!$value->paid) <span class="red">Failed</span> @else <span class="green">Success</span> @endif @else - @endif</td>
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
                        <div class="col-md-12 text-center">
                                <div class="two-button-box mx-auto">
                                    <button type="button" onclick="goBack()" class="btn common-button close-btn">Back</button>
                                  
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
    <script>
        jQuery(document).ready(function ($) {
            $('#copy-link').on('click', function (e) {
                e.preventDefault();
                navigator.clipboard.writeText($(this).attr('data-event-link'));
                
                var html = ''
                html += '<div class="alert custom-alert alert-success d-flex align-items-center" role="alert">';
                html += '<ul>';
                html += '<li><i class="uil uil-check-circle"></i>Event link copied!</li>';
                html += '</ul>';
                html += '</div>';
                $('body').append(html);
                setTimeout(function(){ $('body').find('div.alert.custom-alert').remove(); }, 5000);
                return false;
            });
        })

        function goBack()
        {
            window.history.back()
        }

    </script>
@include('user-dashboard.footer')