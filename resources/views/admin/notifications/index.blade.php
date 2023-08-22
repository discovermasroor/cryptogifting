@include('admin.head')
    <title>Notifications | Crypto Gifting</title>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('admin.header-sidebar')
            <!-- Main Content Starts -->
            <div class="main-content">
                <div class="overlay">
                    <div class="main-heading-box flex">
                        <h1 class="main-heading mb-0">Unread Notifications</h1>
                        <a class="btn blue-button" href="{{route('MarkAllSeenAdmin')}}">Mark all as Read</a>
                    </div>
                    <div class="notifications-wrapper">
                        <?php foreach ($notifications as $key => $value) { ?>
                            <a href="<?php if ($value->notification->event_id) echo route('EventInfoAdmin', [$value->notification->event_id]); else if ($value->notification->beneficiary_id) echo route('BeneficiaryInfoAdmin', [$value->notification->beneficiary_id]); else echo '#'; ?>">
                                <div class="alert alert-dismissible fade show <?php if (!$value->read) echo 'unread'; ?>" role="alert">
                                    <span class="pipe d-none"></span>
                                    <img src="{{asset('/public')}}/assets/images/dashboard/bell-icon.png" class="img-fluid icon">
                                    <div class="detail">
                                        <h4 class="alert-heading">{{$value->notification->heading}}</h4>
                                        <span class="date">{{$value->notification->text}}</span>
                                    </div>
                                    <span class="dot-icon" data-notif-id="{{$value->notification_user_id}}"></span>
                                    <button type="button" class="btn-close d-none" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                    <nav class="d-flex justify-content-end pagination-box">
                        {{$notifications->links("pagination::bootstrap-4")}}
                    </nav>
                </div>
            </div>
        </section>
    </main>
    <style>
        .notifications-wrapper a {
            text-decoration: none;
        }
    </style>
    <script>
        jQuery(document).ready(function () {
            $('.dot-icon').on('click', function (e) {
                e.preventDefault();
                var currentThis = $(this);
                var notifID = $(this).attr('data-notif-id');
                var formData = new FormData();
                formData.append('_token', "{{csrf_token()}}");
                formData.append('notif_id', notifID);
                $('#preloader').removeClass('d-none');
                $.ajax({
                    url: '{{ route("ReadNotificationAdmin") }}',
                    type: 'POST',
                    data: formData,
                    dataType: 'JSON',
                    success: function (response) {
                        if (response.response.detail.notif_count > 0) {
                            $('#notif-counter').html(response.response.detail.notif_count);

                        } else {
                            $('#notif-counter').remove();

                        }
                        $(currentThis).parent().removeClass('unread');
                        $('#preloader').addClass('d-none');
                    },
                    error: function (err) {
                        $('#preloader').addClass('d-none');
                        if (err.status == 422) {
                            displayError(err.responseJSON.errors, false);
                        } else {
                            displayError(err.responseJSON.error.message);
                        }
                    },
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 60000
                });
            })
        });
    </script>
@include('admin.footer')