<div id="deletemodal" class="modal3">

    <!-- Modal content -->
    <div class="modal-content3" style="width:600px !important;">
        <span id="closedelete" class="close3">&times;</span>
        <div class="row mt-9 d-flex justify-content-center">
            <div class="col-md-6">
                <form class="form">
                    <div class="card-body">

                        <div class="mystylishdivs p-10" style="margin-left:-120px !important; ">
                            <center><h3>Delete Out Of Order Reservation</h3></center>
                            <hr>
                            <div class="row" style="margin-top:-25px;">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="col-form-label mr-10">Do you want to delete
                                            this Reservation?</label>
                                        <label class="col-form-label mr-10">Reservation ID</label>
                                        <input type="text" disabled id="bookingid"></input>
                                    </div>
                                    <input onclick="deletebtn()" value="Confirm"
                                           class="btn btn-primary "
                                           style="width:100px !important;margin-left:120px !important;"></input>
                                    <button onclick="deletecancel()" class="btn btn-secondary"
                                            style="width:100px !important;">Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
