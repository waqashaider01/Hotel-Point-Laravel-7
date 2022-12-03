@extends('layouts.master')
@section('content')
@inject('carbon', 'Carbon\Carbon')
    <div>
        @if($errors->any())
        <div class="alert alert-danger mx-auto my-2" style="max-width: 750px;">
            <p><strong>Error: </strong>Please fix the below errors to proceed!</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <x-table title='Ex Reservation List' tableClasses="table reservation-table table-striped table-bordered">
            <x-slot name="header">
                <div class="row">
                    <div class="col-md-10 form-group d-inline-block">
                        <form action="{{ route('ex-reservations-import-list') }}" method="post" enctype="multipart/form-data" id="importForm">
                            @csrf
                            <div class="d-print-none" style="float:left;margin-top:2%;">
                                <input type="file" name="reservations" id="file" accept=".xls, .xlsx"
                                    onchange="uploadFile();" hidden>
                                <button type="button" id="importbtn" name='import' class=""
                                    style='background-color:#48BD91;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'
                                    onclick="file.click()">
                                    <i class="fa fa-upload text-light" aria-hidden="true"></i>
                                    Upload
                                </button>
                                <button name='addnew' id="addnew" type="button" data-toggle="modal"
                                    data-target="#addBookingModal"
                                    style='background-color:#48BD91;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'
                                    class=""><i class="fa fa-plus text-light" aria-hidden="true"></i>&nbsp;
                                    Booking
                                </button>
                            </div>
                        </form>
                    </div>
                    <script>
                        function uploadFile(){
                            document.getElementById('importForm').submit();
                        }
                    </script>
                    <div class="col-md-2">
                        <a href="javascript:if(window.print)window.print()" type="button"
                            class="float-right btn btn-primary m-3">
                            <i class="fa fa-print"></i> Print
                        </a>
                    </div>
                </div>
            </x-slot>
            <x-slot name="heading">
                <th>A/A</th>
                <th>Booking Code</th>
                <th>Checkin Date</th>
                <th>Checkout Date</th>
                <th>Room Type</th>
                <th>Source</th>
                <th>Status</th>
                <th class="d-print-none">More Info</th>
            </x-slot>
            @foreach ($ex_reservations as $item)
                <tr id="tr_{{ $item->id }}">
                    <td>{{ $item->id }}</td>
                    <td><a href="{{ route('reservation-show', $item) }}">#{{ $item->booking_code }}</a>
                    </td>
                    <td>{{ $carbon::parse($item->check_in)->format('d M Y')}}</td>
                    <td>{{ $carbon::parse($item->check_out)->format('d M Y') }}</td>
                    <td>{{ $item->room_type->name }}</td>
                    <td>{{ $item->booking_agency->name }}</td>
                    <td>

                        @switch($item->status)
                            @case('New')
                                <span class="badge badge-reservation badge-new rounded-0">
                                    {{ $item->status }}
                                </span>
                            @break

                            @case('Confirm')
                                <span class="badge badge-reservation badge-confirmed rounded-0">
                                    {{ $item->status }}
                                </span>
                            @break

                            @case('Cancelled')
                                <span class="badge badge-reservation badge-cancelled rounded-0">
                                    {{ $item->status }}
                                </span>
                            @break

                            @case('CheckedOut')
                            @case('Checked Out')
                                <span class="badge badge-reservation badge-checked-out rounded-0">
                                    Checked Out
                                </span>
                            @break

                            @case('No Show')
                                <span class="badge badge-reservation badge-no-show rounded-0">
                                    {{ $item->status }}
                                </span>
                            @break

                            @case('Arrived')
                                <span class="badge badge-reservation badge-arrived rounded-0">
                                    {{ $item->status }}
                                </span>
                            @break

                            @case('Offer')
                                <span class="badge badge-reservation badge-offer rounded-0">
                                    {{ $item->status }}
                                </span>
                            @break

                            @default
                                <span class="badge badge-reservation badge-info rounded-0">
                                    {{ $item->status }}
                                </span>
                        @endswitch
                    </td>
                    <td class="d-print-none text-right"><button class="btn btn-success" data-toggle="modal" data-target="#showMoreInfo_{{ $item->id }}"><i class="fa fa-info-circle"></i></button></td>
                </tr>
            @endforeach
        </x-table>
        @foreach ($ex_reservations as $item)
        <div class="modal" id="showMoreInfo_{{ $item->id }}" tabindex="-1" aria-labelledby="showMoreInfo_{{ $item->id }}Label" aria-modal="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    @csrf
                    <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                        <h5 class="modal-title text-light" id="showMoreInfo_{{ $item->id }}Label">More Info</h5>
                    </div>

                    <div class="modal-body" style="background-color:#F5F7F9;">
                        <table class="table border border-secondary">
                            <thead>
                                <tr class="bg-secondary">
                                    <th>Guests</th>
                                    <th>Total Amount</th>
                                    <th>Country</th>
                                    <th>Booking Date</th>
                                    <th>Rate Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white">
                                    <td>{{ $item->guests ?? "NA" }}</td>
                                    <td>{{ showPriceWithCurrency($item->total_amount) }}</td>
                                    <td>{{ $item->country->name }}</td>
                                    <td>{{ $carbon::parse($item->booking_date)->format('d M Y') }}</td>
                                    <td>{{ $item->rate_type->name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer" style="background-color:#F5F7F9;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="modal" id="addBookingModal" tabindex="-1" aria-labelledby="addBookingModalLabel" aria-modal="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <form class="modal-content" action="{{ route('ex-reservations-store') }}" method="POST">
                    @csrf
                    <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                        <h5 class="modal-title text-light" id="addBookingModalLabel">Add Booking</h5>
                    </div>

                    <div class="modal-body" style="background-color:#F5F7F9;">
                        <div class="mt-0">
                            <div class="form-style-6">
                                <div class="row">
                                    <div class="col">
                                        <label class="">Booking Code</label>
                                        <input type="text" class="form-control1" placeholder="Booking Code" value="{{ old('booking_code') }}"
                                            name="booking_code" id="bookingCode" required="">

                                    </div>
                                    <div class="col">
                                        <label class="">Checkin date</label>
                                        <input type="date" class="form-control1" placeholder="mm/dd/yyyy" value="{{ old('checkin_date') }}"
                                            name="checkin_date" id="checkinDate" value="" required="">

                                    </div>
                                    <div class="col">
                                        <label class="">Checkout date</label>
                                        <input type="date" class=" form-control1" placeholder="mm/dd/yyyy" value="{{ old('checkout_date') }}"
                                            name="checkout_date" id="checkoutDate" value="" required="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col ">
                                        <label class="">Nationality</label>
                                        <select class="form-control1" style="" name="country" id="country"
                                            required="">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}" @if(old('country') == $country->id) selected @endif>{{ ucfirst($country->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col">
                                        <label class="">Guests</label>
                                        <input type="text" class="form-control1" style="" name="guests" id="guests" placeholder="Enter guests"
                                            required="">
                                    </div>
                                    <div class="col">
                                        <label class="">Reservation Amount</label>
                                        <input class="form-control1" type="number" min="0" value="{{ old('reservation_amount') }}"
                                            placeholder="Reservation Amount" name="reservation_amount"
                                            id="reservationAmount" required="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <label class="">Room type</label>
                                        <select class="form-control1" style="" name="room_type" id="roomType"
                                            required="">
                                            <option selected>Choose Room Type...</option>
                                            @foreach ($room_types as $room_type)
                                                <option value="{{ $room_type->id }}" @if(old('room_type') == $room_type->id) selected @endif>{{ ucfirst($room_type->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="">Booking Agency</label>
                                        <select class="form-control1" style="" name="booking_agency"
                                            id="bookingAgency" required="">
                                            <option selected>Choose Booking Agency...</option>
                                            @foreach ($booking_agencies as $booking_agency)
                                                <option value="{{ $booking_agency->id }}" @if(old('booking_agency') == $booking_agency->id) selected @endif>
                                                    {{ ucfirst($booking_agency->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="">Booking status</label>
                                        <select class="form-control1" style="" name="booking_status"
                                            id="bookingStatus" required="">
                                            <option value="Confirmed" @if(old('booking_status') == "Confirmed") selected @endif>Confirmed</option>
                                            <option value="Cancelled" @if(old('booking_status') == "Cancelled") selected @endif>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label class="">Booking Date</label>
                                        <input class="form-control1" placeholder="mm/dd/yyyy" name="booking_date" value="{{ old('booking_date') }}"
                                            id="bookingDate" type="date" value="" required="">
                                    </div>
                                    <div class="col">
                                        <label class="">Rate Type</label>

                                        <select class="form-control1" style="" name="rate_type" id="rateType"
                                            required="">
                                            <option selected="">Choose Rate Type...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer" style="background-color:#F5F7F9;">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const rateTypes = @json($rate_types->groupBy('room_type_id'));
        const roomTypeInput = document.getElementById('roomType');
        const rateTypeInput = document.getElementById('rateType');
        const oldRateType = "{{ old('rate_type', 0) }}"

        const handleRoomTypeInputUpdate = () => {
            rateTypeInput.innerHTML = "<option selected>Choose Rate Type...</option>";

            if(Number.parseInt(roomTypeInput.value)){
                const rateTypeValue = roomTypeInput.value;
                rateTypes[rateTypeValue].forEach(item => {
                    rateTypeInput.insertAdjacentHTML('beforeend', `<option value="${item.id}" ${oldRateType == item.id ? 'selected':''}>${item.name}</option>`)
                });
            }
        }

        roomTypeInput.addEventListener('change', handleRoomTypeInputUpdate);

        $(document).ready(function(){
            handleRoomTypeInputUpdate();
        })
    </script>
@endpush
