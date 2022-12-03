<div>
    <div class="d-flex flex-column-fluid mt-5 ">
        <div class="container-fluid">
            <div class="row m-0 mb-10" style="margin-bottom:50%;">
                <div class="col p-0">
                    <div class="tax_settings shadow-sm bg-white">
                        <div class="row">
                            <div class="col-10">
                                <h1 style="">Payment Mode Settings</h1>
                            </div>
                            <div class="col-2">
                                <span type="button" class="infbtn" data-toggle="modal" data-target="#addEditMode"
                                    wire:click="setNewMode()">
                                    <i class="fas fa-credit-card mt-1" aria-hidden="true"></i>&nbsp;Payment Mode</span>
                            </div>
                        </div>
                        <hr>
                        <table class="table mt-10 text-center  m-auto w-50" id='reservations-table'
                            style="background-color:white !important;">
                            <thead>
                                <tr style="background-color:white !important;">
                                    <th class="w-50 text-center">Payment Mode</th>
                                    <th class="w-50 text-center">Action</th>
                                </div>
                            </thead>
                            <tbody>
                                @foreach ($modes as $mode)
                                    <tr>
                                        <td class=' idcolor text-center'>{{ $mode->name }}</td>
                                        <td class=' text-center' nowrap='nowrap'>
                                            <a href="#" data-toggle="modal" data-target="#addEditMode"
                                                wire:click="setMode({{ $mode->id }})"> <i
                                                    class="fas fa-edit fa-2x"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row m-0 mb-10" style="margin-bottom:50%;">
                <div class="col p-0">
                    <div class="infocard shadow-sm bg-white">
                        <div class="row">
                            <div class="col-8">
                                <h1 style="margin-left:5%;">Payment Method Settings</h1>
                            </div>
                            <div class="col-4 d-flex justify-content-end align-items-center">
                                 <!-- <div type="button" class="infbtn" wire:click="synPaymentMethodsWithOxygen()">
                                    <span wire:loading.remove wire:target="synPaymentMethodsWithOxygen">
                                        <i class="fas fa-sync mt-1" aria-hidden="true"></i> Sync with Oxygen
                                    </span>
                                    <div class="d-none justify-content-center align-items-center" wire:loading.class="d-inline" wire:target="synPaymentMethodsWithOxygen">
                                        <x-loader color="#333" width="25px" height="25px" margin="0"/>
                                    </div>
                                </div> -->
                                <div type="button" class="infbtn" wire:click="setNewMethod()"
                                data-toggle="modal" data-target="#addMethod">
                                <i class="fas fa-credit-card mt-1" aria-hidden="true"></i>&nbsp;Payment
                                Method</div>
                            </div>
                        </div>
                        <hr>
                        <table class="table mt-10 text-center " id='reservations-table'
                            style="background-color:white !important;">
                            <thead>
                                <tr style="background-color:white !important;">
                                    <th>Payment Method</th>
                                    <th>Payment Method Commission (%)</th>
                                    <th>References To Card Payment</th>
                                    <th>Oxygen ID</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($methods as $method)
                                    <tr>
                                        <td class='idcolor'>{{ $method->name }}</td>
                                        <td>{{ $method->commission_percentage }}</td>
                                        <td>{{ $method->is_card_type ? 'Yes' : 'No' }}</td>
                                        <td>{{ $method->oxygen_id ?? "-" }}</td>
                                        <td>
                                            <button wire:click="setMethod({{ $method->id }})" data-toggle="modal"
                                                data-target="#editMethod"
                                                style='background-color:#ffff;border:none !important;margin-top:-5px;'
                                                class='text-center editBtnn'><i class="fas fa-edit fa-2x"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- bank details -->
            <div class="row mb-10 m-0" style="margin-bottom:50%;">
                <div class="col p-0">
                    <div class="infocard shadow-sm bg-white">
                        <div class="row">
                            <div class="col-12">

                                <h1 style="">Bank Details</h1>
                            </div>
                            <div class="col-2">
                                <!-- <span type="button" class="infbtn" id=""  data-toggle="modal" data-target="#addPaymentModeModal" ><i class="fa fa-credit-card-alt" aria-hidden="true"></i>&nbsp;Payment Mode</span> -->
                            </div>
                        </div>
                        <hr>
                        <table class="mt-10 w-100 text-center" id='reservations-table'
                            style="background-color:white !important;">

                            <thead>
                                <tr style="background-color:white !important;">
                                    <th>Bank Name</th>
                                    <th>Swift Code</th>
                                    <th>IBAN</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td class='idcolor ' id="bankName">{{ $settings['bank_name'] }}
                                    </td>
                                    <td class='idcolor ' id="swiftCode">{{ $settings['swift_code'] }}
                                    </td>
                                    <td class='idcolor ' id="bankIban">{{ $settings['iban'] }}</td>
                                    <td class=''>
                                        <!-- <form  id="checkform"> -->
                                        <Button class='btn'>
                                            <input type='checkbox' class='checkbox' id='status_check'
                                                wire:change='bankStatusUpdate()' wire:model='bank.bank_status'
                                                name="booking_status"
                                                {{ $settings['bank_status'] ? 'checked' : '' }} />
                                            <label class='label' for='status_check'>
                                                <div class='ball'></div>
                                            </label>
                                        </Button>
                                        <!-- </form> -->

                                    </td>
                                    <td class='' nowrap='nowrap'>
                                        <button type='btn' name='view' id="showeditbank" data-toggle="modal"
                                            data-target="#bankdetailModal"
                                            style='background-color:#ffff;border:none !important;margin-top:-5px;'
                                            class=' '> <i class='fas fa-edit fa-2x'></i> </button>
                                    </td>
                                    <td class="" hidden>
                                        <form method="post" action="#" id="submitform">
                                            <input type="text" name="bankstatus" id="customstatus">

                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Modals --}}
            <div class="modal fade" id="bankdetailModal" style="border-radius:0px !important;" tabindex="-1"
                aria-labelledby="exampleModalLabel1" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-scrollable">
                    <div class="modal-content rounded-0">
                        <div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
                            <h5 style="margin-left:0%;margin-right:19%;" class="modal-title text-dark"
                                id="exampleModalLabel1">Update Bank Details</h5>
                            <button type="submit" name='update-bank-details' wire:click="saveBank()"
                                class="float-right btn btn-outline-primary" style='' id="">Update</button>

                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal"
                                style=''>Close</button>

                        </div>
                        <div class="modal-body" style="position:relative;background-color:#fff;">


                            <div class="form-style-6" id="">

                                <div class="row">
                                    <div class="col">
                                        <label>Bank Name</label>
                                        <input id="bankname" wire:model.defer='bank.bank_name' type="text"
                                            value='{{ $settings['bank_name'] }}' required>
                                        <x-error field="bank.bankname" />

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label>Swift Code</label>
                                        <input id="swiftcode" wire:model.defer='bank.swift_code' type="text"
                                            value='{{ $settings['swift_code'] }}' required>
                                        <x-error field="bank.swiftcode" />

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label>Bank IBAN</label>
                                        <input id="iban" wire:model.defer='bank.iban' type="text"
                                            value='{{ $settings['iban'] }}' required>
                                        <x-error field="bank.iban" />

                                    </div>
                                </div>




                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="modal fade" id="addEditMode" style="border-radius:0px !important;" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog  modal-dialog-scrollable">
                    <div class="modal-content rounded-0">
                        <div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
                            <h5 style="margin-left:0%;margin-right:19%;" class="modal-title text-dark"
                                id="exampleModalLabel">
                                Insert Payment Mode</h5>
                            <button wire:click="saveMode()" class="float-right btn btn-outline-primary">Submit</button>
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal"
                                style=''>Close</button>
                        </div>
                        <div class="modal-body" style="position:relative;background-color:#fff;">
                            <div class="form-style-6" id="">
                                <div class="row">
                                    <div class="col">
                                        <label>Payment Mode Name</label>
                                        <input type="text" wire:model.defer="selected_mode.name">
                                        <x-error field="selected_mode.name" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addMethod" style="border-radius:0px !important;" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content rounded-0">
                        <div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
                            <h5 style="margin-left:30%;margin-right:23%;" class="modal-title text-dark"
                                id="exampleModalLabel">
                                Add Payment Method</h5>
                            <button type="submit" class="float-right btn btn-outline-primary"
                                wire:click="saveMethod">Insert
                            </button>
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal"
                                style=''>Close</button>
                        </div>
                        <div class="modal-body" style="position:relative;background-color:#fff;">
                            <div class="d-none justify-content-center align-items-center" wire:loading.class="d-flex" wire:target="saveMethod">
                                <x-loader color="#333"/>
                            </div>
                            <div class="form-style-6" wire:loading.remove wire:target="saveMethod">
                                <div class="row">
                                    <div class="col">
                                        <label>Name</label></br>
                                        <select id="paymentmethod" wire:change="onMethodUpdate()"
                                            wire:model.defer="selected_method.name">
                                            <option value="" selected>-Select-</option>
                                            @foreach (\App\Models\PaymentMethod::$types as $key => $type)
                                                <option value="{{ $key }}">{{ $type['name_en'] }}</option>
                                            @endforeach
                                        </select>
                                        <x-error field="selected_method.name" />
                                    </div>
                                    <div class="col">
                                        <label>Commision</label>
                                        <input type="text" placeholder="Enter Commision"
                                            wire:model.defer="selected_method.commission_percentage" />
                                        <x-error field="selected_method.commission_percentage" />
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col">
                                        <label>Refer To Card Payments?</label>
                                        <select wire:model.defer="selected_method.is_card_type">
                                            <option value=''>-select-</option>
                                            <option value=0>No</option>
                                            <option value=1>Yes</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label>Channel Manager Id</label>
                                        <input type="text" placeholder="Enter Channel Manager id"
                                            id="channel_manager_id" wire:model.defer="selected_method.channex_id"
                                            readonly />
                                        <x-error field="selected_method.channex_id" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editMethod" style="border-radius:0px !important;" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content rounded-0">
                        <div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
                            <h5 style="margin-left:30%;margin-right:23%;" class="modal-title text-dark"
                                id="exampleModalLabel">
                                Edit Payment Method</h5>
                            <button type="submit" class="float-right btn btn-outline-primary"
                                wire:click="saveMethod">Update
                            </button>
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal"
                                style=''>Close</button>
                        </div>
                        <div class="modal-body" style="position:relative;background-color:#fff;">
                            <div class="d-none justify-content-center align-items-center" wire:loading.class="d-flex" wire:target="saveMethod">
                                <x-loader color="#333"/>
                            </div>
                            <div class="form-style-6" wire:loading.remove wire:target="saveMethod">
                                <div class="row">
                                    <div class="col">
                                        <label>Name</label></br>
                                        <select id="paymentmethod" disabled wire:model.defer="selected_method.name">
                                            @foreach (\App\Models\PaymentMethod::$types as $key => $type)
                                                <option value="{{ $key }}">{{ $type['name_en'] }}</option>
                                            @endforeach
                                        </select>
                                        {{-- <input type="text" placeholder="Enter Name"/> --}}
                                        <x-error field="selected_method.name" />
                                    </div>
                                    <div class="col">
                                        <label>Commision</label>
                                        <input type="text" placeholder="Enter Commision"
                                            wire:model.defer="selected_method.commission_percentage" />
                                        <x-error field="selected_method.commission_percentage" />
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col">
                                        <label>Refer To Card Payments?</label>
                                        <select wire:model.defer="selected_method.is_card_type">
                                            <option value=0>No</option>
                                            <option value=1>Yes</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label>Channel Manager Id</label>
                                        <input type="text" placeholder="Enter Channel Manager id"
                                            id="channel_manager_id" wire:model.defer="selected_method.channex_id"
                                            readonly />
                                        <x-error field="selected_method.channex_id" />
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col">
                                        <label>Oxygen Id</label>
                                        <input type="text" placeholder="Enter Oxygen ID"
                                            id="oxygen_id" wire:model.defer="selected_method.oxygen_id" readonly/>
                                        <x-error field="selected_method.oxygen_id" />
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
