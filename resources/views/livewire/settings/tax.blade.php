<div>
    <div class="d-flex flex-column-fluid mt-5 ">
        <div class="container-fluid">
            <div class="row mb-10" style="margin-bottom:50%;">
                <div class="col">
                    <div class="tax_settings shadow-sm bg-white">
                        <h1>Accommodation Tax Settings</h1>
                        <hr>
                        <div class="row">
                            <div class="col-4">
                                <div class="">
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="row">
                                    <div class="col">
                                        <label>VAT (%) <i class="fa fa-info-circle" title="Accommodation VAT"
                                                data-html="true" type="button" style="font-size: 16px"
                                                data-toggle="tooltip" data-placement="top"
                                                aria-hidden="true"></i></label></br>
                                        <span class="font-weight-bold">{{ $tax->vat_tax->vat_option->value ?? "N/A" }}</span>
                                    </div>
                                    <div class="col">
                                        <label>City Tax (%)</label></br>
                                        <span class="font-weight-bold">{{ $tax->city_tax ?? 0 }}</span>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col">
                                        <label>Cancelation VAT (%)</label></br>
                                        <span class="font-weight-bold">{{ $tax->cancellation_vat_tax->vat_option->value ?? "N/A" }}</span>
                                    </div>
                                    <div class="col">
                                        <label>Overnight Tax</label></br>
                                        <span
                                            class="font-weight-bold">{{ (showPriceWithCurrency($tax->overnight_tax->tax) ?? "0") }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-1">
                                <a href="#" data-toggle="modal" data-target="#editTaxSettings"><i
                                        class="fas fa-edit fa-2x"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-10" style="margin-bottom:50%;">
                <div class="col">
                    <div class="infocard shadow-sm bg-white">
                        <h1>Document Types Settings</h1>
                        <hr>
                        <table class="table mt-10" style="background-color:white !important;">
                            <thead>
                                <tr style="background-color:white !important;">
                                    <th>Document Type</th>
                                    <th>Status</th>
                                    <th>Row</th>
                                    <th>Enumeration</th>
                                    <th>Reference Code</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documents as $document)
                                    <tr>
                                        <td class='idcolor'>{{ $document->name }}</td>
                                        <td> <Button class='btn '>
                                                <input
                                                    wire:click="$emit('updateStatusSwal',{{ $document->id }},{{ $document->status == 1 ? 0 : 1 }})"
                                                    type='checkbox' class='checkbox ratetypeStatus'
                                                    data-ratetype='{{ $document->id }}'
                                                    id='type.{{ $document->id }}'
                                                    {{ $document->status ? 'checked' : '' }} />
                                                <label class='label' for='type.{{ $document->id }}'>
                                                    <div class='ball'></div>
                                                </label>
                                            </Button>
                    </div>
                    <td>{{ $document->row }}</td>
                    <td>{{ $document->enumeration }}</td>
                    <td>{{ $document->initials }}</td>
                    <td nowrap='nowrap'>
                        <button class='text-center editBtn' data-toggle="modal" data-target="#editDocumentType"
                            wire:click="setDocument({{ $document->id }})"
                            style='background-color:#ffff;border:none !important;margin-top:-5px;'>
                            <i class='fas fa-edit fa-2x'></i>
                        </button>
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
<!-- {{-- MODALS --}} -->
<div class="modal fade" id="editTaxSettings" style="border-radius:0px !important;" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-0">
            <div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
                <h5 style="margin-left:42%;margin-right:23%;" class="modal-title text-dark">Tax Settings</h5>
                <button type="submit" wire:click="saveTax()" class="float-right btn btn-outline-primary">Update
                </button>
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
            </div>
            <div class="modal-body" style="position:relative;background-color:#fff;">
                <div class="form-style-6">
                    <div class="row">
                        <div class="col">
                            <label>VAT (%)</label></br>
                            <!-- <input type="text" wire:model.defer="tax.vat" placeholder="Enter VAT" /> -->
                            <select wire:model.defer="tax.vat_id">
                                <option value="">Select Vat</option>
                                @foreach($vat_options as $option)
                                  <option value="{{$option->id}}">{{$option->vat_option->value}}</option>
                                @endforeach
                                <!-- <option value="2">13</option>
                                <option value="3">6</option>
                                <option value="4">17</option>
                                <option value="5">9</option>
                                <option value="6">4</option> -->
                                <!-- <option value="7">No Vat</option>
                                <option value="8">Without Vat</option> -->
                            </select>
                            @error('tax.vat')
                                <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="col">
                            <label>City Tax (%)</label>
                            <input type="text" wire:model.defer="tax.city_tax" placeholder="Enter City Tax" />
                            @error('tax.city_tax')
                                <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <label>Cancelation VAT (%)</label>
                            <!-- <input type="text" wire:model.defer="tax.cancellation_vat" placeholder="Cancelation VAT" /> -->
                            <select wire:model.defer="tax.cancellation_vat_id">
                                <option value="">Select Cancellation Vat</option>
                                @foreach($vat_options as $option)
                                  <option value="{{$option->id}}">{{$option->vat_option->value}}</option>
                                @endforeach

                            </select>
                            @error('tax.cancellation_vat')
                                <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="col">
                            <label>Overnight Tax</label>
                            <!-- <input type="text" wire:model.defer="tax.overnight_tax" placeholder="Enter Overnight Tax" /> -->
                            <select wire:model.defer="tax.overnight_tax_id">
                                <option value="">Select Overnight Tax</option>
                                @foreach($overnightTaxOptions as $option)
                                  <option value="{{$option->id}}">{{$option->tax}} ({{$option->description}})</option>
                                @endforeach

                            </select>
                            @error('tax.overnight_tax_id')
                                <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editDocumentType" style="border-radius:0px !important;" tabindex="-1" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-0">
            <div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
                <h5 style="margin-left:30%;margin-right:23%;" class="modal-title text-dark" id="exampleModalLabel">
                    Update Document Type</h5>
                <button wire:click="saveDocument()" class="float-right btn btn-outline-primary">Update</button>
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
            </div>
            <div class="modal-body" style="position:relative;background-color:#fff;">
                <div class="form-style-6" id="editDocumentTypeModalBody">
                    <div class="row">
                        <div class="col">
                            <label>Document Type Row</label></br>
                            <input type="text" wire:model.defer="selected_document.row" />
                            @error('selected_document.row')
                                <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="col">
                            <label>Document Type Enumeration</label>
                            <input type="text" wire:model.defer="selected_document.enumeration" />
                            @error('selected_document.enumeration')
                                <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <label class="">Reference Code</label>
                            <input type="text" wire:model.defer="selected_document.initials">
                            @error('selected_document.initials')
                                <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        window.livewire.on('updateStatusSwal', (id, status) => {
            console.log('sdfsd')
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: 'Do you want to change the status of this document type',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    window.livewire.emit('updateStatus', id, status)
                } else {
                    Swal.fire({
                        icon: 'error',
                        text: 'Operation Cancelled!'
                    }).then((result) => {

                        window.location.reload()
                    });
                }
            });
        });
    })
</script>
