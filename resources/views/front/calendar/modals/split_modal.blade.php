<div id="splitmodal" class="stopsellmodal">
    <div class="splitreservation-content">
        <div class="row d-flex ">
            <div class="col-md-12">
                <form class="form" id="stopsellform">
                    <div class="modal-header"
                         style="background-color:#48BBBE;z-index:0;">
                        <h5 class="modal-title text-light font-weight-bolder"
                            style="font-size:20px;" id="">Split Reservation</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-style-6">
                            <div class="row">
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col">
                                            <fieldset
                                                style="border:1px solid #43D1AF; border-radius:5px;padding:15px;margin:0px;margin-bottom:0px !important;height:100%;">
                                                <legend
                                                    style="width:auto; margin-bottom: 0px; font-size: 18px; font-weight: bold; color: #3D3D3D;">
                                                    Guest Details
                                                </legend>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Guest Name</label>
                                                        <input type="text"
                                                               id="splitguestname"
                                                               style="min-width:200px;max-width:200px;"
                                                               class="form-control-solid"
                                                               placeholder="Guest Name"/>
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
                                                    Current Room Details
                                                </legend>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Room</label>
                                                        <select style="min-width:200px;max-width:200px;"
                                                                readonly disabled id="splitoldroom">
                                                            @foreach ($active_rooms as $room)
                                                                <option value='{{$room->id}}' >{{$room->number}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>CheckIn Date</label>
                                                        <input type="date"
                                                               readonly
                                                               placeholder="Select date"
                                                               id="kt_datepicker_71"/>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>CheckOut Date</label>
                                                        <input type="date"
                                                               style="min-width:200px;max-width:200px;"
                                                               placeholder="Select date"
                                                               id="kt_datepicker_81"/>
                                                    </div>
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
                                                    <div class="col">
                                                        <label>Room</label>
                                                        <select class=""
                                                                style="min-width:200px;max-width:200px;"
                                                                id="splitnewroom">
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <label>Rate Type</label>
                                                        <input type="hidden"
                                                               id="splitoldratetype">
                                                        <select class=""
                                                                style="min-width:200px;max-width:200px;"
                                                                id="splitratetype">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>CheckIn Date</label>
                                                        <input type="date" class=""
                                                               style="min-width:200px;max-width:200px;"
                                                               placeholder="Select date"
                                                               id="newsplitcheckin"
                                                               disabled/>
                                                    </div>
                                                    <div class="col">
                                                        <label>CheckOut Date</label>
                                                        <input type="date" class=""
                                                               style="min-width:200px;max-width:200px;"
                                                               readonly
                                                               placeholder="Select date"
                                                               id="kt_datepicker_101"/>
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
                                                    Finance Details
                                                </legend>
                                                <div class="row">
                                                    <div class="col">
                                                        <label style=""> Daily
                                                            Pricing</label></br>
                                                        <span type="button"
                                                              class="infbtn"
                                                              onclick="showdailyrates('newsplitcheckin', 'kt_datepicker_101', 'splitreservationid')"
                                                              style="min-width:auto !important;min-height:auto;padding-top:3px;"
                                                              id="splitdailyrate"><i
                                                                class="fas pt-3 fa-list"
                                                                aria-hidden="true"></i>&nbsp;Pricing</span>

                                                        <!-- <input type="text" class="form-control"  placeholder="enter daily rate" id="splitdailyrate"/> -->
                                                        <input type="hidden"
                                                               class="form-control"
                                                               placeholder="enter id"
                                                               id="splitreservationid"/>
                                                        <input type="hidden"
                                                               class="form-control"
                                                               placeholder="enter id"
                                                               id="dailyratehidden"/>
                                                        <input type="hidden"
                                                               class="form-control"
                                                               placeholder="enter id"
                                                               id="roomtypehidden"/>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer"
                             style="max-height:30px;min-height:30px;">
                            <input type="button" value="Submit" onclick="splitbtn()"
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
