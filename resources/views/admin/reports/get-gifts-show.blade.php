@include('admin.head')
    <title>Get/Gift Crypto | Dashboard</title>
    <body>
        @include('admin.header-sidebar')
            <div class="main-content my-beneficiaries">
                <div class="overlay">
                    <div class="main-heading-box mb-5">
                        <a href="{{route('AllGetGfitCryptoAdmin')}}" class="btn back-btn"><i class="uil uil-angle-left-b"></i></a>
                        <h3 class="ps-4">Get/Gift Crypto Details</h3>
                    </div>
                    <div class="table-responsive transaction-details-table mt-2">
                        <table class="table mb-0">
                            <tr>
                                <th class="payment-gateway-th">Sender</th>
                                <td class="payment-gateway-td">{{get_user_name($gift->sender_id)}}</td>
                            </tr>
                            <tr>
                                <th class="payment-gateway-th">Sender Name</th>
                                <td class="payment-gateway-td">{{$gift->sender_name}}</td>
                            </tr>
                            <tr>
                                <th class="payment-gateway-th">Recipient</th>
                                <td class="payment-gateway-td">{{get_user_name($gift->recipient_id)}}</td>
                            </tr>
                            <tr>
                                <th class="payment-gateway-th">Recipient Name</th>
                                <td class="payment-gateway-td">{{$gift->recipient_name}}</td>
                            </tr>
                            <tr>
                                <th class="date">BTC Amount</th>
                                <td class="date">BTC {{number_format($gift->gift_btc_amount, 10)}}</td>
                            </tr>
                            <tr>
                                <th class="date">ZAR Amount</th>
                                <td class="date">ZAR {{number_format($gift->gift_zar_amount, 2)}}</td>
                            </tr>
                            <tr>
                                <th class="date">Theme</th>
                                <td class="cover-image" style="background: url(<?php echo $gift->event_theme->cover_image_url;?>);"><p style="height: 100px;width: 100px;"></p></td>
                            </tr>
                            <tr>
                                <th class="gateway-result-th">Message</th>
                                <td class="gateway-result-td"><?php print_r($gift->message); ?></td>
                            </tr>
                            <tr>
                                <th class="date">Date</th>
                                <td class="date">{{$gift->created_at->format('d-M-Y')}}</td>
                            </tr>
                            <tr>
                                <th class="gateway-result-th">Payment Status</th>
                                <td class="gateway-result-td">@if($gift->event_acceptance->paid)<span class="green">Success</span>@else <span class="red">Fail</span> @endif</td>
                            </tr>
                            <tr>
                                <th class="date">Payment Response</th>
                                <td class="date"><pre><?php print_r(json_decode($gift->event_acceptance->transaction_details->response)); ?></pre></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <style>
                .cover-image{
                    background-size: 80px !important;
                    background-repeat: no-repeat !important;
                    background-position: left 20px center !important;
                }
            </style>
@include('admin.footer')