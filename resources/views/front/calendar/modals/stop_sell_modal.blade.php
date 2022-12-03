<div id="stopSell" class="stopsellmodal">
    <div class="stopsell-content">
        <div class="row d-flex ">
            <div class="col-md-12">
                <form class="form" id="stopsellform">
                    <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                        <h5 class="modal-title text-light font-weight-bolder" style="font-size:20px;"
                            id="exampleModalLabel">Restrictions</h5>
                    </div>
                    <div class="modal-header" style="z-index:1;border:none;background-color:#F5F7F9;">
                    </div>
                    <div class="modal-body">

                        <div class="form-style-6 " style="margin-top:-8%;">
                            <div class="row " style="">
                                <div class="col">
                                    <label style="">Room Type</label>
                                    <select class="" id="ssroomtype" style="">
                                        @foreach($room_types as $room_type)
                                            <option value="{{$room_type->id}}">{{$room_type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label style="">Restriction</label>
                                    <select class="" id="ssrestriction" style="">
                                        <option selected disabled>Select restriction</option>
                                        <option value="stop_sell">Stop Sell</option>
                                        <option value="min_stay_arrival">Min Stay Arrival</option>
                                        <option value="min_stay_through">Min Stay Through</option>
                                        <option value="max_stay">Max Stay</option>
                                        <option value="closed_to_arrival">Closed to Arrival</option>
                                        <option value="closed_to_departure">Closed to Departure</option>
                                        <option value="max_sell">Max Sell</option>
                                        <option value="max_availability">Max Availability</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row " style="">
                                <div class="col">
                                    <label style="">Start Date</label>
                                    <input type="date" class="" placeholder="Select date"
                                           id="ssStartdate" style=""/>
                                </div>
                                <div class="col">
                                    <label style="">End Date</label>
                                    <input type="date" class="" placeholder="Select date"
                                           id="ssEnddate" style=""/>
                                </div>
                            </div>
                            <div class="row " style="">
                                <div class="col">
                                    <div class="" id="ratetypediv">
                                        <label style="">Rate Type</label>
                                        <select class="" id="ssratetype" style="">
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="" id="stopSelldiv">
                                        <label style="">Status</label>
                                        <!-- Custom switch -->
                                        <div style="margin-left:10%;margin-top:2%;"><input type="checkbox"
                                                                                           class="checkbox "
                                                                                           id="ssStatus"/>
                                            <label class="label" for="ssStatus">
                                                <!-- <i class="fas fa-check"></i>
                                                <i class="fas fa-times"></i> -->
                                                <div class="ball"></div>
                                            </label></div>
                                    </div>
                                    <div class="" id="minStaydiv">
                                        <label style="">Value</label>
                                        <input type="number" id="ssValue" class="" min="1"
                                               oninput="validity.valid||(value='')" style="">
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="">
                            <button type="button" onclick="addRestrictions()"
                                    style='background-color:#48BD91;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'
                                    class="">Submit
                            </button>
                            <button onclick="closeRestrictions()" class=""
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
