<div>
    <div class="row">
        <div class="col">
            <a type="button" class="infbtn shadow" style="" href="{{ route('calendar') }}">
                <i class="fa fa-calendar me-1"></i> Calendar</a>
        </div>
        <div class="col">
            <a type="button" class="infbtn shadow" style="" href="{{ route('daily-cashier') }}">
                <i class="fa fa-inbox mr-1" aria-hidden="true"></i> Cashier</a>
        </div>
        <div class="col">
            <a type="button" class="infbtn shadow" style="" href="{{ route('opex-form') }}">
                <i class="fa fa-file-alt mr-1" aria-hidden="true"></i> Opex</a>
        </div>
        <div class="col-md-2">
            <a type="button" class="infbtn shadow" data-toggle="modal" data-target="#hkModal">
                <i class="fa fa-broom mr-1"></i> Housekeeping Panel
            </a>
        </div>
        <div class="col-md-2">
            <a type="button" class="infbtn shadow" style="" href="{{ route('payment-tracker') }}">
                <i class="fa fa-map-marker-alt mr-1" aria-hidden="true"></i> Payment Tracker</a>
        </div>
        <div class="col">
            <a type="button" class="infbtn shadow" style="" href="{{ route('comments') }}">
                <i class="fa fa-comment mr-1" aria-hidden="true"></i> Comments</a>
        </div>
        <div class="col">
            <a type="button" class="infbtn shadow" data-toggle="modal" data-target="#offerModal">
                <i class="fa fa-handshake mr-1" aria-hidden="true"></i> Offer</a>
        </div>
    </div>

    <div class="modal fade" id="offerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header mb-10" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Offer</h5>
                </div>
                <div class="modal-body" style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-2%;">
                    <div class='row' style="margin-top:-2%;margin-left:-3.5%;">
                        <div class='col-2 ml-5'>
                            <div class="form-style-6" style="">
                                <input wire:model.debouce='offer_search' type="text" placeholder="Search..." />
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 table text-center">
                        <div>
                            <div class="row th">
                                <div class="col">Booking ID</div>
                                <div class="col">Guest Name</div>
                                <div class="col">Room Type</div>
                                <div class="col">Expire Day</div>
                                <div class="col">Booking Status</div>
                            </div>
                        </div>
                        <div id="mo">
                            @forelse($offers as $offer)
                                <div class="row mytr">
                                    <div class="col idcolor">{{ $offer->id }}</div>
                                    <div class="col">{{ $offer->guest->full_name }}</div>
                                    <div class="col">{{ $offer->room->room_type->name }}</div>
                                    <div class="col">{{ $offer->offer_expire_date }}</div>
                                    <div class="col">{{ $offer->status }}
                                        <button data-toggle="modal" data-target="#changeOfferStatus" wire:click="setReservation({{ $offer->id }})"
                                                style="background-color:#48BBBE;padding:2px 8px;color:white;border-radius:2px;border:none;">
                                            <i class="fa text-light fa-pencil-alt" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            @empty
                                <div class="row mytr">
                                    <div class="col text-center">No offers found</div>
                                </div>
                            @endforelse
                        </div>
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
    <div class="modal fade" id="changeOfferStatus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable shadow-lg" style="margin-top:6%;margin-left:28%;">
            @if ($selected_reservation)
                <div class="modal-content">
                    <div class="modal-header mb-10" style="background-color:#48BBBE;z-index:0;">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Change Offer Status</h5>
                    </div>
                    <div class="modal-body" style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-5%;">
                        <div class="form-style-6" id="">
                            <div class="row">
                                <div class="col">
                                    <label>Change Offer Status <span class="text-danger">*</span></label>
                                    <select wire:model.defer="offer_status">
                                        <option value="Confirmed">Confirmed</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>
                                <div class="col"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color:#F5F7F9;">
                        <button type="button" style='background-color:#48BD91;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;' wire:click="updateOfferStatus">Confirm
                        </button>
                        <button type="button" data-dismiss="modal" style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>
                            Close
                        </button>
                    </div>
                </div>
            @else
                <p>Reservation not found</p>
            @endif
        </div>
    </div>
    <div class="modal fade" id="hkModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header mb-5" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Housekeeping Panel</h5>
                </div>
                <div class="modal-body" style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-2%;">
                    <div class='row' style="margin-top:-2%;">
                        <div class='col-3'>
                            <div class="form-style-6">
                                <input wire:model.debouce='hk_search' type="date" placeholder="Search..." />
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table  class="table " >
                            <thead>
                                <tr class="text-center">
                                    <th >Room</th>
                                    <th>Room Type</th>
                                    <th>Actual Status</th>
                                    <th>HK Notes</th>
                                    <th>Room Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody id="tabbody">
                            
                            @forelse($house_keeping as $hk)
                                <tr class="bg-white text-center">
                                        
                                            <td class="idcolor">{{ $hk->room->number }}</td>
                                            <td>{{ $hk->room->room_type->name }}</td>
                                            @php
                                                $status = '';
                                                if ($hk->arrival_date == $hk_search) {
                                                    $status = 'Arrival';
                                                }
                                                if ($hk->departure_date == $hk_search) {
                                                    $status = 'Departure';
                                                }
                                                if ($hk->arrival_date < $hk_search && $hk->departure_date > $hk_search) {
                                                    $status = 'Accommodation';
                                                }
                                                if ($hk->actual_checkout == $hk_search && $status != 'Departure') {
                                                    $status = 'Departure(Early)';
                                                }
                                                $condition = $hk->room
                                                    ->room_conditions()
                                                    ->where('date', $hk_search)
                                                    ->where('reservation_id', $hk->id)
                                                    ->first();
                                            @endphp
                                            <td>{{ $status }}</td>
                                            <td>{{ $hk->room->comments()->whereDate('date', $hk_search)->first()->description ?? '' }}</td>
                                            <td><span style="color:{{ optional($condition)->status == 'Clean' ? 'green' : '' }}">{{ $condition->status ?? '' }}</span>
                                                <div style='float:right;'>
                                                    <button data-target="#changeRoomStatus" data-toggle="modal" wire:click="setRoom({{ $hk->id }})"
                                                            style='background-color:#48BBBE;padding:2px 8px;color:white;border-radius:2px;border:none;'>
                                                        <i class='fa text-light fa-pencil-alt' aria-hidden='true'></i>
                                                    </button>
                                                </div>
                                            </td>
                                            
                                    </tr>
                            @empty

                                <tr class="bg-white text-center">
                                    <td colspan="8">No house keeping</td>
                                </tr>
                                    
                            @endforelse

                            </tbody>
                        </table> 
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
    <div class="modal fade" id="changeRoomStatus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable shadow-lg" style="margin-top:6%;margin-left:28%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#9E9E9E;z-index:0;">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Change Room Status</h5>
                </div>
                <div class="modal-body" style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:0%;">
                    <div class="form-style-6" id="">
                        <div class="row">
                            <div class="col">
                                <label for="">Change Room Status <span class="text-danger">*</span></label>
                                <select id="" wire:model.defer="room_condition">
                                    <option value="" selected disabled> --Choose Status-- </option>
                                    <option value='Dirty'>Dirty</option>
                                    <option value='Clean'>Clean</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color:#F5F7F9;">
                    <button style='background-color:#48BD91;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;' type="button" wire:click="saveRoomCondition">Confirm
                    </button>
                    <button type="button" data-dismiss="modal" style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="closeCashier" style="border-radius:0px !important;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable" style="max-width:300px !important;min-width:300px !important;">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm" style="border-radius:0px !important;z-index:10;">
                    <h5 style="text-align:center;margin-left:5%;" id="closeCashierHead" class="modal-title text-dark text-center">Close
                        Cashier</h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;">
                    <div class="form-style-61" id="">
                        <div style="">
                            <a href="" id="closeCashier-a-tag-href" class="infbtn shadow">
                                <i class="fa fa-inbox" aria-hidden="true"></i> Go to Cashier for close</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color:#fff;">
                    <span type="button" class="infbtn close" style="color:green;max-width:100px !important;min-width:100px !important" data-dismiss="modal">OK
                    </span>
                </div>
            </div>
        </div>
    </div>


</div>
