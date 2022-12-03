<div class="row mb-10">
    <div class="col">
        <div class="extrachargecard">
            <div class="headerstyle">
                <div class="row">
                    <div class="col">
                        <input class="extra_charge_input  float-left"
                               value="#{{$reservation->id}}: {{$guest->full_name}}" type="text">
                    </div>
                    <div class="col">
                        <div style="float:right;">
                            <select class="extra_charge_input" wire:model="category">
                                <option selected="">Choose category..</option>
                                @foreach($categories as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div style="float:right;margin-right:5px;">
                            <select class="extra_charge_input" wire:model="type">
                                <option selected="">Choose type..</option>
                                @foreach($types as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="chosen_services">
                <div class="services_chosen"><h5 style="text-align:center;">Your Selected Services</h5>
                    @foreach($selected_services as $service)
                        <div wire:key="{{$service['id']}}">
                            <hr style="border:1px dashed #B8BBBE;">
                            <div class="row servicechoosed">
                                <div class="col-4">
                                    <h5>{{$service['name']}}</h5>
                                </div>
                                <div class="col-2">
                                    <div class="serviceinput1">{{showPriceWithCurrency($service['price'])}}</div>
                                </div>
                                <div class="col-2">
                                    <div class="serviceinput1"
                                         id="ts1">{{showPriceWithCurrency($service['price'] * $service['count'])}}</div>
                                </div>
                                <div class="col-3">
                                    <div class="input-group w-auto justify-content-end align-items-center">
                                        <input type="button" value="-"
                                               class="button-minus border rounded-circle  icon-shape icon-sm mx-1"
                                               wire:click="removeItem({{$service['id']}})">
                                        <input type="number" step="1" max="10" value="1"
                                               wire:model="selected_services.{{$service['id']}}.count"
                                               class="quantity-field border-0 text-center w-25">
                                        <input type="button" value="+"
                                               class="button-plus border rounded-circle icon-shape icon-sm "
                                               wire:click="addItem({{$service['id']}})">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="invoice_div">
                <div class="row">
                    <div class="col-8">
                        <input class="extra_charge_input" type="text" placeholder="Enter Invoice Number"
                               wire:model.defer="invoice_number">
                        <x-error field="invoice_number"></x-error>
                    </div>
                    <div class="col">
                        <div class="extra_charge_input spandiv">Balance: {{showPriceWithCurrency($balance)}}</div>
                    </div>
                </div>
            </div>
            <div class="total_div">
                <div class="row">
                    <div class="col">
                        <h5>Total Before Discount</h5>
                    </div>
                    <div class="col text-right">
                        <h5 id="tbd" value="this is its value">{{showPriceWithCurrency($total)}}</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h5>Discount</h5>
                    </div>
                    <div class="col text-right">
                        <h5 id="td">{{showPriceWithCurrency($calculated_discount)}}</h5>
                    </div>
                </div>
                <hr style="border:1px dashed #B8BBBE;">
                <div class="row">
                    <div class="col">
                        <h5>Total after Discount</h5>
                    </div>
                    <div class="col text-right">
                        <h5 id="tad">{{showPriceWithCurrency($grand_total)}}</h5>
                    </div>
                </div>
            </div>
            <div class="buttons_div">
                <div style="float:left;">
                    <a class="service_buttons" href="{{url()->previous()}}"
                       style="background-color:#757575;">Back</a>
                </div>
                <div style="float:right;">
                    <span class="service_buttons" data-toggle="modal" data-target="#addDiscount"
                          style="background-color:#757575; cursor: pointer">Transport</span>
                    <span class="service_buttons" data-toggle="modal" data-target="#addDiscount"
                          style="background-color:#757575; cursor: pointer">Discount</span>
                    <span class="service_buttons" wire:click="setPayment"
                          style="background-color:#1BC5BD; cursor: pointer">Pay</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="extrachargecard">
            <div class="headerstyle">
                <div class="row">
                    <div class="col">
                        <div class="headingserv">
                            <h5>{{$type_name ?? 'Type Name'}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="servicesasbtns">
                <div class="row" id="btnsall">
                    @foreach($services as $service)
                        <div class="service_btn" type="button" style="background-color:#FEE1BB;">
                            <span wire:click="addService({{$service->id}})">{{$service->product}}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    {{--    modal --}}
    <div class="modal fade" id="addDiscount" style="border-radius: 0px !important;"
         tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" wire:ignore.self>
        <div class="modal-dialog  modal-dialog-scrollable"
             style="max-width:600px !important;min-width:600px !important;">
            <div class="modal-content rounded-7">
                <div class="modal-header shadow-sm"
                     style="border-radius:0px !important;z-index:10;background-color:#D5D8DC;">
                    <h5 style="text-align:center;margin-left:40%;" class="modal-title text-dark text-center">Add
                        Discount</h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#F5F4F4;">
                    <div class="form-style-61">
                        <div style="text-align:center;">
                            <label>Add Discount Percentage</label>
                            <input class="service-input" min="0" max="100" style="min-width:200px;" type="number"
                                   placeholder="Enter Discount in %" wire:model.defer="discount">
                            <x-error field="discount"></x-error>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color:#EFF5F5;">
                    <div class="" style="background-color:#EFF5F5;float:right;">
                        <span class="servicebuttons" type="button" wire:click="addDiscount"
                              style="background-color:#0EA105;">Add</span>
                        <span class="servicebuttons" type="button" id="" data-dismiss="modal"
                              style="background-color:#757575;">Close</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="payServices" style="border-radius:0px !important;" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable"
             style="max-width:600px !important;min-width:600px !important;">
            <div class="modal-content rounded-7">
                <div class="modal-header shadow-sm "
                     style="border-radius:0px !important;z-index:10;background-color:#D5D8DC;">
                    <h5 style="text-align:center;margin-left:45%;" class="modal-title text-dark text-center"
                        id="adrmodaltitle">Payment</h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#F5F4F4;">
                    <div class="form-style-61" id="">
                        <div style="text-align:center;" class="row mb-10">
                            <div class="col">
                                <span class="servicebuttons" type="button" wire:click="makePayment('cash')"
                                      style="background-color:#1BC5BD;min-width:150px;margin-bottom:3px;">Cash</span></br>
                            </div>
                            <div class="col">
                                <select class="servicebuttons" type="button" wire:model="card_payment"
                                        style="border:none;background-color:#1BC5BD;min-width:150px;">
                                    <option style="background-color:#fff;color:black;" value="" selected>Credit Card
                                    </option>
                                    @foreach($methods as $method)
                                        <option value="{{$method->id}}" style="background-color:#fff;color:black;">{{$method->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <span class="servicebuttons" type="button" wire:click="makePayment('room_charge')"
                                      style="background-color:#1BC5BD;min-width:150px;margin-bottom:3px;">Room Charge
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color:#EFF5F5;">
                    <div class="" style="background-color:#EFF5F5;float:right;">
                        <span class="servicebuttons" type="button" data-dismiss="modal"
                              style="background-color:#757575;">Close</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function () {
            Livewire.on('showPaymentModal', function () {
                $('#payServices').modal('show');
            })
        })
    </script>
@endpush

