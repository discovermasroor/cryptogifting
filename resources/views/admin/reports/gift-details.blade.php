@include('admin.head')
    <title>Gift Details | Dashboard</title>
    <body>
        @include('admin.header-sidebar')
            <div class="main-content my-beneficiaries">
                <div class="overlay">
                    <div class="main-heading-box mb-5">
                        <a href="{{route('EventsTransactionsAdmin')}}" class="btn back-btn"><i class="uil uil-angle-left-b"></i></a><h3 class="ps-4">Transaction Details</h3>
                    </div>
                    <div class="table-responsive transaction-details-table mt-2">
                        <table class="table mb-0">
                            <tr>
                                <th class="date">Status</th>
                                <td class="date">@if (!$gift->paid) <span class="red">Failed</span> @else <span class="green">Success</span> @endif</td>
                            </tr>
                            <tr>
                                <th class="status-th">Gift Type</th>
                                <td class="status-td">
                                    <span class="green-bg status-span"><?php if ($gift->event_id) echo 'Event Gift'; else if (isset($gift->gift_event_info) && $gift->gift_event_info->get_crypto=='1') echo 'Public Link Gift'; else if(isset($gift->gift_event_info) && $gift->gift_event_info->gift_crypto =='1') echo 'E2E Gift'; else if ($gift->event_id == NULL && $gift->gifter_event_id == NULL ) echo 'Public Link Gift'; ?></span>
                                </td>
                            </tr>
                            <?php if ($gift->gift_event_info) { ?>
                                <tr>
                                    <th class="date">Theme</th>
                                    <td class="cover-image" style="background: url(<?php echo $gift->gift_event_info->event_theme->cover_image_url;?>);"><p style="height: 100px;width: 100px;"></p></td>
                                </tr>
                                <tr>
                                    <th class="status-th">Recipient</th>
                                    <td class="status-td">
                                        <span class="green-bg status-span">{{$gift->gift_event_info->recipient_name}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="status-th">Recipient Email</th>
                                    <td class="status-td">
                                        <span class="green-bg status-span">{{$gift->gift_event_info->recipient->email}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="status-th">Sender</th>
                                    <td class="status-td">
                                        <span class="green-bg status-span">{{$gift->gift_event_info->sender_name}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="status-th">Sender Email</th>
                                    <td class="status-td">
                                        <span class="green-bg status-span">{{$gift->gift_event_info->sender->email}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="status-th">Message</th>
                                    <td class="status-td">
                                        <span class="green-bg status-span">{{$gift->gift_event_info->message}}</span>
                                    </td>
                                </tr>
                            <?php } else if ($gift->event_id == NULL && $gift->gifter_event_id == NULL) { ?>
                                <tr>
                                    <th class="status-th">Recipient</th>
                                    <td class="status-td">
                                        <span class="green-bg status-span">{{get_user_name($gift->beneficiary_id)}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="status-th">Gifter</th>
                                    <td class="status-td">
                                        <span class="green-bg status-span">@if($gift->gifter_id) {{get_user_name($gift->gifter_id)}} @else Anonymous @endif</span>
                                    </td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <th class="status-th">Event Name</th>
                                    <td class="status-td">
                                        <span class="green-bg status-span">{{$gift->event_info->name}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="status-th">Hosted By</th>
                                    <td class="status-td">
                                        <span class="green-bg status-span">{{$gift->event_info->hosted_by}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="date">Theme</th>
                                    <td class="cover-image" style="background: url(<?php echo $gift->event_info->event_theme->cover_image_url;?>);"><p style="height: 100px;width: 100px;"></p></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th class="date">Requested Amount</th>
                                <td class="date">R<?php echo ($gift->amount);?></td>
                            </tr>
                            <tr>
                                <th class="date">Requested Amount In BTC</th>
                                <td class="date">{{number_format($gift->transaction_details->zar_into_btc, 10)}} BTC</td>
                            </tr>
                            <tr>
                                <th class="date">Bitcoin Last Traded Rate</th>
                                <td class="date">R{{number_format($gift->transaction_details->btc_rate, 0)}}</td>
                            </tr>
                            <tr>
                                <th class="date">CG Platform Fees</th>
                                <td class="date">{{$gift->transaction_details->cg_platform_fee}}</td>
                            </tr>
                            <tr>
                                <th class="date">CG Platform Fees Type</th>
                                <td class="date">{{ucfirst($gift->transaction_details->cg_platform_fee_type)}}</td>
                            </tr>
                            <tr>
                                <th class="date">CG Platform Fees Charged</th>
                                <td class="date">R{{number_format($gift->transaction_details->cg_platform_fee_share, 2)}}</td>
                            </tr>
                            <tr>
                                <th class="date">VAT Tax</th>
                                <td class="date">{{$gift->transaction_details->vat_tax}}</td>
                            </tr>
                            <tr>
                                <th class="date">VAT TAX Type</th>
                                <td class="date">{{ucfirst($gift->transaction_details->vat_tax_type)}}</td>
                            </tr>
                            <tr>
                                <th class="date">VAT TAX Charged</th>
                                <td class="date">R{{number_format($gift->transaction_details->vat_tax_share, 2)}}</td>
                            </tr>
                            <tr>
                                <th class="date">Valr Maker Fee</th>
                                <td class="date">{{$gift->transaction_details->valr_maker}}</td>
                            </tr>
                            <tr>
                                <th class="date">Valr Maker Fee Type</th>
                                <td class="date">{{ucfirst($gift->transaction_details->valr_maker_type)}}</td>
                            </tr>
                            <tr>
                                <th class="date">Valr Maker Fee Charged</th>
                                <td class="date">R{{number_format($gift->transaction_details->valr_maker_share, 2)}}</td>
                            </tr>
                            <tr>
                                <th class="date">CallPay Handling Fee</th>
                                <td class="date">{{$gift->transaction_details->callpay_handling}}</td>
                            </tr>
                            <tr>
                                <th class="date">CallPay Handling Fee Type</th>
                                <td class="date">{{ucfirst($gift->transaction_details->callpay_handling_type)}}</td>
                            </tr>
                            <tr>
                                <th class="date">CallPay Handling Fee Charged</th>
                                <td class="date">R{{number_format($gift->transaction_details->callpay_handling_share, 2)}}</td>
                            </tr>
                            <tr>
                                <th class="date">CallPay Contigency Fee</th>
                                <td class="date">{{$gift->transaction_details->callpay_contigency}}</td>
                            </tr>
                            <tr>
                                <th class="date">CallPay Contigency Fee Type</th>
                                <td class="date">{{ucfirst($gift->transaction_details->callpay_contigency_type)}}</td>
                            </tr>
                            <tr>
                                <th class="date">CallPay Contigency Fee Charged</th>
                                <td class="date">R{{number_format($gift->transaction_details->callpay_contigency_share, 2)}}</td>
                            </tr>
                            <tr>
                                <th class="date">Charged Amount</th>
                                <td class="date">R{{number_format($gift->transaction_details->amount, 2)}}</td>
                            </tr>
                            <tr>
                                <th class="payment-gateway-th">Date</th>
                                <td class="payment-gateway-td">{{date('d-M-Y', strtotime($gift->created_at))}}</td>
                            </tr>
                            <tr>
                                <th class="gateway-result-th">CallPay Result</th>
                                <td class="gateway-result-td"><pre><?php print_r(json_decode($gift->transaction_details->response)); ?></pre></td>
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