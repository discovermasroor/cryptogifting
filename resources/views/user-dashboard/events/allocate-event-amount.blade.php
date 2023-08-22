@include('user-dashboard.head')
    <title>Amount Allocation | Dashboard</title>
    <body>
        <div id="preloader" class="d-none"></div>
            @include('user-dashboard.user-dashboard-header')
            <div class="main-content crypto-gift-page">
                <div class="overlay">
                    <div class="main-heading-box ">
                        <h3>Select Allocation</h3>
                    </div>

                    <div class="progress-link-wrapper mb-0">
                        
                        <a href="#" class="btn back-btn" style="padding-top: 0px !important;"><i class="uil uil-angle-left-b"></i></a>
                        
                        <nav class="nav">
                            <a class="nav-link" href="#">Select Theme</a>
                            <a class="nav-link" href="#">Share</a>
                        </nav>
                    </div>

                    <div class="gift-box">
                        <h4 class="heading">How would you like your crypto gifts allocated?</h4>
                        <div class="data">
                            <img src="{{asset('public/')}}/assets/images/dashboard/gift-box-1.png" class="img-fluid gift-box-img">
                            <form action="{{route('AllocateEventAmount', [$id])}}" method="post" class="gift-form form-style">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="ethirium_allocation" value="">
                                <div class="custom-row">
                                    <div class="column column-1">
                                        <label for="">
                                            <div>
                                                <img src="{{asset('public/')}}/assets/images/dashboard/icon-bitcoin.png" class="img-fluid">
                                            </div>
                                            Bitcoin
                                        </label>
                                    </div>
                                    <div class="column column-2">
                                        <input type="number" class="form-control" name="bitcoin_allocation" id="bitcoin-allocation" placeholder="50%">
                                    </div>
                                    <div class="column column-1">
                                        <label for="">
                                            <div>
                                                <img src="{{asset('public/')}}/assets/images/dashboard/icon-ethereum.png" class="img-fluid">
                                            </div>
                                            Ethereum
                                        </label>
                                    </div>
                                    <div class="column column-2">
                                        <input type="number" class="form-control" id="ethirium-allocation"  value="0%">
                                    </div>
                                </div>
                                <div class="two-button-box">
                                    <button class="blue-button btn" id="submit-button">Next</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
    <script>
        jQuery(document).ready(function ($) {
            $('#bitcoin-allocation').on('keyup change', function () {
                var bitcoinRate = $(this).val();
                if (bitcoinRate == '') {
                    $(this).val();
                    $('#ethirium-allocation').val('');
                    $('input[name="ethirium_allocation"]').val('');

                } else if (bitcoinRate > 100 || bitcoinRate < 0) {
                    $(this).val('');
                    $('#ethirium-allocation').val('');
                    $('input[name="ethirium_allocation"]').val('');
                    alert('Invalid Input');
                    return false;
                } else {
                    $('#ethirium-allocation').val(100-bitcoinRate);
                    $('input[name="ethirium_allocation"]').val(100-bitcoinRate);

                }
            });
        })
    </script>
@include('user-dashboard.footer')