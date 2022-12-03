@extends('layouts.master')
@section('content')
    <div class="d-flex flex-column-fluid mt-5">
        <div class="container-fluid">
            <div class="row mb-10">
                <div class="col-md-4">
                    <div class="infocard bg-white shadow-sm">
                        <div class="row mt-2">
                            <div class="col">
                                <h3 style="text-align:center;" class="idcolor">#{{ $reservation->id }}</h3>
                            </div>
                        </div>
                        <div style="text-align:right;margin-bottom:-17px !important;" class="">{{ $reservation->guest->full_name }}</div>
                        <hr>
                        <div class="row mt-2">
                            <div class="col">
                                <label>Arrival Date</label></br>
                                <span class="font-weight-bold">{{ $reservation->arrival_date }}</span>
                            </div>
                            <div class="col">
                                <label>Departure Date</label></br>
                                <span class="font-weight-bold">{{ $reservation->departure_date }}</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <label>Actual Check In</label></br>
                                <span class="font-weight-bold">{{ $reservation->actual_checkin }}</span>
                            </div>
                            <div class="col">
                                <label>Actual Check Out</label></br>
                                <span class="font-weight-bold">{{ $reservation->actual_checkout }}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-2">
                            <div class="col">
                                <label>Rate Type</label></br>
                                <span class="font-weight-bold">{{ $reservation->rate_type->name }}</span>
                            </div>
                            <div class="col">
                                <label>Channel</label></br>
                                <span class="font-weight-bold">{{ $reservation->booking_agency->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="infocard bg-white shadow-sm">
                        <div class="row mt-7">
                            <div class="col">
                                <div class="row darker">
                                    <div class="col">
                                        Accommodation Total
                                    </div>
                                    <div class="col">
                                        Paid
                                    </div>
                                    <div class="col">
                                        Accommodation Balance
                                    </div>
                                    <div class="col">
                                        No Show
                                    </div>
                                    <div class="col">
                                        Action
                                    </div>
                                </div>
                                <div class="row lighter">
                                    <div class="col">
                                        {{ showPriceWithCurrency($values['accom_total']) }}
                                    </div>
                                    <div class="col">
                                        {{ showPriceWithCurrency($values['accom_paid']) }}
                                    </div>
                                    <div class="col">
                                        {{ showPriceWithCurrency($values['accom_charge']) }}
                                    </div>
                                    <div class="col" style="color:red">
                                        {{ $values['no_show'] ? 'Yes' : 'No' }}
                                    </div>
                                    <div class="col">
                                        <span type='button' data-toggle="modal" data-target="#accommodationPaymentModal" class='infbtn' onclick="setActive('accommodationPaymentModal')">
                                            <i class='fa fa-credit-card-alt' aria-hidden='true'></i> Payment</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-7">
                            <div class="col">
                                <div class="row darker">
                                    <div class="col">
                                        Services Total
                                    </div>
                                    <div class="col">
                                        Paid
                                    </div>
                                    <div class="col">
                                        Services Balance
                                    </div>
                                    <div class="col">
                                        Services
                                    </div>
                                </div>
                                <div class="row lighter">
                                    <div class="col">
                                        {{ showPriceWithCurrency($values['extras_total']) }}
                                    </div>
                                    <div class="col">
                                        {{ showPriceWithCurrency($values['extras_paid']) }}
                                    </div>
                                    <div class="col">
                                        {{ showPriceWithCurrency($values['extras_charge']) }}
                                    </div>
                                    <div class="col">
                                        <span onclick='showExtras()' type='button' class='infbtn' id=''><i class='fa fa-eye' aria-hidden='true'></i> Show</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-7 mr-5 ml-5" id="extras-table" style="display: none">
                            <div class="col">
                                <div class="row darker" style="font-size:12px !important;">
                                    <div class="col">
                                        Date
                                    </div>
                                    <div class="col">
                                        Receipt No
                                    </div>
                                    <div class="col">
                                        Amount
                                    </div>
                                    <div class="col">
                                        Payment Method
                                    </div>
                                </div>
                                @foreach ($extrasDetails as $key => $detail)
                                    <div class="row lighter" style="font-size:12px !important;">
                                        <div class="col">
                                            {{ $detail->first()->date }}
                                        </div>
                                        <div class="col">
                                            {{ $key }}
                                        </div>
                                        <div class="col">
                                            {{ $detail->sum('extra_charge_total') - $detail->sum('extra_charge_discount') }}
                                        </div>
                                        <div class="col">
                                            @if ($detail->first()->is_paid == 0)
                                                <span type='button' class='infbtn' data-toggle="modal" data-target="#servicePaymentModal{{ $loop->index }}">Pay</span>
                                            @else
                                                {{ $detail->first()->payment_method->name }}
                                            @endif
                                        </div>
                                    </div>

                                    <div class="modal fade" id="servicePaymentModal{{ $loop->index }}" style="border-radius:0px !important;" tabindex="-1" aria-labelledby="exampleModalLabel{{ $loop->index }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content rounded-0">
                                                <div class="modal-header shadow-sm" style="border-radius:0px !important;z-index:10;">
                                                    <h5 style="text-align:center;margin-left:26%;" class="modal-title text-dark text-center" id="exampleModalLabel{{ $loop->index }}">Services Payments</h5>
                                                </div>
                                                <div class="modal-body" style="position:relative;background-color:#fff;">
                                                    <form action="{{ route('post-payment') }}" method="POST">
                                                        @csrf
                                                        <div class="form-style-6">
                                                            <x-error field="extra_status"></x-error>
                                                            <input type="hidden" name="extra_charge_id" id="extra-charge-id" value='{{ $detail->first()->receipt_number }}' />
                                                            <input name="reservationId" type="hidden" value="{{ $reservation->id }}">

                                                            <div class="row mr-1">
                                                                <div class="col">
                                                                    <label class="">Value</label>
                                                                    <input class="smstyle" value="{{ $detail->sum('extra_charge_total') - $detail->sum('extra_charge_discount') }}" name="value" type="text" required />
                                                                    <x-error field="value"></x-error>
                                                                </div>
                                                                <div class="col">
                                                                    <label for="" class="">Payment Date</label>
                                                                    <input class="smstyle"name="service_payment_date" type="date" value="{{ today()->toDateString() }}" min="{{ today()->toDateString() }}" required />
                                                                    <x-error field="payment_date"></x-error>
                                                                </div>
                                                            </div>
                                                            <div class="row mr-1">
                                                                <div class="col">
                                                                    <label for="" class="">Receipt No.</label>
                                                                    <input class="smstyle" name="service_receipt_number" value='{{ $detail->first()->receipt_number }}' type="text" required />
                                                                    <x-error field="deposit"></x-error>
                                                                </div>
                                                                <div class="col">
                                                                    <label for="" class="">Payment Method<span class="text-danger">*</span></label>
                                                                    <select class="smstyle" name="payment_method_id" required>
                                                                        <option value="">Select Payment Method</option>
                                                                        @foreach ($methods as $method)
                                                                            <option value='{{ $method->id }}'>{{ $method->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <x-error field="payment_method_id"></x-error>
                                                                </div>
                                                            </div>
                                                            <div class="row" style="">
                                                                <div class="col">
                                                                    <label for="">Comments<span class="text-danger">*</span></label>
                                                                    <textarea class="" name="service_comment" id="" rows="3" style="min-height:80px !important;"></textarea>
                                                                    <x-error field="service_comment"></x-error>
                                                                </div>
                                                            </div>


                                                        </div>
                                                        <div class="modal-footer" style="background-color:#fff;">
                                                            <button type="submit" class="infbtn float-right" style="color:green;background-color:white;">
                                                                Insert
                                                            </button>
                                                            <span type="button" class="infbtn" style="color:red;" data-dismiss="modal" style=''>Close</span>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row mt-7">
                            <div class="col">
                                <div class="row darker">
                                    <div class="col">
                                        Overnight Tax Total
                                    </div>
                                    <div class="col">
                                        Paid
                                    </div>
                                    <div class="col">
                                        Overnight Tax Balance
                                    </div>
                                    <div class="col">
                                        <div class="ml-13">
                                            Action
                                        </div>
                                    </div>
                                </div>
                                <div class="row lighter">
                                    <div class="col">
                                        {{ showPriceWithCurrency($values['overnight_total']) }}
                                    </div>
                                    <div class="col">
                                        {{ showPriceWithCurrency($values['overnight_paid']) }}
                                    </div>
                                    <div class="col">
                                        {{ showPriceWithCurrency($values['overnight_charge']) }}
                                    </div>
                                    <div class="col">
                                        <div class="ml-13">
                                            <a href='#' type='button' class='infbtn' data-toggle="modal" onclick="setActive('overnightPaymentModal')" data-target="#overnightPaymentModal">
                                                <i class='fa fa-credit-card-alt' aria-hidden='true'></i>Payment</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modals --}}
    <div class="modal fade" id="accommodationPaymentModal" style="border-radius:0px !important;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm" style="border-radius:0px !important;z-index:10;">
                    <h5 style="text-align:center;margin-left:26%;" class="modal-title text-dark text-center" id="exampleModalLabel">Accommodation Payments</h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;">
                    <form action="{{ route('post-payment') }}" method="POST">
                        @csrf
                        <div class="form-style-6">
                            @if (isset($status) && $status != '')
                                <p class="text-danger m-0">{{ $status }}</p>
                            @endif
                            <x-error field="status"></x-error>
                            <div class="row mr-1">
                                <div class="col">
                                    <label class="">Value</label>
                                    <input class="smstyle" name="value" type="text" value="{{ $values['accom_charge'] }}" style="" />
                                    <x-error field="value"></x-error>
                                </div>
                                <div class="col">
                                    <label for="" class="">Payment Date</label>
                                    <input class="smstyle" name="payment_date" type="date" min="{{ today()->toDateString() }}" value="{{ today()->toDateString() }}" />
                                    <x-error field="payment_date"></x-error>
                                </div>
                            </div>
                            @if ($values['accom_charge'] >= 500 && $reservation->payment_method_id == 1)
                                <div style="text-align:center; color:red;">
                                    <small>
                                        <b>
                                            Balance is greater or equal to 500. You can not proceed with a payment of
                                            cash. Please change your payment method.
                                        </b>
                                    </small>
                                </div>
                            @endif
                            <div class="row mr-1" id="payment-method-field">
                                <div class="col">
                                    <label for="" class="">Payment Method<span class="text-danger">*</span></label>
                                    <select class="smstyle" name="payment_method_id">
                                        @foreach ($methods as $method)
                                            <option value='{{ $method->id }}'>{{ $method->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-error field="payment_method_id"></x-error>
                                </div>
                                <div class="col">
                                    <label for="" class="">Is This Payment a Deposit ?<span class="text-danger">*</span></label>
                                    <select class="smstyle" name="deposit">
                                        @if ($reservation->actual_checkin > today() || is_null($reservation->actual_checkin))
                                            <option value=1>Yes</option>
                                        @elseif($reservation->actual_checkin <= today())
                                            <option value=0>No</option>
                                        @endif
                                    </select>
                                    <x-error field="deposit"></x-error>
                                </div>
                            </div>
                            <div class="row" style="">
                                <div class="col">
                                    <label for="">Comments<span class="text-danger">*</span></label>
                                    <textarea class="" name="payment_comments" id="" rows="3" style="min-height:80px !important;"></textarea>
                                    <x-error field="payment_comments"></x-error>
                                </div>
                            </div>
                            <input name="reservationId" type="hidden" value="{{ $reservation->id }}">
                        </div>
                        <div class="modal-footer" style="background-color:#fff;">
                            <button type="submit" class="infbtn float-right" style="color:green;background-color:white;">
                                Insert
                            </button>
                            <span type="button" class="infbtn" style="color:red;" data-dismiss="modal" style=''>Close</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="overnightPaymentModal" style="border-radius:0px !important;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm" style="border-radius:0px !important;z-index:10;">
                    <h5 style="text-align:center;margin-left:26%;" class="modal-title text-dark text-center" id="exampleModalLabel">Overnight Payments</h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;">
                    <form action="{{ route('post-payment') }}" method="POST">
                        @csrf
                        <div class="form-style-6">
                            @if (isset($overnight_status) && $overnight_status != '')
                                <p class="text-danger m-0">{{ $overnight_status }}</p>
                            @endif

                            <x-error field="overnight-status"></x-error>
                            <div class="row mr-1">
                                <div class="col">
                                    <label class="">Value</label>
                                    <input class="smstyle" name="value" type="text" value="{{ $values['overnight_charge'] }}" style="" />
                                    <x-error field="value"></x-error>
                                </div>
                                <div class="col">
                                    <label for="" class="">Payment Date</label>
                                    <input class="smstyle" name="payment_date" type="date" min="{{ today()->toDateString() }}" value="{{ today()->toDateString() }}" />
                                    <x-error field="payment_date"></x-error>
                                </div>
                            </div>
                            <div class="row mr-1" id="payment-method-field">
                                <div class="col">
                                    <label for="" class="">Payment Method<span class="text-danger">*</span></label>
                                    <select class="smstyle" name="payment_method_id">
                                        @foreach ($methods as $method)
                                            <option value='{{ $method->id }}'>{{ $method->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-error field="payment_method_id"></x-error>
                                </div>
                            </div>
                            <div class="row" style="">
                                <div class="col">
                                    <label for="">Comments<span class="text-danger">*</span></label>
                                    <textarea class="" name="payment_comments" id="" rows="3" style="min-height:80px !important;"></textarea>
                                    <x-error field="payment_comments"></x-error>
                                </div>
                            </div>
                            <input name="reservationId" type="hidden" value="{{ $reservation->id }}">
                            <input name="overnight" type="hidden" value="true">
                        </div>
                        <div class="modal-footer" style="background-color:#fff;">
                            <button type="submit" class="infbtn float-right" style="color:green;background-color:white;">
                                Insert
                            </button>
                            <span type="button" class="infbtn" style="color:red;" data-dismiss="modal" style=''>Close</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editReservExtraChargeModal" style="border-radius:0px !important;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm" style="border-radius:0px !important;z-index:10;">
                    <h5 style="text-align:center;margin-left:40%;" class="modal-title text-dark text-center" id="exampleModalLabel">Edit Service</h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;">
                    <form action="../includes/update_extra_charges.php" method="POST">
                        <div class="form-style-6" id="edit_reserv_extra_charges">

                        </div>
                        <div class="modal-footer" style="background-color:#fff;">
                            <button type="submit" name="update-reservation-extra-charge" style="color:green;background-color:white !important;" class="infbtn float-right">Update
                            </button>
                            <span type="button" class="infbtn" style="color:red;" data-dismiss="modal" style=''>Close</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteReservExtraChargeModal" style="border-radius:0px !important;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content rounded-0">
                    <div class="modal-header shadow-sm" style="border-radius:0px !important;z-index:10;">
                        <h5 style="text-align:center;margin-left:37%;" class="modal-title text-dark text-center" id="exampleModalLabel">Delete Service</h5>
                    </div>
                    <div class="modal-body" style="position:relative;background-color:#fff;">
                        <form action="../includes/delete_reservation_extra_charges.php" method="POST">
                            <div class="form-style-6" id="delete_reserv_extra_charges">

                            </div>
                            <div class="modal-footer" style="background-color:#fff;">
                                <button type="submit" name="delete-reservation-extra-charge" style="color:green;background-color:white;" class="infbtn float-right" style='' id="">Confirm
                                </button>
                                <span type="button" class="infbtn" style="color:red;" data-dismiss="modal" style=''>Close</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        let active_modal = 'servicePaymentModal';
        @if (count($errors) > 0)
            active_modal.modal('show');
        @endif
        function setActive(name) {
            active_modal = $('#' + name);
        }

        function showExtras() {
            var x = document.getElementById("extras-table");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
@endsection
