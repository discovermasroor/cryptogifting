@include('head')
    <title>Cookies Policy | Crypto Gifting</title>
    <body>
        @include('home-header')
        <main class="contact-page">
        <section class="cookie-settings">
            <div class="container">
                <h1 class="second-heading">Website cookie Policy</h1>
                <p class="p1">
                    We use data collected by cookies and JavaScript libraries to improve your browsing experience,
                    analyse site traffic, and increase the overall performance of our site.
                </p>

                <form action="">
                    <div class="table-responsive table-design mb-0 cookies-table">
                        <table class="table">
                            <thead>
                                <tr>
                                <?php if (request()->user) { ?> <th>allow </th> <?php } ?>
                                    <th>category</th>
                                    <th>purpose</th>
                                    <th>tools</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php if (request()->user) { ?>
                                        <td class="functional-checks">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="functional"
                                                    id="functional-1" value="yes">
                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="functional"
                                                    id="functional-2" value="no">
                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                            </div>
                                        </td>
                                    <?php } ?>
                                    <td class="border">
                                        Functional
                                    </td>
                                    <td class="border">
                                        To monitor the performance of our site and to
                                        enhance your browsing experience. For example, these tools enable you to
                                        communicate with us via live chat.
                                    </td>
                                    <td rowspan="4" class="border">
                                        Amplitude, Google Analytics, LaunchDarkly Events
                                    </td>
                                </tr>
                                <tr>
                                    <?php if (request()->user) { ?>
                                        <td class="marketing-checks">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="marketing"
                                                    id="marketing-1" value="yes">
                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="marketing"
                                                    id="marketing-2" value="no">
                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                            </div>
                                        </td>
                                    <?php } ?>

                                    <td class="border">
                                        Marketing & Analytics
                                    </td>
                                    <td class="border">
                                        To understand user behavior in order to provide you with a more relevant
                                        browsing experience or personalize the content on our site. For example, we
                                        collect information about which pages you visit to help us present more relevant
                                        information.
                                    </td>
                                </tr>
                                <tr>
                                    <?php if (request()->user) { ?>
                                        <td class="advertising-checks">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="advertising"
                                                    id="advertising-1" value="yes">
                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="advertising"
                                                    id="advertising-2" value="no">
                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                            </div>
                                        </td>
                                    <?php } ?>
                                    <td class="border">Advertising</td>
                                    <td class="border">
                                        To personalize and measure the effectiveness of advertising on our site and
                                        other websites. For example, we may serve you a personalized ad
                                        based on the pages you visit on our site.
                                    </td>
                                </tr>
                                <tr>
                                    <?php if (request()->user) { ?>
                                        <td>
                                            <span>N/A</span>
                                        </td>
                                    <?php } ?>
                                    <td class="border">Essential</td>
                                    <td class="border">
                                        We use browser cookies that are necessary for the site to work as intended. For
                                        example, we store your website data collection preferences so we can honor them
                                        if you return to our site. You can disable these cookies in your browser
                                        settings but if you do the site may not work as intended.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <script>
        jQuery(document).ready(function($) {
            var functionalChecks = getCookie('functional_checks');
            var marketingChecks = getCookie('marketing_checks');
            var advertisingChecks = getCookie('advertising_checks');
            if (functionalChecks != "" && functionalChecks != undefined) {
                if (functionalChecks == 'yes') {
                    $("#functional-1").prop("checked", true);

                } else {
                    $("#functional-2").prop("checked", true);

                }
            } else {
                $("#functional-1").prop("checked", true);
                document.cookie = "functional_checks=yes";

            }
            if (marketingChecks != "" && marketingChecks != undefined) {
                if (marketingChecks == 'yes') {
                    $("#marketing-1").prop("checked", true);

                } else {
                    $("#marketing-2").prop("checked", true);

                }
            } else {
                $("#marketing-1").prop("checked", true);
                document.cookie = "marketing_checks=yes";

            }

            if (advertisingChecks != "" && advertisingChecks != undefined) {
                if (advertisingChecks == 'yes') {
                    $("#advertising-1").prop("checked", true);

                } else {
                    $("#advertising-2").prop("checked", true);

                }
            } else {
                document.cookie = "advertising_checks=yes";
                $("#advertising-1").prop("checked", true);

            }

            $('.functional-checks input[type="radio"]').on('click', function (e) {
                if ($(this).val() == 'yes') {
                    document.cookie = "functional_checks=yes";

                } else {
                    document.cookie = "functional_checks=no";

                }
            });

            $('.marketing-checks input[type="radio"]').on('click', function (e) {
                if ($(this).val() == 'yes') {
                    document.cookie = "marketing_checks=yes";

                } else {
                    document.cookie = "marketing_checks=no";

                }
            });

            $('.advertising-checks input[type="radio"]').on('click', function (e) {
                if ($(this).val() == 'yes') {
                    document.cookie = "advertising_checks=yes";

                } else {
                    document.cookie = "advertising_checks=no";

                }
            });
            function getCookie(cname) {
                let name = cname + "=";
                let decodedCookie = decodeURIComponent(document.cookie);
                let ca = decodedCookie.split(';');
                for(let i = 0; i <ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                    }
                }
                return "";
            }
        });
    </script>
@include('footer')