<!DOCTYPE html>
<html >
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width,initial-scale=1'>
<style>

        /* What it does: Remove spaces around the email design added by some email clients. */
    /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
        margin: 0 auto !important;
        padding: 0 !important;
        height: 100% !important;
        width: 100% !important;
        background: #fff;
    }

    /* What it does: Stops email clients resizing small text. */
    * {
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
    }

    /* What it does: Centers email on Android 4.4 */
    div[style*='margin: 16px 0'] {
        margin: 0 !important;
    }

    /* What it does: Stops Outlook from adding extra spacing to tables. */
    table,
    td {
        mso-table-lspace: 0pt !important;
        mso-table-rspace: 0pt !important;
    }

    /* What it does: Fixes webkit padding issue. */
    table {
        border-spacing: 0 !important;
        border-collapse: collapse !important;
        table-layout: fixed !important;
        margin: 0 auto !important;
    }

    /* What it does: Uses a better rendering method when resizing images in IE. */
    img {
        -ms-interpolation-mode:bicubic;
    }

    /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
    a {
        text-decoration: none;
    }

    /* What it does: A work-around for email clients meddling in triggered links. */
    *[x-apple-data-detectors],  /* iOS */
    .unstyle-auto-detected-links *,
    .aBn {
        border-bottom: 0 !important;
        cursor: default !important;
        color: inherit !important;
        text-decoration: none !important;
        font-size: inherit !important;
        font-family: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
    }

    /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
    .a6S {
        display: none !important;
        opacity: 0.01 !important;
    }

    /* What it does: Prevents Gmail from changing the text color in conversation threads. */
    .im {
        color: inherit !important;
    }

    /* If the above doesn't work, add a .g-img class to any image in question. */
    img.g-img + div {
        display: none !important;
    }

    /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
    /* Create one of these media queries for each additional viewport size you'd like to fix */

    /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
    @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
        u ~ div .email-container {
            min-width: 320px !important;
        }
    }
    /* iPhone 6, 6S, 7, 8, and X */
    @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
        u ~ div .email-container {
            min-width: 375px !important;
        }
    }
    /* iPhone 6+, 7+, and 8+ */
    @media only screen and (min-device-width: 414px) {
        u ~ div .email-container {
            min-width: 414px !important;
        }
    }

            h1,h2,h3,h4,h5,h6{
        font-family: 'Work Sans', sans-serif;
        color: #000000;
        margin-top: 0;
        
    }

    body{
        font-family: 'Work Sans', sans-serif;
        
        font-size: 15px;
        line-height: 1.5;
        
    }
        .product-entry{
            display: block;
            position: relative;
            float: left;
            
            }
        .top-content h5, h4{
            margin-bottom:0px;
        }
        .content{
        margin:10px;
        }
        h4{
        font-size:16px;
        }
        .text{
        font-size: 14px;
        text-align:left;
        }
        .td-column{
        min-width:50px !important;
        max-width:100px !important;
        }
        .tr-bg{
            background:#dfdfdf;
        
        }
        </style>


            </head>
            <body>
            <div style=' max-width: 700px; margin: 0 auto; border: 1px solid  #f1f1f1 ;' class='email-container'>{!!$title!!}
                
            <br/>
            <div class='content'>
                <div class='top-content'><center>
                        <h4>{!!$hotel->name!!}</h4>
                        <h4>{!!$agencyname!!} (Booking-confirmation)</h4>
                        <h4>Res ID: {{$bookingCode}}</h4>
                        <h4>Last Update: {{$lastupdate}}</h4>
                    </center>
                </div>
                <br/>
                <div>
                    <table class='bg_white' role='presentation' border='0' cellpadding='0' cellspacing='0' width='100%'>
                        <tr>
                        <td valign='middle' width='45%' style='text-align:left; '>
                            <div class='top-content'><h4>Reservation General Information</h4></div>
                        </td>
                        <td valign='middle' width='45%' style='text-align:right; '>
                            <div> <h4>Accommodation Amount: {{$totalAmount}}</h4></div>
                        </td>
                        </tr>
                    </table>
                </div>
                <hr>
                <div>
                    <table class='bg_white' role='presentation' border='0' cellpadding='0' cellspacing='0' width='100%'>
                
                    <tr>
                        <td width='45%' style='text-align:left; '>

                        <div class='product-entry'>
                        <div class='text'><b>Rooms, Pax: </b>{{$pax}}</div>
                        <div class='text'><b>Booked By: </b>{!!$name!!}</div>
                        <div class='text'><b>Zip Code: </b>{!!$zip!!}</div>
                        <div class='text'><b>Country, City: </b> {!!$countryName!!}, {!!$city!!}</div>
                        </div>
                        </td>
                        <td width='45%' style='text-align:right;'>
                        <div class='product-entry'>
                        <div class='text'><b>Telephone: </b>{{$phone}}</div>
                        <div class='text'><b>Email: </b>{{$email}}</div>
                        <div class='text'><b>Address: </b> {!!$address!!}</div>
                        </div>
                        </td>
                    </tr>
                </table>

                </div>
                <hr>
                <div>
                <h4>Room Type: {{$roomtypeString}} </h4>
                </div>
                <hr>
                <div>
                <div>
                    <div class='text'><b>Guest Info: </b>{{$guestInfo}}</div>
                    <div class='text'><b>Commission: </b>{{$commission}}</div>
                    <div class='text'>
                        <table role='presentation' border='0' cellpadding='0' cellspacing='0' width='100%'>
                        {!!$rateLevel!!}
                    </table>
                    
                    </div>

            </div>
            </div>
            </div>
            <br>
        </div>
    </body>

</html>