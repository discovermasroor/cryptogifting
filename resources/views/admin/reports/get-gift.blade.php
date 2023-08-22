@include('admin.head')
    <title>All Get/Gift Crypto List | Dashboard</title>
    <body>
        @include('admin.header-sidebar')
            <div class="main-content my-beneficiaries">
                <div class="overlay">
                    <form action="" method="get">
                        <div class="main-heading-box flex">
                            <h3>Get/Gift Crypto</h3>
                        </div>
                    </form>
                    <div class="table-responsive data-table-wrapper mt-2">
                        <table class="table">
                            <thead class="heading-box">
                                <tr>
                                    <th>Sender</th>
                                    <th>#</th>
                                    <th>Recipient</th>
                                    <th>Theme</th>
                                    <th>Gifted Zar Amount</th>
                                    <th class="dob">Fees</th>
                                    <th>Gifted BTC Amount</th>
                                    <th class="dob">Date</th>
                                    <th class="dob">Payment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($gifter_event) {
                                    foreach ($gifter_event as $key => $value) { ?>
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{get_user_name($value->sender_id)}}</td>
                                            <td>{{get_user_name($value->recipient_id)}}</td>
                                            <td class="cover-image" style="background: url(<?php echo $value->event_theme->cover_image_url;?>);"><p style="height: 100px;width: 100px;"></p></td>
                                            <td>ZAR {{$value->gift_zar_amount}}</td>
                                            <td>{{$value->fees}}%</td>
                                            <td>BTC {{number_format($value->gift_btc_amount, 10)}}</td>
                                            <td>{{$value->created_at->format('d-M-Y')}}</td>
                                            <td>@if($value->event_acceptance->paid)<span class="green">Success</span>@else <span class="red">Fail</span> @endif</td>
                                            <td><a href="{{route('ShowGetGfitCryptoAdmin', [$value->gifter_event_id])}}" class="btn edit-button">View</a></td>
                                        </tr>
                                    <?php }
                                } ?>
                            </tbody>
                        </table>
                        <?php if ($gifter_event) { ?>
                            <nav class="d-flex justify-content-end pagination-box">
                                {{$gifter_event->links("pagination::bootstrap-4")}}
                            </nav>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
    <style>
        .cover-image{
            background-size: 80px !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
        }
    </style>
@include('admin.footer')