<!DOCTYPE html>
<html lang="">
<head>
    <title>Εκτύπωση Απόδειξης</title>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'
          integrity='sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z' crossorigin='anonymous'>
    <style>
        html {
            padding-left: 10%;
            padding-right: 10%;
        }

        body {
            font-family: firefly, DejaVu Sans, sans-serif;
        }

        .header {
            text-align: center;
            line-height: 3px;
            font-size: 10pt;
        }

        .customers {
            border-collapse: collapse;
            width: 100%;
            margin-top: 3%;
        }

        .customers td, #customers th {
            border: 0px solid #ddd;
            padding: 8px;
            color: #000;
        }

        .customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #D6D6D6;
            color: #000;
        }
    </style>
</head>
<body>
<div class='logo mb-2' style='text-align:center;'>
    <img src='{{asset($settings->logo)}}' style='width:100%; max-width:400px; max-height:100px;'>
</div>
<div class='header'>
    <p>{{$settings->brand_name}} - {{$settings->activity}}</p>
    <p>ΑΦΜ: {{$settings->tax_id}} - ΔΟΥ: ΜΥΚΟΝΟΥ </p>
    <p>ΑΓ.ΙΩΑΝΝΗΣ - TK {{$settings->tax_id}} - {{$settings->city}} - ΤΗΛ: {{$settings->phone}}</p>
    <p>{{$settings->website}} &nbsp; &nbsp; {{$settings->email}}</p>
    <h4>test</h4>
    <h4>ΑΘΕΩΡΗΤΑ ΒΑΣΕΙ ΤΗΣ ΠΟΛ Α.Υ.Ο 1083/2-6-2003</h4>
</div>
<br>
<table style='width:100%;font-size:8pt; line-height:12px;'>
    <td valign=top width=65%>
        <table style='border:none;  background-color:#D6D6D6; width:100%; height:100px;font-size:8pt;'>
            <tr>
                <td colspan=2>
                    &nbsp;&nbsp;ΕΠΩΝΥΜΙΑ:&nbsp;&nbsp;&nbsp;&nbsp; test</td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;ΤΗΛ. / Tel:&nbsp;&nbsp; test</td>
            </tr>
            <tr>
                <td colspan=2>&nbsp;&nbsp;ΕΠΑΓΓΕΛΜΑ:&nbsp;&nbsp; test</td>
            </tr>
            <tr>
                <td colspan=2>
                    &nbsp;&nbsp;ΔΙΕΥΘΥΝΣΗ:&nbsp;&nbsp;&nbsp; test</td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;ΑΦΜ / Tax ID:&nbsp; test</td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;ΔΟΥ / Tax Office:&nbsp;&nbsp; test</td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;Τ.Κ.:&nbsp;&nbsp; tezxt</td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;Πελ./Guest :&nbsp;&nbsp; asdasd</td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;ΠΛΗΡΩΜΗ:&nbsp;&nbsp; asdasd</td>
            </tr>
        </table>
    </td>
    <td valign=top>
        <div>
            <table style='width:100%; border: none;font-size:7pt;text-align:center;'>
                <tbody>
                <tr>
                    <td style='text-align:center; background-color:#d6d6d6; width:50%;'>&nbsp;&nbsp;<span
                            style='text-align:center; font-size:11pt;'>asd</span> &nbsp;
                    </td>
                    <td style='font-size:11pt;background-color:#d6d6d6;'>ada</td>
                </tr>
                <tr>
                    <td style='font-weight:bold; font-size:7pt; width:70%; '>&nbsp;<span style='text-align:right;'> Δωμάτιο    </span>
                        <span style='text-align:left;'> Room       </span></td>
                    <td>asdqw</td>
                </tr>
                <tr>
                    <td style='font-weight:bold; font-size:7pt; width:70%; '>&nbsp;<span style='text-align:right;'> Γεύματα     </span>
                        &nbsp; <span style='text-align:left;'> Meals      </span></td>
                    <td>asdasd</td>
                </tr>
                <tr>
                    <td style='font-weight:bold; font-size:7pt; width:70%; '>&nbsp;<span style='text-align:right;'>  Άφιξη      </span>
                        &nbsp; <span style='text-align:left;'> Arrival    </span></td>
                    <td> asda</td>
                </tr>
                <tr>
                    <td style='font-weight:bold; font-size:7pt; width:70%; '>&nbsp;<span style='text-align:right;'> Αναχώρηση   </span>
                        &nbsp; <span style='text-align:left;'> Departure  </span></td>
                    <td>resrar</td>
                </tr>
                <tr>
                    <td style='font-weight:bold; font-size:7pt; width:70%; '>&nbsp;<span style='text-align:right;'> Άτομα       </span>
                        &nbsp; <span style='text-align:left;'> Persons    </span></td>
                    <td>resrar</td>
                </tr>
                <tr>
                    <td style='font-weight:bold; font-size:7pt; width:70%; '>&nbsp;<span style='text-align:right;'>  Ημ.Έκδοσης </span>
                        &nbsp; <span style='text-align:left;'> Issue Date </span></td>
                    <td>resrar</td>
                </tr>

                <tr>
                    <td style='font-weight:bold; font-size:7pt; width:70%; '>&nbsp;<span style='text-align:right;'>  Χρήστης    </span>
                        &nbsp; <span style='text-align:left;'> User       </span></td>
                    <td>Reception</td>
                </tr>
                </tbody>
            </table>
        </div>
    </td>
    </tr>
</table>
<table class='customers' style='margin-bottom:5%; line-height:2px; font-size:8pt; height:auto;'>
    <tr>
        <th>Ημ/νία / Date</th>
        <th>Ποσ. / Quant.</th>
        <th>Περιγραφή / Description</th>
        <th>ΦΠΑ / VAT%</th>
        <th>Αξία / Price €</th>
    </tr>
{{--    @foreach($document->activities as $activity)--}}
        <tr>
            <td>asdqweasd</td>
            <td>asdqweasd</td>
            <td>asdqweasd</td>
            <td>asdqweasd</td>
            <td>asdqweasd</td>
        </tr>
{{--    @endforeach--}}
</table>
<div class='values'>
    <div class='col-md-12 taxes-table' style='line-height:6px; font-size:7pt'>
        <table class='customers' style='width:100%; '>
            <tr style='font-size:7pt;'>
                <th>Κωδ. Φόρου</th>
                <th>Καθαρή Αξία</th>
                <th>Έκπτωση</th>
                <th>Καθαρή Αξία Με Εκπτ.</th>
                <th>Δημ. Φόρος</th>
                <th>Φορολογητέο</th>
                <th>ΦΠΑ</th>
                <th>ΦΠΑ2</th>
                <th>Σύνολο</th>
            </tr>
            <tr style='font-size:7pt;'>
                <th>TAX Code</th>
                <th>ΝΕΤ</th>
                <th>Discount</th>
                <th>ΝΕΤ After Disount</th>
                <th>City Tax</th>
                <th>Subject to VAT</th>
                <th>VAT</th>
                <th>VAT2</th>
                <th>Total</th>
            </tr>
            <tr>
                <td></td>
                <td>rtesrwasd</td>
                <td>rtesrwasd</td>
                <td>rtesrwasd</td>
                <td>rtesrwasd</td>
                <td>rtesrwasd</td>
                <td>rtesrwasd</td>
                <td>rtesrwasd</td>
                <td>rtesrwasd</td>
            </tr>
            <tr>
                <td>Συνολο / Total €</td>
                <td>rtesrwasd</td>
                <td>rtesrwasd</td>
                <td>rtesrwasd</td>
                <td>rtesrwasd</td>
                <td>rtesrwasd</td>
                <td>rtesrwasd</td>
                <td>rtesrwasd</td>
                <td>rtesrwasd</td>
            </tr>
        </table>
    </div>
    <div class='total'
         style='margin-top:4%; margin-right:5%; line-height:11px; font-size:8pt; font-weight:bold; float:right;'>
        <p><span style='text-align:right;'> Σύνολο / Total €</span> <span style='text-align:left;'> asdasdqw</span></p>
    </div>
</div>
<div class='comments' style='background-color:#f6f6f6; margin-top:50px; padding:3px;'>
    <p style='font-size:8pt;'><b>Comments:</b> commetns</p>
</div>
<div class='notes'>
</div>
</body>
</html>
<tr>
{{    dd()}}
