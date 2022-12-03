
<div>


 <style type="text/css">
    td{
        max-width:250px;
    }
   
 </style>
    <div class="d-flex flex-column-fluid mt-5">
        <div class="container-fluid">
            <div class="listcard" style="">
                <div class='row'>
                    <div class='col-5'>
                        <h2 class="pl-3 ">Payment Tracker</h2>
                    </div>
                    <div class='col-7 float-right'>
                       
                            <div style="margin-top:-2%;">
                                <!-- <table> 
                                    <tr>
                                        <td> -->
                                            <div class="form-style-6 w-50 float-right">
                                                <input  type="text" value="{{ $date }}" name="payment_date" style="width:307px;"
                                                    id="payment_datepicker" wire:change="setDate($event.target.value)">
                                            </div>
                                        <!-- </td> -->
                                        <!-- <td>
                                            <div class=" d-print-none ml-2  form-group" style="">
                                                <button type="submit" name='date_search_submit'
                                                    style='margin-top:15px;background-color:rgba(0,0,0,0);border:1px solid #D5D8DC; !important;padding:6px 12px;color:black;border-radius:2px;'>
                                                    Run
                                                </button>
                                            </div>
                                        </td> -->
                                    <!-- </tr>
                                </table> -->
                            </div>
                       
                    </div>
                </div>
            </div>
            <div class="row mt-10 mb-10">
                <div class="col-3">
                    <div class="listcard listcard-custom " style="height:150px;">
                        <h3>Total Charge</h3>
                        <div class="text-center font-weight-bold mt-8">
                            <h1 style="font-size:30px;" id="totalcharge">{{$totalcharge}}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="listcard listcard-custom " style="height:150px;">
                        <h3>PrePayments</h3>
                        <div class="text-center font-weight-bold mt-8">
                            <h1 style="font-size:30px;" id="prepayment">{{$prepaymentCharge}}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="listcard listcard-custom " style="height:150px;">
                        <h3>Charge A</h3>
                        <div class="text-center font-weight-bold mt-8">
                            <h1 style="font-size:30px;" id="firstamount">{{$charge_a}}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="listcard listcard-custom " style="height:150px;">
                        <h3>Charge B</h3>
                        <div class="text-center font-weight-bold mt-8">
                            <h1 style="font-size:30px;" id="secondammount">{{$charge_b}}</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive listcard p-10 border-radius-3" >
                <table class="table mt-10 text-center p-0" id='trackerTable'
                    style="font-size:14px;">
                    <thead>
                        <tr name="heading">
                            <th>Booking Code</th>
                            <th>Deposit Type</th>
                            <th>Channel</th>
                            <th>Reservation Amount</th>
                            <th>Charge Amount</th>
                            <th>Paid</th>
                            <th>Balance</th>
                            <th>Payment Status</th>
                            <th>Pay With</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prepayments as $prepayment)
                        <tr class="bg-white">
                            <td  class="idcolor" style=''>{{ $prepayment['booking_code'] }}</td>
                            <td class='idcolor'>Prepayment</td>
                            <td>{{ $prepayment['agency'] }}</td>
                            <td>{{ showPriceWithCurrency($prepayment['total']) }}</td>
                            <td>{{ showPriceWithCurrency($prepayment['prepayment']) }}</td>
                            <td>{{ showPriceWithCurrency($prepayment['deposit']) }}</td>
                            <td><div id='prepayment-balance-input'>{{ showPriceWithCurrency($prepayment['balance']) }}</div></td>
                            <td><span class="btn" style='background-color:{{ $prepayment["balance"] <= 0 ? "#48BD91" : "red" }};padding:2px 8px;color:white;border-radius:2px; margin:2px;'>{{ $prepayment['balance'] <= 0 ? 'Paid' : 'Not Paid' }}</span> </td>
                            <td>
                                @if ($prepayment['balance'] > 0)
                                    <a class='btn' onclick="showPayments(this)"  data-reservation='{{ $prepayment["id"] }}' data-balance='{{$prepayment["balance"]}}' data-deposit='{{$prepayment["deposit"]}}' data-totalcharge='{{$prepayment["prepayment"]}}' data-paymentmethod='{{$prepayment["payment_method_id"]}}' data-paymenttype='1'
                                        style='background-color:#48BD91;padding:2px 8px;color:white;border-radius:2px;margin:2px;'>
                                        Credit Card
                                    </a>
                                    <a onclick="openPopup(this)" class='btn'  data-reservation='{{ $prepayment["id"] }}' data-balance='{{$prepayment["balance"]}}' data-deposit='{{$prepayment["deposit"]}}' data-totalcharge='{{$prepayment["prepayment"]}}' data-paymentmethod='{{$prepayment["payment_method_id"]}}' data-paymenttype='1'
                                        style='background-color:#48BD91;padding:2px 8px;color:white;border-radius:2px; margin:2px;'>
                                        Other
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr class="bg-white"><td colspan="9" class="text-center">No prepayments</td></tr>
                        @endforelse
                        @forelse($firstCharges as $firstCharge)
                        <tr class="bg-white">
                            <td  class="idcolor" style=''>{{ $firstCharge['booking_code'] }}</td>
                            <td class='idcolor'>First Charge</td>
                            <td>{{ $firstCharge['agency'] }}</td>
                            <td>{{ showPriceWithCurrency($firstCharge['total']) }}</td>
                            <td>{{ showPriceWithCurrency($firstCharge['firstCharge']) }}</td>
                            <td>{{ showPriceWithCurrency($firstCharge['deposit']) }}</td>
                            <td><div id='prepayment-balance-input'>{{ showPriceWithCurrency($firstCharge['balance']) }}</div></td>
                            <td><span class="btn" style='background-color:{{ $firstCharge["balance"] <= 0 ? "#48BD91" : "red" }};padding:2px 8px;color:white;border-radius:2px; margin:2px;'>{{ $firstCharge['balance'] <= 0 ? 'Paid' : 'Not Paid' }}</span> </td>
                            <td>
                                @if ($firstCharge['balance'] > 0)
                                    <a class='btn' onclick="showPayments(this)" data-reservation='{{ $firstCharge["id"] }}' data-balance='{{$firstCharge["balance"]}}' data-deposit='{{$firstCharge["deposit"]}}' data-totalcharge='{{$firstCharge["firstCharge"]}}' data-paymentmethod='{{$firstCharge["payment_method_id"]}}' data-paymenttype='2'
                                        style='background-color:#48BD91;padding:2px 8px;color:white;border-radius:2px;margin:2px;'>
                                        Credit Card
                                    </a>
                                    <a onclick="openPopup(this)" class='btn' data-reservation='{{ $firstCharge["id"] }}' data-balance='{{$firstCharge["balance"]}}' data-deposit='{{$firstCharge["deposit"]}}' data-totalcharge='{{$firstCharge["firstCharge"]}}' data-paymentmethod='{{$firstCharge["payment_method_id"]}}' data-paymenttype='2'
                                        style='background-color:#48BD91;padding:2px 8px;color:white;border-radius:2px; margin:2px;'>
                                        Other
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr class="bg-white"><td colspan="9" class="text-center">No first charge</td></tr>
                        @endforelse

                        @forelse($secondCharges as $secondCharge)
                        <tr class="bg-white">
                            <td  class="idcolor" style=''>{{ $secondCharge['booking_code'] }}</td>
                            <td class='idcolor'>Second Charge</td>
                            <td>{{ $secondCharge['agency'] }}</td>
                            <td>{{ showPriceWithCurrency($secondCharge['total']) }}</td>
                            <td>{{ showPriceWithCurrency($secondCharge['secondCharge']) }}</td>
                            <td>{{ showPriceWithCurrency($secondCharge['deposit']) }}</td>
                            <td><div>{{ showPriceWithCurrency($secondCharge['balance']) }}</div></td>
                            <td><span class="btn" style='background-color:{{ $secondCharge["balance"] <= 0 ? "#48BD91" : "red" }};padding:2px 8px;color:white;border-radius:2px; margin:2px;'>{{ $secondCharge['balance'] <= 0 ? 'Paid' : 'Not Paid' }}</span> </td>
                            <td>
                                @if ($secondCharge['balance'] > 0)
                                    <a class='btn' onclick="showPayments(this)" data-reservation='{{ $secondCharge["id"] }}' data-balance='{{$secondCharge["balance"]}}' data-deposit='{{$secondCharge["deposit"]}}' data-totalcharge='{{$secondCharge["secondCharge"]}}' data-paymentmethod='{{$secondCharge["payment_method_id"]}}' data-paymenttype='3'
                                        style='background-color:#48BD91;padding:2px 8px;color:white;border-radius:2px;margin:2px;'>
                                        Credit Card
                                    </a>
                                    <a onclick="openPopup(this)" class='btn'  data-reservation='{{ $secondCharge["id"] }}' data-balance='{{$secondCharge["balance"]}}' data-deposit='{{$secondCharge["deposit"]}}' data-totalcharge='{{$secondCharge["secondCharge"]}}' data-paymentmethod='{{$secondCharge["payment_method_id"]}}' data-paymenttype='3'
                                        style='background-color:#48BD91;padding:2px 8px;color:white;border-radius:2px; margin:2px;'>
                                        Other
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr class="bg-white"><td colspan="9" class="text-center">No second charge</td></tr>
                        @endforelse
                    </tbody>
                            

                </table>
            </div>
        </div>
    </div>
    <div  class="modal" id="payModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content alert alert-light">
                <div class="modal-body align-items-center">
                    @livewire('finance.payment-tracker.multi-step-form', ["reservationId"=>$currentReservationId, "balance"=>$balance, "depositType"=>$depositType], key(time())) 
                    
                </div>
            </div>
        </div>
    </div>

    <!-------------------------RESERVATION CAHRGE MODEL  ------------------->
    <div class="modal fade" id="reservation-charge" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Reservation Deposit</h5>

                </div>
                <div class="modal-header" style="z-index:1;border:none;background-color:#F5F7F9;">
                    <canvas id="myCanvas1"
                        style="margin-left:42%;margin-top:-14%;z-index:990 !important;position:relative;"
                        width="80" height="80"></canvas>

                </div>
                <form action="{{route('payment.store')}}" method="POST">
                        @csrf
                <div class="modal-body"
                    style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-5%;">

                   
                        <input type="hidden" name="reservation_id" id="reservation_id">

                        <input type="hidden" name="balance" id="balance">

                        <input type="hidden" name="deposit_type" id="depositType" value=''>
                        

                        <div class="form-style-6">
                            <div class="row">

                                <div class=" col">
                                    <label class=" ">Ammount to Deposit<span class="text-danger">*</span></label>

                                    <input class=" " name='payment_ammount' type="text"
                                        value='' id="payment" required />

                                </div>

                            </div>
                            <div class="row ">
                                <div class="col">
                                    <label for="exampleSelect1">Payment Method<span
                                            class="text-danger">*</span></label>
                                    <select class=" " name='payment_method'
                                        style="max-width:210px !important; min-width:210px !important;"
                                        id="payment_method_id">
                                        @foreach ($paymentMethods as $method)
                                            <option name='payment_method' value='{{ $method->id }}'>
                                                {{ $method->name }}</option>";
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="example-date-input" class=" ">Payment Date</label>

                                    <input class=" " name='payment_date' id="date"
                                        style="max-width:210px !important; min-width:210px !important;" type="date"
                                        value="{{today()->toDateString()}}" required />

                                </div>

                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="" class=" ">Transaction ID</label>
                                    <input type="text" name='payment_comments' required>
                                </div>

                            </div>
                        </div>
                </div>
                <div class="modal-footer" style="background-color:#F5F7F9;">
                    <button type="submit" name="submit_payment"
                        style='background-color:#48BD91;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'
                        class="">Confirm</button>
                    <button type="button" class="" data-dismiss="modal"
                        style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    
    <script>
        let greenDates = @json($greenDates);
        $("#payment_datepicker").flatpickr({
            onDayCreate: function(dObj, dStr, fp, dayElem) {
                // if (greenDates.indexOf(+dayElem.dateObj) === -1) {
                //     dayElem.className += "green-date";
                // }
            }
        });
    </script>

    <script>

   
        function openPopup(elm) {

            let reservid = elm.getAttribute("data-reservation");
            let balanceTopay = elm.getAttribute("data-balance");
            let paymentMethodId = elm.getAttribute("data-paymentmethod");
            let paymentType = elm.getAttribute("data-paymenttype");
            document.getElementById("balance").value = balanceTopay;
            document.getElementById("payment").value = balanceTopay;
            document.getElementById("reservation_id").value = reservid;
            document.getElementById("payment_method_id").value = paymentMethodId;
            document.getElementById("depositType").value = paymentType;

            $('#reservation-charge').modal('show');

            }


        // ........show popup for payments..........
        window.addEventListener('openPciModel', event=>{
            $("#payModal").modal('show');
        })

        // ..........close popup and reload
        window.addEventListener('closePciModel', event=>{
            $("#payModal").modal('hide');
            location.reload();
        })

       
        function showPayments(elm) {

            @this.depositType=elm.getAttribute("data-paymenttype");
            @this.balance=elm.getAttribute("data-balance");
            @this.currentReservationId=elm.getAttribute("data-reservation");
            
        }

        // ..........5 minute timer...........
        function countdownTimer() {

            var interval = setInterval(function() {

                var timer = $("#cardtime").html();
                timer = timer.split(":");
                var minutes = timer[0];
                var seconds = timer[1];
                seconds -= 1;
                if (minutes < 0) return;
                else if (seconds < 0 && minutes != 0) {

                    minutes -= 1;
                    seconds = 59;

                } else if (seconds < 10 && seconds.length != 2) {

                    seconds = '0' + seconds;

                }

                if (minutes.length != 2) {

                    minutes = '0' + minutes;

                }

                $("#cardtime").html(minutes + ':' + seconds);

                if (minutes == 0 && seconds == 0) {

                    clearInterval(interval);
                    $('#payModal').modal('hide');
                    location.reload();


                }

            }, 1000)
        }

       
    </script>
</div>
