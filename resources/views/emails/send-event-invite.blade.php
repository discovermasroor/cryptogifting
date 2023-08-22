<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-type" content="text/html; charset-utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://discoveritech.org/crypto-gifting-front-end/assets/images/favicon.png" type="image/png"
        rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <title>Gifter Flow</title>
    <style type="text/css">
        @media screen and (max-width: 600px) {
            .content td {
                padding: 0px 40px !important;
            }
        }

        @media screen and (max-width: 450px) {
            .content td {
                padding: 0px 15px !important;
            }

            .logo .h1 {
                font-size: 32px !important;
            }
        }
    </style>
</head>

<body style="Margin:0;padding:0;">
    <center class="wrapper"
        style="width:100%;table-layout:fixed;background-color:#fff;padding-top:20px;padding-bottom:20px;">
        <div class="webkit" style="max-width:700px;background-color:#fff;">
            <table class="outer" align="center"
                style="font-family:'Poppins', sans-serif;Margin:0 auto;width:100%;max-width:700px;border-spacing:0;color:#000;">
                <tbody style="min-width:100%;min-width:100% !important;border:5px solid green !important;">
                    <!-- Banner Image -->
                    <tr style="min-width:100% !important;">
                        <td align="center" style="min-width:100%;padding:0;">
                            <table style="width:100%;border-spacing:0;font-family:'Poppins', sans-serif;">
                                <tbody
                                    style="min-width:100%;min-width:100% !important;border:5px solid green !important;">
                                    <tr style="min-width:100% !important;">
                                        <td align="center" class="banner-img" style="min-width:100%;padding:0;">
                                            <img src="https://discoveritech.org/crypto-gifting-front-end/email/banner-img.png"
                                                style="border:0;width:100%;max-width:100%;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <!-- Banner Image Ends -->
                    <!-- Main Content -->
                    <tr style="min-width:100% !important;">
                        <td style="min-width:100%;padding:0;">
                            <table class="content"
                                style="width:100%;border-spacing:0;font-family:'Poppins', sans-serif;">
                                <tbody
                                    style="min-width:100%;min-width:100% !important;border:5px solid green !important;">
                                    <tr style="min-width:100% !important;">
                                        <td class="logo" style="min-width:100%;padding:0;padding:0px 50px;">
                                            <p class="h1"
                                                style="color:#242021;font-size:14px;font-weight:400;color:#1947A1;font-weight:600;text-align:center;font-size:42px;margin:20px auto;">
                                                CryptoGifting</p>
                                        </td>
                                    </tr>
                                    <!-- <tr style="min-width:100% !important;">
                                        <td class="person-title" style="min-width:100%;padding:0;padding:0px 50px;">
                                            <h3 style="color:#242021;font-weight:600;">Hi <span
                                                    class="name">Georgios</span>
                                            </h3>
                                        </td>
                                    </tr> -->
                                    <tr style="min-width:100% !important;">
                                        <td style="min-width:100%;padding:0;padding:0px 50px;">
                                            <p style="color:#242021;font-size:14px;font-weight:400;">
                                                You have been cordially invited to celebrate this special occasion with
                                                <a href="#" style="font-weight:700;color:#1947A1 !important;">{{$event->event_creator->first_name}} {{$event->event_creator->last_name}}</a> who has entrusted CryptoGifting to
                                                provide an easy-to-gift experience.
                                            </p>
                                            <p style="color:#242021;font-size:14px;font-weight:400;">
                                                <a href="{{route('EventPreviewForGuest', [$event->event_id])}}"
                                                    style="font-weight:700;color:#1947A1 !important;">Click
                                                    here</a> to access your invite and let them know that
                                                you will be attending by selecting the option to RSVP on the invite.
                                            </p>
                                        </td>
                                    </tr>
                                    <tr style="min-width:100% !important;">
                                        <td class="to-crypto" style="min-width:100%;padding:0;padding:0px 50px;">
                                            <p class="h6"
                                                style="color:#242021;font-size:14px;font-weight:400;font-weight:700;">
                                                Team CryptoGifting <br>
                                                Making Gifting Crypto Easy
                                            </p>
                                        </td>
                                    </tr>
                                    <tr style="min-width:100% !important;">
                                        <td class="questions"
                                            style="min-width:100%;padding:0;padding:0px 50px;padding-bottom:20px !important;">
                                            <p style="color:#242021;font-size:14px;font-weight:400;">
                                                CryptoGifting makes inviting guests and receiving gifts easy with just a
                                                few clicks. Want to know more? <a href="{{route('Index')}}"
                                                    style="font-weight:700;color:#1947A1 !important;">Click here</a>
                                            </p>
                                            <p style="color:#242021;font-size:14px;font-weight:400;">
                                                Question? <a href="{{route('Help')}}"
                                                    style="font-weight:700;color:#1947A1 !important;">Click here</a> to
                                                visit our Help Page
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <!-- Main Content Ends -->
                    <!-- Footer -->
                    <tr style="min-width:100% !important;">
                        <td class="footer"
                            style="min-width:100%;padding:0;background-image:linear-gradient(to right, #1D2D81, #1A47A2);text-align:center;">
                            <table style="width:100%;border-spacing:0;font-family:'Poppins', sans-serif;">
                                <tbody
                                    style="min-width:100%;min-width:100% !important;border:5px solid green !important;">
                                    <tr style="min-width:100% !important;">
                                        <td align="center" style="min-width:100%;padding:0;">
                                            <p
                                                style="color:#fff;text-align:center !important;Margin-bottom:0px !important;">
                                                Contact us on</p>
                                        </td>
                                    </tr>
                                    <tr style="min-width:100% !important;">
                                        <td align="center" class="social-icons"
                                            style="min-width:100%;padding:0;padding-bottom:15px;">
                                            <p
                                                style="color:#fff;text-align:center !important;Margin-bottom:0px !important;">
                                                <a href="https://www.facebook.com/CryptoGifting" class="social"
                                                    style="display:inline-block;Margin:0px 5px;font-size:0;">
                                                    <img src="https://discoveritech.org/crypto-gifting-front-end/email/icon-fb.png"
                                                        style="border:0;">
                                                </a>
                                                <a href="#" class="social"
                                                    style="display:inline-block;Margin:0px 5px;font-size:0;">
                                                    <img src="https://discoveritech.org/crypto-gifting-front-end/email/icon-whatsapp.png"
                                                        style="border:0;">
                                                </a>
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <!-- Footer Ends-->
                </tbody>
            </table>
        </div>
    </center>
</body>

</html>