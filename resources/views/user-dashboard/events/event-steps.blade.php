<div class="progress-link-wrapper">
    <nav class="nav">
        <a class="nav-link <?php if (Route::current()->getName() == 'SelectBeneficiariesForEvent' || Route::current()->getName() == 'CreateEvent' || Route::current()->getName() == 'ThemeSelection' || Route::current()->getName() == 'AddDetailsForEvent' || Route::current()->getName() == 'ShareEventView' || Route::current()->getName() == 'EventPreviewSelf') echo 'active'; ?>" href="#"> <span>(a)</span> Choose Beneficiary</a>
        <a class="nav-link <?php if (Route::current()->getName() == 'CreateEvent' || Route::current()->getName() == 'ThemeSelection' || Route::current()->getName() == 'AddDetailsForEvent' || Route::current()->getName() == 'ShareEventView' || Route::current()->getName() == 'EventPreviewSelf') echo 'active'; ?>" href="#"> <span>(b)</span> Create Event</a>
        <a class="nav-link  <?php if (Route::current()->getName() == 'ThemeSelection' || Route::current()->getName() == 'AddDetailsForEvent' || Route::current()->getName() == 'ShareEventView' || Route::current()->getName() == 'EventPreviewSelf') echo 'active'; ?>" href="#"> <span>(c)</span> Theme Card</a>
        <a class="nav-link  <?php if (Route::current()->getName() == 'AddDetailsForEvent' || Route::current()->getName() == 'ShareEventView' || Route::current()->getName() == 'EventPreviewSelf') echo 'active'; ?>" href="#"> <span>(d)</span> Event Info</a>
        <a class="nav-link  <?php if (Route::current()->getName() == 'ShareEventView' || Route::current()->getName() == 'EventPreviewSelf') echo 'active'; ?>" href="#"> <span>(f)</span> Share Event</a>
        <a class="nav-link  <?php if (Route::current()->getName() == 'ShareEventView' || Route::current()->getName() == 'EventPreviewSelf') echo 'active'; ?>" href="#"> <span>(f)</span> Select Guest List</a>
        <a class="nav-link  <?php if (Route::current()->getName() == 'EventPreviewSelf') echo 'active'; ?>" href="#"> <span>(g)</span> Preview & Send</a>
    </nav>
</div>