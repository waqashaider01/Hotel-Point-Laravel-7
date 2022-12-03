@extends('layouts.master')
@section('content')
    @inject('carbon', 'Carbon\Carbon')
    <div class="container-fluid reservation-view">
        <div class="row">
            <div class="col-md-4">
                <div class="infocard shadow-sm bg-white">
                    <div class="row mt-1">
                        <div class="col">
                            <label>Status: &nbsp;</label>
                            @switch($reservation->status)
                                @case('New')
                                    <span class="text-theme-new">
                                        {{ $reservation->status }}
                                    </span>
                                @break

                                @case('Confirm')
                                    <span class="text-theme-confirmed">
                                        {{ $reservation->status }}
                                    </span>
                                @break

                                @case('Cancelled')
                                    <span class="text-theme-cancelled">
                                        {{ $reservation->status }}
                                    </span>
                                @break

                                @case('CheckedOut')
                                @case('Checked Out')
                                    <span class="text-theme-checked-out">
                                        Checked Out
                                    </span>
                                @break

                                @case('No Show')
                                    <span class="text-theme-no-show">
                                        {{ $reservation->status }}
                                    </span>
                                @break

                                @case('Arrived')
                                    <span class="text-theme-arrived">
                                        {{ $reservation->status }}
                                    </span>
                                @break

                                @case('Offer')
                                    <span class="text-theme-offer">
                                        {{ $reservation->status }}
                                    </span>
                                @break

                                @default
                                    <span class="text-theme-info">
                                        {{ $reservation->status }}
                                    </span>
                            @endswitch
                        </div>
                    </div>
                    <hr style="">
                    <div class="row">
                        <div class="col">
                            <label>Name</label><br>
                            <span class="font-weight-bold">{{ ucwords($reservation->guest->full_name) }}</span>
                        </div>
                        <div class="col">
                            <label>Country</label><br>
                            <span class="font-weight-bold">{{ $reservation->guest->country->name ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <label>Phone</label><br>
                            <span class="font-weight-bold">{{ $reservation->guest->phone }}</span>
                        </div>
                        <div class="col">
                            <label>Email</label><br>
                            <span class="font-weight-bold">{{ $reservation->guest->email }}</span>
                        </div>
                    </div>
                    <hr style="">
                    <div class="row">
                        <div class="col">
                            <label>Check-in</label><br>
                            <span
                                class="font-weight-bold">{{ $carbon::parse($reservation->check_in)->format('d M Y') }}</span>
                        </div>
                        <div class="col">
                            <label>Check-out</label><br>

                            <span
                                class="font-weight-bold">{{ $carbon::parse($reservation->check_out)->format('d M Y') }}</span>
                        </div>
                        <div class="col">
                            <label>Nights</label><br>
                            <span class="font-weight-bold">{{ $reservation->overnights ?? 0 }}</span>
                        </div>
                    </div>
                    <hr style="">
                    <div class="row">
                        <div class="col">
                            <label>Adults</label><br>
                            <span class="font-weight-bold">{{ $reservation->adults }}</span>
                        </div>
                        <div class="col">
                            <label>Kids</label><br>
                            <span class="font-weight-bold">{{ $reservation->kids }}</span>
                        </div>
                        <div class="col">
                            <label>Infants</label><br>
                            <span class="font-weight-bold">{{ $reservation->infants }}</span>
                        </div>
                    </div>
                    <hr style="">
                    <div class="row">
                        <div class="col">
                            <label>Booking Source</label><br>
                            <span class="font-weight-bold">{{ ucwords($reservation->booking_agency->name ?? "N/A") }}</span>
                        </div>
                        <div class="col">
                            <label>Company</label><br>
                            <span class="font-weight-bold">{{ ucwords($reservation->company->name ?? "N/A") }}</span>
                        </div>
                    </div>
                    <hr style="">
                    <div class="row">
                        <div class="col">
                            <label>Arrival Hour</label><br>
                            <span class="font-weight-bold">
                                {{ $carbon::parse($reservation->arrival_hour)->format('h:i A') }} </span>
                        </div>
                    </div>
                    <hr style="">
                    <div class="row">
                        <div class="col">
                            <label>Guest's Message</label><br>
                            <span class="font-weight-bold">{{ ucfirst($reservation->comment) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="d-none d-print-block" style="height: 15px;"></div>
                <div class="infocard shadow-sm bg-white">
                    <div class="row">
                        <div class="col d-print-none">
                            <span type="button" class="btn btn-outline-secondary border-2 rounded-md"
                                onclick="window.print()">
                                <i class="fa fa-print" aria-hidden="true"></i> Print
                            </span>
                            <a href="{{ route('calendar') }}" type="button"
                                class="btn btn-outline-secondary border-2 rounded-md">
                                <i class="fas fa-calendar-alt" aria-hidden="true"></i> Calendar
                            </a>
                            <span type="button" class="btn btn-outline-secondary border-2 rounded-md" id="showEmailModal">
                                <i class="far fa-envelope" aria-hidden="true"></i> Send Email
                            </span>
                            <span type="button" class="btn btn-outline-secondary border-2 rounded-md"
                                onclick="document.getElementById('paymentInfo').classList.toggle('d-none')">
                                <i class="far fa-credit-card" aria-hidden="true"></i> Payment
                            </span>
                        </div>
                        <div class="col">
                            <div class="text-right">Booking was made on <span>
                                    {{ $carbon::parse($reservation->booking_date)->format('d M Y') }} </span></div>
                        </div>
                    </div>
                    <div class="row mt-7">
                        <div class="col">
                            <div class="row darker">
                                <div class="col">
                                    Booking ID
                                </div>
                                <div class="col">
                                    Booking Code
                                </div>
                                <div class="col">
                                    Room Type
                                </div>
                                <div class="col">
                                    Room No.
                                </div>
                            </div>
                            <div class="row lighter">
                                <div class="col">
                                    #{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}
                                </div>
                                <div class="col">
                                    {{ $reservation->booking_code }}
                                </div>
                                <div class="col">
                                    {{ $reservation->room->room_type->name }}
                                </div>
                                <div class="col">
                                    {{ $reservation->room->number }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-7">
                        <div class="col">
                            <div class="row darker">
                                <div class="col">
                                    Rate Type
                                </div>
                                <div class="col">
                                    Meal Category
                                </div>
                                <div class="col">
                                    Reservation Amount
                                </div>
                                <div class="col">
                                    Payment Method
                                </div>
                            </div>
                            <div class="row lighter">
                                <div class="col">
                                    {{ $reservation->rate_type->name }}
                                </div>
                                <div class="col">
                                    {{ $reservation->rate_type->rate_type_category->name }}
                                </div>
                                <div class="col">
                                    {{ showPriceWithCurrency($reservation->reservation_amount) }}
                                </div>
                                <div class="col">
                                    {{ $reservation->payment_method->name }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-7">
                        <div class="col">
                            <div class="row darker ">
                                <div class="col-5">
                                    Payment Mode
                                </div>
                                <div class="col-4">
                                    Charge Date
                                </div>
                                <div class="col-3 ">
                                    Virtual Card
                                </div>
                            </div>
                            <div class="row lighter ">
                                <div class="col-5">
                                    {{ $reservation->payment_mode->name }}
                                </div>
                                <div class="col-4">
                                    {{ $carbon::parse($reservation->charge_date)->format('d M Y') }}
                                </div>
                                <div class="col-3">
                                    @if ($reservation->virtual_card)
                                        <span class="text-theme-confirmed">{{ $reservation->virtual_card }}</span>
                                    @else
                                        <span class="text-theme-cancelled">No</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-7 d-none" id="paymentInfo">
                        <div class="col">
                            <div class="row darker">
                                <div class="col-5">
                                    Payment Type
                                </div>
                                <div class="col-4">
                                    Payment Date
                                </div>
                                <div class="col-3">
                                    Payment Value
                                </div>
                            </div>
                            @php
                                $reservation_payments = [
                                    'Accommodation Payment' => $reservation->guest_accommodation_payment,
                                    'Extras Payment' => $reservation->guest_extras_payments,
                                    'Overnight Tax' => $reservation->guest_overnight_tax_payments,
                                ];
                            @endphp
                            @foreach ($reservation_payments as $type => $payments)
                                @foreach ($payments as $payment)
                                    <div class="row lighter">
                                        <div class="col-5">
                                            {{ $type }}
                                        </div>
                                        <div class="col-4">
                                            {{ $carbon::parse($payment->date)->format('d M Y') }}
                                        </div>
                                        <div class="col-3">
                                            {{ showPriceWithCurrency($payment->value) }}
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @livewire('reservations.send-reservation-email', ['reservation' => $reservation->id])
@endsection
@push('scripts')
    <script>
        $("#showEmailModal").on('click', function(){
            $('#sendEmailModal').modal('show');
        })
    </script>
@endpush
