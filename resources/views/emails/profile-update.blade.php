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
                                            <td class="person-title" style=" min-width:100%;padding:0;padding:0px 70px;">
                                                <?php if (!empty($user->first_name) && !empty($user->last_name)) { ?>
                                                    <h3 class="my-0" style="color:#242021;font-weight:600;">Hi <span class="name">{{$user->first_name}} {{$user->last_name}}</span>

                                                <?php } else { ?>
                                                    <h3 class="my-0" style="color:#242021;font-weight:600;">Hi <span class="name">{{$user->username}}</span>

                                                <?php } ?>
                                                </h3>
                                            </td>
                                        </tr>
                                        <tr style="min-width:100% !important;">
                                            <td class="signin-pin" style="min-width:100%;padding:0;padding:0px 70px;">
                                                <p class="my-0" style="margin-top:0 !important;color:#242021;font-size:14px;font-weight:400;">You have successfully changed your profile name on your CryptoGifting.com account.</p>
                                            </td>
                                        </tr>
                                        
                                        <tr style="min-width:100% !important;">
                                            <td class="signin-pin" style="min-width:100%;padding:0;padding:0px 70px;">
                                                <p class="my-0" style="margin-top:0 !important; color:#242021;font-size:14px;font-weight:400;">Don't recognise this activity?.</p>
                                            </td>
                                        </tr>
                                        <tr style="min-width:100% !important;">
                                            <td class="signin-pin" style="min-width:100%;padding:0;padding:0px 70px;">
                                                <p class="my-0" style="margin-top:0 !important; color:#242021;font-size:14px;font-weight:400;"><a href="{{route('ContactUs')}}">Click here </a> to lock your account immediately.</p>
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