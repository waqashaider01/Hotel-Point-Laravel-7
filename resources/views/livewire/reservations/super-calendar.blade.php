<div>
    <div class="container-fluid d-print-none">
        <div class="card shadow-lg">
            <div class="card-header py-4">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md d-flex justify-content-center justify-content-md-start align-items-center mb-2">
                        <button class="mycstm text-light gradient-bg shadow editBtn" title="Previous" wire:click="prev">
                            <i style="color:white;" class="fas fa-chevron-circle-left"></i>
                        </button>
                        <div class="form-style-6 d-inline-flex justify-content-center align-items-center m-0">
                            <input type="text" class="date-inputs start-date" wire:model.lazy="text_dates.start">
                            <input type="text" class="date-inputs end-date" wire:model.lazy="text_dates.end">
                        </div>
                        <button class="mycstm text-light gradient-bg shadow editBtn" title="Next" wire:click="next">
                            <i style="color:white;" class="fas fa-chevron-circle-right"></i>
                        </button>
                        @error('text_dates.*')
                            <div style="max-width: 100%; margin-top: .25rem; font-size: .875em; color: #dc3545;"
                                role="alert"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-body p-0 m-0">
                <div style="display: none;" class="justify-content-center align-items-center" wire:loading.flex
                    wire:target="next,prev,loadCalendar">
                    <x-loader color="#333" />
                </div>
                <table class="table table-bordered shadow mb-0" id="calendar" style="max-width: 100% !important;"
                    wire:target="next,prev,loadCalendar" wire:loading.remove>
                    <thead style="max-width: 100% !important;">
                        <tr class="header_row bg-primary text-light">
                            <th style="min-width: 175px; border-right: none;">&nbsp;</th>
                            @foreach ($months as $month)
                                <th colspan="{{ $month['span'] }}"
                                    style="height:10px !important; border-left: none; {{ $loop->last ? '' : 'border-right: none;' }}">
                                    <span class="month_title">{{ $month['name'] }}</span>
                                </th>
                            @endforeach
                        </tr>
                        <tr class="header_row bg-primary text-light">
                            <th style="vertical-align: middle; border-bottom: none;">
                                <h3 class="mb-0" style="font-weight: normal; font-size: 1.5rem;">
                                    Rooms</h3>
                            </th>
                            @for ($loop_date = $start->copy(); $loop_date->lte($end); $loop_date->addDay())
                                <th class="text-center">
                                    {{ Str::substr($loop_date->format('D'), 0, 1)  }}<br>
                                    {{ $loop_date->format('d') }}
                                </th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody id="tabbody" style="max-width: 100% !important;">
                        @foreach ($room_types as $room_type)
                            <tr id="room_type_{{ $room_type->id }}" class="type">
                                <th style="border: none;">
                                    <span class="stick">
                                        <span class="font-weight-normal" style="font-size: 12px;">
                                            {{ $room_type->hotel_setting->name }}<br>
                                        </span>
                                        {{ $room_type->name }}
                                    </span>
                                    <span style="float: right;" data-toggle="tooltip" data-placement="right"
                                        data-html="true"
                                        data-original-title='<div class="mb-2">{{ $room_type->rate_types->map(fn($i) => "<b>{$i->name}:</b> {$i->reference_code}")->join('<br>') }}</div>'>
                                        <i class="bi bi-link-45deg" style="font-size: 16px;"></i>
                                    </span>
                                </th>
                                @for ($loop_date = $start->copy(); $loop_date->lte($end); $loop_date->addDay())
                                    <td class="text-center">
                                        <span
                                            @if ($calendar_objects[$room_type->id]['availability'][$loop_date->format('Y-m-d')] == 0) style="background-color: rgb(255, 0, 0);" @endif
                                            class="typespan">{{ $calendar_objects[$room_type->id]['availability'][$loop_date->format('Y-m-d')] }}</span>
                                        @foreach ($calendar_objects[$room_type->id]['restriction'][$loop_date->format('Y-m-d')] ?? [] as $restriction)
                                            <span class="cursor-pointer" data-toggle="tooltip" data-placement="right"
                                                data-html="true"
                                                data-original-title="<div class='mb-2'><b>{{ $restriction['rate_type']['name'] }}:</b> {{ $restriction['value'] }}</div>">
                                                <i class="fa fa-exclamation text-danger"
                                                    wire:click="showRestriction({{ $restriction['id'] }})"></i>
                                            </span>
                                        @endforeach
                                    </td>
                                @endfor
                            </tr>
                            @foreach ($room_type->active_rooms as $room)
                                <tr id="room_{{ $room->number }}" class="room">
                                    <td class="bg-white" style="border: none;">
                                        <span class="stick">{{ $room->number }}</span>
                                        <span class="cursor-pointer" style="float:right;"
                                            wire:click="showRoomInfo({{ $room->id }})">
                                            <i class="bi bi-info-circle roominfo"></i>
                                        </span>
                                    </td>
                                    @for ($loop_date = $start->copy(); $loop_date->lte($end); $loop_date->addDay())
                                        @php
                                            $maintenance = $calendar_objects[$room_type->id]['maintenance'][$room->id][$loop_date->format('Y-m-d')] ?? null;
                                            $reservation = $calendar_objects[$room_type->id]['reservations'][$room->id][$loop_date->format('Y-m-d')] ?? null;
                                            $skip = $calendar_objects[$room_type->id]['skip'][$room->id][$loop_date->format('Y-m-d')] ?? null;

                                            if ($maintenance) {
                                                if (is_array($maintenance)) {
                                                    $maintenance = new \App\Models\Maintenance($maintenance);
                                                }
                                                $span = \Carbon\Carbon::parse($maintenance->end_date)->diffInDays(\Carbon\Carbon::parse($maintenance->start_date)) + 1;
                                            } elseif ($reservation) {
                                                if (is_array($reservation)) {
                                                    $reservation = new \App\Models\Reservation($reservation);
                                                }
                                                $start_date = \Carbon\Carbon::parse($reservation->check_in);
                                                if ($start_date->format('Y-m-d') == $loop_date->format('Y-m-d')) {
                                                    $span = $start_date->diffInDays(\Carbon\Carbon::parse($reservation->check_out));
                                                } else {
                                                    $span = $loop_date->diffInDays(\Carbon\Carbon::parse($reservation->check_out));
                                                }
                                            }
                                        @endphp
                                        @if ($maintenance)
                                            <td class="text-center" colspan="{{ $span ?? 1 }}">
                                                <div class="reservdiv out-of-order"
                                                    wire:click="showOutOfOrder({{ $maintenance->id }})">
                                                    <span class="reservation-text">Out Of Order</span>
                                                </div>
                                            </td>
                                        @else
                                            @if ($reservation)
                                                <td class="text-center" colspan="{{ $span ?? 1 }}">

                                                    @php
                                                        $classes = "";
                                                        switch($reservation->status){
                                                            case('New'):
                                                                $classes = "reservdiv badge-new";
                                                                break;

                                                            case('Confirm'):
                                                                $classes = "reservdiv badge-confirmed";
                                                                break;
                                                             case('Confirmed'):
                                                                $classes = "reservdiv badge-confirmed";
                                                                break;

                                                            case('No Show'):
                                                                $classes = "reservdiv badge-no-show";
                                                                break;

                                                            case('Arrived'):
                                                                $classes = "reservdiv badge-arrived";
                                                                break;

                                                            case('Complimentary'):
                                                                $classes = "reservdiv badge-complimentary";
                                                                break;

                                                            case('Offer'):
                                                                $classes = "reservdiv badge-offer";
                                                                break;

                                                            case('CheckedOut'):
                                                                $classes = "reservdiv badge-checked-out";
                                                            case('Checked Out'):
                                                                $classes = "reservdiv badge-checked-out";
                                                             case('Checkedout'):
                                                                $classes = "reservdiv badge-checked-out";

                                                           
                                                        }
                                                    @endphp
                                                    <div class="{{ $classes }}" wire:click="showReservation({{ $reservation->id }})">
                                                        <span
                                                        class="reservation-text">{{ $reservation['guest']['full_name'] ?? "NA" }}</span>
                                                    </div>
                                                </td>
                                            @else
                                                @if (!$skip)
                                                    <td></td>
                                                @endif
                                            @endif
                                        @endif
                                    @endfor
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Modals --}}
    <div class="modal fade" id="outOfOrderModal" tabindex="-1" data-backdrop="static" data-keyboard="false"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light font-weight-bolder" style="font-size:20px;">Room Out Of Order Information
                    </h5>
                </div>
                <div class="modal-body" wire:loading>
                    <div class="d-flex justify-content-center align-items-center">
                        <x-loader color="#333" />
                    </div>
                </div>
                <div class="modal-body" wire:loading.remove>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Room Type</th>
                            <td>{{ $selected_out_of_order->room->room_type->name ?? "" }}</td>
                        </tr>
                        <tr>
                            <th>Room</th>
                            <td>{{ $selected_out_of_order->room->number ?? "" }}</td>
                        </tr>
                        <tr>
                            <th>Reason</th>
                            <td>{{ ucfirst($selected_out_of_order->reason) }}</td>
                        </tr>
                        <tr>
                            <th>Start Date</th>
                            <td>{{ $selected_out_of_order->start_date }}</td>
                        </tr>
                        <tr>
                            <th>End Date</th>
                            <td>{{ $selected_out_of_order->end_date }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer" wire:loading.remove>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="restrictionModal" tabindex="-1" data-backdrop="static" data-keyboard="false"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light font-weight-bolder" style="font-size:20px;">
                        Restriction Information
                    </h5>
                </div>
                <div class="modal-body" wire:loading>
                    <div class="d-flex justify-content-center align-items-center">
                        <x-loader color="#333" />
                    </div>
                </div>
                <div class="modal-body" wire:loading.remove>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Room Type</th>
                            <td>{{ $selected_restriction->room_type->name ?? "" }}</td>
                        </tr>
                        <tr>
                            <th>Rate Type</th>
                            <td>{{ $selected_restriction->rate_type->name ?? "" }} - [{{ $selected_restriction->rate_type->reference_code ?? "" }}]</td>
                        </tr>
                        <tr>
                            <th>Restriction Type</th>
                            <td>{{ ucfirst($selected_restriction->value) }}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{ $selected_restriction->date }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer" wire:loading.remove>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="roomInfoModal" tabindex="-1" data-backdrop="static" data-keyboard="false"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body" wire:loading wire:target="showRoomInfo">
                    <div class="d-flex justify-content-center align-items-center">
                        <x-loader color="#333" />
                    </div>
                </div>
                <div class="modal-body" wire:loading.remove wire:target="showRoomInfo">

                    <div class="mb-2" style=" position: relative; height: 40px !important;">
                        <h5 class="text-dark text-align-bottom" style="position: absolute; bottom: 0; left: 10;">Room
                            <i class="fa fa-info-circle text-dark" aria-hidden="true"></i>
                        </h5>
                        <h5 class="" style="position: absolute; bottom: 0; right: 0;">Room No: <span
                                id="showRoomno"><b>{{ $room_info['room_number'] }}</b></span></h5>
                    </div>
                    <hr style=" border-top: 3px solid #dfdfdf;">
                    <table class="table table-borderless table-striped">
                        <tbody>
                            <tr scope="row" class="bg-white">
                                <td>Room type</td>
                                <td><b>{{ $room_info['room_type'] }}</b></td>
                            </tr>
                            <tr scope="row" class="bg-white">
                                <td>Occupancy Rate</td>
                                <td><b>{{ number_format($room_info['occupancy_rate'], 2) }} % </b></td>
                            </tr>

                            <tr scope="row" class="bg-white">
                                <td>ADR</td>
                                <td><b>{{ showPriceWithCurrency($room_info['adr']) }}</b></td>
                            </tr>

                            <tr scope="row" class="bg-white">
                                <td>Out Of Order</td>
                                <td><b>{{ $room_info['out_of_order'] }}</b></td>
                            </tr>

                            <tr scope="row" class="bg-white">
                                <td>Accommodation Revenue (Net)</td>
                                <td>
                                    <b>{{ showPriceWithCurrency($room_info['accommodation_revenue']) }}</b>
                                </td>
                            </tr>

                            <tr scope="row" class="bg-white">
                                <td>Extra Revenue (Net)</td>
                                <td><b>{{ showPriceWithCurrency($room_info['extra_revenue']) }}</b>
                                </td>
                            </tr>
                            <tr scope="row" class="bg-white">
                                <td>Overnight Tax Revenue</td>
                                <td>
                                    <b>{{ showPriceWithCurrency($room_info['overnight_tax_revenue']) }}</b>
                                </td>
                            </tr>

                            <tr scope="row" class="bg-white">
                                <td>Commission</td>
                                <td><b>{{ showPriceWithCurrency($room_info['commission']) }}</b></td>
                            </tr>

                            <tr scope="row" class="bg-white">
                                <td>Guest Count</td>

                                <td>
                                    <span class="mr-2">
                                        <span>Adults:
                                        </span><span><b>{{ $room_info['guest_count']['adult'] }}</b></span>
                                    </span class="mr-2">
                                    <span class="mr-2"><span>Kids:
                                        </span><span><b>{{ $room_info['guest_count']['kids'] }}</b></span></span
                                        class="mr-2">
                                    <span class="mr-2"><span>Infants:
                                        </span><span><b>{{ $room_info['guest_count']['infants'] }}</b></span>
                                    </span class="mr-2">
                                </td>

                            </tr>

                            <tr scope="row" class="bg-white">
                                <td>Channel</td>
                                <td> {!! $room_info['channel']['total'] !!}
                                </td>
                            </tr>

                            <tr scope="row" class="bg-white">
                                <td>VAT</td>
                                <td>
                                    <div class="mr-5 float-left"><span>Accommodation:
                                        </span><span><b>{{ showPriceWithCurrency($room_info['vat']['accommodation']) }}</b></span>
                                    </div>
                                    <div class="mr-5 float-left"><span>Extras:
                                        </span><span><b>{{ showPriceWithCurrency($room_info['vat']['extra']) }}</b></span>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <hr style=" border-top: 3px solid #dfdfdf;">
                    <div class="mb-2 mt-5 d-flex justify-content-end align-items-center">
                        <button type="button" class="btn btn-outline-primary d-print-none mr-5"
                            style="padding-left:30px;padding-right:30px;" id="printinfo" onclick="window.print()">
                            Print
                        </button>

                        <button type="button" class=" btn btn-outline-secondary d-print-none" wire:loading.remove
                            wire:target="showRoomInfo" style="padding-left:30px;padding-right:30px;"
                            data-dismiss="modal">Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reservationModal" tabindex="-1" data-backdrop="static" data-keyboard="false"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light font-weight-bolder" style="font-size:20px;">
                        Reservation Info
                    </h5>
                </div>
                <div class="modal-body" wire:loading>
                    <div class="d-flex justify-content-center align-items-center">
                        <x-loader color="#333" />
                    </div>
                </div>
                <div class="modal-body p-0" style="overflow-x: hidden;" wire:loading.remove>
                    <div class="px-2 py-3">
                        <table class="table table-bordered table-striped">
                            <tbody>
                            @if($selected_reservation)
                                    <tr scope="row">
                                        <th>Booking ID</th>
                                        <td>{{ $selected_reservation->id }}</td>
                                    </tr>
                                    <tr scope="row">
                                        <th>Booking Code</th>
                                        <td>{{ $selected_reservation->booking_code }}</td>
                                    </tr>
                                    <tr scope="row">
                                        <th>Agency</th>
                                        <td>{{$selected_reservation->booking_agency? $selected_reservation->booking_agency->name:''}}</td>
                                    </tr>
                                    <tr scope="row">
                                        <th>Check In</th>
                                        <td>{{ \Carbon\Carbon::parse($selected_reservation->check_in ?? now())->format('F j, Y') }}
                                        </td>
                                    </tr>
                                    <tr scope="row">
                                        <th>Check Out</th>
                                        <td>{{ \Carbon\Carbon::parse($selected_reservation->check_out ?? now())->format('F j, Y') }}
                                        </td>
                                    </tr>
                                    <tr scope="row">
                                        <th>Amount</th>
                                        <td>{{ showPriceWithCurrency($selected_reservation->reservation_amount) }}
                                        </td>
                                    </tr>
                                    <tr scope="row">
                                        <th>Payment Method</th>
                                        <td>{{$selected_reservation->payment_method? $selected_reservation->payment_method->name:''}}</td>
                                    </tr>
                                    <tr scope="row">
                                        <th>Payment Mode</th>
                                        <td>{{$selected_reservation->payment_mode? $selected_reservation->payment_mode->name:''}}</td>
                                    </tr>
                                    <tr scope="row">
                                        <th>Rate Type</th>
                                        <td>{{$selected_reservation->rate_type? $selected_reservation->rate_type->reference_code:'' }}</td>
                                    </tr>
                                    <tr scope="row">
                                        <th>Status</th>
                                        <td>{{ Str::title($selected_reservation->status) }}</td>
                                    </tr>
                                    @endif
                            </tbody>
                        </table>
                        <div style="max-width: 100%">
                            <hr style="border-top: 3px solid #dfdfdf;">
                            <div class="mb-2 mt-5 d-flex justify-content-end align-items-center">
                                <button type="button" class=" btn btn-secondary btn-sm" data-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- End Modals --}}
    <script>
        document.addEventListener('livewire:load', function() {
            $('.start-date').flatpickr({
                dateFormat: "F j, Y",
            });
            $('.end-date').flatpickr({
                dateFormat: "F j, Y",
                position: "auto right"
            });
        });
    </script>
</div>
