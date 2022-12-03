<div>
    <x-table title='Channel List'>
        <x-slot name="header">
            <a href="#" type="button" data-toggle="modal" data-target="#addEditModal" wire:click="newChannel" class="btn btn-primary float-right">
                <i class="link-icon" data-feather="plus"></i>New Channel
            </a>
        </x-slot>
        <x-slot name="heading">
            <th>Name</th>
            <th>Channel Code</th>
            <th>Virtual Card</th>
            <th data-orderable="false">Actions</th> 
        </x-slot>
        @foreach ($channels as $item)
            <tr id="tr_{{ $item->id }}">
                <td>{{ $item->name }}</td>
                <td>{{ $item->channel_code }}</td>
                <td>{{ $item->supports_virtual_card }}</td>
                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="#" type="button" data-toggle="modal" data-target="#addEditModal" wire:click="setChannel({{ $item->id }})" class="btn btn-outline-info btn-xs">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button type="button" wire:click="deleteChannel({{ $item->id }})" class="btn btn-outline-danger btn-xs">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-table>

    <div class="modal fade" id="addEditModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" id="exampleModalLabel">{{ $editing_channel ? 'Edit' : 'Add' }} Channel</h5>
                </div>
                <div class="modal-header" style="z-index:1;border:none;background-color:#F5F7F9;">
                </div>
                <div class="modal-body" style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-3%;">
                    <div class="">
                        <div class="mt-0">

                            <div class="form-style-6" x-data="{ open: @entangle('has_vc_card').defer }">
                                <div class="row">
                                    <div class="col">
                                        <label>Channel Name</label>
                                        <input type="text" class="form-control1" placeholder="Channel Name" wire:model.defer='selected_channel.name'>
                                        @error('selected_channel.name')
                                            <span class="invalid-input-data" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <x-channelSelect />
                                        @error('selected_channel.channel_code')
                                            <span class="invalid-input-data" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label>VAT No</label>
                                        <input class="form-control1" placeholder=" VAT No" wire:model.defer='selected_channel.vat_number' type="text" />
                                        @error('selected_channel.vat_number')
                                            <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label>Channel Activity</label>
                                        <input class="form-control1" placeholder="Channel Activity" wire:model.defer='selected_channel.activity' type="text">
                                        @error('selected_channel.activity')
                                            <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label>TAX Office</label>
                                        <input class="form-control1" wire:model.defer='selected_channel.tax_office' placeholder="TAX Office" type="text" />
                                        @error('selected_channel.tax_office')
                                            <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label>Channel Address</label>
                                        <input class="form-control1" placeholder=" Channel Address" wire:model.defer='selected_channel.address' type="text">
                                        @error('selected_channel.address')
                                            <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label>Country</label>
                                        <select class="form-control1" wire:model.defer='selected_channel.country'>
                                            <option value=""> Select Country </option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('selected_channel.country')
                                            <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="col">
                                        <label>Payment Mode</label>
                                        <select class="form-control1" wire:model.defer='selected_channel.default_payment_mode_id'>
                                            <option value=""> Select Mode </option>
                                            @foreach ($payment_modes as $mode)
                                                <option value="{{ $mode->id }}">{{ $mode->name }}</option>h
                                            @endforeach
                                        </select>
                                        @error('selected_channel.default_payment_mode_id')
                                            <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label>Payment Method</label>
                                        <select class="form-control1" wire:model.defer='selected_channel.default_payment_method_id'>
                                            <option value=""> Select Method </option>
                                            @foreach ($payment_methods as $method)
                                                <option value="{{ $method->id }}">{{ $method->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('selected_channel.default_payment_method_id')
                                            <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label>Channel Category</label>
                                        <input class="form-control1" placeholder="Channel Category" wire:model.defer='selected_channel.category' type="text" />
                                        @error('selected_channel.category')
                                            <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label>Channel Branc</label>
                                        <input class="form-control1" placeholder="Channel Branc" wire:model.defer='selected_channel.branch' type="text" />
                                        @error('selected_channel.branch')
                                            <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label>Channel Headquarters</label>
                                        <input class="form-control1" wire:model.defer='selected_channel.headquarters' placeholder="Channel Headquarters" type="text" />
                                        @error('selected_channel.headquarters')
                                            <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label>Postal Code</label>
                                        <input class="form-control1" placeholder="Postal Code" wire:model.defer='selected_channel.postal_code' type="text" />
                                        @error('selected_channel.postal_code')
                                            <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label>Phone Number</label>
                                        <input class="form-control1" placeholder="Phone Number" wire:model.defer='selected_channel.phone_number' type="text" />
                                        @error('selected_channel.phone_number')
                                            <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label>Virtual Card</label>
                                        <select class="form-control1" x-model='open'>
                                            <option value="no">No</option>
                                            <option value="yes">Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" x-show="open == 'yes'">
                                    <div class="col-4">
                                        <label>Charge Mode</label>
                                        <select class="form-control1" id="chanrge_mode_select" wire:model.defer='selected_channel.charge_mode'>
                                            <option value=""> Select Mode </option>
                                            <option value="beforearrival">Before Arrival</option>
                                            <option value="onarrival">On Arrival</option>
                                            <option value="afterarrival">After Arrival</option>
                                        </select>
                                        @error('selected_channel.charge_mode')
                                            <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <label>Charge Days</label>
                                        <input class="form-control1" id="chanrge_days_input" wire:model.defer='selected_channel.charge_date_days' type="number" min="0" />
                                        @error('selected_channel.charge_date_days')
                                            <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <label>Virtual Card Payment Mode</label>
                                        <select class="form-control1" wire:model.defer='selected_channel.virtual_card_payment_mode_id'>
                                            <option value=""> Select Option </option>
                                            @foreach ($payment_modes as $mode)
                                                <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('selected_channel.virtual_card_payment_mode_id')
                                            <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <label>Channel Manager ID</label>
                                        <input class="form-control1" placeholder="Channel Manager ID" wire:model.defer='selected_channel.channex_channel_id' type="text" />
                                        <i class="fa fa-2x fa-unlock-alt" style="margin-top:10px;margin-left:-30px;position:absolute;">
                                        </i>
                                        <br>
                                        @error('selected_channel.channex_channel_id')
                                            <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color:#F5F7F9;">
                        <button type="submit" wire:click="saveChannel" class="modal_footer_submit float-right">
                            Submit
                        </button>
                        <button type="button" class="modal_footer_cancel" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
