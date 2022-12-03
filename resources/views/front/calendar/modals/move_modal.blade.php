<div id="movemodal" class="stopsellmodal">
    <div class="movreservation-content">
        <div class="row d-flex ">
            <div class="col-md-12">
                <form class="form" id="stopsellform">
                    <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                        <h5 class="modal-title text-light font-weight-bolder"
                            style="font-size:20px;" id="">Move Reservation</h5>
                    </div>
                    <div class="modal-header"
                         style="z-index:1;border:none;background-color:#F5F7F9;">
                    </div>
                    <div class="modal-body">
                        <div class="form-style-6 " style="margin-top:-4%;">
                            <div class="row">
                                <div class="col-4">
                                    <fieldset
                                        style="border:1px solid #43D1AF; border-radius:5px;padding:15px;margin:0px;margin-bottom:0px !important;height:100%;">
                                        <legend
                                            style="width:auto; margin-bottom: 0px; font-size: 18px; font-weight: bold; color: #3D3D3D;">
                                            Current Room
                                        </legend>
                                        <div class="row">
                                            <div class="col">
                                                <label>This Room</label></br>
                                                <select
                                                    style="max-width:150px !important;min-width:150px !important;"
                                                    readonly id="moveoldroom">
                                                    @foreach ($active_rooms as $room) {
                                                    <option value='{{$room->id}}'>{{$room->number}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col">
                                    <fieldset
                                        style="border:1px solid #43D1AF; border-radius:5px;padding:15px;margin:0px;margin-bottom:0px !important;height:100%;">
                                        <legend
                                            style="width:auto; margin-bottom: 0px; font-size: 18px; font-weight: bold; color: #3D3D3D;">
                                            New Room
                                        </legend>

                                        <div class="row" style="">
                                            <div class="col">
                                                <div class="row" style="">
                                                    <div class="col">
                                                        <label>New Room</label>
                                                        <select class=""
                                                                style="max-width:200px !important;min-width:200px !important;"
                                                                id="movenewroom">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Rate type</label>

                                                        <input type="hidden"
                                                               id="moveoldratetype"/>
                                                        <select class=" "
                                                                style="max-width:200px !important;min-width:200px !important;"
                                                                id="moveratetype">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div style="margin-top:20%;margin-left:20%;">

                                                    <label style=""> Daily Pricing</label></br>
                                                    <span type="button" class="infbtn"
                                                          onclick="showdailyrates('movecheckin','movecheckout', 'movereservationid' )"
                                                          style="min-width:auto !important;min-height:auto;padding-top:3px;"
                                                          id="showmoveratebtn"><i
                                                            class="fas pt-3 fa-list"
                                                            aria-hidden="true"></i>&nbsp;Pricing</span>
                                                    <input type="hidden" class=""
                                                           placeholder="enter id"
                                                           id="movereservationid"/>
                                                    <input type="hidden" class="form-control"
                                                           placeholder="enter id"
                                                           id="movedailyratehidden"/>
                                                    <input type="hidden" class="form-control"
                                                           placeholder="enter id"
                                                           id="moveroomtypehidden"/>
                                                    <input type="hidden" class="form-control"
                                                           placeholder="enter id"
                                                           id="movecheckin"/>
                                                    <input type="hidden" class="form-control"
                                                           placeholder="enter id"
                                                           id="movecheckout"/>
                                                </div>
                                            </div>
                                        </div>

                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="">
                            <input type="button" value="Move" id="" onclick="movebtn()"
                                   style='background-color:#48BD91;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'
                                   class=""/>
                            <button onclick="cancelmove()" class=""
                                    style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>
                                Close
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
