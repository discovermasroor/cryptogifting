@include('admin.head')
    <title>Notifications Settings | Crypto Gifting</title>
    <body>
        @include('admin.header-sidebar')
        <div class="main-content">
            <div class="overlay">
                <div class="heading-wrapper">
                    <h1 class="main-heading">Notifications</h1>
                </div>
                <div class="card notifications-card">
                    <div class="card-body">
                        <form action="{{route('AdminNotificationsSettingsUpdate')}}" method="post" class="notifications-form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <h3 class="card-title">Account Emails</h3>
                            <hr class="underline">
                            <div class="checkbox-wrapper">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="acc-email-1"
                                        value="1" name="daily_summary" <?php if (request()->admin->daily_summary) echo 'checked'; ?>>
                                    <label class="form-check-label" for="acc-email-1">Daily Summary</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="acc-email-2"
                                        value="1" name="weekly_summary" <?php if (request()->admin->weekly_summary) echo 'checked'; ?>>
                                    <label class="form-check-label" for="acc-email-2">Weekly Summary</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="acc-email-3"
                                        value="1" name="monthly_summary" <?php if (request()->admin->monthly_summary) echo 'checked'; ?>>
                                    <label class="form-check-label" for="acc-email-3">Monthly Summary</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="acc-email-4"
                                        value="1" name="promotions" <?php if (request()->admin->promotions) echo 'checked'; ?>>
                                    <label class="form-check-label" for="acc-email-4">Promotions</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="acc-email-5"
                                        value="1" name="newsletters" <?php if (request()->admin->newsletters) echo 'checked'; ?>>
                                    <label class="form-check-label" for="acc-email-5">Newsletter</label>
                                </div>
                            </div>

                            <hr class="underline">
                            <h3 class="card-title">Every Time a Gifter...</h3>

                            <div class="checkbox-wrapper">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="gifter-1" value="1" name="opens_an_invite" <?php if (request()->admin->opens_an_invite) echo 'checked'; ?>>
                                    <label class="form-check-label" for="gifter-1">Opens an invite</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="gifter-2" value="1" name="rsvp_for_my_event" <?php if (request()->admin->rsvp_for_my_event) echo 'checked'; ?>>
                                    <label class="form-check-label" for="gifter-2">RSPVs for my event</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="gifter-3" value="1" name="process_a_gift" <?php if (request()->admin->process_a_gift) echo 'checked'; ?>>
                                    <label class="form-check-label" for="gifter-3">Processes a Gift</label>
                                </div>
                            </div>

                            <hr class="underline">
                            <h3 class="card-title">When CryptoGifting performs a task for you</h3>

                            <div class="checkbox-wrapper">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="task-1" value="1" name="resend_card" <?php if (request()->admin->resend_card) echo 'checked'; ?>>
                                    <label class="form-check-label" for="task-1">Resends card on your behalf</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="task-2" value="1" name="sends_reminder_of_event" <?php if (request()->admin->sends_reminder_of_event) echo 'checked'; ?>>
                                    <label class="form-check-label" for="task-2">Sends a reminder of the event</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="task-3" value="1" name="send_thank_you_card" <?php if (request()->admin->send_thank_you_card) echo 'checked'; ?>>
                                    <label class="form-check-label" for="task-3">Sends a post event "thank you"
                                        card</label>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mt-4">
                                <button class="blue-button btn" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Content Ends -->
    </section>
    <!-- Dashboard Main Content Ends -->
</main>
@include('admin.footer')