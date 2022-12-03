<div class="modal-header shadow-sm" style="border-radius:0px !important;z-index:10;">
    <h5 style="text-align:center;margin-left:40%;" class="modal-title text-dark text-center" id="exampleModalLabel">
        Απόδειξη Παροχής Υπηρεσιών</h5>
</div>
<div class="modal-body" style="position:relative;background-color:#fff;max-height:400px;overflow-y:scroll;overflow-x:hidden;width:100% !important;">
    <div class="form-style-6">
        <div style="">
            <div class="row">
                <div class="col">
                    <label for="exampleSelect1">Document Type<span class="text-danger">*</span></label>
                    <input wire:model.defer="receipt_document_name" type="text" />
                    <x-error field="receipt_document_name" />
                </div>
                <div class="col">
                    <label class="">Guest</label>
                    <input wire:model.defer="receipt_guest_name" type="text" />
                    <x-error field="receipt_guest_name" />
                </div>
                <div class="col">
                    <label class="" id=checkout_label>Document Print Date</label>
                    <input wire:model.defer="receipt_document_print_date" type="date" />
                    <x-error field="receipt_document_print_date" />
                </div>
                <div class="col">
                    <label for="exampleSelect1">Paid <span class="text-danger">*</span></label>
                    <select wire:model.defer="receipt_is_paid" id="exampleSelect1">
                        <option value=1>Yes</option>
                        <option value=0>No</option>
                    </select>
                    <x-error field="receipt_is_paid" />
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="exampleSelect1">Payment Method <span class="text-danger">*</span></label>
                    <select wire:model.defer="receipt_payment_method" id="payment_method1">
                        @foreach ($methods as $method)
                            <option value="{{ $method->id }}">{{ $method->name }}</option>
                        @endforeach
                    </select>
                    <x-error field="receipt_payment_method" />
                </div>
                <div class="col">
                    <label class="">Total Payment</label>
                    <input wire:model.defer="receipt_total_payment" type="text" />
                    <x-error field="receipt_total_payment" />
                </div>
                <div class="col">
                    <label class="">Net Value</label>
                    <input wire:model.defer="receipt_net_value" type="text" />
                    <x-error field="receipt_net_value" />
                </div>
                <div class="col">
                    <label class="">Discount</label>
                    <input wire:model.defer="receipt_discount" type="text" />
                    <x-error field="receipt_discount" />
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label class="">Net Value With Discount</label>
                    <input wire:model.defer="receipt_discount_net_value" type="text" />
                    <x-error field="receipt_discount_net_value" />
                </div>
                <div class="col">
                    <label class="">Taxable Amount</label>
                    <input wire:model.defer="receipt_taxable" type="text" />
                    <x-error field="receipt_taxable" />
                </div>
                <div class="col">
                    <label class="">Municipal Tax</label>
                    <input wire:model.defer="receipt_municipal_tax" type="text" />
                    <x-error field="receipt_municipal_tax" />
                </div>
                <div class="col">
                    <label class="">Document Vat Amount (Tax)</label>
                    <input wire:model.defer="receipt_document_tax" type="text" />
                    <x-error field="receipt_document_tax" />
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Rate Vat Amount (Tax)</label>
                    <input wire:model.defer="receipt_rate_tax" type="text" />
                    <x-error field="receipt_rate_tax" />
                </div>
                <div class="col">
                    <label class="">Checkin Date</label>
                    <input wire:model.defer="receipt_checkin_date" type="date" />
                    <x-error field="receipt_checkin_date" />
                </div>
                <div class="col">
                    <label class="">CheckOut Date</label>
                    <input wire:model.defer="receipt_checkout_date" type="date" />
                    <x-error field="receipt_checkout_date" />
                </div>
                <div class="col">
                    <label>VAT 1 (%)</label>
                    <input wire:model.defer="receipt_vat" type="text" />
                    <x-error field="receipt_vat" />
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>VAT 2 (%)</label>
                    <input wire:model.defer="receipt_vat2" type="text" />
                    <x-error field="receipt_vat2" />
                </div>
                <div class="col">
                    <label>City Tax</label>
                    <input wire:model.defer="receipt_city_tax" type="text" />
                    <x-error field="receipt_city_tax" />
                </div>
                <div class="col">
                    <label for="exampleTextarea">Comments</label>
                    <textarea wire:model.defer="receipt_document_comments" rows="3"></textarea>
                    <x-error field="receipt_document_comments" />
                </div>
                <div class="col"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer" style="background-color:#fff;">
    <button type="button" style="color:black;background-color:white;" class="payment-button print-document-btn float-right" wire:click="printDocument('{{ $selected_accom_type }}')">Print
    </button>
    <span type="button" class="payment-button" style="color:red;" data-dismiss="modal">Close</span>
</div>
