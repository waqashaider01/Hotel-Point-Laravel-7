<div class="d-flex flex-column-fluid mt-5">
    <div class="container-fluid">
        <div class="row" id="btndiv1">
            <div class="col">
                <div class="reservation_info shadow-sm bg-white" style="padding:1%;">
                    <div class="row">
                        <div class="col-md-6">
                            @if($editing)
                                <div class="float-left">
                                    <h1>Edit Reservation Form</h1>
                                </div>
                            @else
                                <div class="float-right">
                                    <h1>Reservation Form</h1>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6 btndiv" wire:ignore>
                            <div class="" style="float:right;">
                                <span type="button" class="payment-button" id="printForm">
                                    <i class="fa fa-print"></i> Print</span>
                                <a href="{{route('calendar')}}" type="button" class="payment-button"
                                   style="color: #5D606F !important;">
                                    <i class="fas fa-calendar-alt"></i> Calendar</a>
                                @if($editing)
                                    <span type="button" class="payment-button" data-toggle="modal"
                                          data-target="#sendEmail">
                                        <i class="fa fa-envelope"></i> Send Email</span>
                                    <span type="button" class="payment-button" data-toggle="modal"
                                          data-target="#accommodationPaymentModal" wire:click="setAccomPayment">
                                        <i class="fa fa-credit-card"></i> Payment</span>
                                @endif
                                <span type="button" class="payment-button" id="complimentary_button">
                                        <i class="fas fa-gift"></i> Complimentary</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row  mt-5">
            <div class="col">
                <div class="reservation_info shadow-sm bg-white">
                    <div class="form-style-6">
                        <fieldset
                            style="border:1px solid #43D1AF; border-radius:5px;padding:15px;margin:0px;margin-bottom:-20px !important;">
                            <legend
                                style="width:auto; margin-bottom: 0px; font-size: 18px; font-weight: bold; color: #3D3D3D;">
                                Booking Info
                            </legend>
                            <div class="row">
                                <div class="col">
                                    <label>Company</label>
                                    <select wire:model.defer="reservation.company_id">
                                        <option value="">Choose compnay...</option>
                                        @foreach($companies as $company)
                                            <option value='{{$company->id}}'>{{$company->name}}</option>
                                        @endforeach
                                    </select>
                                    <x-error field="reservation.company_id"/>
                                </div>
                                <div class="col">
                                    <label>Channel</label>
                                    <select wire:model.defer="reservation.booking_agency_id" wire:change="getCode">
                                        <option value=''>Choose ...</option>
                                        @if($agency)
                                            <option value='{{$agency->id}}'>{{$agency->name}}</option>
                                        @endif
                                    </select>
                                    <x-error field="reservation.booking_agency_id"/>
                                </div>
                                <div class="col">
                                    <label>Booking Code</label>
                                    <input placeholder="Booking Code..." wire:model.defer='reservation.booking_code'
                                           type="text"/>
                                    <x-error field="reservation.booking_code"/>
                                </div>
                                <div class="col">
                                    <label>Booking Date</label>
                                    <input type="date" wire:model='reservation.booking_date'/>
                                    <x-error field="reservation.booking_date"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Booking Status</label>
                                    <select wire:model.defer='reservation.channex_status'>
                                        <option value="cancelled">Cancelled</option>
                                        <option value="new">New</option>
                                        <option value="modified">Modified</option>
                                    </select>
                                    <x-error field="reservation.channex_status"/>
                                </div>
                                <div class="col">
                                    <label>Check In</label>
                                    <input type="date" wire:model="reservation.check_in"/>
                                    <x-error field="reservation.check_in"/>
                                </div>
                                <div class="col">
                                    <label>Check Out</label>
                                    <input type="date" wire:model="reservation.check_out"
                                           wire:change="checkoutChanged"/>
                                    <x-error field="reservation.check_out"/>
                                </div>
                                <div class="col">
                                    <label>Arrival hour</label>
                                    <input type="time" wire:model.defer="reservation.arrival_hour"/>
                                    <x-error field="reservation.arrival_hour"/>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-8">
            <div class="col">
                <div class="reservation_info shadow-sm bg-white">
                    <div class="form-style-6">
                        <fieldset
                            style="border:1px solid #43D1AF; border-radius:5px;padding:15px;margin:0px;margin-bottom:-20px !important;">
                            <legend
                                style="width:auto; margin-bottom: 0px; font-size: 18px; font-weight: bold; color: #3D3D3D;">
                                Guest Info
                            </legend>

                            <div class="row">
                                <div class="col">
                                    <label>Guest Name</label>
                                    <input wire:model.defer="guest.full_name" type="text"/>
                                    <x-error field="guest.full_name"/>
                                </div>
                                <div class="col">
                                    <label>Guest Email</label>
                                    <input wire:model.defer="guest.email" type="email"/>
                                    <x-error field="guest.email"/>
                                </div>
                                <div class="col">
                                    <label>Guest Telephone</label>
                                    <input wire:model.defer="guest.phone" type="text"/>
                                    <x-error field="guest.phone"/>
                                </div>
                                <div class="col">
                                    <label>Select Country</label>
                                    <select wire:model.defer="reservation.country_id">
                                        @foreach($countries as $country)
                                            <option value='{{$country->id}}'>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    <x-error field="reservation.country_id"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Adults</label>
                                    <input wire:model.defer="reservation.adults" type="number"
                                           min="0"/>
                                    <x-error field="reservation.adults"/>
                                </div>
                                <div class="col">
                                    <label>Children</label>
                                    <input wire:model.defer="reservation.kids" type="number"
                                           min="0"/>
                                    <x-error field="reservation.kids"/>
                                </div>
                                <div class="col">
                                    <label>Infants</label>
                                    <input wire:model.defer="reservation.infants" type="number"
                                           min="0"/>
                                    <x-error field="reservation.infants"/>
                                </div>
                                <div class="col"></div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-8">
            <div class="col">
                <div class="reservation_info shadow-sm bg-white">
                    <div class="form-style-6">
                        <fieldset
                            style="border:1px solid #43D1AF; border-radius:5px;padding:15px;margin:0px;margin-bottom:-20px !important;">
                            <legend
                                style="width:auto; margin-bottom: 0px; font-size: 18px; font-weight: bold; color: #3D3D3D;">
                                Room and Rates
                            </legend>
                            <div class="row" style="margin-bottom:0%;">
                                <div class="col">
                                    <label>Room Type</label>
                                    <select wire:model="selected_room_type">
                                        <option selected>Choose ...</option>
                                        @foreach($room_types as $type)
                                            <option value='{{$type->id}}'>
                                                {{$type->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label>Room Number</label>
                                    <select wire:model.defer="reservation.room_id">
                                        <option selected>Choose ...</option>
                                        @foreach($rooms as $room)
                                            <option value='{{$room->id}}'>{{$room->number}}</option>
                                        @endforeach
                                    </select>
                                    <x-error field="reservation.room_id"/>
                                </div>
                                <div class="col">
                                    <label>Rate Plan</label>
                                    <select wire:model="reservation.rate_type_id">
                                        <option value="">Choose....</option>
                                        @foreach($rates as $rate)
                                            <option value='{{$rate->id}}'>{{$rate->name}}</option>
                                        @endforeach
                                    </select>
                                    <x-error field="reservation.rate_plan_id"/>
                                </div>
                                <div class="col">
                                    <label>Daily Pricing</label></br>
                                    <span type="button" class="infbtn" data-toggle="modal"
                                          data-target="#dailyRatesModal"
                                          style="min-width:100% !important;min-height:40px;padding-left:35%;padding-top:3%;">
                                    <i class="fas fa-list"></i> Add Price</span>
                                    <x-error field="daily_rates"/>
                                </div>
                                @if($editing)
                                    <div class="col">
                                        <label>Reservation Amount</label><br>
                                        <input class="" wire:model.defer="reservation_amount" type="number" readonly="">
                                    </div>
                                @endif
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-8">
            <div class="col">
                <div class="reservation_info shadow-sm bg-white">
                    <div class="form-style-6">
                        <fieldset
                            style="border:1px solid #43D1AF; border-radius:5px;padding:15px;margin:0px;margin-bottom:-20px !important;">
                            <legend
                                style="width:auto; margin-bottom: 0px; font-size: 18px; font-weight: bold; color: #3D3D3D;">
                                Payment Plan
                            </legend>
                            <div class="row">
                                <div class="col">
                                    <label>Charge Date</label>
                                    <input wire:model.defer="reservation.charge_date" type="date" readonly/>
                                    <x-error field="reservation.charge_date"/>
                                </div>
                                <div class="col">
                                    <label>Payment Method</label>
                                    <select wire:model.defer="reservation.payment_method_id">
                                        <option selected>Choose ...</option>
                                        @foreach($methods as $method)
                                            <option value="{{$method->id}}">{{$method->name}}</option>
                                        @endforeach
                                    </select>
                                    <x-error field="reservation.payment_method_id"/>
                                </div>
                                @if($editing)
                                    <div class="col">
                                        <label>Virtual Card</label>
                                        <input value="{{$reservation->virtual_card?'Yes':'No'}}" type="text" readonly/>
                                        <x-error field="reservation.charge_date"/>
                                    </div>
                                @endif
                                <div class="col">
                                    <label>Payment Mode</label>
                                    <select
                                        wire:model.defer="reservation.payment_mode_id" {{$modeSelected ? 'disabled':''}}>
                                        <option selected>Choose ...</option>
                                        @foreach($modes as $mode)
                                            <option value="{{$mode->id}}">{{$mode->name}}</option>
                                        @endforeach
                                    </select>
                                    <x-error field="reservation.payment_mode_id"/>
                                </div>
                                @if($editing)
                                    <div class="col">
                                        <label>Discount</label>
                                        <input value="{{$reservation->discount}}" type="text" readonly/>
                                        <x-error field="reservation.charge_date"/>
                                    </div>
                                @endif
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-8 ">
            <div class="col">
                <div class="reservation_info shadow-sm bg-white">
                    <div class="form-style-6">
                        <fieldset
                            style="border:1px solid #43D1AF; border-radius:5px;padding:15px;margin:0px;margin-bottom:-20px !important;">
                            <legend
                                style="width:auto; margin-bottom: 0px; font-size: 18px; font-weight: bold; color: #3D3D3D;">
                                Reservation Info
                            </legend>
                            <div class="row">
                                <div class="col">
                                    <label>Arrival Date</label>
                                    <input type="date" wire:model.defer="reservation.check_in" readonly/>
                                </div>
                                <div class="col">
                                    <label>Departure Date</label>
                                    <input type="date" wire:model.defer="reservation.check_out" readonly/>
                                </div>
                                <div class="col">
                                    <label>Reservation Status</label>
                                    <select wire:model.defer="reservation.status" id="res_status">
                                        <option value="New">New</option>
                                        <option value="Offer">Offer</option>
                                        <option value="Complimentary">Complimentary</option>
                                        <option value="Confirmed">Confirmed</option>
                                        <option value="Arrived">Arrived</option>
                                        <option value="CheckedOut">Check Out</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                    <x-error field="reservation.status"/>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom:-4%;">
                                <div class="col">
                                    <label>Comments</label>
                                    <textarea wire:model.defer="reservation.comment" style="min-height:80px;"
                                              rows="3"></textarea>
                                    <x-error field="reservation.comment"/>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-8 mb-15 btndiv" id="btndiv">
            <div class="col">
                <div class="reservation_info shadow-sm bg-white" style="padding:2%;">
                    <div class="row">
                        <div class="col">
                            <div style="float:right;">
                                <button class="payment-button" wire:click="storeReservation"
                                        style='background-color:white;color:#43D1AF;'>Submit
                                </button>
                            </div>
                        </div>
                    </div>
                    @if($errors->any())
                    <div class="row">
                        <div class="col">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{--    daily rate modal--}}
    <div class="modal" id="dailyRatesModal" tabindex="-1" wire:ignore.self aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable ">
            <div class="modal-content shadow"
                 style=" width:100%;margin-left:10% !important;margin-top:5%;border-radius:0px;border:1px solid #43D1AF;">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"
                        style="margin-left:40% !important;padding:0px;font-size:25px;margin-top:-10px;margin-bottom:-10px;"
                        id="exampleModalLabel">Pricing</h5>
                </div>
                <form class="form">
                    <div class="modal-body" style="overflow-y:auto;max-height:400px;overflow-x:hidden;">
                        <div class="form-style-6">
                            @foreach($daily_rates as $daily_rate)
                                <div class="row">
                                    <div class="col">
                                        <label for="dailyRates">{{$daily_rate['date']}}</label>
                                        <input type="text" placeholder="Add daily rate"
                                               {{$complimentary?'readonly':''}}
                                               wire:model.defer="daily_rates.{{$loop->index}}.price">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="payment-button" wire:click="submitDailyRates"
                                style='background-color:white;color:#43D1AF;'>
                            Submit
                        </button>
                        <button type="button" data-dismiss="modal" class="payment-button"
                                style='background-color:white;color:red;'>Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--        offer modal --}}
    <div class="modal" id="offerModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog  modal-dialog-scrollable ">
            <div class="modal-content shadow"
                 style=" width:100%;margin-left:10% !important;margin-top:5%;border-radius:0px;border:1px solid #43D1AF;">
                <div class="modal-header">
                    <h5 class="modal-title text-dark text-center"
                        style="width:100%; padding:0px;font-size:25px;margin-top:-10px;margin-bottom:-10px;"
                        id="exampleModalLabel">Offer Expire Date</h5>
                </div>
                <div class="modal-body" id="" style="overflow-y:auto;max-height:400px;overflow-x:hidden;">
                    <div class="form-style-6">
                        <input type="date" min="{{today()->toDateString()}}"
                               wire:model.defer="reservation.offer_expire_date">
                        <x-error field="reservation.offer_expire_date"></x-error>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="payment-button" wire:click="submitOffer"
                            style='background-color:white;color:green;'>Add
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{--        email modal sendEmail--}}
    <div id="sendEmail" class="modal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-content" style="width:60%;margin-left:20% !important;margin-top:5%;border-radius:0px;">
            <div class="modal-header" style="background-color:#EAECEE;">
                <h5 class="modal-title text-dark"
                    style="margin-left:45% !important;padding:0px;font-size:25px;margin-top:-10px;margin-bottom:-10px;">
                    Email &nbsp;<i class="fa fa-paper-plane text-dark" aria-hidden="true"></i></h5>
            </div>
            <div class="modal-body" id="agency_detail">
                <div class="row " style="margin-left:-2% !important;margin-right:-2% !important;">
                    <div class='col form-style-6 '>
                        <div class=""><label>Template</label>
                            <select class="form-control1" wire:model="selected_template">
                                <option value="" selected>Choose Template...</option>
                                @foreach($templates as $template)
                                    <option value="{{$template->id}}">{{$template->name}}</option>
                                @endforeach
                            </select>
                            <x-error field="selected_template"></x-error>
                        </div>
                    </div>
                    <div class="col form-style-6 " style="">
                        <label>Subject:</label>
                        <input class="form-control1" placeholder="Enter Email Subject..."
                               wire:model.defer="email_subject" type="text"/>
                        <x-error field="email_subject"></x-error>
                    </div>
                    <div class=" col form-style-6 " style="">
                        <label>To: </label>
                        <input class="form-control1" wire:model="guest_email" type="text"/>
                    </div>
                </div>
                <div class="row"
                     style="background-color:#F2EFEA;border:1px solid #CBCBCB;height:300px ; overflow-y: scroll;">
                    <div class='col-md-12'>
                        <div>
                            {!! $email_body !!}
                        </div>
                        <div class="mt-2">
                            @foreach($attachments as $item)
                                <p class="alert alert-success">Attached File {{$item->getClientOriginalName()}}
                                    <i class="fa fa-paperclip" style="color:black;"></i>
                                </p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row ">
                    <div class='col'>
                        <div style="float:left;margin-right:3px;">
                            <label class="btn btn-success">
                                <i class="fa fa-paperclip" style="color:#fff;"></i>
                                <input type="file" style="display: none" wire:model="attachment"/>
                            </label>
                        </div>
                        <button type="button" class="btn btn-success" wire:click="sendEmail" wire:loading.remove><i
                                class="fa fa-paper-plane text-light" aria-hidden="true"></i></button>
                        <button class="btn btn-success" type="button" disabled wire:loading wire:target="sendEmail">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Sending Email...
                        </button>
                        <button type="button" class="btn btn-light-danger font-weight-bold hide"
                                data-dismiss="modal">Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    PAYMENT MODAL--}}
    <div class="modal fade" id="accommodationPaymentModal" style="border-radius:0px !important;" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
                    <h5 style="text-align:center;margin-left:26%;" class="modal-title text-dark text-center"
                        id="exampleModalLabel">Accommodation Payments</h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;">
                    <div class="form-style-6">
                        <x-error field="status"></x-error>
                        <div class="row mr-1">
                            <div class="col">
                                <label class="">Value</label>
                                <input class="smstyle" wire:model.defer="accom_value" type="text"/>
                                <x-error field="accom_value"></x-error>
                            </div>
                            <div class="col">
                                <label for="" class="">Payment Date</label>
                                <input class="smstyle" wire:model.defer="accom_payment_date" type="date"
                                       min="{{today()->toDateString()}}"
                                       value="{{today()->toDateString()}}"/>
                                <x-error field="accom_payment_date"></x-error>
                            </div>
                        </div>
                        <div class="row mr-1" id="payment-method-field">
                            <div class="col">
                                <label for="" class="">Payment Method<span class="text-danger">*</span></label>
                                <select class="smstyle" wire:model.defer="accom_payment_method">
                                    <option value="">Select </option>
                                    @foreach($methods as $method)
                                        <option value='{{$method->id}}'>{{$method->name}}</option>
                                    @endforeach
                                </select>
                                <x-error field="accom_payment_method"></x-error>
                            </div>
                            <div class="col">
                                <label for="" class="">Is This Payment a Deposit ?<span
                                        class="text-danger">*</span></label>
                                <select class="smstyle" wire:model.defer="accom_is_deposit">
                                    @if($reservation->actual_checkin > today() || is_null($reservation->actual_checkin))
                                        <option value=1>Yes</option>
                                    @elseif($reservation->actual_checkin <= today())
                                        <option value=0>No</option>
                                    @endif
                                </select>
                                <x-error field="accom_is_deposit"></x-error>
                            </div>
                        </div>
                        <div class="row" style="">
                            <div class="col">
                                <label for="">Transaction ID<span class="text-danger">*</span></label>
                                <input type="text" class="smstyle" wire:model.defer="transaction_id" />
                                <x-error field="transaction_id"></x-error>
                            </div>
                            <div class="col"></div>
                        </div>
                        <input name="reservationId" type="hidden" value="{{$reservation->id}}">
                    </div>
                    <div class="modal-footer" style="background-color:#fff;">
                        <button type="submit" class="float-right payment-button" wire:click="saveAccommodationPayment"
                                style="color:green;background-color:white;">
                            Insert
                        </button>
                        <span type="button" class="payment-button" style="color:red;" data-dismiss="modal"
                              style=''>Close</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@push('scripts')
    <script>
        $('#res_status').change(function () {
            if ($('#res_status').val() == 'Offer') {
                $('#offerModal').modal('show');
            }
            if ($('#res_status').val() == 'Complimentary') {
                $('#complimentary_button').css({'background-color': 'green', 'color': 'white'});
            } else {
                $('#complimentary_button').css({'background-color': '', 'color': 'black'});
            }
        })
        $("#printForm").click(function () {
            $('.btndiv').css('display', 'none');
            window.print();
        });
        $(window).on('afterprint', function () {
            $('.btndiv').css('display', 'block');
        });
    </script>
@endpush
