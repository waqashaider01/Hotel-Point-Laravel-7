<div>
    {{-- <div class="card card-custom card-stretch gutter-b" style='max-height:90%;'>
        <div class="card-body p-2 position-relative " style='overflow-y:scroll; max-height:400px;'
             id='todays_checkin'>
            @foreach ($results as $result)
                <div class='col px-2 py-4 rounded-xl mb-3' style='border:1px solid #ABB2B9 !important;'>
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
                                    <span style='font-size:14px; font-weight:bold;'></span><span
                                        style='font-size:12px; font-weight:bold;'>{{$result['reservation']->guest->full_name}}</span>
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
                                        style='font-size:16px; font-weight:bold;'>{{$result['reservation']->room? $result['reservation']->room->number: 'N/A'}}</span>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-6 mt-4'>
                                    <span><img src='{{asset('images/logo/fn.png')}}' class='max-h-25px' alt=''/></span>
                                    <span>{{$result['reservation']->rate_type->reference_code}}</span>
                                </div>
                                <div class='col-md-6 mt-4'>
                                    <span
                                        style='font-size:16px; font-weight:bold;'>{{$result['reservation']->booking_agency->name}}</span>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <button wire:click="setCheckin({{$result['reservation']->id}})" data-toggle="modal"
                                    data-target="#check-in-confirmation-modal"
                                    class='btn btn-default font-weight-normal font-size-s pb-8 mb-1 ml-3 CheckInBtn'
                                    style='height:28px;width:100px; background-color:#49c4d1; color:white; margin-left:0px !important;'>
                                Check In
                            </button>
                            <button wire:click="setNoshow({{$result['reservation']->id}})" data-toggle="modal" data-target="#no-show-confirmation-modal"
                                    class="btn btn-default {{($result['reservation']->arrival_date < $result['reservation']->departure_date)?'':'bg-light-danger'}} font-weight-normal font-size-s pb-8 mb-1 ml-3 noShowBtn"
                                    style='height:28px; width:100px; background-color:#49c4d1; color:white;margin-left:0px !important;'>
                                No Show
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div> --}}

    {{-- <div class="w-100 table-responsive" wire:ignore>
        <table id="check-in-table" class="table-striped table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Guest Name</th>
                    <th>Members</th>
                    <th>Kids</th>
                    <th>Nights</th>
                    <th>Room</th>
                    <th>Agency</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $result)
                    <tr>
                        <td>{{ $result['reservation']->id }}</td>
                        <td>{{ $result['reservation']->guest->full_name }}</td>
                        <td>{{ $result['reservation']->adults }}</td>
                        <td>{{ $result['reservation']->kids }}</td>
                        <td>{{ $result['reservation']->overnights }}</td>
                        <td>{{ $result['reservation']->room? $result['reservation']->room->number: 'N/A' }}</td>
                        <td>{{ $result['reservation']->booking_agency->name }}</td>
                        <td>
                            <button wire:click="setCheckin({{ $result['reservation']->id }})" data-toggle="modal" data-target="#check-in-confirmation-modal" class="btn btn-sm btn-info">Check In</button>
                            <button wire:click="setNoshow({{ $result['reservation']->id }})" data-toggle="modal" data-target="#no-show-confirmation-modal" class="btn btn-sm btn-primary">No Show</button>
                            <a href="#" class="btn btn-success btn-sm">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> --}}

    <div>
        <div class="d-flex justify-content-end custom-input-box">
            <button wire:click="resetFields" class="btn btn-secondary mr-2"> <i style="margin: 0 !important" class="fas fa-sync-alt"></i> </button>
            <input wire:model="search_text" type="search" placeholder="Search">
        </div>
        @if (sizeof($results) > 0)
            <div class="card-body position-relative p-2" style='overflow-y:scroll; max-height:400px;' id='todays_checkin'>
                @foreach ($results as $result)
                    <div class='col mb-3 rounded-xl px-5 py-4' style='border:1px solid #ABB2B9 !important;'>
                        <div class='row'>
                            <div class='col-md-9'>
                                <div class='d-flex justify-content-between' style="gap: 10px">
                                    <div>
                                        <a style="color: #4075FF" href="{{ route('edit-reservation', $result['reservation']->id) }}"> #{{ $result['reservation']->id }} </a>
                                    </div>
                                    <div>
                                        {{ $result['reservation']->guest->full_name }}
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
                                            <span>{{ $result['reservation']->room? $result['reservation']->room->number: 'N/A' }}</span>
                                        </div>
                                    </div>

                                    @if ($result['statuses']['full_status'] == 'green')
                                        <span><img class="max-h-25px tippy-tooltip" src='../images/logo/money-green.png' type="button" data-title="{{ $result['tooltip'] }}" /></span>
                                    @elseif($result['statuses']['full_status'] == 'red')
                                        <span><img class="max-h-25px tippy-tooltip" src='../images/logo/money-red.png' type="button" data-title="{{ $result['tooltip'] }}" /></span>
                                    @elseif($result['statuses']['full_status'] == 'yellow')
                                        <span><img class="max-h-25px tippy-tooltip" src='../images/logo/money-yellow.png' type="button" data-title="{{ $result['tooltip'] }}" /></span>
                                    @endif

                                </div>
                                <div class='d-flex justify-content-between'>
                                    <div class="d-flex align-items-center" style="gap: 10px">
                                        <span><img src='{{ asset('images/logo/fn.png') }}' class='max-h-25px' alt='' /></span>
                                        <span>{{ $result['reservation']->rate_type->reference_code }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span>{{ $result['reservation']->booking_agency->name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-3 d-flex flex-column align-items-end'>
                                <button wire:click="setCheckin({{ $result['reservation']->id }})" data-toggle="modal" data-target="#check-in-confirmation-modal"
                                        class='btn btn-default font-weight-normal font-size-s CheckInBtn mb-1 ml-3 pb-8' style='height:28px;width:100px; background-color:#49c4d1; color:white; margin-left:0px !important;'>
                                    Check In
                                </button>
                                <button @if ($result['reservation']->arrival_date < $result['reservation']->departure_date) wire:click="setNoshow({{ $result['reservation']->id }})" @endif data-toggle="modal" data-target="#no-show-confirmation-modal"
                                        class='btn btn-default {{ $result['reservation']->arrival_date < $result['reservation']->departure_date ? '' : 'bg-light-danger' }} font-weight-normal font-size-s noShowBtn mb-1 ml-3 pb-8'
                                        style='height:28px; width:100px; background-color:#49c4d1; color:white;margin-left:0px !important;'>
                                    No Show
                                </button>
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

    <div class="modal fade" id="check-in-confirmation-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header mb-4" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Reservation Check In</h5>
                </div>
                <div class="modal-body" style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-5%;">
                    <div class="form-style-6">
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="">
                                    <h5>Check In The Reservation?</h5>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="">
                                    <select wire:model="template">
                                        <option value="">Choose ...</option>
                                        @foreach ($templates as $template)
                                            <option value="{{ $template->id }}">{{ $template->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-error field="template" />
                                </div>
                            </div>
                        </div>
                        <x-error field="reservation" />
                    </div>
                </div>
                <div class="modal-footer" style="background-color:#F5F7F9;">
                    <button type="submit" wire:click="saveCheckin" style='background-color:#48BD91;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;' class="">Confirm
                    </button>
                    <button type="button" data-dismiss="modal" style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="no-show-confirmation-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header mb-4" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" id="exampleModalLabel">No Show</h5>
                </div>
                <div class="modal-body" style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-5%;">
                    <div class="form-style-6">
                        <h5>Are you sure You Want To Move The Reservation One Day Later?</h5>
                    </div>
                </div>
                <div class="modal-footer" style="background-color:#F5F7F9;">
                    <button type="submit" wire:click="saveNoshow" style='background-color:#48BD91;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>
                        Confirm
                    </button>
                    <button type="button" data-dismiss="modal" style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
