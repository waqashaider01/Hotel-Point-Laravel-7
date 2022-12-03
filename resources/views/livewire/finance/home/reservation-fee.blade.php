<div class="infocard bg-white shadow-sm" x-data="{ showExtras: false }">
    <div class="row mt-4">
        <div class="col">
            {!! $mynoshow !!}
            @if($isFullNoShow!=1) {!! $myaccomDoc !!} @endif
            {!! $mycancellationFeesAccomDoc !!}
            {!! $mynote !!}
        </div>
    </div>
    <div class="row mt-7">
        <div class="col">
            <div class="row darker">
                <div class="col">
                    Accommodation Total
                </div>
                <div class="col">
                    Paid
                </div>
                <div class="col">
                    Accommodation Balance
                </div>
                <div class="col">
                    Action
                </div>
            </div>
            <div class="row lighter">
                <div class="col">
                    {{ showPriceWithCurrency($values['accom_total']) }}
                </div>
                <div class="col">
                    {{ showPriceWithCurrency($values['accom_paid']) }}
                </div>
                <div class="col">
                    {{ showPriceWithCurrency($values['accom_charge']) }}
                </div>
                <div class="col">
                    @if ($isFullNoShow!=1 && $accommodation_payable)
                        <span type='button' data-toggle="modal" data-target="#accommodationPaymentModal" class='payment-button' wire:click="setAccomPayment">
                            <i class='fa fa-credit-card' aria-hidden='true'></i> Payment
                        </span>
                    @endif
                    @if ($isFullNoShow==1 || $accommodation_printable)
                        <span type='button' data-toggle="modal" data-target="#accomSelect" wire:click="getAccomSelect" class='payment-button'>
                            <i class='fa fa-book' aria-hidden='true'></i> Document
                        </span>
                    @else
                        <span type='button' style="background-color: rgb(255, 0, 0); color:white;" class='payment-button'>
                            <i class='fa fa-book' style="color:white;" aria-hidden='true'></i> Document
                        </span>
                    @endif
                    @if ($isFullNoShow!=1 && $values['accom_total'] < $values['accom_paid'])
                        <span type='button' class='payment-button' data-toggle="modal" data-target="#accommodationRefundPaymentModal" wire:click="refundBtnClick">
                            <i class='fa fa-credit-card' aria-hidden='true'></i> Refund ({{ showPriceWithCurrency($values['accom_charge'] * -1) }})
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-7">
        <div class="col">
            <div class="row darker">
                <div class="col">
                    Services Total
                </div>
                <div class="col">
                    Paid
                </div>
                <div class="col">
                    Services Balance
                </div>
                <div class="col">
                    Services
                </div>
            </div>
            <div class="row lighter">
                <div class="col">
                    {{ showPriceWithCurrency($values['extras_total']) }}
                </div>
                <div class="col">
                    {{ showPriceWithCurrency($values['extras_paid']) }}
                </div>
                <div class="col">
                    {{ showPriceWithCurrency($values['extras_charge']) }}
                </div>
                <div class="col">
                    <span @click="showExtras = !showExtras" type='button' class='payment-button' id=''>
                        <i class='fa fa-eye' aria-hidden='true'></i> Show
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-7 mr-5 ml-5" x-show="showExtras">
        <div class="col">
            <div class="row darker" style="font-size:12px !important;">
                <div class="col">
                    Date
                </div>
                <div class="col">
                    Receipt No
                </div>
                <div class="col">
                    Amount
                </div>
                <div class="col">
                    Payment Method
                </div>
            </div>
            @foreach ($extrasDetails as $receipt => $detail)
                <div class="row lighter" style="font-size:12px !important;" wire:key="{{ $receipt }}">
                    <div class="col">
                        {{ $detail->first()->date }}
                    </div>
                    <div class="col">
                        {{ $receipt }}
                    </div>
                    <div class="col">
                        {{ $detail->sum('extra_charge_total') - $detail->sum('extra_charge_discount') }}
                    </div>
                    <div class="col">
                        @if ($detail->first()->is_paid == 0)
                            <span type='button' class='payment-button' wire:click="setServicePayment('{{ $receipt }}')" data-toggle="modal" data-target="#servicePaymentModal">Pay</span>
                        @else
                            {{ $detail->first()->payment_method->name }}
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="row mt-7">
        <div class="col">
            {!! $myovernightDoc !!}
            {!! $myaccomDocText !!}
        </div>
    </div>
    <div class="row mt-7">
        <div class="col">
            <div class="row darker">
                <div class="col">
                    Overnight Tax Total
                </div>
                <div class="col">
                    Paid
                </div>
                <div class="col">
                    Overnight Tax Balance
                </div>
                <div class="col">
                    Action
                </div>
            </div>
            <div class="row lighter">
                <div class="col">
                    {{ showPriceWithCurrency($values['overnight_total']) }}
                </div>
                <div class="col">
                    {{ showPriceWithCurrency($values['overnight_paid']) }}
                </div>
                <div class="col">
                    {{ showPriceWithCurrency($values['overnight_charge']) }}
                </div>
                <div class="col">
                    @if ($overnight_payable)
                        <span type='button' class='payment-button' data-toggle="modal" wire:click="setOvernightPayment" data-target="#overnightPaymentModal">
                            <i class='fa fa-credit-card' aria-hidden='true'></i>Payment</span>
                    @endif
                    @if ($overnight_printable && $overnightDoc == 0)
                        @if ($accomDoc == 0 || $cancellationFeesAccomDoc == 0)
                            <span type='button' style="background: #9da0b0;opacity: 0.8;" disabled class='payment-button' title="Accommodation Document not printed">
                                <i class='fa fa-book' aria-hidden='true'></i> Document
                            </span>
                        @else
                            <span type='button' data-toggle="modal" wire:click="setActive('overnight')" data-target="#overnightDocumentModal" class='payment-button'>
                                <i class='fa fa-book' aria-hidden='true'></i> Document
                            </span>
                        @endif
                    @endif
                    @if ($overnight_printable && $overnightDoc == 1)
                        <span type='button' style="background: #9da0b0;opacity: 0.8;" disabled class='payment-button' title="No access to print the Document">
                            <i class='fa fa-book' aria-hidden='true'></i> Document
                        </span>
                    @endif
                    @if ($values['overnight_total'] < $values['overnight_paid'])
                        <span type='button' class='payment-button' data-toggle="modal" data-target="#overnightRefundPaymentModal" wire:click="refundBtnClick('overnight')">
                            <i class='fa fa-credit-card' aria-hidden='true'></i> Refund ({{ showPriceWithCurrency($values['overnight_charge'] * -1) }})
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="mt-5" style="float:right;display: flex;align-items: center;gap: 1.5rem;">
                @if($isFullNoShow==1 && $cancellationFeesAccomDoc==1)
                <i class="fa fa-2x fa-check-circle" type="button" data-html="true" type="button" data-toggle="tooltip" data-placement="top" title=" All necessary actions are completed. You can procceed to Check out."
                       style="color:green;" aria-hidden="true"></i>
                    <a href='/checkout-reservation/{{ $reservation->id }}' type='button' style='background-color:white;color:green;' class='infbtn font-weight-bolder'>Checkout</a>
                @elseif (($accomDoc == 0 || $cancellationFeesAccomDoc == 0 || $overnightDoc == 0) && ($values['overnight_charge'] != 0 || $values['accom_charge'] != 0 || $values['extras_charge'] != 0))
                    <i class="fa fa-2x fa-bell" type="button" data-html="true" type="button" data-toggle="tooltip" data-placement="top"
                       title="Not all of the required documents are printed, and Guest Balance is not 0. Check out can not be completed." style="color:red;" aria-hidden="true"></i>
                    <button type='button' style='background-color:white;color:#ABB2B9;' class='infbtn disabled font-weight-bolder'>Checkout</button>
                @elseif (($accomDoc == 0 || $cancellationFeesAccomDoc == 0 || $overnightDoc == 0) && ($values['overnight_charge'] == 0 && $values['accom_charge'] == 0 && $values['extras_charge'] == 0))
                    <i class="fa fa-2x fa-bell" type="button" data-html="true" type="button" data-toggle="tooltip" data-placement="top" title="Not all of the required documents are printed. Check out can not be completed."
                       style="color:red;" aria-hidden="true"></i>
                    <button type='button' style='background-color:white;color:#ABB2B9;' class='infbtn disabled font-weight-bolder'>Checkout</button>
                @elseif (($accomDoc == 1 || $cancellationFeesAccomDoc == 1 || $overnightDoc == 1) && ($values['overnight_charge'] != 0 && $values['accom_charge'] != 0 && $values['extras_charge'] != 0))
                    <i class="fa fa-2x fa-bell" type="button" data-html="true" type="button" data-toggle="tooltip" data-placement="top" title="Guest Balance is not 0. Check out can not be completed." style="color:red;"
                       aria-hidden="true"></i>
                    <button type='button' style='background-color:white;color:#ABB2B9;' class='infbtn disabled font-weight-bolder'>Checkout</button>
                @elseif($values['overnight_charge'] != 0 || $values['accom_charge'] != 0 || $values['extras_charge'] != 0)
                    <i class="fa fa-2x fa-bell" type="button" data-html="true" type="button" data-toggle="tooltip" data-placement="top" title="Guest Balance is not 0. Check out can not be completed." style="color:red;"
                       aria-hidden="true"></i>
                    <button type='button' style='background-color:white;color:#ABB2B9;' class='infbtn disabled font-weight-bolder'>Checkout</button>
                @else
                    <i class="fa fa-2x fa-check-circle" type="button" data-html="true" type="button" data-toggle="tooltip" data-placement="top" title=" All necessary actions are completed. You can procceed to Check out."
                       style="color:green;" aria-hidden="true"></i>
                    <a href='/checkout-reservation/{{ $reservation->id }}' type='button' style='background-color:white;color:green;' class='infbtn font-weight-bolder'>Checkout</a>
                @endif
            </div>
        </div>
    </div>
    {{-- Modals --}}
    <div class="modal fade" id="accomSelect" style="border-radius:0px !important;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm" style="border-radius:0px !important;z-index:10;">
                    <h5 style="text-align:center;margin-left:25%;" class="modal-title text-dark text-center" id="exampleModalLabel">Accommodation Document</h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;">
                    <div class="form-style-61" id="">
                        <ul class="navi flex-column navi-hover py-2">
                            <li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">
                                Choose an option:
                            </li>
                            @foreach ($accom_options as $option)
                                <li class='navi-item'>
                                    @if (isset($option['disabled']) && $option['disabled'])
                                        <a type="button" class='navi-link'>
                                            <span class='navi-icon'>
                                                <i class='fa fa-file-alt'></i>
                                            </span>
                                            <span class='navi-text' style='color:{{ isset($option['color']) ? $option['color'] : 'gray' }}; '>{{ $option['name'] }}</span>
                                        </a>
                                    @else
                                        <a type="button" data-toggle="modal" data-target="#accommodationDocumentModal" class='navi-link' wire:click="setSelectedType({{ $option['type'] }},'{{ $option['document'] }}')">
                                            <span class='navi-icon'>
                                                <i class='fa fa-file-alt'></i>
                                            </span>
                                            <span class='navi-text' style='color:{{ isset($option['color']) ? $option['color'] : 'green' }}; '>{{ $option['name'] }}</span>
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="modal-footer" style="background-color:#fff;">
                    <span type="button" class="payment-button" style="color:red;" data-dismiss="modal">Close</span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="accommodationPaymentModal" style="border-radius:0px !important;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm" style="border-radius:0px !important;z-index:10;">
                    <h5 style="text-align:center;margin-left:26%;" class="modal-title text-dark text-center" id="exampleModalLabel">Accommodation Payments</h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;">
                    <div class="form-style-6">
                        <x-error field="status"></x-error>
                        <div class="row mr-1">
                            <div class="col">
                                <label class="">Value</label>
                                <input class="smstyle" wire:model.defer="accom_value" type="text" />
                                <x-error field="value"></x-error>
                            </div>
                            <div class="col">
                                <label for="" class="">Payment Date</label>
                                <input class="smstyle" wire:model.defer="accom_payment_date" type="date" min="{{ today()->toDateString() }}" value="{{ today()->toDateString() }}" />
                                <x-error field="payment_date"></x-error>
                            </div>
                        </div>
                        <div class="row mr-1" id="payment-method-field">
                            <div class="col">
                                <label for="" class="">Payment Method<span class="text-danger">*</span></label>
                                <select class="smstyle" wire:model.defer="accom_payment_method">
                                    <option value="">Select Payment Method</option>
                                    @foreach ($methods as $method)
                                        <option value='{{ $method->id }}'>{{ $method->name }}</option>
                                    @endforeach
                                </select>
                                <x-error field="payment_method_id"></x-error>
                            </div>
                            <div class="col">
                                <label for="" class="">Is This Payment a Deposit ?<span class="text-danger">*</span></label>
                                <select class="smstyle" wire:model.defer="accom_is_deposit">
                                    @if ($reservation->actual_checkin > today() || is_null($reservation->actual_checkin))
                                        <option value=1>Yes</option>
                                    @elseif($reservation->actual_checkin <= today())
                                        <option value=0>No</option>
                                    @endif
                                </select>
                                <x-error field="deposit"></x-error>
                            </div>
                        </div>
                        <div class="row" style="">
                            <div class="col">
                                <label for="">Transaction ID<span class="text-danger">*</span></label>
                                <input class="" wire:model.defer="accom_comment" type="number">
                                <x-error field="payment_comments"></x-error>
                            </div>
                        </div>
                        <input name="reservationId" type="hidden" value="{{ $reservation->id }}">
                    </div>
                    <div class="modal-footer" style="background-color:#fff;">
                        <button type="submit" class="payment-button float-right" wire:click="saveAccommodationPayment" style="color:green;background-color:white;">
                            Insert
                        </button>
                        <span type="button" class="payment-button" style="color:red;" data-dismiss="modal" style=''>Close</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="accommodationRefundPaymentModal" style="border-radius:0px !important;" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm" style="border-radius:0px !important;z-index:10;">
                    <h5 style="text-align:center;" class="modal-title text-dark w-100 text-center" id="exampleModalLabel2">Accommodation Payment Refund</h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;">
                    <div class="form-style-6">
                        <x-error field="status"></x-error>
                        <div class="row mr-1">
                            <div class="col">
                                <label class="">Value</label>
                                <input class="smstyle" wire:model.defer="accom_refund_value" type="number" />
                                <x-error field="accom_refund_value"></x-error>
                            </div>
                            <div class="col">
                                <label for="" class="">Refund Date</label>
                                <input class="smstyle" wire:model.defer="accom_payment_date" type="date" min="{{ today()->toDateString() }}" />
                                <x-error field="accom_payment_date"></x-error>
                            </div>
                        </div>
                        <div class="row mr-1" id="payment-method-field">
                            <div class="col">
                                <label for="" class="">Payment Method<span class="text-danger">*</span></label>
                                <select class="smstyle" wire:model.defer="accom_payment_method">
                                    <option value="">Select Payment Method</option>
                                    @foreach ($methods as $method)
                                        <option value='{{ $method->id }}'>{{ $method->name }}</option>
                                    @endforeach
                                </select>
                                <x-error field="payment_method_id"></x-error>
                            </div>
                        </div>
                        <div class="row" style="">
                            <div class="col">
                                <label for="">Transaction ID<span class="text-danger">*</span></label>
                                <input class="smstyle" wire:model.defer="accom_comment" >
                                <x-error field="payment_comments"></x-error>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer" style="background-color:#fff;">
                        <button type="submit" class="payment-button float-right" wire:click="refundAccomPayment" style="color:green;background-color:white;">
                            Refund
                        </button>
                        <span type="button" class="payment-button" style="color:red;" data-dismiss="modal" style=''>Close</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="servicePaymentModal" style="border-radius:0px !important;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm" style="border-radius:0px !important;z-index:10;">
                    <h5 style="text-align:center;margin-left:26%;" class="modal-title text-dark text-center" id="exampleModalLabel">Services Payments</h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;">
                    <div class="form-style-6">
                        <x-error field="status"></x-error>
                        <div class="row mr-1">
                            <div class="col">
                                <label class="">Value</label>
                                <input class="smstyle" wire:model="service_value" type="text" />
                                <x-error field="value"></x-error>
                            </div>
                            <div class="col">
                                <label for="" class="">Payment Date</label>
                                <input class="smstyle" wire:model.defer="service_payment_date" type="date" min="{{ today()->toDateString() }}" />
                                <x-error field="payment_date"></x-error>
                            </div>
                        </div>
                        <div class="row mr-1">
                            <div class="col">
                                <label for="" class="">Receipt No.</label>
                                <input class="smstyle" wire:model="service_receipt_number" type="text" />
                                <x-error field="deposit"></x-error>
                            </div>
                            <div class="col">
                                <label for="" class="">Payment Method<span class="text-danger">*</span></label>
                                <select class="smstyle" wire:model.defer="service_payment_method">
                                    <option value="">Select Payment Method</option>
                                    @foreach ($methods as $method)
                                        <option value='{{ $method->id }}'>{{ $method->name }}</option>
                                    @endforeach
                                </select>
                                <x-error field="payment_method_id"></x-error>
                            </div>
                        </div>
                        <div class="row" style="">
                            <div class="col">
                                <label for="">Transaction ID<span class="text-danger">*</span></label>
                                <textarea class="smstyle" wire:model.defer="service_comment" >
                                <x-error field="payment_comments"></x-error>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color:#fff;">
                        <button type="submit" class="payment-button float-right" wire:click="saveExtrasPayment" style="color:green;background-color:white;">
                            Insert
                        </button>
                        <span type="button" class="payment-button" style="color:red;" data-dismiss="modal" style=''>Close</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="overnightPaymentModal" style="border-radius:0px !important;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm" style="border-radius:0px !important;z-index:10;">
                    <h5 style="text-align:center;margin-left:26%;" class="modal-title text-dark text-center" id="exampleModalLabel">Overnight Payments</h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;">
                    <div class="form-style-6">
                        <div class="row mr-1">
                            <div class="col">
                                <label class="">Value</label>
                                <input class="smstyle" wire:model.defer="overnight_value" type="text" />
                                <x-error field="overnight_value"></x-error>
                            </div>
                            <div class="col">
                                <label for="" class="">Payment Method<span class="text-danger">*</span></label>
                                <select class="smstyle" wire:model.defer="overnight_payment_method">
                                    <option value="">Select Payment Method</option>
                                    @foreach ($methods as $method)
                                        <option value='{{ $method->id }}'>{{ $method->name }}</option>
                                    @endforeach
                                </select>
                                <x-error field="overnight_payment_method"></x-error>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="" class="">Payment Date</label>
                                <input class="smstyle" wire:model.defer="overnight_payment_date" type="date" min="{{ today()->toDateString() }}" />
                                <x-error field="overnight_payment_date"></x-error>
                            </div>
                        </div>
                        <div class="row" style="">
                            <div class="col">
                                <label for="">Transaction ID<span class="text-danger">*</span></label>
                                <textarea class="smstyle" wire:model.defer="overnight_comment" >
                                <x-error field="overnight_comment"></x-error>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color:#fff;">
                        <button type="submit" class="payment-button float-right" wire:click="saveOvernightPayment" style="color:green;background-color:white;">
                            Insert
                        </button>
                        <span type="button" class="payment-button" style="color:red;" data-dismiss="modal" style=''>Close</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="overnightRefundPaymentModal" style="border-radius:0px !important;" tabindex="-1" aria-labelledby="exampleModalLabel302" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm" style="border-radius:0px !important;z-index:10;">
                    <h5 style="text-align:center;" class="modal-title text-dark w-100 text-center" id="exampleModalLabel302">Overnight Payment Refund</h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;">
                    <div class="form-style-6">
                        <x-error field="status"></x-error>
                        <div class="row mr-1">
                            <div class="col">
                                <label class="">Value</label>
                                <input class="smstyle" wire:model.defer="accom_refund_value" type="number" />
                                <x-error field="accom_refund_value"></x-error>
                            </div>
                            <div class="col">
                                <label for="" class="">Refund Date</label>
                                <input class="smstyle" wire:model.defer="accom_payment_date" type="date" min="{{ today()->toDateString() }}" />
                                <x-error field="accom_payment_date"></x-error>
                            </div>
                        </div>
                        <div class="row mr-1" id="payment-method-field">
                            <div class="col">
                                <label for="" class="">Payment Method<span class="text-danger">*</span></label>
                                <select class="smstyle" wire:model.defer="accom_payment_method">
                                    <option value="">Select Payment Method</option>
                                    @foreach ($methods as $method)
                                        <option value='{{ $method->id }}'>{{ $method->name }}</option>
                                    @endforeach
                                </select>
                                <x-error field="accom_payment_method"></x-error>
                            </div>
                        </div>
                        <div class="row" style="">
                            <div class="col">
                                <label for="">Transaction ID<span class="text-danger">*</span></label>
                                <textarea class="smstyle" wire:model.defer="accom_comment" >
                                <x-error field="accom_comments"></x-error>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer" style="background-color:#fff;">
                        <button type="submit" class="payment-button float-right" wire:click="refundOvernightPayment" style="color:green;background-color:white;">
                            Refund
                        </button>
                        <span type="button" class="payment-button" style="color:red;" data-dismiss="modal" style=''>Close</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="accommodationDocumentModal" style="border-radius:0px !important;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content rounded-0">
                @if ($selected_accom_type == 'invoice_accom')
                    @include('front.Reservation.partials.invoice_accommodation_form')
                @elseif($selected_accom_type == 'invoice_cancel')
                    @include('front.Reservation.partials.invoice_cancellation_fees_accommodation_form')
                @elseif($selected_accom_type == 'receipt_accom')
                    @include('front.Reservation.partials.receipt_accommodation_form')
                @elseif($selected_accom_type == 'receipt_cancel')
                    @include('front.Reservation.partials.receipt_cancellation_fees_accommodation_form')
                @endif
            </div>
        </div>
    </div>
    <div class="modal fade" id="overnightDocumentModal" style="border-radius:0px !important;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm" style="border-radius:0px !important;z-index:10;">
                    <h5 style="text-align:center;margin-left:40%;" class="modal-title text-dark text-center" id="exampleModalLabel">Overnight Tax Form</h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;max-height:400px;overflow-y:scroll;overflow-x:hidden;width:100% !important;">
                    <div class="form-style-6">
                        <div class="row justify-content-end">
                            <div class="col-3">
                                <label for="">Mark Id<span class="text-danger">*</span></label>
                                <input wire:model.defer="mark_id" type="text">
                                <x-error field="mark_id"></x-error>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="">Document Type<span class="text-danger">*</span></label>
                                <input wire:model.defer="type_name" type="text" disabled>
                                <x-error field="type_name"></x-error>
                            </div>
                            <div class="col">
                                <label>Guest</label>
                                <input wire:model.defer="guest" type="text">
                                <x-error field="guest"></x-error>
                            </div>
                            <div class="col">
                                <label for="">Payment Method <span class="text-danger">*</span></label>
                                <select wire:model.defer="payment_method_id">
                                    <option value="">Select Payment Method</option>
                                    @foreach ($methods as $method)
                                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                                    @endforeach
                                </select>
                                <x-error field="payment_method_id"></x-error>
                            </div>
                            <div class="col">
                                <label for="">Paid <span class="text-danger">*</span></label>
                                <select wire:model.defer="paid">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <x-error field="paid"></x-error>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="" id="">Document Print Date</label>
                                <input wire:model.defer="print_date" type="date">
                                <x-error field="print_date"></x-error>
                            </div>
                            <div class="col">
                                <label for="" id="">Checkin Date</label>
                                <input wire:model.defer="check_in" type="date">
                                <x-error field="check_in"></x-error>

                            </div>
                            <div class="col">
                                <label for="" id="">Checkout Date</label>
                                <input wire:model.defer="check_out" type="date">
                                <x-error field="check_out"></x-error>
                            </div>
                            <div class="col">
                                <label class="">VAT %</label>
                                <input wire:model.defer="vat" type="text">
                                <x-error field="vat"></x-error>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="">Overnight Tax per night / € </label>
                                <input wire:model.defer="overnight_tax" type="text">
                                <x-error field="overnight_tax"></x-error>
                            </div>0
                            <div class="col">
                                <label class="">Total Overnight Tax payment / € </label>
                                <input wire:model.defer="overnight_tax_paid" type="text">
                                <x-error field="overnight_tax_paid"></x-error>
                            </div>
                            <div class="col-6">
                                <label for="">Comments</label>
                                <textarea wire:model.defer="comments" rows="3"></textarea>
                                <x-error field="comments"></x-error>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color:#fff;">
                    <button style="color:black;background-color:white;" class="payment-button print-document-btn float-right" wire:click="printDocument('overnight')">
                        <i class="fa fa-print"></i>Print
                    </button>
                    <span type="button" class="payment-button" style="color:red;" data-dismiss="modal">Close</span>
                </div>
            </div>
        </div>
    </div>
</div>
