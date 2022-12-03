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
   .product-entry .text{
     
     padding-left: 15px;
   }
   .product-entry .text h3{
     margin-bottom: 0;
     padding-bottom: 0;
     margin-top:0px;
     
   }
   .product-entry .text p{
     margin-top: 0;
   }
   .product-entry i, .product-entry .text{
     float: left;
   }
   h1{
     font-size:1.6em !important;
   }
   .btn {
       font-size: 14px;
       padding: 12px 40px;
       margin-bottom: 0;

       display: inline-block;
       text-decoration: none;
       text-align: center;
       white-space: nowrap;
       vertical-align: middle;
       -ms-touch-action: manipulation;
       touch-action: manipulation;
       cursor: pointer;
       -webkit-user-select: none;
       -moz-user-select: none;
       -ms-user-select: none;
       user-select: none;
       background-image: none;
       border: 1px solid transparent;
   }
   .btn:focus,
   .btn:active:focus {
       outline: thin dotted;
       outline: 5px auto -webkit-focus-ring-color;
       outline-offset: -2px;
   }
   .btn:hover,
   .btn:focus {
       color: #333;
       text-decoration: none;
   }
   .btn:active {
       background-image: none;
       outline: 0;
       -webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
       box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
   }
   .btn-success {
     background: #087830;
     color: #ffffff;
   }

   .btn-success:hover {
     background: #006b3c;
     color: #ffffff;
     cursor:pointer;
   }
   .btn-default {
     background: #f1f1f1;
     color: #000000;
   }

   .btn-default:hover {
     background: #dfdfdf;
     color: #000000;
     cursor:pointer;
   }
   p{
      color: #000000 !important;
   }


   </style>


   </head>

   <body>
    <div style=' max-width: 700px; margin: 0 auto; border: 1px solid  #f1f1f1 ;' class='email-container'>
    <div style='background:#48BBBE; color:white; padding:10px 0px; font-size:20px; '><center>Booking Offer</center></div>
    <div style=' margin: 20px;' >
    
    <p style='font-size:1.8em;'>Dear {{ $data['guest']->full_name }},</p><p>We would like to thank you for your interest in {{$data['hotel_details']->name}} .</p>
         <p>Further to your enquiry, we are delighted to confirm availability as follows:<br/>
      <h1>Booking offer number: # {{ $data['reservation']->booking_code }}.</h1><br/>

      <table class='bg_white' role='presentation' border='0' cellpadding='0' cellspacing='0' width='100%'>
 
       <tr>
        <td valign='middle' width='45%' style='text-align:left; '>

          <div class='product-entry'>
           <div class='text'><h3>Your Booking Offer:</h3><p>{{ $data['nights'] }} Nights, {{ $data['room_type'] }}{{-- , {{ $mealdesc }} --}}</p></div>
           </div>
       </td>
       <td valign='middle' width='45%' style='text-align:left;'>
           <div class='product-entry'>
           <div class='text'><h3>Group:</h3><p>Adults: {{ $data['reservation']->adults }}, Children: {{ $data['reservation']->kids }}, Infants: {{ $data['reservation']->infants }}</p></div>
           </div>
        </td>
     </tr>
       
     <tr>
       <td valign='middle' width='45%' style='text-align:left; '>
         <div class='product-entry'>
         <div class='text'><h3>Check in:</h3><p>{{ date('l', strtotime($data['reservation']->check_in)) }}, {{ date('F', strtotime($data['reservation']->check_in)) }} {{ date('d', strtotime($data['reservation']->check_in)) }}, {{ date('Y', strtotime($data['reservation']->check_in)) }}</p></div>
         </div>
       </td>

       <td valign='middle' width='45%' style='text-align:left;'>
         <div class='product-entry'>
         <div class='text'><h3>Check out:</h3><p >{{ date('l', strtotime($data['reservation']->check_out)) }}, {{ date('F', strtotime($data['reservation']->check_out)) }} {{ date('d', strtotime($data['reservation']->check_out)) }}, {{ date('Y', strtotime($data['reservation']->check_out)) }}</p></div>
         </div>
       </td>
     </tr>
 </table>
       <br/><br/>

       <table width='100%'>
       <tr>
       <td style='text-align:left; width:50%;'>
       price of booking offer
       </td>
       <td style='text-align:right; width:50%;'>{{ $data['total_price'] }}</td>
       </tr>
       <tr>
       <td style='text-align:left; width:50%;'> {{ $data['vat'] }}% VAT is included </td>
       </tr>
       <tr>
       <td style='text-align:left; width:50%;'> {{ $data['hotel_details']->city_tax }}% city tax is included</td>
       </tr>
       <tr>
       <td style='text-align:left; width:50%; font-size:24px; '><b> Total Price</b> </td>
       <td style='text-align:right; width:50%; font-size:24px;'> <b> {{ $data['total_price'] }} </b></td>
       </tr>
       </table>
       <br/><hr><br/>

       @php
       if ($data['rateType']->rate_type_cancellation_policy->name=='Based At Nights') {
	       	   $cancellationText="In case of cancellation of reservation within ".$data['rateType']->cancellation_charge_days." days before the arrival, you will be charged sum of ".$data['rateType']->cancellation_charge." nights accomodation.";
       }elseif ($data['rateType']->rate_type_cancellation_policy->name=='Based At Percent') {
	       	   $cancellationText="In case of cancellation of reservation within ".$data['rateType']->cancellation_charge_days." days before the arrival, you will be charged ".$data['rateType']->cancellation_charge."% of accomodation.";
       }else{
	       	   $cancellationText="In case of cancellation of reservation within ".$data['rateType']->cancellation_charge_days." days before the arrival, you will be charged ".showPriceWithCurrency($data['rateType']->cancellation_charge).".";
	       
       }
       @endphp

       <h1>Cancellation Policy</h1>
       <p>
         {{$cancellationText}}
       </p><br/>
       
       <h1>Prepayment</h1>
       @if($data['rateType']->prepayment>0)
       <p>Payment of {{ $data['rateType']->prepayment }}% is required at the time of booking. </p><br/>
       @else
       <p>No Prepayment</p>
       @endif

       <h1>First Charge</h1>
       @if($data['rateType']->charge>0)
         <p>Payment of {{ $data['rateType']->charge }}% is required {{$data['rateType']->reservation_charge_days}} days before arrival.</p><br/>
       @else
         <p>No First Charge</p></br>
       @endif

       <h1>Second Charge </h1>
       @if($data['rateType']->charge2>0)
         <p>Payment of {{ $data['rateType']->charge2 }}% is required {{$data['rateType']->reservation_charge_days_2}} days before arrival.</p><br/>
       @else
         <p>No Second Charge</p>
       @endif

      

       <p>This offer is valid upto {{ $data['expire'] }} <br/> To confirm it please press the corresponding button.</p>

       <h3>Below are our banking details.</h3>

      <p>Bank Name: {{ $data['hotel_details']->bank_name }} </p>
      <p>Swift Code: {{ $data['hotel_details']->swift_code }} </p>
      <p>IBAN: {{ $data['hotel_details']->iban }} </p>


       <div style='text-align:center;'>
       <a style='margin:auto;' href="{{ $data['accept_url'] }}" ><button type='button' class='btn btn-success'>Confirm Offer</button></a>
       <a style='margin:auto;' href="{{ $data['reject_url'] }}" ><button type='button' class='btn btn-default'>Decline Offer</button></a>
       </div>
       <br/>
       </div>
       </div>
       <br/>
       </body>
       </html>
