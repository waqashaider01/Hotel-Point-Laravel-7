<div>

    <div class="d-flex flex-column-fluid mt-5">
        <!--begin::Container-->
        <div class="container-fluid">
            <div id="roomtypesTableCard">
                <div class="row" id="btndiv1">
                    <div class="col">
                        <div class="infocard shadow-sm bg-white" style="padding:1%;">
                            <div class="row">

                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <h1>Room Types and Rooms</h1>
                                </div>
                                <div class="col-md-4">
                                    <div style="float:right">
                                        <a href="{{ route('room-type-and-room.sync-with-channex') }}" class="infbtn"><i
                                            class="fa fa-sync" style="font-size: 14px;" aria-hidden="true"></i>&nbsp;&nbsp;Sync Rooms with Channel Manager</a>
                                        <span type="button" class="infbtn" id="addroomType"><i
                                                class="fa fa-plus" style="font-size: 14px;" aria-hidden="true"></i>&nbsp;&nbsp;New Room Type</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-8">
                    <div class="col">
                        {{-- <div class="infocard shadow-sm bg-white" style="padding:1%;" id="typesTable1">
                            <div class="row shadow-sm text-center"
                                style="font-size:16px; color:black;padding:1%;margin-top:-1%;">
                                <div class="col text-left">Room Type</div>
                                <div class="col">Reference Code</div>
                                <div class="col">Channel Manager ID</div>
                                <div class="col">Rooms</div>
                                <div class="col">Action</div>
                                <div class="col">Status</div>
                            </div>
                            <div id="roomtypesTableBody">



                                @foreach ($roomtypes as $type)
                                    <div class='row text-center' style='padding:1%; font-size:14px;'>
                                        @if ($type->status == 0)
                                            <div class='col selectedroomtype text-left' data-value='{{ $type->id }}'
                                                style=' '>
                                                <i class='fas fa-edit sortRoomtype' data-value='{{ $type->id }}'
                                                    style=''></i>
                                                {{ $type->name }}
                                            </div>
                                        @else
                                            <div class='col selectedroomtype text-left'
                                                data-value='{{ $type->id }}'><i class='fas fa-edit sortRoomtype'
                                                    data-value='{{ $type->id }}' style=''></i>
                                                {{ $type->name }} </div>
                                        @endif

                                        <div class='col'>{{ $type->reference_code }}</div>
                                        <div class='col'> {{ $type->channex_room_type_id }} </div>
                                        <div class='col'> {{ $type->rooms->count() }} </div>
                                        <div class='col' nowrap='nowrap'>

                                            <span type='button' class='infbtn'><i class='fas  fa-edit editroomType'
                                                    style='' data-value='{{ $type->id }}'></i></span>

                                            <span type='button' class='infbtn'> <i class='fa fa-trash deleteroomType '
                                                    aria-hidden='true' style=''
                                                    data-value='{{ $type->id }}'></i></span>

                                        </div>
                                        <div class='col'>
                                            <Button class='btn '>
                                                <input type='checkbox' class='checkbox roomtypeStatus'
                                                    data-roomtype='{{ $type->id }}' id='type.{{ $type->id }}'
                                                    {{ $type->type_status == 0 ? '' : 'checked' }} />
                                                <label class='label' for='type.{{ $type->id }}'>
                                                    <div class='ball'></div>
                                                </label>
                                            </Button>

                                        </div>
                                    </div>
                                @endforeach


                            </div>
                        </div> --}}
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive" wire:ignore>
                                    <table id="dataTableExample" class="roomtypesTable table">
                                        <thead>
                                            <tr>
                                                <td>Room Type</td>
                                                <td>Reference Code</td>
                                                <td>Channel Manager ID</td>
                                                <td>Rooms</td>
                                                <td>Action</td>
                                                <td>Status</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($roomtypes as $type)
                                                <tr>
                                                    @if ($type->status == 0)
                                                        <td class=' selectedroomtype text-left'
                                                            data-value='{{ $type->id }}' style=' '>
                                                            <i class='fas fa-edit sortRoomtype'
                                                                data-value='{{ $type->id }}' style=''></i>
                                                            {{ $type->name }}
                                                        </td>
                                                    @else
                                                        <td class=' selectedroomtype text-left'
                                                            data-value='{{ $type->id }}'><i
                                                                class='fas fa-edit sortRoomtype'
                                                                data-value='{{ $type->id }}' style=''></i>
                                                            {{ $type->name }} </td>
                                                    @endif

                                                    <td class=''>{{ $type->reference_code }}</td>
                                                    <td class=''> {{ $type->channex_room_type_id }} </td>
                                                    <td class=''> {{ $type->rooms->count() }} </td>
                                                    <td class='' nowrap='nowrap'>

                                                        <span type='button' class='infbtn'><i
                                                                class='fas  fa-edit editroomType' style=''
                                                                data-value='{{ $type->id }}'></i></span>

                                                        <span type='button' class='infbtn'> <i
                                                                class='fa fa-trash deleteroomType ' aria-hidden='true'
                                                                style='' data-value='{{ $type->id }}'></i></span>

                                                    </td>
                                                    <td class=''>
                                                        <Button class='btn '>
                                                            <input type='checkbox' class='checkbox roomtypeStatus'
                                                                data-roomtype='{{ $type->id }}'
                                                                id='type.{{ $type->id }}'
                                                                {{ $type->type_status == 0 ? '' : 'checked' }} />
                                                            <label class='label' for='type.{{ $type->id }}'>
                                                                <div class='ball'></div>
                                                            </label>
                                                        </Button>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="" id="roomsTableCard">
                <div class="row mt-8">
                    <div class="col">
                        <div class="infocard shadow-sm bg-white" style="padding:1%;">
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="" style="text-align:right;">
                                        <span style="display: none;" id="selected_roomtype_id"></span>
                                        <h1 id="selected_roomtype_name">Rooms</h1>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mt-2" style="float:right;">
                                        <span class="infbtn " type="button" id="addRoom"><i
                                                class="fa fa-plus " aria-hidden="true"></i>&nbsp;New Room</span>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-8 mb-15" id="">
                    <div class="col">
                        <div class="infocard shadow-sm bg-white" style="padding:1%;" id="">
                            <div class="card">

                                <div class="card-body">
                                    <div class="table-responsive" wire:ignore>
                                        <table id="dataTableExample" class="table">
                                            <thead>
                                                <tr>
                                                    <td class="col-md-4">Room Number</td>
                                                    <td class="col-md-4">Occupancy</td>
                                                    <td class="col-md-2">Action</td>
                                                    <td class="col-md-2">Status</td>
                                                </tr>
                                            </thead>
                                            <tbody id="roomsTableBody">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="row shadow-sm text-center"
                                style="font-size:16px; color:black;padding:1%;margin-top:-1%;">
                                <div class="col-md-4">Room Number</div>
                                <div class="col-md-4">Occupancy</div>
                                <div class="col-md-2">Action</div>
                                <div class="col-md-2">Status</div>
                            </div> --}}
                            {{-- <div id="roomsTableBody">


                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <div class="modal fade" id="addRoomtypeModal" style="border-radius:0px !important;" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
                    <h5 style="text-align:center;margin-left:38%;" class="modal-title text-dark text-center"
                        id="exampleModalLabel">Add Room Type</h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;">
                    <form action="" method="POST">
                        <div class="form-style-6">
                            <div class="row">
                                <div class="col">
                                    <label>Room type name</label>
                                    <input type="text" name="" class="" id="roomtypeName" style="">
                                </div>
                                <div class="col">
                                    <label>Reference Code</label>
                                    <input type="text" name="" class="" id="roomtypeReferenceCode"
                                        style="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Total No. of rooms</label>
                                    <input type="number" name="" class="" id="roomtypeRooms" style="">

                                    <label>Do you want to connect this room type to channel manager?
                                        <input type="checkbox" name="" class=""
                                            id="confirm_connection"></label>
                                </div>
                                <div class="col">
                                    <label>Description</label>
                                    <textarea class="" id="roomtypeDescription" style="height:80px !important;"></textarea>
                                </div>
                            </div>
                            <div class="row" id="channex_msg">
                                <div class="col text-center">
                                    <h4> Add occupancy for channel manager </h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" id="adultdiv">
                                    <label>Adults</label>
                                    <input type="number" name="" class="" id="occAdult" style="">
                                </div>
                                <div class="col" id="kidsdiv">
                                    <label>Kids</label>
                                    <input type="number" name="" class="" id="occKids" style="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" id="infantsdiv">
                                    <label>Infants</label>
                                    <input type="number" name="" class="" id="occInfants" style="">
                                </div>
                                <div class="col" id="defaultdiv">
                                    <label>Default Occupancy</label>
                                    <input type="number" name="" class="" id="occdefault" style="">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer" style="background-color:#fff;">
                    <span type="submit" name='submit' style="color:green;" class="float-right infbtn" style=''
                        id="addRoomtypebtn">Submit</span>
                    <span type="button" class="infbtn" style="color:red;" data-dismiss="modal"
                        style=''>Close</span>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editRoomtypeModal" style="border-radius:0px !important;" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
                    <h5 style="text-align:center;margin-left:38%;" class="modal-title text-dark text-center"
                        id="exampleModalLabel">Edit Room Type</h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;">
                    <form action="" method="POST">
                        <div class="form-style-6">
                            <div class="row">
                                <div class="col">
                                    <label>Room type id</label>
                                    <input type="text" name="" class="" id="RoomtypeId" style="" readonly>
                                </div>
                                <div class="col">
                                    <label>Room type name</label>
                                    <input type="text" name="" class="" id="editroomtypeName" style="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Reference Code</label>
                                    <input type="text" name="" class="" id="editroomtypeReferenceCode"
                                        style="">

                                    <label>This room type is connected to channel manager?</label>
                                    <label name="" class="" id="edit_confirm_connection"></label>
                                </div>
                                <div class="col">
                                    <label>Description</label>
                                    <textarea class="" id="editroomtypeDescription" style="height:80px !important;"></textarea>
                                </div>
                            </div>
                            <div class="row" id="channex_msg">
                                <div class="col text-center">
                                    <h4> Add occupancy for channel manager </h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" id="editadultdiv">
                                    <label>Adults</label>
                                    <input type="number" name="" class="" id="editoccAdult" style="">
                                </div>
                                <div class="col" id="editkidsdiv">
                                    <label>Kids</label>
                                    <input type="number" name="" class="" id="editoccKids" style="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" id="editinfantsdiv">
                                    <label>Infants</label>
                                    <input type="number" name="" class="" id="editoccInfants" style="">
                                </div>
                                <div class="col" id="editdefaultdiv">
                                    <label>Default Occupancy</label>
                                    <input type="number" name="" class="" id="editoccdefault" style="">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer" style="background-color:#fff;">
                    <span type="button" name='submit' style="color:green;" class="float-right infbtn" style=''
                        id="editRoomtypebtn">Submit</span>
                    <span type="button" class="infbtn" style="color:red;" data-dismiss="modal"
                        style=''>Close</span>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addRoomModal" style="border-radius:0px !important;" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
                    <h5 style="text-align:center;margin-left:40%;" class="modal-title text-dark text-center"
                        id="exampleModalLabel">Add Room</h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;">
                    <form action="" method="POST">
                        <div class="form-style-6">
                            <div class="row " style="margin-right:-6%;" id="embedDiv">
                                <div class="col">
                                    <label>Room Number</label>
                                    <input type="text" name="" class="" id="addroomno" style="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Default Occupancy</label>
                                    <input type="text" name="" class="" id="addoccupancy" style="">
                                </div>
                                <div class="col">
                                    <label>Adults</label>
                                    <input type="number" name="" class="" id="addadults" style="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Kids</label>
                                    <input type="number" name="" class="" id="addkids" style="">
                                </div>
                                <div class="col">
                                    <label>Infants</label>
                                    <input type="number" name="" class="" id="addinfants" style="">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer" style="background-color:#fff;">
                    <span type="submit" name='update_agency' style="color:green;" class="float-right infbtn" style=''
                        id="addRoombtn">Submit</span>
                    <span type="button" class="infbtn" style="color:red;" data-dismiss="modal"
                        style=''>Close</span>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editRoomModal" style="border-radius:0px !important;" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
                    <h5 style="text-align:center;margin-left:40%;" class="modal-title text-dark text-center"
                        id="exampleModalLabel">Edit Room</h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;">
                    <form action="" method="POST">
                        <div class="form-style-6">
                            <div class="row" id="">
                                <div class="col">
                                    <label>Room Id</label>
                                    <input type="text" name="" class="" id="editroomid" style=""
                                        readonly>
                                </div>
                                <div class="col">
                                    <label>Room Number</label>
                                    <input type="text" name="" class="" id="editroomno" style="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Default Occupancy</label>
                                    <input type="text" name="" class="" id="editoccupancy" style="">
                                </div>
                                <div class="col">
                                    <label>Adults</label>
                                    <input type="number" name="" class="" id="editadults" style="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Kids</label>
                                    <input type="number" name="" class="" id="editkids" style="">
                                </div>
                                <div class="col">
                                    <label>Infants</label>
                                    <input type="number" name="" class="" id="editinfants" style="">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer" style="background-color:#fff;">
                    <span type="submit" name='update_agency' style="color:green;" class="float-right infbtn hide"
                        style='' id="editRoombtn">Submit</span>
                    <span type="button" class="infbtn" style="color:red;" data-dismiss="modal"
                        style=''>Close</span>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rtpositionModal" style="border-radius:0px !important;" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
                    <h5 style="text-align:center;margin-left:26%;" class="modal-title text-dark text-center"
                        id="exampleModalLabel">Update Room type position</h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;">
                    <form action="" method="POST">
                        <div class="form-style-6">
                            <div class="row">
                                <div class="col">
                                    <label>Room type</label>
                                    <div id="sortedRoomtypeid" hidden></div>
                                    <div><input type="text" id="sortedRoomtypename" readonly></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Position on Calendar</label>
                                    <input type="number" id="positionRoomtype">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer" style="background-color:#fff;">
                    <span type="submit" name='update_agency' style="color:green;" class="float-right infbtn" style=''
                        id="updateroomtypePosition">Update</span>
                    <span type="button" class="infbtn" style="color:red;" data-dismiss="modal"
                        style=''>Close</span>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
