<div>
    {{-- <div>
        <div class="card card-custom card-stretch gutter-b" style='max-height:90%;'>
            <div class="card-header border-0  check-in-gradient1"
                 style='background-color:#E0E0E0;max-height:52px !important;min-height:52px !important;'>
                <div class="row" style="width:100%;">
                    <div class="col">
                        <h3 class="card-title font-weight-bolder text-dark" style="margin-left:-4%;">In House
                            <span id="checkouttoday" class="counthkp checkin-btn">{{count($results)}}</span>
                        </h3>
                    </div> 
                    <div class="col">
                        <div class="search-box mt-2" style="float:right;">
                            <button name="submitsearchid3" type="button" class="btn-search"><i
                                    class="fas fa-search"></i></button>
                            <input type="text" wire:model="query"
                                   style="color:black !important;border-color:black !important;"
                                   class="input-search"
                                   placeholder="Search by Room No.">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-2 position-relative " style='overflow-y:scroll; max-height:400px;'
                 id='todays_checkin'>
                @foreach ($results as $result)
                    <div class='col px-2 py-4 rounded-xl mb-3'
                         style='border:1px solid {{($result['reservation']->check_out == today()->toDateString())?'#ABB2B9':'#f58787'}} !important;'>
                        <div class='row'>
                            <div class='col-md-9'>
                                <div class='row'>
                                    <div class='col-md-3'>
                                    <span class='' style='font-size:14px; font-weight:bold;color:#49c4d1;'>#<span
                                            style='font-size:14px; font-weight:bold;color:#49c4d1;'><a
                                                style='font-size:14px; font-weight:bold;color:#49c4d1;'
                                                href='{{route('edit-reservation',$result['reservation']->id)}}'>{{$result['reservation']->id}}</a></span></span>
                                    </div>
                                    <div class='col-md-6'>
                                        @if ($result['reservation']->checkin_guest)
                                            <a type="button" data-toggle="modal" data-target="#editAddGuest"
                                               wire:click="setReservation({{$result['reservation']->id}},{{$result['reservation']->checkin_guest->id}})">
                                                <span style='font-size:12px; font-weight:bold;'>
                                                    {{$result['reservation']->checkin_guest->full_name}}
                                                </span>
                                            </a>
                                        @else
                                            <a type="button" data-toggle="modal" data-target="#editAddGuest"
                                               wire:click="setReservation({{$result['reservation']->id}})">
                                                <span style='font-size:12px; font-weight:bold; color:#edbbbb;'>
                                                    {{$result['reservation']->guest->full_name}}
                                                </span>
                                            </a>
                                        @endif
                                    </div>
                                    <div class='col-md-2'>
                                    <span>
                                        <img
                                            src='{{asset('images/logo/money-'.$result['statuses']['full_status'].'.png')}}'
                                            class='max-h-25px hui 1'
                                            data-html="true" type="button" data-toggle="tooltip"
                                            data-placement="top" title="{{$result['tooltip']}}"/></span> <span>
                                    </span>
                                    </div>
                                    <div class='col-md-1'>
                                        <img src='{{$result['reservation']->country->flag}}' class='max-h-25px' alt=''/>
                                    </div>
                                </div>
                                <div class='row mt-4 mb-4'>
                                    <div class='col-md-3 mt-3'>
                                    <span><img src='{{asset('images/logo/couple.png')}}' class='max-h-25px'
                                               alt=''/></span>
                                        <span
                                            style='font-size:16px; font-weight:bold;'>{{$result['reservation']->adults}}</span>
                                    </div>
                                    <div class='col-md-3 mt-3'>
                                        <span><img src='{{asset('images/logo/kids.png')}}' class='max-h-25px'
                                                   alt=''/></span><span
                                            style='font-size:16px; font-weight:bold;'>{{$result['reservation']->kids}}</span>
                                    </div>
                                    <div class='col-md-3 mt-3'>
                                        <span><img src='{{asset('images/logo/moon.png')}}'
                                                   class='max-h-25px hi' data-html="true"
                                                   type="button" data-toggle="tooltip" data-placement="top"/>
                                        </span><span
                                            style='font-size:16px; font-weight:bold;'>{{$result['reservation']->overnights}}</span>
                                    </div>
                                    <div class='col-md-3 mt-3'>
                                    <span><img src='{{asset('images/logo/room.png')}}' class='max-h-25px'
                                               alt=''/></span>
                                        <span
                                            style='font-size:16px; font-weight:bold;'>{{ optional( $result['reservation']->room)->number ?? 'N/A'}}</span>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-6 mt-4'>
                                        <span><img src='{{asset('images/logo/fn.png')}}' class='max-h-25px'
                                                   alt=''/></span>
                                        <span>{{$result['reservation']->rate_type->reference_code}}</span>
                                    </div>
                                    <div class='col-md-6 mt-4'>
                                    <span
                                        style='font-size:16px; font-weight:bold;'>{{$result['reservation']->booking_agency->name}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-3'>
                                <div style='float:right;'>
                                    <a href="{{route('reservation-payments',['id'=>$result['reservation']->id])}}"
                                       class='btn btn-default font-weight-normal font-size-m text-center  pb-8 mb-1 ml-3'
                                       style='height:28px; width:100px; background-color:#49c4d1; color:white'>Payments</a>
                                    <a href="{{route('reservation-extra-charge',['id'=>$result['reservation']->id])}}"
                                       class='btn btn-default text-center pb-8 font-weight-normal font-size-m  mb-1 ml-3'
                                       id="checkin"
                                       style='height:28px; width:100px; background-color:#49c4d1; color:white'>Services </a>
                                    @if ($result['reservation']->actual_checkout < today()->toDateString() && $result['reservation']->checkin_guest)
                                        <button type='button' data-toggle="modal" data-target="#earlyCheckout"
                                                wire:click="setReservation({{$result['reservation']->id}})"
                                                class='btn btn-default font-weight-normal font-size-s pb-8 mb-1 ml-3 '
                                                style='height:28px; width:100px; background-color:#49c4d1; color:white'>
                                            Early
                                            <i class='fa fa-sign-out-alt text-light' aria-hidden='true'></i></button>
                                    @else
                                        <button type='button' value='Early'
                                                class='btn btn-default font-weight-normal font-size-s pb-8 mb-1 ml-3'
                                                style='height:28px; width:100px; background-color:#b0b0b0; color:white'>
                                            Early
                                            <i class='fa fa-sign-out-alt text-light' aria-hidden='true'></i></button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div> --}}

    <div>
        <div class="d-flex justify-content-end custom-input-box">
            <button wire:click="resetFields" class="btn btn-secondary mr-2"> <i style="margin: 0 !important" class="fas fa-sync-alt"></i> </button>
            <input wire:model="search_text" type="search" placeholder="Search">
        </div>
        @if (sizeof($results) > 0)
            <div class="card-body position-relative p-2" style='overflow-y:scroll; max-height:400px;' id='todays_checkin'>
                @foreach ($results as $result)
                    <div class='col mb-3 rounded-xl px-2 py-4' style='border:1px solid {{ $result['reservation']->check_out == today()->toDateString() ? '#ABB2B9' : '#f58787' }} !important;'>
                        <div class='row'>
                            <div class='col-md-9'>
                                <div class='d-flex justify-content-between' style="gap: 10px">
                                    <div>
                                        <a style="color: #4075FF" href="{{ route('edit-reservation', $result['reservation']->id) }}"> #{{ $result['reservation']->id }} </a>
                                    </div>
                                    <div>
                                        @if (is_null($result['reservation']->checkin_guest_id))
                                            <span style="color: rgb(253, 73, 73); cursor: pointer" role="button" data-toggle="modal" data-target="#editAddGuest" wire:click="setReservation({{ $result['reservation']->id }})">
                                                {{ optional($result['reservation']->guest)->full_name ?? 'N/A' }}
                                            </span>
                                        @else
                                            <span role="button" data-toggle="modal" data-target="#editAddGuest" wire:click="setReservation({{ $result['reservation']->id }},{{ $result['reservation']->checkin_guest->id }})">
                                                {{ optional($result['reservation']->checkin_guest)->full_name ?? 'N/A' }}
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        {{ $result['reservation']->booking_date }}
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between" style="gap: 20px;">
                                    <div class='d-flex justify-content-between mt-3 mb-3' style="gap: 10px; width: 300px;">
                                        <div class='d-flex align-items-center' style="gap: 5px;">
                                            <span><img src='{{ asset('images/logo/couple.png') }}' class='max-h-25px' alt='' /></span>
                                            <span>{{ $result['reservation']->adults }}</span>
                                        </div>
                                        <div class='d-flex align-items-center' style="gap: 5px;">
                                            <span><img src='{{ asset('images/logo/kids.png') }}' class='max-h-25px' alt='' /></span>
                                            <span>{{ $result['reservation']->kids }}</span>
                                        </div>
                                        <div class='d-flex align-items-center' style="gap: 5px;">
                                            <span style="cursor: pointer"><img src='{{ asset('images/logo/moon.png') }}' class='max-h-25px hi tippy-tooltip' data-title="{{ $result['moonTooltip'] }}" />
                                            </span><span>{{ $result['reservation']->overnights ?? 0 }}</span>
                                        </div>
                                        <div class='d-flex align-items-center' style="gap: 5px;">
                                            <span><img src='{{ asset('images/logo/room.png') }}' class='max-h-25px' alt='' /></span>
                                            <span>{{ optional($result['reservation']->room)->number ?? 'N/A' }}</span>
                                        </div>
                                    </div>

                                    @if ($result['statuses']['full_status'] == 'green')
                                        <span type="button" class="tippy-tooltip" data-title="{{ $result['tooltip'] }}"><img class="max-h-25px" src='../images/logo/money-green.png' /></span>
                                    @elseif($result['statuses']['full_status'] == 'red')
                                        <span type="button" class="tippy-tooltip" data-title="{{ $result['tooltip'] }}"><img class="max-h-25px" src='../images/logo/money-red.png' /></span>
                                    @elseif($result['statuses']['full_status'] == 'yellow')
                                        <span type="button" class="tippy-tooltip" data-title="{{ $result['tooltip'] }}"><img class="max-h-25px" src='../images/logo/money-yellow.png' /></span>
                                    @endif

                                </div>
                                <div class='d-flex justify-content-between'>
                                    <div class="d-flex align-items-center" style="gap: 10px">
                                        <span><img src='{{ asset('images/logo/fn.png') }}' class='max-h-25px' alt='' /></span>
                                        <span>{{ optional( $result['reservation']->rate_type)->reference_code ?? 'N/A' }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span>{{ optional( $result['reservation']->booking_agency)->name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-3 d-flex flex-column align-items-end'>
                                <a href="{{ route('reservation-payments', ['id' => $result['reservation']->id]) }}" class='btn btn-default font-weight-normal font-size-m mb-1 ml-3 pb-8 text-center'
                                   style='height:28px; width:100px; background-color:#49c4d1; color:white'>Payments</a>
                                <a href="{{ route('reservation-extra-charge', ['id' => $result['reservation']->id]) }}" class='btn btn-default font-weight-normal font-size-m mb-1 ml-3 pb-8 text-center' id="checkin"
                                   style='height:28px; width:100px; background-color:#49c4d1; color:white'>Services </a>
                                @if ($result['reservation']->check_out > today()->toDateString() && $result['reservation']->guest_id && $result['reservation']->departure_date > today()->toDateString() && is_null($result['reservation']->actual_checkout))
                                    <button type='button' data-toggle="modal" data-target="#earlyCheckout" wire:click="setReservation({{ $result['reservation']->id }})" class='btn btn-default font-weight-normal font-size-s mb-1 ml-3 pb-8'
                                            style='height:28px; width:100px; background-color:#49c4d1; color:white'>
                                        Early
                                        <i class='fa fa-sign-out-alt text-light' aria-hidden='true'></i></button>
                                @else
                                    <button type='button' value='Early' class='btn btn-default font-weight-normal font-size-s mb-1 ml-3 pb-8' style='height:28px; width:100px; background-color:#b0b0b0; color:white'>
                                        Early
                                        <i class='fa fa-sign-out-alt text-light' aria-hidden='true'></i></button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center">
                <h4 class="text-danger mt-2">No results found</h4>
            </div>
        @endif
    </div>

    <div class="modal fade" id="earlyCheckout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Early Check Out</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Are You Sure You Want To Proceed To Early Checkout?</h5>
                </div>
                <div class="modal-footer">
                    <button type="submit" wire:click="earlyCheckout" class="btn btn-success">Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" style="max-height:100% !important;" id="editAddGuest" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header mb-5" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Guest Form</h5>
                </div>
                <div class="modal-body" style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-5%;">
                    <div class="form-style-6" style="" id="newGuestModalBody">
                        <div class="row">
                            <div class="col">
                                <label> Guest Full Name</label>
                                <input wire:model="selected_guest.full_name" type="text" />
                                <x-error field="selected_guest.full_name" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>Guest Email 1</label>
                                <input wire:model='selected_guest.email' type="text" />
                                <x-error field="selected_guest.email" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>Guest Email 2</label>
                                <input wire:model='selected_guest.email_2' type="text" />
                                <x-error field="selected_guest.email_2" />
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col">
                                <label for="exampleSelect1">Guest Country<span class="text-danger">*</span></label>
                                <select class="halfstyle" wire:model='selected_guest.country_id'>
                                    <option selected>Choose...</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <x-error field="selected_guest.country_id" />
                            </div>
                            <div class="col">
                                <label>Guest Phone</label>
                                <input wire:model='selected_guest.phone' class="halfstyle" type="text" />
                                <x-error field="selected_guest.phone" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>Guest Mobile</label>
                                <input wire:model='selected_guest.mobile' class="halfstyle" type="text" />
                                <x-error field="selected_guest.mobile" />
                            </div>
                            <div class="col">
                                <label> Guest Postal Code</label>
                                <input wire:model='selected_guest.postal_code' class="halfstyle" type="text" />
                                <x-error field="selected_guest.postal_code" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color:#F5F7F9;">
                    <button type="button" wire:click="saveGuest" style="background-color:#48BD91;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;">
                        Insert
                    </button>
                    <button type="button" data-dismiss="modal" style="background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
