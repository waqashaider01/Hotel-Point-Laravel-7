@extends('layouts.master')
@section('content')
    <div>
        <x-table title='Payment Folio'>
            <x-slot name="header">
                <table class="table">
                    <thead>
                        <tr>
                            <td scope="col">Booking ID</td>
                            <td scope="col">Arrival Date</td>
                            <td scope="col">Departure Date</td>
                            <td scope="col">Rate Type</td>
                            <td scope="col">Channel</td>
                            <td scope="col">Room Number</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                #{{ $reservation->id }}
                            </td>
                            <td>{{ $reservation->check_in }}</td>
                            <td>{{ $reservation->check_out }}</td>
                            <td>{{ $reservation->rate_type->name }}</td>
                            <td>{{ $reservation->booking_agency->name }}</td>
                            <td>{{ $reservation->room->number }}</td>
                            <td>
                                <a style="padding: 0.5rem 0.7rem;" href="{{ route('edit-reservation', ['id' => $reservation->id]) }}" class="btn btn-info">
                                    <i class="fa fa-edit" style="font-size: 1.1rem;"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </x-slot>
            <x-slot name="heading">
                <th>Revenue Type</th>
                <th>Total</th>
                <th>Paid</th>
                <th>Balance</th>
                <th>Status</th>
                <th data-orderable="false">More Info</th>
            </x-slot>
            @if ($data)
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item['title'] }}</td>
                        <td>{{ showPriceWithCurrency($item['total']) }}</td>
                        <td>{{ showPriceWithCurrency($item['paid']) }}</td>
                        <td>{{ showPriceWithCurrency($item['balance']) }}</td>
                        <td>
                            @if ($item['balance'] == 0)
                                <span class='' style='background-color:#48BD91;text-align:right;padding:2px 12px;color:white;border-radius:2px;'>Paid</span>
                            @else
                                <span class='' style='background-color:red;text-align:right;padding:2px 12px;color:white;border-radius:2px;'>Not Paid </span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#modal{{ explode(' ', trim($item['title']))[0] }}"><i class="fas fa-info-circle"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </x-table>
    </div>

    {{-- modals --}}
    <div class="modal fade" id="modalAccommodation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg w-50 modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header mb-4" style="background-color:#48BBBE;">
                    <h5 class="modal-title text-light">Accommodation Analysis</h5>
                </div>
                <div class="modal-body" style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-3%;">
                    <div class="table" id='reservations-table'>
                        <div>
                            <div class="row th text-center">
                                <div class="col">Date</div>
                                <div class="col">Rate Type</div>
                                <div class="col">Daily Rate</div>
                            </div>
                        </div>
                        @foreach ($daily_rates as $rate)
                            <div class='row mytr text-center'>
                                <div class="col idcolor">{{ $rate->date }}</div>
                                <div class="col">{{ $rate->reservation->rate_type->name }}</div>
                                <div class="col">{{ showPriceWithCurrency($rate->price) }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer" style="background-color:#F5F7F9;">
                    <button type="button" class="" data-dismiss="modal" style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalOvernight" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header mb-4" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Overnight Tax</h5>
                </div>
                <div class="modal-body" style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-5%;">
                    <div class="table" id='reservations-table'>
                        <div>
                            <div class="row th text-center">
                                <div class="col">Date</div>
                                <div class="col">Overnight Tax</div>
                                <div class="col">Comments</div>
                            </div>
                        </div>
                        @foreach ($overnights as $overnight)
                            <div class='row mytr text-center'>
                                <div class="col idcolor">{{ $overnight->date }}</div>
                                <div class="col">{{showPriceWithCurrency($overnight->value) }}</div>
                                <div class="col">{{ $overnight->comments }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer" style="background-color:#F5F7F9;">
                    <button type="button" class="" data-dismiss="modal" style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalServices" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header mb-4" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Services</h5>
                </div>
                <div class="modal-body" style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-3%;">
                    <div class="table" id='reservations-table'>
                        <div>
                            <div class="row th text-center">
                                <div class="col">Date</div>
                                <div class="col">Type</div>
                                <div class="col">Units</div>
                                <div class="col">Price</div>
                            </div>
                        </div>
                        @foreach ($services as $service)
                            <div class='row mytr text-center'>
                                <div class="col idcolor">{{ $service->date }}</div>
                                <div class="col">{{ $service->extra_charge->product }}</div>
                                <div class="col">{{ $service->units }}</div>
                                <div class="col">{{ showPriceWithCurrency($service->extra_charge_total) }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer" style="background-color:#F5F7F9;">
                    <button type="button" class="" data-dismiss="modal" style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
