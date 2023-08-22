@include('user-dashboard.head')
    <title>Withdrawal Detail | Dashboard</title>
    <body>
    <div id="preloader" class="d-none"></div>
    @include('user-dashboard.user-dashboard-header')
            <div class="main-content my-beneficiaries">
                <div class="overlay">
                    <div class="main-heading-box mb-5">
                        <h3 class="ps-4">Withdrawal Details</h3>
                    </div>
                    <div class="table-responsive transaction-details-table mt-2">
                        <table class="table mb-0">
                            <tr>
                                <th class="status-th">Withdrawal ID</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">{{$withdrawals->withdrawal_id}}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="payment-gateway-th">Date</th>
                                <td class="payment-gateway-td">{{date('d-M-Y', strtotime($withdrawals->created_at))}}</td>
                            </tr>
                            <tr>
                                <th class="status-th">User</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">{{get_user_name($withdrawals->user_id)}}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="status-th">Beneficiary</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">{{get_user_name($withdrawals->beneficiary_id)}}</span>
                                </td>
                            </tr>
                             <tr>
                                <th class="date">Status</th>
                                <td class="date">@if ($withdrawals->in_progress) <span class="blue">In Progress</span> @elseif($withdrawals->completed) <span class="green">Completed</span> @else <span class="red">Failed</span> @endif</td>
                            </tr>
                            
                            <tr>
                                <th class="status-th">Bitcoin Value at Time of Conversion</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">R{{$withdrawals->btc_zar_rate}}</span>
                                </td>
                            </tr>
                             
                            <tr>
                                <th class="status-th">Requested Amount (BTC)</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">{{number_format($withdrawals->requested_amount,10)}} BTC</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="date">Requested amount in (ZAR)</th>
                                <td class="date">R{{number_format($withdrawals->requested_amount_by_user_in_zar, 2)}}</td>
                            </tr>
                            <tr>
                                <th class="status-th">Combined Fees Charged</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">{{number_format($withdrawals->all_charged_fees_in_zar+$withdrawals->valr_taker_share+$withdrawals->valr_withdrawal_fees_share, 2)}}</span>
                                </td>
                            </tr>
                             <tr>
                                <th class="date">Amount Received by Customer (ZAR)</th>
                                <td class="date">R{{number_format($withdrawals->requested_amount_by_user_in_zar-($withdrawals->all_charged_fees_in_zar+$withdrawals->valr_taker_share+$withdrawals->valr_withdrawal_fees_share), 2)}}</td>
                            </tr>
                           
                        </table>
                    </div>
                    <div class="two-button-box" style="max-width:450px;">
                            <button type="button" onclick="goBack()" class="btn common-button close-btn">Back</button>
                        </div>
                </div>
            </div>
        </section>
    </main>
    <script>
            function goBack()
            {
            window.history.back()
            }
    </script>
@include('user-dashboard.footer')