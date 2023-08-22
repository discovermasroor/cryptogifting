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
                                            <h3 style="color:#242021;font-weight:600;">Hello <span class="name">{{ucfirst($gift_info->recipient_name)}}</span>
                                            </h3>
                                        </td>
                                    </tr>
                                    <tr style="min-width:100% !important;">
                                        <td class="signin-pin" style="min-width:100%;padding:0;padding:0px 70px;">
                                            <p style="color:#242021;font-size:14px;font-weight:400;">You have received BTC {{number_format($gift_info->gift_btc_amount, 10)}} from {{ucfirst($gift_info->sender_name)}} who used CryptoGifting.com to send you the Gift of crypto and your Theme Card is attached to this email.</p>
                                        </td>
                                    </tr>
                                    <tr style="min-width:100% !important;">
                                        <td class="signin-pin" style="min-width:100%;padding:0;padding:0px 70px;">
                                            <p class="my-0" style="margin-top:0 !important; color:#242021;font-size:14px;font-weight:400;">The details of your transaction are as follows</p>
                                        </td>
                                    </tr>
                                    <tr style="min-width:100% !important;">
                                        <td class="signin-pin" style="min-width:100%;padding:0;padding:0px 70px;">
                                                <p class="my-0" style="margin-top:0 !important; color:#242021;font-size:14px;font-weight:400;">
                                                Amount (ZAR): R{{$gift_info->gift_zar_amount}} <br>
                                                Amount (BTC):  {{number_format($gift_info->gift_btc_amount, 10)}}<br>
                                                Date: <?php echo date('Y-m-d');?><br>
                                                Time: <?php echo date('H:i:s');?>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr style="min-width:100% !important;">
                                        <td class="signin-pin" style="min-width:100%;padding:0;padding:0px 70px;">
                                            <p class="my-0" style="margin-top:0 !important; color:#242021;font-size:14px;font-weight:400;">
                                            What do you need to do? Easy!</p>
                                        </td>
                                    </tr>
                                    <tr style="min-width:100% !important;">
                                        <td class="signin-pin" style="min-width:100%;padding:0;padding:0px 70px;">
                                            <p class="my-0" style="margin-top:0 !important; color:#242021;font-size:14px;font-weight:400;">
                                            <a href="{{route('RegisterGiftUser', [$gift_info->recipient_id])}}" class="web-link" style="font-weight:700;color:#1947A1 !important;">Click here</a> to sign up for your own CryptoGifting.com account and as soon as you have logged in, you will be able to access your BTC and also Create an Event which you can share with friends and family in order receive cryptocurrencies for your special occasions. </p>
                                        </td>
                                    </tr>
                                    <tr style="min-width:100% !important;">
                                            <td class="signin-pin" style="min-width:100%;padding:0;padding:0px 70px;">
                                                <p class="my-0" style="margin-top:0 !important; color:#242021;font-size:14px;font-weight:400;">Don't recognise this activity?.</p>
                                            </td>
                                        </tr>
                                        <tr style="min-width:100% !important;">
                                            <td class="signin-pin" style="min-width:100%;padding:0;padding:0px 70px;">
                                                <p class="my-0" style="margin-top:0 !important; color:#242021;font-size:14px;font-weight:400;"><a href="{{route('ContactUs')}}">Click here </a> to let us know if your email address was used without your consent..</p>
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
                                                <p class="my-0" style="margin-top:0 !important; color:#242021;font-size:14px;font-weight:400;">Questions? Visit our  <a href="{{route('Help')}}">Help Centre. </a></p>
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