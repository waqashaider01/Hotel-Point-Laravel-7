@extends('layouts.master')
@section('content')
<script>
    
$('input[name="dates"]').daterangepicker();
</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <div>
        <x-table title='Reservation List' tableClasses="table reservation-table table-striped table-bordered">
            <x-slot name="header">
                <div class="row">
                    <div class="col-md-10 form-group d-flex d-print-none">
 <form action="{{ route('reservations-list') }}" method="get" class="mr-5">                     


                  <input type="text" name="daterange" class="custom_date_style" value="01/01/2018 - 01/15/2018" />
                    
                            {{-- <table>
                                <tbody>
                                    <tr>
                                        <input type="hidden" name="status" value="{{ request()->query('status', null) }}">
                                        <td class="align-middle">
                                            <div class="form-style-6 reservation-input my-0 p-0">
                                                <input class="m-0" name="from_date" type="date"
                                                    style="min-width: 270px;"
                                                    value="{{ old('from_date', request()->query('from_date', null)) }}"
                                                    id="from-date">
                                            </div>
                                        </td>
                                        <td class="align-middle"><span class="text-center px-2">-To-</span></td>
                                        <td class="align-middle">
                                            <div class="form-style-6 reservation-input my-0 p-0">
                                                <input class="m-0" name="to_date" type="date"
                                                    style="min-width: 270px;"
                                                    value="{{ old('to_date', request()->query('to_date', null)) }}"
                                                    id="to-date">
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-print-none pl-2">
                                                <button type="submit" class="btn btn-success rounded-0">
                                                    Run
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    @error('from_date')
                                        <tr>
                                            <td colspan="4" class="text-danger">{{ $message }}</td>
                                        </tr>
                                    @enderror

                                    @error('to_date')
                                        <tr>
                                            <td colspan="4" class="text-danger">{{ $message }}</td>
                                        </tr>
                                    @enderror
                            </table> --}}
                        </form>
                        <form action="{{ route('reservations-list') }}" method="get" class="ml-5">
                            <table>
                                <tbody>
                                    <tr>
                                        <input type="hidden" name="from_date"
                                            value="{{ request()->query('from_date', null) }}">
                                        <input type="hidden" name="to_date"
                                            value="{{ request()->query('to_date', null) }}">
                                        <td class="align-middle">
                                            <div class="form-style-6 reservation-input my-0 p-0">
                                                <select name="status" class="mb-0 all_filter_field" style="min-width: 150px;">
                                                    <option value="">All</option>
                                                    @foreach (['New', 'Confirmed', 'Arrived', 'Modified', 'Cancelled', 'CheckedOut'] as $item)
                                                        <option value="{{ $item }}"
                                                            @if ($item == request()->query('status', 'None')) selected @endif>
                                                            {{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-print-none pl-2">
                                                <button type="submit" class="btn btn-success rounded-0 filter_btn">
                                                    Filter
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    @error('status')
                                        <tr>
                                            <td colspan="2" class="text-danger">{{ $message }}</td>
                                        </tr>
                                    @enderror
                            </table>
                        </form>
                    </div>
                    <div class="col-md-2 d-print-none">
                        <a href="javascript:if(window.print)window.print()" type="button"
                            class="float-right btn btn-primary m-3 filter_btn">
                            <i class="fa fa-print print_icon"></i> Print
                        </a>
                    </div>
                    <div class="col d-none d-print-block">
                        <h1 class="h3">{{ request()->query('status', 'All') }} Reservations</h1>
                    </div>
                </div>
            </x-slot>
            <x-slot name="heading">
                <th>Booking ID</th>
                <th>Booking Code</th>
                <th>Channel</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Guest Name</th>
                <th>Amount</th>
                <th>Reservation Status</th>
                <th class="d-print-none">Actions</th>
            </x-slot>
            @foreach ($reservations as $item)
                <tr id="tr_{{ $item->id }}">
                    <td>
                        <a href="{{ route('reservation-show', $item) }}">
                            #{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                        </a>
                    </td>
                    <td>{{ $item->booking_code }}</td>
                    <td>{{ $item->booking_agency->name }}</td>
                    <td>{{ $item->check_in }}</td>
                    <td>{{ $item->check_out }}</td>
                    <td>{{ $item->guest->full_name }}</td>
                    <td>{{showPriceWithCurrency($item->reservation_amount)}}</td>
                    <td>
                        @switch($item->status)
                            @case('New')
                                <span class="badge badge-reservation badge-new rounded-0">
                                    {{ $item->status }}
                                </span>
                            @break

                            @case('Confirm')
                            @case('Confirmed')
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
                    <td class="text-right d-print-none">
                        @if ($item->status == 'Cancelled')
                            @if($item->cancellation_date < \Carbon\Carbon::parse($item->arrival_date)->subDays($item->rate_type->cancellation_charge_days)->toDateString())
                            <a class="btn btn-secondary btn-sm text-center"><i class="fa fa-print"></i></a>
                            <button class="btn btn-success btn-sm text-center" data-toggle="modal"
                                data-target="#addGuestModal_{{ $item->id }}"><i class="fa fa-user"></i></button>
                            
                            @else
                            <a href="{{ route('reservations-cancelled-print', $item) }}" class="btn btn-secondary btn-sm text-center"><i class="fa fa-print"></i></a>
                            <button class="btn btn-success btn-sm text-center" data-toggle="modal"
                                data-target="#addGuestModal_{{ $item->id }}"><i class="fa fa-user"></i></button>
                            @endif
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-table>
        @foreach ($reservations->where('status', 'Cancelled') as $item)
            <div class="modal" id="addGuestModal_{{ $item->id }}" tabindex="-1" aria-labelledby="addGuestModal_{{ $item->id }}Label" aria-modal="true">
                <div class="modal-dialog  ">
                    <form class="modal-content add-guest-form" action="{{ route('reservations-add-guest') }}" method="POST">
                        @csrf
                        <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                            <h5 class="modal-title text-light" id="addGuestModal_{{ $item->id }}Label">Guest Form for Reservation #{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</h5>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="reservation_id" value="{{ $item->id }}">
                            <input type="hidden" name="guest_info_match" value="yes">
                            @if($item->guest)
                                <input type="hidden" name="guest_id" value="{{ $item->guest->id }}">
                                <p class="text-center mb-2">There is already a guest attached to this reservation!</p>
                            @endif
                            @error('guest_info_match')
                                <p class="text-danger text-center mb-2">The newly entered guest information matches another guest information!</p>
                            @endif
                            <x-error field="reservation_id" />
                            <x-error field="matched_guest_id" />
                            <x-error field="guest_id" />
                            <x-error field="operation" />
                            <div class="form-style-6"
                                style="overflow-y:scroll; overflow-x:hidden; max-height:450px;" id="">
                                <div class="row">
                                    <div class="col">
                                        <label class="" for="guestFullName">Guest Full Name</label>
                                        <input class="" name="guest_full_name" type="text" placeholder="Jon Doe"
                                            value="{{ old('guest_full_name', $item->guest->full_name ?? "") }}" id="guestFullName">
                                        <x-error field="guest_full_name"/>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <label class="" for="guestEmail1">Guest Email 1</label>
                                        <input class="" name="guest_email_1" type="text" placeholder="jon@mail.com"
                                        value="{{ old('guest_email', $item->guest->email ?? "") }}" id="guestEmail1">
                                        <x-error field="guest_email_1"/>
                                    </div>
                                </div>

                                <div class=" row">
                                    <div class="col">
                                        <label class="" for="guestEmail2">Guest Email 2</label>
                                        <input class="" name="guest_email_2" type="text" placeholder="jon_doe@mail.com"
                                            value="{{ old('guest_email_2', $item->guest->email_2 ?? "") }}" id="guestEmail2">
                                        <x-error field="guest_email_2"/>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="" for="guestCountry">Guest Country</label>
                                        <select class="halfstyle" name="guest_country" id="guestCountry">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                        @if(old('guest_country', $item->guest->country_id ?? null) == $country->id) selected @endif>
                                                    {{ ucfirst($country->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-error field="guest_country"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="">Guest Phone</label>
                                        <input class="halfstyle" name="guest_phone" type="text" placeholder="Enter phone number"
                                        value="{{ old('guest_phone', $item->guest->phone ?? "") }}" id="example-text-input">
                                        <x-error field="guest_phone"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="">Guest Mobile</label>
                                        <input class="halfstyle" name="guest_mobile" type="text" placeholder="Enter mobile number"
                                        value="{{ old('guest_mobile', $item->guest->mobile ?? "") }}" id="example-text-input">
                                        <x-error field="guest_mobile"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="">Guest Postal Code</label>
                                        <input class="halfstyle" name="guest_postal_code" type="text" placeholder="Enter postal code"
                                        value="{{ old('guest_postal_code', $item->guest->postal_code ?? "") }}" id="example-text-input">
                                        <x-error field="guest_postal_code"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="background-color:#F5F7F9;">
                            @if($errors->has('guest_info_match'))
                                @error('guest_info_match')
                                <input type="hidden" name="matched_guest_id" value="{{ $message }}">
                                @enderror
                                <button type="submit" name="operation" value="update_and_attach_guest" class="btn btn-success btn-sm">Update & Attach Guest</button>
                                <button type="submit" name="operation" value="skip_guest_check" class="btn btn-primary btn-sm">Continue Create New Guest</button>
                            @else
                                <button type="submit" name="operation" value="update_guest" class="btn btn-success btn-sm">@if($item->guest) Update Guest Information @else Create Guest @endif</button>
                                <button type="submit" name="operation" value="skip_guest_check" class="btn btn-primary btn-sm">Create New Guest</button>
                            @endif
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" >Close</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    <script>
$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'right'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});
</script>
@endsection

@push('scripts')
    @if(old('reservation_id'))
        <script>
            $(document).ready(function(){
                $("#addGuestModal_{{ $item->id }}").modal('show');
            });
        </script>
    @endif
@endpush
