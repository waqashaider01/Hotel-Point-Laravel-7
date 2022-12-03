<div>
    <div class="d-flex flex-column-fluid mt-5 ">
        <div class="container-fluid">
            <div class="row mb-10" style="margin-bottom:50%;">
                <div class="col">
                    <div class="infocard shadow-sm bg-white">
                        <h1>General Settings</h1>
                        <hr>
                        @if ($setting)
                            <div class="row">
                                <div class="col-4">
                                    <div class="">
                                        <h5>Hotel Logo</h5>
                                        <img style="width:209px;height:65px;" alt="logo"
                                            src="{{ asset($setting->logo) }}" />
                                    </div>
                                    <div class="mt-5">
                                        <h5>Booking Engine Background</h5>
                                        <img style="width:209px;height:65px;" alt="logo"
                                            src="{{ asset($agency->bg) }}" />
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <div class="col">
                                            <label>Hotel Name</label></br>
                                            <span class="font-weight-bold">{{ $setting->name }}</span>
                                        </div>
                                        <div class="col">
                                            <label>Brand Name</label></br>
                                            <span class="font-weight-bold">{{ $setting->brand_name }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col">
                                            <label>Activity</label></br>
                                            <span class="font-weight-bold">{{ $setting->activity }}</span>
                                        </div>
                                        <div class="col">
                                            <label>Tax ID</label></br>
                                            <span class="font-weight-bold">{{ $setting->tax_id }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col">
                                            <label>Tax Office</label></br>
                                            <span class="font-weight-bold">{{ $setting->tax_office }}</span>
                                        </div>
                                        <div class="col">
                                            <label>General Commercial Register</label></br>
                                            <span
                                                class="font-weight-bold">{{ $setting->general_commercial_register }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col">
                                            <label>Address</label></br>
                                            <span class="font-weight-bold">{{ $setting->address }}</span>
                                        </div>
                                        <div class="col">
                                            <label>Postal Code</label></br>
                                            <span class="font-weight-bold">{{ $setting->postal_code }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col">
                                            <label>City</label></br>
                                            <span class="font-weight-bold">{{ $setting->city }}</span>
                                        </div>
                                        <div class="col">
                                            <label>Phone</label></br>
                                            <span class="font-weight-bold">{{ $setting->phone }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col">
                                            <label>Website</label></br>
                                            <span class="font-weight-bold">{{ $setting->website }}</span>
                                        </div>
                                        <div class="col">
                                            <label>Currency</label></br>
                                            <span class="font-weight-bold text-capitalize">{{ $setting->currency->name }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col">
                                            <label>Date</label></br>
                                            <span class="font-weight-bold">{{ $setting->date }}</span>
                                        </div>
                                        <div class="col">
                                            <label>Cashier Password</label></br>
                                            <span
                                                class="font-weight-bold">{{ str_repeat('*', strlen($setting->name)) }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col">
                                            <label>Complimentary Rate</label></br>
                                            <span class="font-weight-bold">{{ number_format($setting->complimentary_rate, 2) }}</span>
                                        </div>
                                        <div class="col">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <a href="#" data-toggle="modal" data-target="#editSettings"><i
                                            class="fas fa-edit fa-2x"></i></a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editSettings" style="border-radius:0px !important;" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
                    <h5 style="margin-left:42%;margin-right:30%;" class="modal-title text-dark" id="exampleModalLabel">
                        General Settings</h5>
                    <button type="submit" wire:click="saveSettings" class="float-right btn btn-outline-primary">Update
                    </button>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal" style=''>Close
                    </button>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;">
                    <div class="form-style-6">
                        <div class="row">
                            <div class="col">
                                <label>Hotel Logo</label></br>
                                @if (is_object($logo))
                                    <img src="{{ $logo->temporaryUrl() }}" alt="Hotel Logo"
                                        style="height:50px !important" class="img-thumbnail" width="190px">
                                @else
                                    <img src="{{ $setting->logo }}" alt="Hotel Logo" style="height:50px !important"
                                        class="img-thumbnail" width="190px">
                                @endif
                                <input type="file" wire:model="logo" accept="image/*">
                                @error('logo')
                                    <span class="invalid-input-data"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col">
                                <label>Booking Engine Background</label></br>
                                @if (is_object($bg))
                                    <img src="{{ $bg->temporaryUrl() }}" alt="Booking Engine bg"
                                        style="height:50px !important" class="img-thumbnail" width="190px">
                                @else
                                    <img src="{{ $setting->bg }}" alt="Booking Engine bg" style="height:50px !important"
                                        class="img-thumbnail" width="190px">
                                @endif
                                <input type="file" wire:model="bg" accept="image/*">
                                @error('bg')
                                    <span class="invalid-input-data"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col">
                                <label>Hotel Name</label>
                                <input type="text" wire:model="setting.name" placeholder="Enter Hotel Name" />
                                @error('setting.name')
                                    <span class="invalid-input-data"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col">
                                <label>Brand Name</label>
                                <input type="text" wire:model="setting.brand_name" placeholder="Enter Brand Name" />
                                @error('setting.brand_name')
                                    <span class="invalid-input-data"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <label>Activity</label>
                                <input type="text" wire:model="setting.activity" placeholder="Enter Activity" />
                                @error('setting.activity')
                                    <span class="invalid-input-data"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror

                            </div>
                            <div class="col">
                                <label>Tax ID</label>
                                <input type="text" wire:model="setting.tax_id" placeholder="Enter Tax ID" />
                                @error('setting.tax_id')
                                    <span class="invalid-input-data"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror

                            </div>
                            <div class="col">
                                <label>Tax Office</label>
                                <input type="text" wire:model="setting.tax_office" placeholder="Tax Office" />
                                @error('setting.tax_office')
                                    <span class="invalid-input-data"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror

                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <label>General Commercial Register</label>
                                <input type="text" wire:model="setting.general_commercial_register"
                                    placeholder="General Commercial Register" />
                                @error('setting.general_commercial_register')
                                    <span class="invalid-input-data"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror

                            </div>
                            <div class="col">
                                <label>Address</label>
                                <input type="text" wire:model="setting.address" placeholder="Address" />
                                @error('setting.address')
                                    <span class="invalid-input-data"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror

                            </div>
                            <div class="col">
                                <label>Postal Code</label>
                                <input type="text" wire:model="setting.postal_code" placeholder="Postal Code" />
                                @error('setting.postal_code')
                                    <span class="invalid-input-data"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror

                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <label>City</label>
                                <input type="text" wire:model="setting.city" placeholder="City" />
                                @error('setting.city')
                                    <span class="invalid-input-data"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror

                            </div>
                            <div class="col">
                                <label>Phone</label>
                                <input type="text" wire:model="setting.phone" placeholder="Phone" />
                                @error('setting.phone')
                                    <span class="invalid-input-data"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror

                            </div>
                            <div class="col">
                                <label>Website</label>
                                <input type="text" wire:model="setting.website" placeholder="Website" />
                                @error('setting.website')
                                    <span class="invalid-input-data"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror

                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <label>Currency</label>
                                <select class="form-control1 text-capitalize " wire:model="setting.currency_id">
                                    <option value="">Select Currency</option>
                                    @foreach ($currencies as $currency)
                                        <option class="text-capitalize" value="{{ $currency->id }}">{{ $currency->name }}</option>
                                    @endforeach
                                </select>
                                @error('setting.currency_id')
                                    <span class="invalid-input-data"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col">
                                <label>Date</label>
                                <input type="date" wire:model="setting.date" placeholder="Date" />
                                @error('setting.date')
                                    <span class="invalid-input-data"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col">
                                <label>Cashier Password</label>
                                <input type="password" wire:model="cashier_pass"
                                    placeholder="Enter Cashier Password if want to change" />
                                @error('cashier_pass')
                                    <span class="invalid-input-data"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <label>Complimentary Rate</label>
                                <input type="text" wire:model="setting.complimentary_rate"
                                    placeholder="Complimentary Rate" />
                                @error('setting.complimentary_rate')
                                    <span class="invalid-input-data"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col"></div>
                            <div class="col"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
