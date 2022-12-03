<div id="Roomoutoforder11" class="modal3">
    <div class="modal-content3" style="width:600px !important;">
        <span id="closeoooroom" class="close3">&times;</span>
        <div class="row mt-9 d-flex justify-content-center">
            <div class="col-md-6">
                <form class="form">
                    <div class="card-body">
                        <div class="mystylishdivs" style="margin-left:-120px !important;background: linear-gradient(-45deg,#4dcbce,  #f3f3dc , #AFEEEE, #dce7f3);
                      		  background-size: 600% 400%;">
                            <center><h3>Room Out Of Order</h3></center>
                            <hr>
                            <div class="row" style="margin-top:-25px;">
                                <div class="col">
                                    <div class="form-group">
                                        <div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col"></div>
                            </div>
                            <button type="button" onclick="roomoutoforder()"
                                    style="margin-left:140px;margin-bottom:5px;"
                                    class="btn btn-primary mr-2">Submit
                            </button>
                            <button style="margin-bottom:5px;" class="btn btn-secondary">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="Roomoutoforder" class="stopsellmodal">
    <div class="stopsell-content">
        <div class="row d-flex ">
            <div class="col-md-12">
                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light font-weight-bolder" style="font-size:20px;">Room
                        Out Of Order</h5>
                </div>
                <div class="modal-header" style="z-index:1;border:none;background-color:#F5F7F9;">
                </div>
                <form class="form" id="ratesform">
                    <div class="modal-body">
                        <div class="form-style-6 " style="margin-top:-8%;">
                            <div class="row" id="">
                                <div class="col" id="">
                                    <label class="">Room</label>
                                    <select class="" id="roomooo">
                                        @foreach($active_rooms as $room)
                                            <option value='{{$room->id}}'>{{$room->number}}</option>"
                                        @endforeach
                                    </select></div>
                                <div class="col">
                                    <label class="">Start Date</label>
                                    <input type="date" class="" placeholder="Select date"
                                           id="startdate"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label class="">End Date</label>
                                    <input type="date" class="" placeholder="Select date" id="enddate"/>
                                </div>
                                <div class="col">
                                    <label class="">Add Reason</label>
                                    <input type="text" class="" placeholder="Enter reason"
                                           id="ooreason"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="">
                        <button type="button" value="" onclick="roomoutoforder()"
                                style='background-color:#48BD91;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'
                                class="" id="">Add
                        </button>
                        <button type="button" value="" onclick="roomooocancel()"
                                style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'
                                class="" id="">close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="Roomenabledisablemodal" class="modal3">
    <div class="modal-content3">
        <span id="closeedroom" class="close3">&times;</span>
        <div class="row mt-12 d-flex ">
            <div class="col-md-12 justify-content-center">
                <form class="form">
                    <div class="modal-body mystylishdivs ml-11">
                        <h3 style="text-align: center;">Room enable/disable</h3>
                        <div class="form-group">
                            <label>Room</label>
                            <select class="form-control" id="roomed">
                                @foreach($rooms as $room)
                                    <option value='{{$room->id}}'>{{$room->number}}</option>"
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Room Status</label>
                            <select class="form-control" id="statused">
                                <option value="Disabled">Disable</option>
                                <option value="Enabled">Enable</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" onclick="roomenabledisable()"
                               class="btn btn-primary mr-2" value="Submit">
                        <button onclick="roomedcancel()" class="btn btn-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="roominfoModal" style="" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable ">
        <div class="modal-content" style="width: 600px !important;" id="roominfoModalContent">
            <div class="modal-body text-dark">
                <div class="mb-2" style=" position: relative; height: 40px !important;">
                    <h5 class="text-dark text-align-bottom" style="position: absolute; bottom: 0; left: 10;">Room <i
                            class="fa fa-info-circle text-dark" aria-hidden="true"></i></h5>
                    <h5 class="" style="position: absolute; bottom: 0; right: 0;">Room No: <span
                            id="showRoomno"></span></h5>
                </div>
                <hr style=" border-top: 3px solid #dfdfdf;">
                <div class="row mb-5">
                    <div class="col-5">Room type</div>
                    <div class="col-7" id="riroomtype"></div>
                </div>
                <div class="row mb-5">
                    <div class="col-5">Occupancy Rate</div>
                    <div class="col-7" id="rioccrate"></div>
                </div>

                <div class="row mb-5">
                    <div class="col-5">ADR</div>
                    <div class="col-7" id="riadr"></div>
                </div>

                <div class="row mb-5">
                    <div class="col-5">Out Of Order</div>
                    <div class="col-7" id="riooo"></div>
                </div>

                <div class="row mb-5">
                    <div class="col-5">Accommodation Revenue (Net)</div>
                    <div class="col-7" id="riaccomnet"></div>
                </div>

                <div class="row mb-5">
                    <div class="col-5">Extra Revenue (Net)</div>
                    <div class="col-7" id="riextranet"></div>
                </div>
                <div class="row mb-5">
                    <div class="col-5">Overnight Tax Revenue</div>
                    <div class="col-7" id="riovernighttax"></div>
                </div>

                <div class="row mb-5">
                    <div class="col-5">Commission</div>
                    <div class="col-7" id="ricommission"></div>
                </div>

                <div class="row mb-5">
                    <div class="col-5">Guest Count</div>

                    <div class="col-7" id="riguest">
                        <div class="mr-5 float-left">
                            <span>Adults: </span><span id="riadults"></span></div>
                        <div class="mr-5 float-left"><span>Kids: </span><span id="rikids"></span></div>
                        <div class="mr-5 float-left"><span>Infants: </span><span id="riinfants"></span></div>
                    </div>

                </div>

                <div class="row mb-5">
                    <div class="col-5">Channel</div>
                    <div class="col-7" id="richannel"></div>
                </div>

                <div class="row mb-5">
                    <div class="col-5">VAT</div>
                    <div class="col-7" id="rivat">
                        <div class="mr-5 float-left"><span>Accommodation: </span><span id="riaaccvat"></span></div>
                        <div class="mr-5 float-left"><span>Extras: </span><span id="riextravat"></span></div>
                    </div>
                </div>

                <hr style=" border-top: 3px solid #dfdfdf;">
                <div class=" mb-2 mt-5  " style="margin-left:60%;">
                    <button type="button" class="btn btn-outline-primary d-print-none mr-5"
                            style="padding-left:30px;padding-right:30px;" id="printinfo" onclick="window.print()">
                        Print
                    </button>

                    <button type="button" class=" btn btn-outline-secondary d-print-none "
                            style="padding-left:30px;padding-right:30px;" data-dismiss="modal" style=''>Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
