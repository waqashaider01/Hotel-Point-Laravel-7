<div>
    <div class="d-flex flex-column-fluid mt-5">
        <!--begin::Container-->
        <div class="container-fluid">

            <div class="row" id="btndiv1">
                <div class="col">
                    <div class="infocard shadow-sm bg-white" style="padding:1%;">
                        <div class="row">

                            <div class="col">
                                <div style="float:left;margin-top:2px;">
                                    <a type="button" class="infbtn " href="{{ route('rate-plans.index') }}"><i
                                            class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a>
                                </div>
                                <div>
                                @if($editing)
                                    <h1>Edit Rate Plan</h1>
                                @else
                                    <h1>Rate Plan</h1>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row  mt-5 ">
                <div class="col-md-8">
                    <div class="infocard shadow-sm bg-white">
                        <div class="form-style-6 pt-5" style="padding-left:2%;padding-right:2%;">
                            <h3 style="text-align:center;">Rate Plan PMS</h3>
                            <hr>
                            <h4>Basic Details</h4>
                            <hr>
                            <div class="row">
                                <div class="col-4 form-group">
                                    <label>Rate Plan Name</label>
                                    <input wire:model.lazy='rate_plan.name' type="text"
                                        placeholder="Enter rate plan name...">
                                    <x-custom-error field="rate_plan.name" />
                                </div>
                                <div class="col-4 form-group">
                                    <label>Room Type</label>
                                    <select wire:model="rate_plan.room_type_id" wire:change="roomTypeUpdated" required>
                                        <option value="">Choose Room Type</option>
                                        @foreach ($room_types as $room)
                                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-custom-error field="rate_plan.room_type_id" />
                                </div>
                                <div class="col-4 form-group">
                                    <label>Reference Code</label>
                                    <input wire:model.lazy="rate_plan.reference_code" type="text"
                                        placeholder="Enter reference code e.g. 1234">
                                    <x-custom-error field="rate_plan.reference_code" />
                                </div>
                                <div class="col-4 form-group">
                                    <label>Basic Pricing</label>
                                    <input wire:model.lazy='rate_plan.reservation_rate' type="number"
                                        placeholder="Enter the basic daily rate...">
                                    <x-custom-error field="rate_plan.reservation_rate" />
                                </div>
                            </div>
                            <h4>Meal</h4>
                            <hr>
                            <div class="row">
                                <div class="col-4 form-group">
                                    <label>Meal Category</label>
                                    <select wire:model="rate_plan.meal_category" wire:change="rateTypeCategoryUpdated" required>
                                        <option selected value="">Select Meal Category...</option>
                                        @foreach ($rate_type_categories as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-custom-error field="rate_plan.meal_category" />
                                </div>
                                <div class="col-4 form-group" id="mealdescriptionauto">
                                    <label>Description To Document <i class="fa fa-info-circle"
                                            data-original-title="How the rate type will be shown in the document regardless of its actual name."
                                            data-html="true" type="button" data-toggle="tooltip" data-placement="top"
                                            aria-hidden="true"></i></label>
                                    <input wire:model.lazy='rate_plan.description_to_document' type="text"
                                        placeholder="Document rate type actual name..">
                                    <x-custom-error field="rate_plan.description_to_document" />
                                </div>
                                <div class="col-4 form-group">

                                    <label>Derived Percentage/Amount <i class="fa fa-info-circle"
                                            data-original-title="Drived percentage/Amount" data-html="true" type="button"
                                            data-toggle="tooltip" data-placement="top" aria-hidden="true"></i></label>

                                    <div class="input-group">
                                        <input class="littlestyle" wire:model.lazy='rate_plan.rate_percentage'
                                            type="number">
                                        <div class="input-group-append"
                                            style="margin-top:0px;border-radius:0px !important;max-height:40px;">
                                            <span class="input-group-text">%</span>
                                        </div>
                                        <input class="littlestyle" type="number"
                                            wire:model.lazy='rate_plan.rate_amount'>
                                        <div class="input-group-append"
                                            style="margin-top:0px;border-radius:0px !important;max-height:40px;">
                                            <span class="input-group-text">{{ $hotel->currency->symbol }}</span>
                                        </div>
                                    </div>
                                    @if ($errors->has('rate_plan.rate_percentage') xor $errors->has('rate_plan.rate_amount'))
                                        <x-custom-error field="rate_plan.rate_percentage" />
                                        <x-custom-error field="rate_plan.rate_amount" />
                                    @else
                                        @if ($errors->has('rate_plan.rate_amount') || $errors->has('rate_plan.rate_percentage'))
                                            <div style="max-width: 100%; margin-top: .25rem; font-size: .875em; color: #dc3545;"
                                                role="alert"><strong>The Derived Percentage or Amount is
                                                    required.</strong></div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <h4>Payment Policy</h4>
                            <hr>
                            <div class="row">
                                <div class="col-4 form-group">
                                    <label>Prepayment <i class="fa fa-info-circle"
                                            data-original-title="How much will be charged as soon as the resevation is created."
                                            data-html="true" type="button" data-toggle="tooltip" data-placement="top"
                                            aria-hidden="true"></i> </label>
                                    <div class="input-group ">
                                        <input class="perstyle" wire:model.lazy='rate_plan.prepayment' type="number"
                                            placeholder='e.g. 50'>
                                        <div class="input-group-append"
                                            style="margin-top:0px;border-radius:0px !important;max-height:40px;">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                    <x-custom-error field="rate_plan.prepayment" />
                                </div>
                                <div class="col-4 form-group">
                                    <label>Reservation First Charge </label></br>
                                    <div class="input-group ">
                                        <input class="littlestyle" wire:model.lazy='rate_plan.charge'
                                            type="number" placeholder="e.g. 25">
                                        <div class="input-group-append"
                                            style="margin-top:0px;border-radius:0px !important;max-height:40px;">
                                            <span class="input-group-text">%</span>
                                        </div>
                                        <input class="littlestyle" wire:model.lazy='rate_plan.reservation_charge_days'
                                            type="number" placeholder="e.g. 4">
                                        <div class="input-group-append"
                                            data-original-title="How many days the first charge will take place." data-html="true"
                                            type="button" data-toggle="tooltip" data-placement="top"
                                            style="margin-top:0px;border-radius:0px !important;max-height:40px;">
                                            <span class="input-group-text">Days</span>
                                        </div>
                                    </div>
                                    <x-custom-error field="rate_plan.charge" />
                                    <x-custom-error field="rate_plan.reservation_charge_days" />
                                </div>
                                <div class="col-4 form-group">
                                    <label>Reservation Second Charge </label></br>
                                    <div class="input-group ">
                                        <input class="littlestyle"
                                            wire:model.lazy='rate_plan.charge2' type="number"
                                            placeholder="e.g. 25">
                                        <div class="input-group-append"
                                            style="margin-top:0px;border-radius:0px !important;max-height:40px;">
                                            <span class="input-group-text">%</span>
                                        </div>
                                        <input class="littlestyle" wire:model.lazy='rate_plan.reservation_charge_days_2'
                                            type="number" placeholder='e.g. 4'>
                                        <div class="input-group-append"
                                            data-original-title="How many days the second charge will take place." data-html="true"
                                            type="button" data-toggle="tooltip" data-placement="top"
                                            style="margin-top:0px;border-radius:0px !important;max-height:40px;">
                                            <span class="input-group-text">Days</span>
                                        </div>
                                    </div>
                                    <x-custom-error field="rate_plan.charge2" />
                                    <x-custom-error field="rate_plan.reservation_charge_days_2" />
                                </div>
                            </div>
                            <h4>Terms and Conditions</h4>
                            <hr>
                            <div class="row">
                                <div class="col-4 form-group">
                                    <label>Rate Type Cancellation Policy</label>
                                    <select wire:model="rate_plan.cancellation_policy_id" wire:change="cancellationPolicyUpdated">
                                        <option selected value="">Choose a value...</option>
                                        @foreach ($rate_type_policies as $value)
                                            <option value="{{ $value->id }}" data-type="{{ $value->type }}">
                                                {{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-custom-error field="rate_plan.cancellation_policy_id" />
                                </div>
                                <div class="col-4 form-group">
                                    <label>Cancellation Policy Amount <i id="cancellationtext"
                                            class="fa fa-info-circle"
                                            data-original-title="{{$rate_plan['cancellation_info']??''}}" data-html="true"
                                            type="button" data-toggle="tooltip" data-placement="top"
                                            aria-hidden="true"></i></label>
                                    <div class="input-group ">
                                        <input class="littlestyle" type="number"
                                            wire:model.lazy="rate_plan.cancellation_charge"
                                            placeholder="Enter Amount...">
                                        <div class="input-group-append"
                                            style="margin-top:0px;border-radius:0px !important;max-height:40px;">
                                            <span
                                                class="input-group-text">{{ $rate_plan['cancellation_amount_symbol']??'' }}</span>
                                        </div>
                                    </div>
                                    <x-custom-error field="rate_plan.cancellation_charge" />
                                </div>
                                <div class="col-4 form-group">
                                    <label>Cancellation Policy Charge Days <i class="fa fa-info-circle"
                                    data-original-title="How many days before arrival." data-html="true" type="button"
                                            data-toggle="tooltip" data-placement="top"
                                            aria-hidden="true"></i></label>
                                    <div class="input-group ">
                                        <input class="littlestyle" type="number"
                                            wire:model.lazy="rate_plan.cancellation_charge_days" placeholder="E.g. 8">
                                        <div class="input-group-append"
                                            style="margin-top:0px;border-radius:0px !important;max-height:40px;">
                                            <span class="input-group-text">Days</span>
                                        </div>
                                    </div>
                                    <x-custom-error field="rate_plan.cancellation_charge_days" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4 form-group">
                                    <label>Early Checkout Charge <i class="fa fa-info-circle"
                                    data-original-title="How much will be charged if the guest leaves earlier."
                                            data-html="true" type="button" data-toggle="tooltip"
                                            data-placement="top" aria-hidden="true"></i></label>
                                    <div class="input-group ">
                                        <input class="littlestyle" type="number"
                                            wire:model.lazy="rate_plan.early_checkout_charge_percentage"
                                            placeholder="E.g. 35">
                                        <div class="input-group-append"
                                            style="margin-top:0px;border-radius:0px !important;max-height:40px;">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                    <x-custom-error field="rate_plan.early_checkout_charge_percentage" />
                                </div>
                                <div class="col-4 form-group">
                                    <label>No Show Percentage</label>
                                    <div class="input-group ">
                                        <input class="littlestyle" type="number"
                                            wire:model.lazy="rate_plan.no_show_charge_percentage" placeholder="E.g. 25">
                                        <div class="input-group-append"
                                            style="margin-top:0px;border-radius:0px !important;max-height:40px;">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                    <x-custom-error field="rate_plan.no_show_charge_percentage" />
                                </div>
                                <div class="col-4 form-group"></div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="infocard shadow-sm bg-white">
                        <div class="form-style-6 pt-5" style="padding-left:5%;padding-right:5%;">
                            <h3 style="text-align:center;">Rate Channel Manager</h3>
                            <hr>
                            <h5 style="text-align: center; color: red;" id="channex_connect"></h5>
                            <div id="channel_manager_tab">
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label>Title</label>
                                        <input type="text" value="{{ $rate_plan['name']??'' }}" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label>Property</label>
                                        <input type="text" value="{{ $hotel->name??'' }}" readonly>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label>Room type</label>
                                        <input type="text" value="{{ $selected_room_type->name??'' }}"
                                            placeholder="Room Type" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <button class="ratebtn @if ($rate_plan['rate_type'] == 'manual') active @endif"
                                            type="button"
                                            wire:click="$set('rate_plan.rate_type', 'manual')">Manual</button>
                                    </div>
                                    <div class="col-6">
                                        <button class="ratebtn @if ($rate_plan['rate_type'] == 'derived') active @endif"
                                            type="button"
                                            wire:click="$set('rate_plan.rate_type', 'derived')">Derived</button>
                                    </div>
                                    <div class="col-12 pt-2">
                                        <x-custom-error field="rate_plan.rate_type" />
                                    </div>
                                </div>
                                @if ($rate_plan['rate_type'] == 'derived')
                                    <div>
                                        <hr>
                                        <h4>Derived Options</h4>
                                        <hr>
                                        <div class="row">
                                            <div class="col-12 form-group">
                                                <label>Parent Rate Plan</label>
                                                <select name="type" wire:model="rate_plan.parent_rate_plan_id">
                                                    <option selected>Choose an option</option>
                                                    @foreach ($rate_types->where('room_type_id', $rate_plan['room_type_id']) as $rate)
                                                        <option value="{{ $rate->id }}">{{ $rate->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <x-custom-error field="rate_plan.parent_rate_plan_id" />
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <hr>
                                <h4>Price Settings</h4>
                                <hr>
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label>Currency</label>
                                        <input type="text" placeholder="Your hotel currency"
                                            value="{{ $hotel->currency->initials }}" readonly>
                                    </div>
                                </div>
                                <hr>
                                <h4>Sell Mode</h4>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <button type="button"
                                            class="ratebtn @if ($rate_plan['sell_mode'] == 'per_room') active @endif"
                                            id="cper_room" data-html="true" type="button" data-toggle="tooltip"
                                            data-placement="top" wire:click="$set('rate_plan.sell_mode', 'per_room')"
                                            data-original-title="Per Room Rate Plan mean price is equal to any count of allowed guests. Price for 1 Guest will be same with price for 2 Guests.">Per
                                            Room</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="button"
                                            class="ratebtn @if ($rate_plan['sell_mode'] == 'per_person') active @endif"
                                            id="cper_person" data-html="true" type="button" data-toggle="tooltip"
                                            data-placement="top"
                                            wire:click="$set('rate_plan.sell_mode', 'per_person')"
                                            data-original-title="Per Person Rate Plan used to create Rate Plans where price is calculated based at Guests count.">Per
                                            Person</button>
                                    </div>
                                    <div class="col-12">
                                        <x-custom-error field="rate_plan.sell_mode" />
                                    </div>
                                </div>
                                @if ($rate_plan['sell_mode'] == 'per_person')
                                    @if ($rate_plan['rate_type'] == 'manual')
                                        <div class="row mt-5" id="manual_sel_mode_div">
                                            <div class="col-4">
                                                <button type="button"
                                                    class="ratebtn perperson-ratemode sellmodebtn @if ($rate_plan['rate_mode'] == 'manual') active @endif"
                                                    value="manual" data-html="true" type="button"
                                                    data-toggle="tooltip" data-placement="top"
                                                    wire:click="$set('rate_plan.rate_mode', 'manual')"
                                                    data-original-title="Price is specified at options.rate field">Manual</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button"
                                                    class="ratebtn perperson-ratemode sellmodebtn @if ($rate_plan['rate_mode'] == 'derived') active @endif"
                                                    value="derived" data-html="true" type="button"
                                                    data-toggle="tooltip" data-placement="top"
                                                    wire:click="$set('rate_plan.rate_mode', 'derived')"
                                                    data-original-title="Price derived from parent_rate_plan for primary occupancy option">Derived</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button"
                                                    class="ratebtn perperson-ratemode sellmodebtn @if ($rate_plan['rate_mode'] == 'auto') active @endif"
                                                    value="auto" data-html="true" type="button"
                                                    data-toggle="tooltip" data-placement="top"
                                                    wire:click="$set('rate_plan.rate_mode', 'auto')"
                                                    data-original-title="Price calculated automatically based at price for primary occupancy option and auto_rate_settings">Auto</button>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($rate_plan['rate_type'] == 'derived')
                                        <div class="row mt-5">
                                            <div class="col-4">
                                                <button type="button"
                                                    class="ratebtn perperson-ratemode sellmodebtn @if ($rate_plan['rate_mode'] == 'auto') active @endif"
                                                    value="auto" data-html="true" type="button"
                                                    data-toggle="tooltip" data-placement="top"
                                                    wire:click="$set('rate_plan.rate_mode', 'auto')"
                                                    data-original-title="Price calculated automatically based at price for primary occupancy option and auto_rate_settings">Auto</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button"
                                                    class="ratebtn perperson-ratemode sellmodebtn @if ($rate_plan['rate_mode'] == 'derived') active @endif"
                                                    value="derived" data-html="true" type="button"
                                                    data-toggle="tooltip" data-placement="top"
                                                    wire:click="$set('rate_plan.rate_mode', 'derived')"
                                                    data-original-title="Price derived from parent_rate_plan for primary occupancy option">Derived</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button"
                                                    class="ratebtn perperson-ratemode sellmodebtn @if ($rate_plan['rate_mode'] == 'cascade') active @endif"
                                                    value="cascade" data-html="true" type="button"
                                                    data-toggle="tooltip" data-placement="top"
                                                    wire:click="$set('rate_plan.rate_mode', 'cascade')"
                                                    data-original-title="Price derived from parent_rate_plan for each occupancy option">Cascade</button>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row py-2">
                                        <x-custom-error field="rate_plan.rate_mode" />
                                    </div>
                                    @if ($rate_plan['sell_mode'] == 'per_person')
                                        @if (in_array($rate_plan['rate_mode'], ['derived', 'auto']))
                                            <div class="row mt-3">
                                                <div class="col">
                                                    <label>Primary Occupancy <i class="fa fa-info-circle"
                                                            data-original-title="Max occupancy is equal to room type max adults."
                                                            data-html="true" type="button" data-toggle="tooltip"
                                                            data-placement="top" aria-hidden="true"></i></label>
                                                    <select wire:model="rate_plan.primary_occupancy">
                                                        @for ($i = 1; $i <= $max_occupancy; $i++)
                                                            <option value="{{ $i }}">{{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                    <x-custom-error field="rate_plan.primary_occupancy" />
                                                </div>
                                            </div>
                                        @endif

                                        @if ($rate_plan['rate_mode'] == 'derived')
                                            @for ($i = 1; $i <= $max_occupancy; $i++)
                                                <div>
                                                    <div class="row mt-5">
                                                        <div class="col"><label>Rate Logic for {{ $i }}
                                                                person</label>
                                                        </div>
                                                        @if ($i == $rate_plan['primary_occupancy'])
                                                            <div class="col primarydiv"><label
                                                                    style="color: red !important;">Primary
                                                                    Occupancy</label></div>
                                                        @else
                                                            <div class="col otherselect">
                                                                <select
                                                                    wire:model="rate_plan.occupancy_logic.{{ $i }}.modifier"
                                                                    style="width: 100% !important; min-width: 100% !important; max-width: 100% !important; ">
                                                                    <option value="">Choose...</option>
                                                                    <option value="increase_by_amount">
                                                                        Increase By Amount
                                                                    </option>
                                                                    <option value="decrease_by_amount">
                                                                        Decrease By Amount
                                                                    </option>
                                                                    <option value="increase_by_percent">
                                                                        Increase By Percent
                                                                    </option>
                                                                    <option value="decrease_by_percent">
                                                                        Decrease By Percent
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="col otherinput"><input type="number"
                                                                    wire:model="rate_plan.occupancy_logic.{{ $i }}.value"
                                                                    placeholder="Enter Value"
                                                                    style="width: 100% !important; min-width: 100% !important; max-width: 100% !important; ">
                                                            </div>
                                                            <div class="col-12 py-2 text-right">
                                                                <x-custom-error field="rate_plan.occupancy_logic" />
                                                                <x-custom-error field="rate_plan.occupancy_logic.*" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endfor
                                        @endif
                                        {{-- <div id="autoratesDiv">
                                        <div class="row mt-5">
                                            <div class="col">

                                                <label>Increase Value</label>
                                            </div>
                                            <div class="col">
                                                <select id="autoselectType1"
                                                    style="width: 100% !important; min-width: 100% !important; max-width: 100% !important; ">
                                                    <option selected disabled>Choose Type</option>
                                                    <option value="increase_by_amount">Increase By Amount</option>
                                                    <option value="increase_by_percent">Increase By Percent</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <input type="number" id="autoselectValue1" placeholder="Enter value"
                                                    style="width: 100% !important; min-width: 100% !important; max-width: 100% !important; ">
                                            </div>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col">

                                                <label>Decrease Value</label>
                                            </div>
                                            <div class="col">
                                                <select id="autoselectType2"
                                                    style="width: 100% !important; min-width: 100% !important; max-width: 100% !important; ">
                                                    <option selected disabled>Choose Type</option>
                                                    <option value="decrease_by_amount">Decrease By Amount</option>
                                                    <option value="decrease_by_percent">Decrease By Percent</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <input type="number" id="autoselectValue2" placeholder="Enter value"
                                                    style="width: 100% !important; min-width: 100% !important; max-width: 100% !important; ">
                                            </div>
                                        </div>
                                    </div> --}}
                                        @if ($rate_plan['rate_mode'] == 'cascade')
                                            <div class="row mt-5">
                                                <div class="col">
                                                    <label>Rate Logic</label>
                                                </div>
                                                <div class="col">
                                                    <select wire:model="rate_plan.cascade_select_type"
                                                        style="width: 100% !important; min-width: 100% !important; max-width: 100% !important; ">
                                                        <option selected value="">Choose Type</option>
                                                        <option value="increase_by_amount">Increase By Amount</option>
                                                        <option value="increase_by_percent">Increase By Percent
                                                        </option>
                                                        <option value="decrease_by_amount">Decrease By Amount</option>
                                                        <option value="decrease_by_percent">Decrease By Percent
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <input type="number" wire:model.lazy="rate_plan.cascade_select_value"
                                                        placeholder="Enter value"
                                                        style="width: 100% !important; min-width: 100% !important; max-width: 100% !important; ">
                                                </div>
                                                <div class="col-12 py-2 text-right">
                                                    <x-custom-error field="rate_plan.cascade_select_type" />
                                                    <x-custom-error field="rate_plan.cascade_select_value" />
                                                </div>
                                            </div>
                                        @endif

                                        <div class="row mt-5">
                                            <div class="col form-group">
                                                <label>Children Fee</label>
                                                <div class="input-group ">
                                                    <input type="number" placeholder="E.g. 55"
                                                        wire:model.lazy="rate_plan.children_fee"
                                                        style="width: 90% !important;min-width: 90% !important; max-width: 90% !important;">
                                                    <div class="input-group-append"
                                                        style="margin-top:0px;border-radius:0px !important;max-height:40px;">
                                                        <span
                                                            class="input-group-text">{{ $hotel->currency->symbol }}</span>
                                                    </div>
                                                </div>
                                                <x-custom-error field="rate_plan.children_fee" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col form-group">
                                                <label>Infant Fee</label>
                                                <div class="input-group ">
                                                    <input type="number" placeholder="E.g. 55"
                                                        wire:model.lazy="rate_plan.infant_fee"
                                                        style="width: 90% !important;min-width: 90% !important; max-width: 90% !important;">
                                                    <div class="input-group-append"
                                                        style="margin-top:0px;border-radius:0px !important;max-height:40px;">
                                                        <span
                                                            class="input-group-text">{{ $hotel->currency->symbol }}</span>
                                                    </div>
                                                </div>
                                                <x-custom-error field="rate_plan.infant_fee" />
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <!--end form-->
                    </div>
                </div>
                <!--end channel manager div-->
            </div>

            <div class="row mt-8 mb-15 btndiv" id="btndiv">
                <div class="col">
                    <div class="infocard shadow-sm bg-white" style="padding:2%;">
                        <div class="row">

                            <div class="col">

                                <div style="float:right;">
                                    <button type="button" class="infbtn" wire:click="submitRatePlan"
                                        style='background-color:white;color:#43D1AF;'>Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
