@include('admin.head')
    <title>Withdrawal Detail | Dashboard</title>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('admin.header-sidebar')
            <div class="main-content my-beneficiaries">
                <div class="overlay">
                    <div class="main-heading-box mb-5">
                        <a href="{{route('WithdrawalRequestAdmin')}}" class="btn back-btn"><i class="uil uil-angle-left-b"></i></a>
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
                                <th class="status-th">Bank Name</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">{{$bank_info->bank}}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="status-th">Account Type</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">{{$bank_info->account_type}}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="status-th">Account Number</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">{{$bank_info->account_number}}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="status-th">Branch Code</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">{{$bank_info->branch_code}}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="date">Status</th>
                                <td class="date">@if ($withdrawals->in_progress) <span class="blue">In Progress</span> @elseif($withdrawals->completed) <span class="green">Completed</span> @else <span class="red">Failed</span> @endif</td>
                            </tr>
                            <tr>
                                <th class="status-th">Currency</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">{{$withdrawals->currency}}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="status-th">Requested Amount</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">{{number_format($withdrawals->requested_amount, 10)}} BTC</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="status-th">Bitcoin Last Traded Rate</th>
                                <td class="status-td">
                                    <span class="green-bg status-span">R{{number_format($withdrawals->btc_zar_rate, 0)}}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="date">CG Platform Fees</th>
                                <td class="date">{{$withdrawals->cg_platform_fees}}</td>
                            </tr>
                            <tr>
                                <th class="date">CG Platform Fees Type</th>
                                <td class="date">{{ucfirst($withdrawals->cg_platform_fees_type)}}</td>
                            </tr>
                            <tr>
                                <th class="date">CG Platform Fees Charged</th>
                                <td class="date">R{{number_format($withdrawals->cg_platform_fees_share, 2)}}</td>
                            </tr>
                            <tr>
                                <th class="date">VAT Tax</th>
                                <td class="date">{{$withdrawals->vat_tax}}</td>
                            </tr>
                            <tr>
                                <th class="date">VAT TAX Type</th>
                                <td class="date">{{ucfirst($withdrawals->vat_tax_type)}}</td>
                            </tr>
                            <tr>
                                <th class="date">VAT TAX Charged</th>
                                <td class="date">R{{number_format($withdrawals->vat_tax_share, 2)}}</td>
                            </tr>
                            <tr>
                                <th class="date">Valr Taker Fee</th>
                                <td class="date">{{$withdrawals->valr_taker}}</td>
                            </tr>
                            <tr>
                                <th class="date">Valr Taker Fee Type</th>
                                <td class="date">{{ucfirst($withdrawals->valr_taker_type)}}</td>
                            </tr>
                            <tr>
                                <th class="date">Valr Taker Fee Charged</th>
                                <td class="date">R{{number_format($withdrawals->valr_taker_share, 2)}}</td>
                            </tr>
                            <tr>
                                <th class="date">VALR Withdrawal Fees</th>
                                <td class="date">{{$withdrawals->bank_charges}}</td>
                            </tr>
                            <tr>
                                <th class="date">VALR Withdrawal Fees Type</th>
                                <td class="date">{{ucfirst($withdrawals->bank_charges_type)}}</td>
                            </tr>
                            <tr>
                                <th class="date">VALR Withdrawal Fees Charged</th>
                                <td class="date">R{{$withdrawals->bank_charges_share}}</td>
                            </tr>
                            <tr>
                                <th class="date">Bank Withdrawal Fees</th>
                                <td class="date">{{$withdrawals->valr_withdrawal_fees}}</td>
                            </tr>
                            <tr>
                                <th class="date">Bank Withdrawal Fees Type</th>
                                <td class="date">{{ucfirst($withdrawals->valr_withdrawal_fees_type)}}</td>
                            </tr>
                            <tr>
                                <th class="date">Bank Withdrawal Fees Charged</th>
                                <td class="date">R{{$withdrawals->valr_withdrawal_fees_share}}</td>
                            </tr>
                            <tr>
                                <th class="date">Combine Fees Charged</th>
                                <td class="date">R{{number_format($withdrawals->all_charged_fees_in_zar+$withdrawals->valr_taker_share+$withdrawals->valr_withdrawal_fees_share, 2)}}</td>
                            </tr>
                            <tr>
                                <th class="date">Customer requested amount in ZAR</th>
                                <td class="date">R{{number_format($withdrawals->requested_amount_by_user_in_zar, 2)}}</td>
                            </tr>
                            <tr>
                                <th class="date">Final Amount Receive by Customer</th>
                                <td class="date">R{{number_format($withdrawals->requested_amount_by_user_in_zar-($withdrawals->all_charged_fees_in_zar+$withdrawals->valr_taker_share+$withdrawals->valr_withdrawal_fees_share), 2)}}</td>
                            </tr>
                            <tr>
                                <th class="payment-gateway-th">Date</th>
                                <td class="payment-gateway-td">{{date('d-M-Y', strtotime($withdrawals->created_at))}}</td>
                            </tr>
                            @if($withdrawals->customer->address_doc_url)
                                <tr>
                                    <th class="payment-gateway-th">Proof of Address Document</th>
                                    <td class="payment-gateway-td"><a href="{{$withdrawals->customer->address_doc_url}}" target="_blank" class="btn edit-button">View</a></td>
                                </tr>
                            @endif
                            @if($withdrawals->customer->bank_doc_url)
                                <tr>
                                    <th class="payment-gateway-th">Proof of Bank Account Document</th>
                                    <td class="payment-gateway-td"><a href="{{$withdrawals->customer->bank_doc_url}}" target="_blank" class="btn edit-button">View</a></td>
                                </tr>
                            @endif
                            <tr>
                                <th class="payment-gateway-th">Domestic Politically Exposed Person (PEP)</th>
                                <td class="payment-gateway-td"><span class="green-bg status-span">@if($withdrawals->customer->domistic_politically) Yes @else No @endif</span></td>
                            </tr>
                            <tr>
                                <th class="payment-gateway-th">Foreign Politically Exposed Person (PEP)</th>
                                <td class="payment-gateway-td"><span class="green-bg status-span">@if($withdrawals->customer->foreign_politically) Yes @else No @endif</span></td>
                            </tr>
                            <tr>
                                <th class="gateway-result-th">Valr Response</th>
                                <td class="gateway-result-td"><pre><?php print_r(json_decode($withdrawals->response)); ?></pre></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
@include('admin.footer')