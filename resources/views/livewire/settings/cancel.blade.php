<div>
    <div class="d-flex flex-column-fluid mt-5 ">
        <div class="container-fluid">
            <div class="row mb-10 m-0" style="margin-bottom:50%;">
                <div class="col">
                    <div class="infocard shadow-sm bg-white">
                        <h1>Cancellation Policies Settings</h1>
                        <hr>
                        <div class="table mt-10 text-center " style="background-color:white !important;">
                            <div>
                                <div class="row th " style="background-color:white !important;">
                                    <div class="col">Policy Name</div>
                                    <div class="col text-center">Policy Amount (%)</div>
                                    <div class="col text-center">Police Charge Days</div>
                                    <div class="col text-center">Action</div>
                                </div>
                            </div>
                            <div>
                                @foreach ($policies as $policy)
                                    <div class='row mytr'>
                                        <div class='col idcolor'>{{ $policy->name }}</div>
                                        <div class='col text-center'>{{ $policy->amount }}</div>
                                        <div class='col text-center'>{{ $policy->charge_days }}</div>
                                        <div class='col text-center' nowrap='nowrap'>
                                            <button wire:click="setPolicy({{ $policy->id }})" data-toggle="modal"
                                                data-target="#editPolicy"
                                                style='background-color:#ffff;border:none !important;margin-top:-5px;'
                                                class='text-center editBtn'><i class='fas fa-edit fa-2x '></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- modals --}}
            <div class="modal fade" id="editPolicy" style="border-radius:0px !important;" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog  modal-dialog-scrollable">
                    <div class="modal-content rounded-0">
                        <div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
                            <h5 style="margin-left:5%;margin-right:43%;" class="modal-title text-dark">
                                Edit Policy</h5>
                            <button type="submit" wire:click="savePolicy"
                                class="float-right btn btn-outline-primary">Update
                            </button>
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal" style=''>Close
                            </button>
                        </div>
                        <div class="modal-body" style="position:relative;background-color:#fff;">
                            <div class="form-style-6">
                                <div class="row">
                                    <div class="col">
                                        <label>Policy Amount</label></br>
                                        <input type="email" wire:model.defer="selected_policy.amount" />
                                        <x-error field="selected_policy.amount" />
                                    </div>
                                    <div class="col">
                                        <label>Policy Charge Days</label>
                                        <input type="email" wire:model.defer="selected_policy.charge_days" />
                                        <x-error field="selected_policy.charge_days" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
