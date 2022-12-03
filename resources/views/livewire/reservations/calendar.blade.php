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
                    <div class="col-md d-flex justify-content-center justify-content-md-end align-items-center">
                        <a class="mycstm text-light gradient-bg shadow editBtn" title="Create New Reservation"
                            href="{{ route('new-reservation') }}">
                            <i style="color:white;" class="fas fa-plus"></i>
                        </a>
                        <button class="mycstm text-light gradient-bg shadow editBtn"
                            title="Create New Out Of Order Room" wire:click="newOutOfOrder">
                            <i style="color:white;" class="fas fa-user-slash"></i>
                        </button>
                        <!-- <button class="mycstm text-light gradient-bg shadow editBtn" title="Create New Restrictions"
                            wire:click="newRestriction">
                            <i style="color:white;" class="fas fa-exclamation"></i>
                        </button> -->
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
                                    <span class="stick">{{ $room_type->name }}</span>
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
                                                    wire:click="modifyRestriction({{ $restriction['id'] }})"></i>
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
                                                if($start_date->format('Y-m-d') == $loop_date->format('Y-m-d')){
                                                    $span = $start_date->diffInDays(\Carbon\Carbon::parse($reservation->check_out));
                                                } else {
                                                    $span = $loop_date->diffInDays(\Carbon\Carbon::parse($reservation->check_out));
                                                }
                                            }
                                        @endphp
                                        @if ($maintenance)
                                            <td class="text-center" colspan="{{ $span ?? 1 }}">
                                                <div class="reservdiv out-of-order"
                                                    wire:click="modifyOutOfOrder({{ $maintenance->id }})">
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
                                                    <div class="{{ $classes }}" wire:click="showReservation({{ $reservation->id }})" x-on:dblclick="window.location.replace('{{ route('edit-reservation', $reservation->id) }}')">
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
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form class="modal-content" wire:submit.prevent="saveOutOfOrder">
                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light font-weight-bolder" style="font-size:20px;">Room Out Of Order
                    </h5>
                </div>
                <div class="modal-body" wire:loading wire:target="saveOutOfOrder,modifyOutOfOrder,deleteOutOfOrder">
                    <div class="d-flex justify-content-center align-items-center">
                        <x-loader color="#333" />
                    </div>
                </div>
                <div class="modal-body" wire:loading.remove
                    wire:target="saveOutOfOrder,modifyOutOfOrder,deleteOutOfOrder">
                    <div class="form-style-6">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label>Room</label>
                                <select class="mb-1" wire:model="selected_out_of_order.room_id" required>
                                    <option value="">Select Room</option>
                                    @foreach ($room_types as $room_type)
                                        @foreach ($room_type->rooms as $room)
                                            <option value="{{ $room->id }}">{{ $room->number }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                                <x-error field="selected_out_of_order.room_id" />
                            </div>
                            <div class="col-md-6 mb-4">
                                <label>Reason</label>
                                <input type="text" class="mb-1" wire:model.lazy="selected_out_of_order.reason"
                                    placeholder="Enter reason" required>
                                <x-error field="selected_out_of_order.reason" />
                            </div>
                            <div class="col-md-6 mb-4">
                                <label>Start Date</label>
                                <input type="text" class="mb-1" wire:model="selected_out_of_order.start_date"
                                    placeholder="Select start date" id="outOfOrderStartDate" required>
                                <x-error field="selected_out_of_order.start_date" />
                            </div>
                            <div class="col-md-6 mb-4">
                                <label>End Date</label>
                                <input type="text" class="mb-1" wire:model="selected_out_of_order.end_date"
                                    placeholder="Select end date" id="outOfOrderEndDate" required>
                                <x-error field="selected_out_of_order.end_date" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" wire:loading.remove
                    wire:target="saveOutOfOrder,modifyOutOfOrder,deleteOutOfOrder">
                    <button type="submit" class="btn btn-success btn-sm">
                        @if ($editingOutOfOrder)
                            Update
                        @else
                            Add
                        @endif
                    </button>
                    @if ($editingOutOfOrder)
                        <button type="button" class="btn btn-danger btn-sm"
                            wire:click="deleteOutOfOrder({{ $selected_out_of_order->id }})">Remove</button>
                    @endif
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="restrictionModal" tabindex="-1" data-backdrop="static" data-keyboard="false"
        wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form class="modal-content" wire:submit.prevent="saveRestriction">
                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light font-weight-bolder" style="font-size:20px;">
                        Restrictions
                    </h5>
                </div>
                <div class="modal-body" wire:loading
                    wire:target="saveRestriction,modifyRestriction,deleteRestriction">
                    <div class="d-flex justify-content-center align-items-center">
                        <x-loader color="#333" />
                    </div>
                </div>
                <div class="modal-body" wire:loading.remove
                    wire:target="saveRestriction,modifyRestriction,deleteRestriction">
                    <div class="form-style-6">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label>Room Type</label>
                                <select class="mb-1" wire:model="selected_restriction.room_type_id" required>
                                    <option value="">Select Room</option>
                                    @foreach ($room_types as $room_type)
                                        <option value="{{ $room_type->id }}">{{ $room_type->name }}</option>
                                    @endforeach
                                </select>
                                <x-error field="selected_restriction.room_type_id" />
                            </div>
                            <div class="col-md-6 mb-4">
                                <label>Rate Type</label>
                                <select class="mb-1" wire:model="selected_restriction.rate_type_id" required>
                                    <option value="">Select Rate</option>
                                    @foreach ($room_types->where('id', $selected_restriction->room_type_id)->first()->rate_types ?? [] as $rate_type)
                                        <option value="{{ $rate_type->id }}">{{ $rate_type->name }}</option>
                                    @endforeach
                                </select>
                                <x-error field="selected_restriction.rate_type_id" />
                            </div>
                            <div class="col-md-6 mb-4">
                                <label>Restriction Name</label>
                                <select class="mb-1" wire:model="selected_restriction.name" required>
                                    <option value="">Select Rate</option>
                                    @foreach ($restriction_types as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <x-error field="selected_restriction.rate_type_id" />
                            </div>
                            <div class="col-md-6 mb-4">
                                <label>Date</label>
                                <input type="text" class="mb-1" wire:model="selected_restriction.date"
                                    placeholder="Select start date" id="restrictionDate" required>
                                <x-error field="selected_restriction.date" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" wire:loading.remove
                    wire:target="saveRestriction,modifyRestriction,deleteRestriction">
                    <button type="submit" class="btn btn-success btn-sm">
                        @if ($editingRestriction)
                            Update
                        @else
                            Add
                        @endif
                    </button>
                    @if ($editingRestriction)
                        <button type="button" class="btn btn-danger btn-sm"
                            wire:click="deleteRestriction({{ $selected_restriction->id }})">Remove</button>
                    @endif
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </form>
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
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light font-weight-bolder" style="font-size:20px;">
                        Reservation Info
                    </h5>
                    <a href="{{ route('edit-reservation', $selected_reservation->id ?? 0) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit" style="font-size: 12px;"></i> Edit</a>
                </div>
                <div class="modal-body" wire:loading wire:target="changeReservationTab,handleReservationSplit">
                    <div class="d-flex justify-content-center align-items-center">
                        <x-loader color="#333" />
                    </div>
                </div>
                <div class="modal-body p-0" style="overflow-x: hidden;" wire:loading.remove wire:target="changeReservationTab,handleReservationSplit">
                    <ul class="nav nav-pills nav-fill" style="margin-top: -4px; border-bottom: 3px solid #dfdfdf;">
                        <li class="nav-item">
                            <a style="border-radius: 0;" class="nav-link {{ $active_tab == 'info' ? 'active' : '' }}"
                                wire:click="changeReservationTab('info', '#reservationInfo')" role="button"
                                aria-expanded="false" aria-controls="reservationInfo">
                                Info
                            </a>
                        </li>
                        <li class="nav-item">
                            <a style="border-radius: 0;"
                                class="nav-link {{ $active_tab == 'split' ? 'active' : '' }}"
                                wire:click="changeReservationTab('split', '#reservationSplit')" role="button"
                                aria-expanded="false" aria-controls="reservationSplit">
                                Split
                            </a>
                        </li>
                        <li class="nav-item">
                            <a style="border-radius: 0;" class="nav-link {{ $active_tab == 'move' ? 'active' : '' }}"
                                wire:click="changeReservationTab('move', '#reservationMove')" role="button"
                                aria-expanded="false" aria-controls="reservationMove">
                                Move
                            </a>
                        </li>
                        <li class="nav-item">
                            <a style="border-radius: 0;"
                                class="nav-link {{ $active_tab == 'resize' ? 'active' : '' }}"
                                wire:click="changeReservationTab('resize', '#reservationResize')" role="button"
                                aria-expanded="false" aria-controls="reservationResize">
                                Resize
                            </a>
                        </li>
                    </ul>
                    <div class="px-2 py-3">
                        <div id="reservationInfo" class="collapse @if($active_tab == 'info') show @endif">
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
                                        <td>{{$selected_reservation->booking_agency_id? $selected_reservation->booking_agency->name:''}}</td>
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
                                        <td>{{$selected_reservation->payment_method_id? $selected_reservation->payment_method->name:''}}</td>
                                    </tr>
                                    <tr scope="row">
                                        <th>Payment Mode</th>
                                        <td>{{$selected_reservation->payment_mode_id? $selected_reservation->payment_mode->name:''}}</td>
                                    </tr>
                                    <tr scope="row">
                                        <th>Rate Type</th>
                                        <td>{{$selected_reservation->rate_type_id? $selected_reservation->rate_type->reference_code:'' }}</td>
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
                        <form id="reservationSplit" class="collapse @if($active_tab == 'split') show @endif" wire:submit.prevent="handleReservationSplit">
                            <div class="form-style-6">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="row">
                                            <div class="col">
                                                <fieldset
                                                    style="border:1px solid #43D1AF; border-radius:5px;padding:15px;margin:0px;margin-bottom:0px !important;height:100%;">
                                                    <legend
                                                        style="width:auto; margin-bottom: 0px; font-size: 18px; font-weight: bold; color: #3D3D3D;">
                                                        Guest Details
                                                    </legend>
                                                    <div>
                                                        <label class="d-block">Guest Name</label>
                                                        <input type="text"
                                                            wire:model.lazy="reservation_split.guest.name"
                                                            placeholder="Guest Name">
                                                            <x-error field="reservation_split.guest.name" />
                                                    </div>
                                                    <div>
                                                        <label class="d-block">Guest Email</label>
                                                        <input type="text"
                                                            wire:model.lazy="reservation_split.guest.email"
                                                            placeholder="Guest Email">
                                                            <x-error field="reservation_split.guest.email" />
                                                    </div>
                                                    <div>
                                                        <label class="d-block">Guest Phone</label>
                                                        <input type="text"
                                                            wire:model.lazy="reservation_split.guest.phone"
                                                            placeholder="Guest Phone">
                                                            <x-error field="reservation_split.guest.phone" />
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <fieldset
                                                    style="border:1px solid #43D1AF; border-radius:5px;padding:15px;margin-top:10px;margin-bottom:0px !important;height:100%;">
                                                    <legend
                                                        style="width:auto; margin-bottom: 0px; font-size: 18px; font-weight: bold; color: #3D3D3D;">
                                                        Current Room Details
                                                    </legend>
                                                    <div>
                                                        <label class="d-block">Room</label>
                                                        <input type="text"
                                                            value="{{$selected_reservation->room_id? $selected_reservation->room->number:''}}"
                                                            readonly="" disabled="">
                                                    </div>
                                                    <div>
                                                        <label class="d-block">CheckIn Date</label>
                                                        <input type="text"
                                                            value="{{ \Carbon\Carbon::parse($selected_reservation->check_in)->format('F j, Y') }}"
                                                            readonly disabled>
                                                    </div>
                                                    <div>
                                                        <label class="d-block">CheckOut Date</label>
                                                        <input type="text" wire:model.lazy="reservation_split.new_room.checkin" readonly disabled>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <fieldset
                                                    style="border:1px solid #43D1AF; border-radius:5px;padding:15px;margin:0px;margin-bottom:0px !important;height:100%;">
                                                    <legend
                                                        style="width:auto; margin-bottom: 0px; font-size: 18px; font-weight: bold; color: #3D3D3D;">
                                                        New Room Details
                                                    </legend>
                                                    <div class="row">
                                                        <div class="col-md-4 mb-4">
                                                            <label>Room Type</label>
                                                            <select class="mb-1" wire:model="reservation_split.new_room.type" required>
                                                                <option value="">Select Room Type</option>
                                                                @foreach ($room_types as $room_type)
                                                                    <option value="{{ $room_type->id }}">{{ $room_type->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <x-error field="reservation_split.new_room.type" />
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label>Room Number</label>
                                                            <select class="mb-1" wire:model="reservation_split.new_room.number" required>
                                                                <option value="">Select Room</option>
                                                                @foreach ($room_types->where('id', $reservation_split['new_room']['type'])->first()->rooms ?? [] as $room)
                                                                    <option value="{{ $room->id }}">{{ $room->number }}</option>
                                                                @endforeach
                                                            </select>
                                                            <x-error field="reservation_split.new_room.number" />
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label>Rate Type</label>
                                                            <select class="mb-1" wire:model="reservation_split.new_room.rate" required>
                                                                <option value="">Select Rate</option>
                                                                @foreach ($room_types->where('id', $reservation_split['new_room']['type'])->first()->rate_types ?? [] as $rate_type)
                                                                    <option value="{{ $rate_type->id }}">{{ $rate_type->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <x-error field="reservation_split.new_room.rate" />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>CheckIn Date</label>
                                                            <input type="text" id="newRoomCheckin" wire:model.lazy="reservation_split.new_room.checkin">
                                                            <x-error field="reservation_split.new_room.checkin" />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>CheckOut Date</label>
                                                            <input type="text" value="{{ \Carbon\Carbon::parse($selected_reservation->check_out)->format('F j, Y') }}" readonly disabled>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">

                                                <fieldset
                                                    style="border:1px solid #43D1AF; border-radius:5px;padding:15px;margin-top:10px;margin-bottom:0px !important;height:100%;">
                                                    <legend
                                                        style="width:auto; margin-bottom: 0px; font-size: 18px; font-weight: bold; color: #3D3D3D;">
                                                        Daily Rates
                                                    </legend>
                                                    <div class="row">
                                                        @php
                                                            $rate_start = \Carbon\Carbon::parse($reservation_split['new_room']['checkin']);
                                                            $rate_end = \Carbon\Carbon::parse($selected_reservation->check_out);
                                                        @endphp
                                                        @for(; $rate_start->lt($rate_end); $rate_start->addDay())
                                                            <div class="col-md-4">
                                                                <label>{{ $rate_start->format('d-m-Y') }}</label>
                                                                <input type="number" min="0" step="0.01" wire:model.lazy="reservation_split.rates.{{ $rate_start->format('Y-m-d') }}" required>
                                                            </div>
                                                        @endfor
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="max-width: 100%">
                                <hr style="border-top: 3px solid #dfdfdf;">
                                <div class="mb-2 mt-5 d-flex justify-content-end align-items-center">
                                    <button type="submit" class="btn btn-outline-primary btn-sm mr-3">
                                        Split Reservation
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                        data-dismiss="modal">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </form>
                        <form id="reservationMove" class="collapse @if($active_tab == 'move') show @endif" wire:submit.prevent="handleReservationMove">
                            <div class="form-style-6">
                                <div class="row">
                                    <div class="col-3">
                                        <fieldset
                                            style="border:1px solid #43D1AF; border-radius:5px;padding:15px;margin:0px;margin-bottom:0px !important;height:100%;">
                                            <legend
                                                style="width:auto; margin-bottom: 0px; font-size: 18px; font-weight: bold; color: #3D3D3D;">
                                                Current Room
                                            </legend>
                                            <div>
                                                <label class="d-block">Room Number</label>
                                                <input type="text" value="{{ $selected_reservation->room->number ?? ''  }}" readonly disabled>
                                            </div>
                                            <div>
                                                <label class="d-block">Rate Type</label>
                                                <input type="text" value="{{ $selected_reservation->rate_type->name ?? '' }}" readonly disabled>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-3">
                                        <fieldset
                                            style="border:1px solid #43D1AF; border-radius:5px;padding:15px;margin:0px;margin-bottom:0px !important;height:100%;">
                                            <legend
                                                style="width:auto; margin-bottom: 0px; font-size: 18px; font-weight: bold; color: #3D3D3D;">
                                                New Room
                                            </legend>
                                            <div>
                                                <label>New Room</label>
                                                <select wire:model="reservation_move.room" required>
                                                    <option value="">Choose Room</option>
                                                    @foreach ($room_types as $room_type)
                                                        <optgroup label="{{ $room_type->name }}">
                                                            @foreach ($room_type->rooms as $room)
                                                                <option value="{{ $room->id }}">{{ $room->number }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label>Rate type</label>
                                                <select wire:model="reservation_move.rate" required>
                                                    <option value="">Choose Rate Type</option>
                                                    @foreach (\App\Models\Room::find($reservation_move['room'])->room_type->rate_types ?? [] as $rate_type)
                                                        <option value="{{ $rate_type->id }}">{{ $rate_type->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col">
                                        <fieldset
                                            style="border:1px solid #43D1AF; border-radius:5px;padding:15px;margin:0px;margin-bottom:0px !important;height:100%;">
                                            <legend
                                                style="width:auto; margin-bottom: 0px; font-size: 18px; font-weight: bold; color: #3D3D3D;">
                                                Daily Rates
                                            </legend>
                                            <div class="row">
                                                @foreach ($reservation_move['rates'] as $date => $price)
                                                    <div class="col-6">
                                                        <label class="d-block">{{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</label>
                                                        <input type="number" min="1" step="0.01" wire:model.lazy="reservation_move.rates.{{ $date }}" required>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div style="max-width: 100%">
                                <hr style="border-top: 3px solid #dfdfdf;">
                                <div class="mb-2 mt-5 d-flex justify-content-end align-items-center">
                                    <button type="submit" class="btn btn-outline-primary btn-sm mr-3">
                                        Move Reservation
                                    </button>
                                    <button type="button" class=" btn btn-outline-secondary btn-sm"
                                        data-dismiss="modal">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </form>
                        <form id="reservationResize" class="collapse @if($active_tab == 'resize') show @endif" wire:submit.prevent="handleReservationResize">
                            <div class="form-style-6">
                                <div class="row">
                                    <div class="col">
                                        <label>Check In Date</label>
                                        <input type="text" id="resizeCheckin" wire:model.lazy="reservation_resize.checkin" readonly="" disabled>
                                    </div>
                                    <div class="col">
                                        <label>Check Out Date</label>
                                        <input type="text" id="resizeCheckout" wire:model.lazy="reservation_resize.checkout">
                                        <x-error field="reservation_resize.checkout" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <h3 class="mb-4">Choose Daily Rates</h3>
                                        <div class="row">
                                            @php
                                                $resize_start = \Carbon\Carbon::parse($reservation_resize['checkin']);
                                                $resize_end = \Carbon\Carbon::parse($reservation_resize['checkout']);
                                            @endphp
                                            @for(;$resize_start->lt($resize_end);$resize_start->addDay())
                                                <div class="col-4">
                                                    <label class="d-block">{{ $resize_start->format('d-m-Y') }}</label>
                                                    <input type="number" min="1" step="0.01" wire:model.lazy="reservation_resize.rates.{{ $resize_start->format('Y-m-d') }}" placeholder="Enter amount..." required>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="max-width: 100%">
                                <hr style="border-top: 3px solid #dfdfdf;">
                                <div class="mb-2 mt-5 d-flex justify-content-end align-items-center">
                                    <button type="submit" class="btn btn-outline-primary btn-sm mr-3">
                                        Resize Reservation
                                    </button>
                                    <button type="button" class=" btn btn-outline-secondary btn-sm"
                                        data-dismiss="modal">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </form>
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

            $('#outOfOrderStartDate').flatpickr({
                dateFormat: "F j, Y",
            });
            $('#outOfOrderEndDate').flatpickr({
                dateFormat: "F j, Y",
            });

            $('#restrictionDate').flatpickr({
                dateFormat: "F j, Y",
            });

            $('#newRoomCheckin').flatpickr({
                dateFormat: "F j, Y",
            });

            $('#resizeCheckin').flatpickr({
                dateFormat: "F j, Y",
            });

            $('#resizeCheckout').flatpickr({
                dateFormat: "F j, Y",
            });
        });
    </script>
</div>
