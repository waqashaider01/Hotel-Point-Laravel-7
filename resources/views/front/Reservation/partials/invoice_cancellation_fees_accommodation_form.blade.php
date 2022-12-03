<div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
    <h5 style="text-align:center;margin-left:40%;" class="modal-title text-dark text-center" id="exampleModalLabel">
        Τιμολόγιο Παροχής Υπηρεσιών</h5>
</div>
<div class="modal-body"
     style="position:relative;background-color:#fff;max-height:400px;overflow-y:scroll;overflow-x:hidden;width:100% !important;">
    <div class="form-style-6">
        <div style="">
            <div class="row">
            <div class="col-12">
                <div class="float-right">
                    <select wire:change="companyChanged('invoice_cancel_company')" wire:model="invoice_cancel_company" required>
                        <option selected value="">Select Company...</option>
                        @foreach($companies as $company)
                            <option value="{{$company->id}}">{{$company->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <label for="">Document Type<span class="text-danger">*</span></label>
                    <select wire:model.defer="invoice_cancel_document_type" id="">
                        <option selected
                                value={{$invoice_cancel_document_type}}>{{$invoice_cancel_document_name}}</option>
                    </select>
                    <x-error field="invoice_cancel_document_type"></x-error>
                </div>
                <div class="col">
                    <label for="">Paid <span class="text-danger">*</span></label>
                    <select wire:model.defer="invoice_cancel_is_paid" id="">
                        <option value=1>Yes</option>
                        <option value=0>No</option>
                    </select>
                </div>
                <div class="col">
                    <label for="">Payment Method <span class="text-danger">*</span></label>
                    <select wire:model.defer="invoice_cancel_payment_method" id="payment_method1">
                        @foreach($methods as $method)
                            <option value="{{$method->id}}">{{$method->name}}</option>
                        @endforeach
                    </select>
                    <x-error field="invoice_cancel_payment_method"></x-error>
                </div>
                <div class="col">
                    <label for="" id="checkout_label">Document Print Date</label>
                    <input wire:model.defer="invoice_cancel_document_print_date" type="date" value=""/>
                    <x-error field="invoice_cancel_document_print_date"></x-error>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Guest</label>
                    <input wire:model.defer="invoice_cancel_guest_name" type="text"/>
                    <x-error field="invoice_cancel_guest_name"></x-error>
                </div>
                <div class="col">
                    <label for="">Checkin Date</label>
                    <input wire:model.defer="invoice_cancel_checkin_date" type="date">
                    <x-error field="invoice_cancel_checkin_date"></x-error>
                </div>
                <div class="col">
                    <label for="">Checkout Date</label>
                    <input wire:model.defer="invoice_cancel_checkout_date" type="date">
                    <x-error field="invoice_cancel_checkout_date"></x-error>
                </div>
                <div class="col"></div>
            </div>
            <hr>
            <div id="company-agency-column">
                <div class="row">
                    <div class="col">
                        <label>Channel/Company Name <small>
                                <abbr title="This field contains agency or company name">
                                    <i class="fa fa-exclamation-circle" style=""></i>
                                </abbr>
                            </small>
                        </label>
                        <input wire:model.defer="invoice_cancel_agency_name" type="text"/>
                        <x-error field="invoice_cancel_agency_name"></x-error>
                    </div>
                    <div class="col">
                        <label>Channel/Company activity <abbr title="This field contains agency or company activity"><i
                                    class="fa fa-exclamation-circle" style=""></i></small></label>

                        <input wire:model.defer="invoice_cancel_agency_activity" type="text"/>
                        <x-error field="invoice_cancel_agency_activity"></x-error>
                    </div>
                    <div class="col">
                        <label>Channel/Company Address<abbr title="This field contains agency or company address"><i
                                    class="fa fa-exclamation-circle" style=""></i></small></label>
                        <input wire:model.defer="invoice_cancel_agency_address" type="text"/>
                        <x-error field="invoice_cancel_agency_address"></x-error>
                    </div>
                    <div class="col">
                        <label>Channel/Company Tax ID <abbr title="This field contains agency or company tax id"><i
                                    class="fa fa-exclamation-circle" style=""></i></small></label>
                        <input wire:model.defer="invoice_cancel_agency_tax_id" type="text"/>
                        <x-error field="invoice_cancel_agency_tax_id"></x-error>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label>Channel/Company Tax Office <abbr
                                title="This field contains agency or company tax office"><i
                                    class="fa fa-exclamation-circle" style=""></i></small></label>
                        <input wire:model.defer="invoice_cancel_agency_tax_office" type="text"/>
                        <x-error field="invoice_cancel_agency_tax_office"></x-error>
                    </div>
                    <div class="col">
                        <label>Channel/Company Postal Code <abbr
                                title="This field contains agency or company postal code"><i
                                    class="fa fa-exclamation-circle" style=""></i></small></label>
                        <input wire:model.defer="invoice_cancel_agency_postal" type="text"/>
                        <x-error field="invoice_cancel_agency_postal"></x-error>
                    </div>
                    <div class="col">
                        <label>Channel/Company Phone Number<abbr
                                title="This field contains agency or company phone number"><i
                                    class="fa fa-exclamation-circle" style=""></i></small></label>
                        <input wire:model.defer="invoice_cancel_agency_phone" type="text"/>
                        <x-error field="invoice_cancel_agency_phone"></x-error>
                    </div>
                    <div class="col">
                    </div>
                </div>
            </div>
            <hr>
            <div id="">
                <div class="row">
                    <div class="col">
                        <label>Total Payment</label>
                        <input wire:model.defer="invoice_cancel_total_payment" type="text"/>
                        <x-error field="invoice_cancel_total_payment"></x-error>
                    </div>
                    <div class="col">
                        <label>Net Value</label>
                        <input wire:model.defer="invoice_cancel_net_value" type="text"/>
                        <x-error field="invoice_cancel_net_value"></x-error>
                    </div>
                    <div class="col">
                        <label>Subject To Vat(Taxable Amount)</label>
                        <input wire:model.defer="invoice_cancel_taxable" type="text"/>
                        <x-error field="invoice_cancel_taxable"></x-error>
                    </div>
                    <div class="col">
                        <label>Municipal Tax</label>
                        <input wire:model.defer="invoice_cancel_municipal_tax" type="text"/>
                        <x-error field="invoice_cancel_municipal_tax"></x-error>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label>Document Vat Amount (Tax)</label>
                        <input wire:model.defer="invoice_cancel_document_tax" type="text"/>
                        <x-error field="invoice_cancel_document_tax"></x-error>
                    </div>
                    <div class="col">
                        <label>Cancellation VAT</label>
                        <input wire:model.defer="invoice_cancel_cancellation_tax" type="text"/>
                        <x-error field="invoice_cancel_cancellation_tax"></x-error>
                    </div>
                    <div class="col">
                        <label></label>
                    </div>
                    <div class="col">
                        <label></label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <label>Comments</label>
                    <textarea rows="3" wire:model.defer="invoice_cancel_document_comments"></textarea>
                    <x-error field="invoice_cancel_document_comments"></x-error>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer" style="background-color:#fff;">
    <button type="button" style="color:black;background-color:white;"
            class="float-right payment-button print-document-btn" wire:click="printDocument('{{$selected_accom_type}}')">Print
    </button>
    <span type="button" class="payment-button" style="color:red;" data-dismiss="modal">Close</span>
</div>

