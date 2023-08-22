@include('user-dashboard.head')
    <title>Gift Details | Dashboard</title>
    <body>
        @include('user-dashboard.user-dashboard-header')
            <div class="main-content my-beneficiaries">
                <div class="overlay">
                    <div class="main-heading-box mb-5">
                        
                        <h3 class="ps-4">Transaction Details</h3>
                    </div>
                    <div class="table-responsive transaction-details-table mt-2">
                        <table class="table mb-0">
                             <tr>
                              <th class="status-th">Gift ID</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">{{$gift->event_acceptance_id}}</span>
                                </td>
                            </tr>
                            <tr>
                              <th class="status-th">Date</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">{{date('d-M-Y', strtotime($gift->created_at))}}</span>
                                </td>
                            </tr>
                            <tr>
                              <th class="status-th">Status</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">@if (!$gift->paid) <span class="red">Failed</span> @else <span class="green">Success</span> @endif</span>
                                </td>
                            </tr>
                             <?php if ($gift->gift_event_info) { ?>
                                
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
                              <th class="status-th">Bitcoin Value at Time of Conversion</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">R{{number_format($gift->transaction_details->btc_rate, 0)}}</span>
                                </td>
                            </tr>
                            <tr>
                              <th class="status-th">Gift Amount (ZAR)</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">R{{$gift->amount}}</span>
                                </td>
                            </tr>
                            <tr>
                              <th class="status-th">Currency</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">{{$gift->transaction_details->currency}}</span>
                                </td>
                            </tr>
                            <tr>
                              <th class="status-th">Gift Amount (BTC)</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">{{number_format($gift->transaction_details->zar_into_btc, 10)}} BTC</span>
                                </td>
                            </tr>
                            <tr>
                              <th class="status-th">Amount Charged to Gifter (ZAR)</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">R{{number_format($gift->transaction_details->amount, 2)}}</span>
                                </td>
                            </tr>
                          
                        </table>
                        
                    </div>
                    <div class="col-md-12 text-center">
                                <div class="two-button-box mx-auto">
                                    <button type="button" onclick="goBack()" class="btn common-button close-btn">Back</button>
                                  
                                </div>
                            </div>
                </div>
            </div>
            <script>
                 function goBack()
                    {
                        window.history.back()
                    }

            </script>
@include('user-dashboard.footer')