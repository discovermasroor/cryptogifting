<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-type" content="text/html; charset-utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <title>CryptoGifting</title>
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
<?php
    if ($contact_us->contact_us) {
        $message = 'Someone has filled in the "Contact Us" Form on the website';

    } else if ($contact_us->loyalty_program) {
        $message = 'Someone just fillup the loyalty program form on our website!';

    } else if ($contact_us->feedback) {
        $message = 'Someone has filled in the “Give us Feedback” Form on the website';

    } else {
        $message = 'Someone has filled in the Affiliate Program Form on the website';

    }

?>
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
                                        <td class="logo" style="min-width:100%;padding:0;padding:0px 70px;">
                                            <p class="h1"
                                                style="color:#242021;font-size:14px;font-weight:400;color:#1947A1;font-weight:600;text-align:center;font-size:42px;margin:20px auto;">
                                                CryptoGifting</p>
                                        </td>
                                    </tr>
                                    <tr style="min-width:100% !important;">
                                        <td class="person-title" style="min-width:100%;padding:0;padding:0px 70px;">
                                            <h3 style="color:#242021;font-weight:600;">Hello <span class="name"><?php echo $contact_us->email; ?></span>
                                            </h3>
                                        </td>
                                    </tr>
                                    <tr style="min-width:100% !important;">
                                        <td class="signin-pin" style="min-width:100%;padding:0;padding:0px 70px;">
                                            <p style="color:#242021;font-size:14px;font-weight:400;">We would like to inform you that we have received your email and you have now officially joined the whitelist for our loyalty program that is due for launch in 2022</p>
                                        </td>
                                    </tr>
                                    <tr style="min-width:100% !important;">
                                        <td class="details" style="min-width:100%;padding:0;padding:0px 70px;">
                                            <p style="color:#242021;font-size:14px;font-weight:400;width:100%;max-width:85%;">Email: <?php echo $contact_us->email; ?></p>
                                            <p style="color:#242021;font-size:14px;font-weight:400;width:100%;max-width:85%;">Date: <?php echo date('Y-m-d'); ?></p>
                                            <p style="color:#242021;font-size:14px;font-weight:400;width:100%;max-width:85%;">Time: <?php echo date('H:i:s'); ?></p>
                                            <?php if ($contact_us->submitted_user_id) { ?>
                                                <p style="color:#242021;font-size:14px;font-weight:400;width:100%;max-width:85%;">User ID: {{$contact_us->submitted_user_id}}</p>

                                            <?php } ?>
                                            <p style="color:#242021;font-size:14px;font-weight:400;width:100%;max-width:85%;">Submitted by login user: <?php if ($contact_us->login_or_not) echo 'Yes'; else echo 'No'; ?></p>
                                           
                                            <p style="color:#242021;font-size:14px;font-weight:400;width:100%;max-width:85%;">Topic: <?php echo $contact_us->topic; ?></p>
                                            <p style="color:#242021;font-size:14px;font-weight:400;width:100%;max-width:85%;">Subject: <?php echo $contact_us->subject; ?></p>
                                            <p style="color:#242021;font-size:14px;font-weight:400;width:100%;max-width:85%;">Message: <?php echo $contact_us->description; ?></p>
                                           
                                        </td>
                                    </tr>
                                    <tr style="min-width:100% !important;">
                                        <td class="signin-pin" style="min-width:100%;padding:0;padding:0px 70px;">
                                            <p style="color:#242021;font-size:14px;font-weight:400;">At CryptoGitfing.com, we are working hard at creating an unprecedented loyalty program that will reward you for using our platform.</p>
                                        </td>
                                    </tr>
                                    <tr style="min-width:100% !important;">
                                        <td class="signin-pin" style="min-width:100%;padding:0;padding:0px 70px;">
                                            <p style="color:#242021;font-size:14px;font-weight:400;">So, start sharing it with friends and family through all of our favourite communication channels including email, WhatsApp and Facebook.</p>
                                        </td>
                                    </tr>
                                    <tr style="min-width:100% !important;">
                                        <td class="signin-pin" style="min-width:100%;padding:0;padding:0px 70px;">
                                            <p style="color:#242021;font-size:14px;font-weight:400;">Do you have any questions? <a href="{{route('ContactUs')}}">Click here</a> to send us an email via our Contact Us form.</p>
                                        </td>
                                    </tr>
                                    <tr style="min-width:100% !important;">
                                            <td class="signin-pin" style="min-width:100%;padding:0;padding:0px 70px;">
                                                <p class="my-0" style="margin-top:0 !important; color:#242021;font-size:14px;font-weight:400;">Don't recognise this activity?.</p>
                                            </td>
                                        </tr>
                                        <tr style="min-width:100% !important;">
                                            <td class="signin-pin" style="min-width:100%;padding:0;padding:0px 70px;">
                                                <p class="my-0" style="margin-top:0 !important; color:#242021;font-size:14px;font-weight:400;"><a href="{{route('ContactUs')}}">Click here </a> to secure your account immediately or to let us know if your email address is used without your consent.</p>
                                            </td>
                                        </tr>
                                        <tr style="min-width:100% !important;">
                                            <td class="signin-pin" style="min-width:100%;padding:0;padding:0px 70px;">
                                                <p class="my-0" style="margin-top:0 !important; color:#242021;font-size:14px;font-weight:400;">Thanks</p>
                                            </td>
                                        </tr>
                                        <tr style="min-width:100% !important;">
                                            <td class="signin-pin" style="min-width:100%;padding:0;padding:0px 70px;">
                                                <p class="my-0" style="margin-top:0 !important; color:#242021;font-size:14px;font-weight:400;">Team CryptoGifting</p>
                                            </td>
                                        </tr>
                                        <tr style="min-width:100% !important;">
                                            <td class="signin-pin" style="min-width:100%;padding:0;padding:0px 70px;">
                                                <p class="my-0" style="margin-top:0 !important; color:#242021;font-size:14px;font-weight:400;">Questions? Learn more about <a href="{{route('ContactUs')}}">securing your account </a></p>
                                            </td>
                                        </tr>
                                   
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </center>
</body>

</html>