@include('admin.head')
    <title>Dashboard | Crypto Gifting</title>
    <body>
        @include('admin.header-sidebar')
            <div class="main-content">
                <div class="overlay">
                    <div class="heading-wrapper">
                        <h1 class="main-heading" style="text-transform: inherit;">Search Results for <?php if (isset($_GET['search']) && !empty($_GET['search'])) echo $_GET['search']; ?></h1>
                    </div>
                    <?php if (!empty($search_results)) { ?>
                        <div class="notifications-wrapper">
                            <?php foreach ($search_results as $key => $value) {
                                if (isset($value['event_id']) && !empty($value['event_id'])) { ?>
                                    <a href="{{route('EventInfoAdmin', [$value['event_id']]) }}">
                                        <div class="alert alert-dismissible fade show" role="alert">
                                            <span class="pipe pending"></span>
                                            <div class="detail">
                                                    <h4 class="alert-heading">{{$value['name']}}</h4>
                                                    <p>Click to see details of this event!</p>
                                            </div>
                                        </div>
                                    </a>
                                <?php } else if (isset($value['user_id']) && !empty($value['user_id'])) { ?>
                                    <a href="{{route('UserInfoAdmin', [$value['user_id']])}}">
                                        <div class="alert alert-dismissible fade show" role="alert">
                                            <span class="pipe pending"></span>
                                            <div class="detail">
                                                    <h4 class="alert-heading">{{get_user_name($value['user_id'])}}</h4>
                                                    <p>Click to view his/her profile!</p>
                                            </div>
                                        </div>
                                    </a>
                                <?php } else { ?>
                                    <a href="<?php if ($value['contact_us']) echo route('ContactUsInfoAdmin', [$value['contact_us_id']]); else if ($value['loyalty_program']) echo route('LoyaltyProgramInfoAdmin', [$value['contact_us_id']]); else if ($value['feedback']) echo route('FeedbackInfoAdmin', [$value['contact_us_id']]); else if ($value['affiliates']) echo route('AffiliateInfoAdmin', [$value['contact_us_id']]); ?>">
                                        <div class="alert alert-dismissible fade show" role="alert">
                                            <span class="pipe pending"></span>
                                            <div class="detail">
                                                    <h4 class="alert-heading"><?php echo $value['topic']; ?></h4>
                                                    <p>Click to view details!</p>
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