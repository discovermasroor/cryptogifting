@include('user-dashboard.head')
    <title>Search Results | Dashboard</title>
    <body>
        @include('user-dashboard.user-dashboard-header')
            <!-- Main Content Starts -->
            <div class="main-content">
                <div class="overlay">
                    <div class="heading-wrapper">
                        <h1 class="main-heading" style="text-transform: inherit;">Search Results for <?php if (isset($_GET['search']) && !empty($_GET['search'])) echo $_GET['search']; ?></h1>
                    </div>
                    <?php if (!empty($search_results)) { ?>
                        <div class="notifications-wrapper">
                            <?php foreach ($search_results as $key => $value) {
                                if (isset($value['event_id']) && !empty($value['event_id'])) { ?>
                                    <a href="{{route('EventsDetails', [$value['event_id']]) }}">
                                        <div class="alert alert-dismissible fade show" role="alert">
                                            <span class="pipe pending"></span>
                                            <div class="detail">
                                                    <h4 class="alert-heading">{{$value['name']}}</h4>
                                                    <p>Click to see details of this event!</p>
                                            </div>
                                        </div>
                                    </a>
                                <?php } else if (isset($value['beneficiary_id']) && !empty($value['beneficiary_id'])) { ?>
                                    <a href="{{route('EditBeneficiary', [$value['beneficiary_id']])}}">
                                        <div class="alert alert-dismissible fade show" role="alert">
                                            <span class="pipe pending"></span>
                                            <div class="detail">
                                                    <h4 class="alert-heading">{{$value['name']}} {{$value['surname']}}</h4>
                                                    <p>Click to view his/her profile!</p>
                                            </div>
                                        </div>
                                    </a>
                                <?php } else { ?>
                                    <a href="{{route('EditContact', [$value['contact_id']])}}">
                                        <div class="alert alert-dismissible fade show" role="alert">
                                            <span class="pipe pending"></span>
                                            <div class="detail">
                                                    <h4 class="alert-heading">{{$value['name']}} {{$value['surname']}}</h4>
                                                    <p>Click to view his/her profile!</p>
                                            </div>
                                        </div>
                                    </a>
                                <?php }
                            } ?>
                        </div>
                    <?php } else { ?>
                        <h4 class="red">No result found!</h4>
                    <?php } ?>
                </div>
            </div>
        </section>
    </main>
    <style>
        .notifications-wrapper a {
            text-decoration: none;
        }
    </style>
@include('user-dashboard.footer')