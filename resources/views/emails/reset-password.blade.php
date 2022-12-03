<html>
<head>
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }

        .main_body {
            font-family: 'Poppins', sans-serif;
            background-color: #cdcdd0;
            margin: 0;
            padding-left: 20px;
            padding-right: 20px;
            -webkit-font-smoothing: antialiased;
            width: 100% !important;
            -webkit-text-size-adjust: none;
        }
    </style>
</head>
<body class="main_body">
<table class="wrapper" align="center" role="presentation">
    <tr>
        <td>
            <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation"
                   style=" margin: 0; padding: 0; width: 100%;">
                <tr>
                    <td class="header"
                        style="position: relative; padding: 25px 0; text-align: center;">
                        <a href="{{route('home')}}"
                           style="position: relative; color: #3d4852; font-size: 19px; font-weight: bold; text-decoration: none; display: inline-block;">
                            <img alt='logo' style='width:209px;height:65px;'
                                 src='https://live.hotelpoint.gr/images/logo/logo.png'/>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="body" width="100%" cellpadding="0" cellspacing="0"
                        style=" background-color: #edf2f7; border-bottom: 1px solid #edf2f7; border-top: 1px solid #edf2f7; margin: 0; padding: 0; width: 100%;">
                        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0"
                               role="presentation"
                               style="background-color: #ffffff; border-color: #e8e5ef; border-radius: 2px; border-width: 1px; box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015); margin: 0 auto; padding: 0; width: 570px;">
                            <tr>
                                <td class="content-cell"
                                    style="position: relative; max-width: 100vw; padding: 32px;">
                                    <h1 style="position: relative; color: #3d4852; font-size: 18px; font-weight: bold; margin-top: 0; text-align: left;">
                                        Hello {{$user_name}}</h1>
                                    <p style="position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                        You are receiving this email because we received a password reset request for
                                        your account.</p>
                                    <table class="action" align="center" width="100%" cellpadding="0" cellspacing="0"
                                           role="presentation"
                                           style=" margin: 30px auto; padding: 0; text-align: center; width: 100%;">
                                        <tr>
                                            <td align="center">
                                                <table width="100%" border="0" cellpadding="0" cellspacing="0"
                                                       role="presentation">
                                                    <tr>
                                                        <td align="center">
                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                   role="presentation">
                                                                <tr>
                                                                    <td>
                                                                        <a href="{{$url}}"
                                                                           class="button button-primary" target="_blank"
                                                                           style="padding:12px;border-radius:5px;text-decoration:none;margin-top:100px;background-color:#48BBBE;color:white;font-weight:bold;">
                                                                            Reset Password</a>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <p style="position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                        This password reset link will expire in 60 minutes.</p>
                                    <p style="position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                        If you did not request a password reset, no further action is required.</p>
                                    <p style="position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                        Regards,<br>
                                        HotelPoint</p>
                                    <table class="subcopy" width="100%" cellpadding="0" cellspacing="0"
                                           role="presentation"
                                           style="position: relative; border-top: 1px solid #e8e5ef; margin-top: 25px; padding-top: 25px;">
                                        <tr>
                                            <td>
                                                <p style="position: relative; line-height: 1.5em; margin-top: 0; text-align: left; font-size: 14px;">
                                                    If you're having trouble clicking the "Reset Password" button, copy
                                                    and paste the URL below
                                                    into your web browser:
                                                    <span class="break-all"
                                                          style="position: relative; word-break: break-all;">
                                                        <a href="{{$url}}" style="position: relative; color: #3869d4;">
                                                            {{$url}}
                                                        </a>
                                                    </span>
                                                </p>

                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0"
                               role="presentation"
                               style="margin: 0 auto; padding: 0; text-align: center; width: 570px;">
                            <tr>
                                <td class="content-cell" align="center"
                                    style="position: relative; max-width: 100vw; padding: 32px;">
                                    <p style="position: relative; line-height: 1.5em; margin-top: 0; color: #b0adc5; font-size: 12px; text-align: center;">
                                        © 2022 HotelPoint. All rights reserved.</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
