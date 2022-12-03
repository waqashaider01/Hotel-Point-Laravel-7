<html lang="">

<head>
    <title>Εκτύπωση Απόδειξης</title>
    <meta charset="utf-8" />
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
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
            line-height: 5px;
            font-size: 10pt;
        }

        .customers {
            border-collapse: collapse;
            width: 100%;
            margin-top: 3%;
        }

        .customers td,
        #customers th {
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
        <img src="{{$logoImage }}" style='width:100%; max-width:400px; max-height:100px;'>
    </div>
    <div class='header'>
        <p>{{ $settings->brand_name }} - {{ $settings->activity }}</p>
        <p>VAT: {{ $settings->tax_id }} - TAX Office: {{ $settings->tax_office }} </p>
        <p>{{ $settings->address }} - TK {{ $settings->postal_code }} - {{ $settings->city }} - ΤΗΛ: {{ $settings->phone }}</p>
        <p>{{ $settings->website }} &nbsp; &nbsp; {{ $settings->email }}</p>
        <p style="font-weight: bold; margin-top: 5px;">{{ $document->document_type->name }}</p>
        <!-- <p style="font-weight: bold; margin-top: 5px;">ΑΘΕΩΡΗΤΑ ΒΑΣΕΙ ΤΗΣ ΠΟΛ Α.Υ.Ο 1083/2-6-2003</p> -->
    </div>
    <br>
    <table style='width:100%;font-size:8pt; line-height:12px;'>
        <td valign=top width=65%>
            <table style='border:none;  background-color:#D6D6D6; width:100%; height:100px;font-size:8pt;'>
                @if ($document->document_info->company && $document->document_type->type != 3 && $document->document_type->type != 5 && $document->document_type->type != 2)
                    <tr>
                        <td colspan=2>
                            &nbsp;&nbsp;Company:&nbsp;&nbsp; {{ $document->document_info->company->name }}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Tel:&nbsp;&nbsp; {{ $document->document_info->company->phone_number }}</td>
                    </tr>
                    <tr>
                        <td colspan=2>&nbsp;&nbsp;Profession:&nbsp;&nbsp; {{ $document->document_info->company->activity }}</td>
                    </tr>
                    <tr>
                        <td colspan=2>
                            &nbsp;&nbsp;Address:&nbsp;&nbsp;&nbsp; {{ $document->document_info->company->address }}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Tax ID:&nbsp; {{ $document->document_info->company->tax_id }}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Tax Office:&nbsp;&nbsp; {{ $document->document_info->company->tax_office }}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Post Code:&nbsp;&nbsp; {{ $document->document_info->company->postal_code }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan=2>
                            &nbsp;&nbsp;Company:&nbsp;&nbsp; </td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Tel:&nbsp;&nbsp; </td>
                    </tr>
                    <tr>
                        <td colspan=2>&nbsp;&nbsp;Profession:&nbsp;&nbsp; </td>
                    </tr>
                    <tr>
                        <td colspan=2>
                            &nbsp;&nbsp;Address:&nbsp;&nbsp;&nbsp; </td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Tax ID:&nbsp; </td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Tax Office:&nbsp;&nbsp; </td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Post Code:&nbsp;&nbsp; </td>
                    </tr>
                @endif
                <tr>
                    <td>&nbsp;&nbsp;Guest :&nbsp;&nbsp; {{ $document->document_info->guest->full_name }}</td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;Payment:&nbsp;&nbsp; {{ $document->payment_method->name }}</td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;Reservation No.: &nbsp;&nbsp; {{ $reservation->booking_code }}</td>
                </tr>
            </table>
        </td>
        <td valign=top>
            <div>
                <table style='width:100%; border: none;font-size:7pt;text-align:center;'>
                    <tbody>
                        <tr>
                            <td style='text-align:center; background-color:#d6d6d6; width:50%;'>
                                <span style='text-align:center; font-size:11pt;'>No:</span> &nbsp;
                            </td>
                            <td style='font-size:11pt;background-color:#d6d6d6;'>{{ $document->enumeration }}</td>
                        </tr>
                        <tr>
                            <td style='font-weight:bold; font-size:7pt; width:70%; '>
                                <span style='text-align:left;'> Room </span>
                            </td>
                            <td>{{ $reservation->room->number }}</td>
                        </tr>
                        <tr>
                            <td style='font-weight:bold; font-size:7pt; width:70%; '>
                                &nbsp; <span style='text-align:left;'> Meals </span></td>
                            <td>{{ $reservation->rate_type->rate_type_category? $reservation->rate_type->rate_type_category->name:'' }}</td>
                        </tr>
                        <tr>
                            <td style='font-weight:bold; font-size:7pt; width:70%; '>
                                &nbsp; <span style='text-align:left;'> Arrival </span></td>
                            <td> {{ $reservation->actual_checkin }}</td>
                        </tr>
                        <tr>
                            <td style='font-weight:bold; font-size:7pt; width:70%; '>
                                &nbsp; <span style='text-align:left;'> Departure </span></td>
                            <td>{{ $reservation->actual_checkout }}</td>
                        </tr>
                        <tr>
                            <td style='font-weight:bold; font-size:7pt; width:70%; '>
                                &nbsp; <span style='text-align:left;'> Persons </span></td>
                            <td>{{ $reservation->adults + $reservation->kids + $reservation->infants }}</td>
                        </tr>
                        <tr>
                            <td style='font-weight:bold; font-size:7pt; width:70%; '>
                                &nbsp; <span style='text-align:left;'> Issue Date </span></td>
                            <td>{{ $document->print_date }}</td>
                        </tr>

                        <tr>
                            <td style='font-weight:bold; font-size:7pt; width:70%; '>
                                &nbsp; <span style='text-align:left;'> User </span></td>
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
            <th>Date</th>
            <th>Quant.</th>
            <th>Description</th>
            <th>VAT%</th>
            <th>Price {{ getHotelSettings()->currency->symbol }}</th>
        </tr>
        @foreach ($document->activities as $activity)
            <tr>
                <td>{{ $activity->date }}</td>
                <td>{{ $activity->quantity }}</td>
                <td>{{ $activity->description }}</td>
                <td>{{ $activity->vat }}</td>
                <td>{{ $activity->price }}</td>
            </tr>
        @endforeach
    </table>
    <div class='values'>
        <div class='col-md-12 taxes-table' style='line-height:6px; font-size:7pt'>
            <table class='customers' style='width:100%; '>
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
                    <td>{{ showPriceWithCurrency($document->net_value) }}</td>
                    <td>{{ showPriceWithCurrency($document->discount ?? 0) }}</td>
                    <td>{{ showPriceWithCurrency($document->discount_net_value) }}</td>
                    <td>{{ showPriceWithCurrency($document->municipal_tax) }}</td>
                    <td>{{ showPriceWithCurrency($document->taxable_amount) }}</td>
                    <td>{{ showPriceWithCurrency($document->tax) }}</td>
                    <td>{{ showPriceWithCurrency($document->tax_2) }}</td>
                    <td>{{ showPriceWithCurrency($document->total) }}</td>
                </tr>
                <tr>
                    <td> Total {{ getHotelSettings()->currency->symbol }}</td>
                    <td>{{ showPriceWithCurrency($document->net_value) }}</td>
                    <td>{{ showPriceWithCurrency($document->discount ?? 0) }}</td>
                    <td>{{ showPriceWithCurrency($document->discount_net_value) }}</td>
                    <td>{{ showPriceWithCurrency($document->municipal_tax) }}</td>
                    <td>{{ showPriceWithCurrency($document->taxable_amount) }}</td>
                    <td>{{ showPriceWithCurrency($document->tax) }}</td>
                    <td>{{ showPriceWithCurrency($document->tax_2) }}</td>
                    <td>{{ showPriceWithCurrency($document->total) }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class='total' style='margin-top:4%; margin-right:5%;padding-bottom: 15px; line-height:11px; font-size:8pt; font-weight:bold; float:right;'>
        <p><span style='text-align:right; padding-bottom: 10px;'> Total </span> <span style='text-align:left;'> {{ showPriceWithCurrency($document->total) }}</span></p>
    </div>
    <div class='comments' style='background-color:#f6f6f6; margin-top:50px; padding:3px;'>
        <p style='font-size:8pt;'><b>Comments:</b> {{ $document->comments }}</p>
    </div>
    <div class='notes'>
    </div>
</body>

</html>
