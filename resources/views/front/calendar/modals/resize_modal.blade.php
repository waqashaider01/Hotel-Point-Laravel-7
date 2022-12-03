<div id="resizemodal" class="stopsellmodal">
    <div class="stopsell-content">
        <div class="row d-flex ">
            <div class="col-md-12">
                <form class="form" id="stopsellform">
                    <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                        <h5 class="modal-title text-light font-weight-bolder"
                            style="font-size:20px;" id="restitle">Resize Reservation</h5>
                    </div>
                    <div class="modal-header"
                         style="z-index:1;border:none;background-color:#F5F7F9;">
                    </div>
                    <div class="modal-body">

                        <div class="form-style-6 " style="margin-top:-8%;">
                            <div class="row">
                                <div class="col">
                                    <label class="" id="stitle">Check In Date</label>
                                    <input type="date" class="" readonly
                                           placeholder="Select date" id="resizecheckin"/>
                                </div>
                                <div class="col">
                                    <label class="" id="etitle">Check Out Date</label>
                                    <input type="date" class="" placeholder="Select date"
                                           id="resizecheckout"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label class="" id="idtitle">Reservation</label>
                                    <input type="text" class="" readonly placeholder="id"
                                           id="resizebookingid"/>
                                </div>
                                <div class="col">
                                    <div class="" id="roomdiv" style="visibility: hidden;">
                                        <label class="">Room No</label>
                                        <input type="text" class="" readonly
                                               id="resizeroom"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col">
                                    <div class="" id="resizedratesrow">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="">Choose daily
                                                    rates</label></br>
                                                <button id="showresizeratebtn" class=""
                                                        type="button"
                                                        style='background-color:#48BBBE;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'
                                                        onclick="showdailyrates('resizecheckin','resizecheckout', 'resizebookingid' )">
                                                    Add Rates
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="" placeholder="enter id"
                                   id="hiddenresizecheckout"/>
                            <input type="hidden" class="" placeholder="enter id"
                                   id="hiddenresizeroomid"/>
                            <input type="hidden" class="" placeholder="enter id"
                                   id="hiddenresizeroomtype"/>

                        </div>
                        <div class="modal-footer" style="">
                            <input type="button" value="Submit" id="resizesubmit"
                                   onclick="resizebtn()"
                                   style='background-color:#48BD91;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'
                                   class=""/>
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
