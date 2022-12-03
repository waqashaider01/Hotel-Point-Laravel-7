<div>
    @inject('carbon', 'Carbon\Carbon')
    <div class="container-fluid reservation-view">
        <div class="row">
            <div class="col-md-12">
                <div class="infocard shadow-sm bg-white">
                    <div class="row pb-4">
                        <div class="col d-print-none">
                            <span type="button" class="btn btn-outline-secondary border-2 rounded-md"
                                onclick="window.print()">
                                <i class="fa fa-print" aria-hidden="true"></i> Print
                            </span>
                            <span type="button" class="btn btn-outline-secondary border-2 rounded-md"
                                onclick="document.getElementById('paymentInfo').classList.toggle('d-none')">
                                <i class="far fa-credit-card" aria-hidden="true"></i> Toggle Payment
                            </span>
                        </div>
                        <div class="col">
                            <div class="text-right">Booking was made on <span>
                                    {{ $carbon::parse($reservation->booking_date)->format('d M Y') }} </span></div>
                        </div>
                    </div>
                    <table class="table border">
                        <thead class="col">
                            <tr class="bg-secondary">
                                <th>
                                    Booking ID
                                </th>
                                <th>
                                    Arrival Date
                                </th>
                                <th>
                                    Departure Date
                                </th>
                                <th>
                                    Rate Type
                                </th>
                                <th>
                                    Channel
                                </th>
                                <th>
                                    Cancellation Date
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white">
                                <td>
                                    #{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td>
                                    {{ $carbon::parse($reservation->arrival_date)->format('d M Y') }}
                                </td>
                                <td>
                                    {{ $carbon::parse($reservation->departure_date)->format('d M Y') }}
                                </td>
                                <td>
                                    {{ ucfirst($reservation->rate_type->name) }}
                                </td>
                                <td>
                                    {{ ucfirst($reservation->booking_agency->name) }}
                                </td>
                                <td>
                                    {{ $carbon::parse($reservation->cancel_date ?? now())->format('d M Y') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d-flex pt-4">
                        @if ($accom_balance < 0)
                            <div class="alert alert-warning">
                                <strong>{{ showPriceWithCurrency(abs($accom_balance)) }} must be returned to the
                                    customer!</strong>
                            </div>
                        @endif
                    </div>
                    <table class="table border mt-7 ">
                        <thead class="col">
                            <tr class="bg-secondary">
                                <th>
                                    Accommodation Total
                                </th>
                                <th>
                                    Cancellation Total
                                </th>
                                <th>
                                    Paid
                                </th>
                                <th>
                                    Cancellation Balance
                                </th>
                                <th class="d-print-none">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white">
                                <td>
                                    {{ showPriceWithCurrency(abs($reserve_total)) }}
                                </td>
                                <td>
                                    {{ showPriceWithCurrency($cancellation_total) }}
                                </td>
                                <td>
                                    {{ showPriceWithCurrency($accommodation_payment) }}
                                </td>
                                <td>
                                    {{ showPriceWithCurrency($accom_balance) }}
                                </td>
                                <td class="d-print-none">
                                    <button class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                                        data-target="#insertAccommodationPayment"><i class="far fa-credit-card"
                                            aria-hidden="true"></i> Insert Payment</button>
                                    <button class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                                        data-target="#printDocumentModal"><i class="fa fa-print" aria-hidden="true"></i>
                                        Document</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table border mt-7 d-none" id="paymentInfo">
                        <thead>
                            <tr class="bg-secondary">
                                <td>
                                    Payment Type
                                </td>
                                <td>
                                    Payment Date
                                </td>
                                <td>
                                    Payment Value
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservation_payments as $type => $payments)
                                @foreach ($payments as $payment)
                                    <tr class="bg-white">
                                        <td>
                                            {{ $type }}
                                        </td>
                                        <td>
                                            {{ $carbon::parse($payment['date'])->format('d M Y') }}
                                        </td>
                                        <td>
                                            {{ showPriceWithCurrency($payment['value']) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                    <div class="modal" id="insertAccommodationPayment" tabindex="-1"
                        aria-labelledby="insertAccommodationPaymentLabel" aria-modal="true">
                        <div class="modal-dialog  ">
                            <form class="modal-content add-guest-form" wire:submit.prevent="insert_accommodation_payment">
                                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                                    <h5 class="modal-title text-light" id="insertAccommodationPaymentLabel">Insert
                                        Accommodation Payment</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="form-style-6"
                                        style="overflow-y:scroll; overflow-x:hidden; max-height:450px;" id="">
                                        <div class="row">
                                            <div class="col">
                                                <label class="" for="value">Value</label>
                                                <input class="halfstyle" wire:model.defer="accommodation_payment_data.value"
                                                    type="number" placeholder="E.g 2500/-" step="0.01" id="value" required>
                                                <x-error field="accommodation_payment_data.value" />
                                            </div>
                                            <div class="col">
                                                <label class="" for="paymentDate">Payment Date</label>
                                                <input class="halfstyle"
                                                    wire:model.defer="accommodation_payment_data.payment_date" type="date"
                                                    placeholder="Jon Doe"
                                                    id="paymentDate" required>
                                                <x-error field="accommodation_payment_data.payment_date" />
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="" for="paymentMethod">Payment Method</label>
                                                <select class="halfstyle"
                                                    wire:model.defer="accommodation_payment_data.payment_method"
                                                    id="paymentMethod" required>
                                                    <option value="">Select Payment Method</option>
                                                    @foreach ($payment_methods as $payment_method)
                                                        <option value="{{ $payment_method->id }}">
                                                            {{ ucfirst($payment_method->name) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <x-error field="accommodation_payment_data.payment_method" />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="" for="isDeposit">Is this payment a Deposit?</label>
                                                <select class="halfstyle"
                                                    wire:model.defer="accommodation_payment_data.is_deposit" id="isDeposit"
                                                    required>
                                                    <option value="">Select Value</option>
                                                    @foreach (['Yes', 'No'] as $is_deposit)
                                                        <option value="{{ $is_deposit }}">
                                                            {{ ucfirst($is_deposit) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <x-error field="accommodation_payment_data.is_deposit" />
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <label class="">Comments</label>
                                                <textarea class="halfstyle" wire:model.defer="accommodation_payment_data.comments" rows="3"
                                                    placeholder="Enter comments" id="comments"></textarea>
                                                <x-error field="accommodation_payment_data.comments" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer" style="background-color:#F5F7F9;">
                                    <button type="submit" class="btn btn-primary btn-sm">Insert Payment</button>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal" id="printDocumentModal" tabindex="-1"
                        aria-labelledby="printDocumentModalLabel" aria-modal="true">
                        <div class="modal-dialog  ">
                            <div class="modal-content add-guest-form">
                                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                                    <h5 class="modal-title text-light" id="printDocumentModalLabel">Print
                                        Accommodation Document</h5>
                                </div>
                                <div class="modal-body">
                                    <h6 class="mb-2">Choose an option:</h6>
                                    <div class="list-group list-group-flush">
                                        @foreach ($document_types as $document_type)
                                            @if($isdocumentPrinted>0)
                                            <a class="list-group-item list-group-item-action" style="cursor: pointer; color:grey;" >
                                                <i class="fa fa-file"></i> &nbsp;
                                                {{ $document_type['name'] }}
                                            </a>
                                            @else
                                            <a href="javascript: void(0)" class="list-group-item list-group-item-action" style="cursor: pointer" wire:click="changeSelectedDocument({{$document_type['id']}})">
                                                <i class="fa fa-file"></i> &nbsp;
                                                {{ $document_type['name'] }}
                                            </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="modal-footer" style="background-color:#F5F7F9;">
                                    <button type="button" class="btn btn-danger btn-sm"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal" id="printDocumentInfoModal" tabindex="-1"
                        aria-labelledby="printDocumentInfoModalLabel" aria-modal="true" data-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <form class="modal-content add-guest-form" wire:submit.prevent="generatePrintDocument">
                                <div class="modal-header text-center" style="background-color:#48BBBE;z-index:0;">
                                    <h5 class="modal-title text-light h3" id="printDocumentInfoModalLabel">{{ $selected_document->name ?? "NA" }}</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="form-style-6"
                                        style="overflow-y:scroll; overflow-x:hidden; max-height:450px;" >
                                        <div class="row">
                                            @if($selected_type==2)
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4">
                                                <label class="text-success" for="documentCompany">Company</label>
                                                <select class="" id="documentCompany" wire:model.defer="company_id" required>
                                                    <option selected value="null">Select Company </option>
                                                    @foreach($companies as $company)
                                                    <option value="{{$company->id}}">{{$company->name}}</option>
                                                    @endforeach
                                                    
                                                </select>
                                                <x-error field="company_id"></x-error>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="text-success" for="documentType">Document Type</label>
                                                <input class="halfstyle" type="text" id="documentType" value='{{ $selected_document->name ?? "NA" }}' disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="text-success" for="documentGuestName">Guest</label>
                                                <input class="halfstyle"  type="text" id="documentGuestName" value="{{ $reservation->guest->full_name }}" disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="text-success" for="documentPrintDate">Document Print Date</label>
                                                <input class="halfstyle" type="date" id="documentPrintDate" wire:model.defer="selected_document_info.print_date">
                                                <x-error field="selected_document_info.print_date"></x-error>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="text-success" for="documentPaid">Paid</label>
                                                <select class="halfstyle" id="documentPaid" wire:model="selected_document_info.paid" disabled>
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <label class="text-success" for="documentPaymentMethod">Payment Method</label>
                                                <select class="halfstyle" id="documentPaymentMethod" wire:model.defer="selected_document_info.payment_method_id" >
                                                    @foreach ($payment_methods as $payment_method)
                                                        <option value="{{ $payment_method->id }}">{{ $payment_method->name }}</option>
                                                    @endforeach
                                                </select>
                                                <x-error field="selected_document_info.payment_method_id"></x-error>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="text-success" for="documentTotalPayment">Total Payment</label>
                                                <input class="halfstyle" type="number" step="0.01" id="documentTotalPayment" wire:model="selected_document_info.total" disabled>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <label class="text-success" for="documentNetValue">Net Value</label>
                                                <input class="halfstyle" type="number" step="0.01" id="documentNetValue" wire:model="selected_document_info.net_value" disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="text-success" for="documentTaxableAmount">Taxable Amount</label>
                                                <input class="halfstyle" type="number" step="0.01" id="documentTaxableAmount" wire:model="selected_document_info.taxable_amount" disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="text-success" for="documentMunicipalTax">Municipal Tax</label>
                                                <input class="halfstyle" type="number" step="0.01" id="documentMunicipalTax" wire:model="selected_document_info.municipal_tax" disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="text-success" for="documentVatAmount">Dcoument Vat Amount (Tax)</label>
                                                <input class="halfstyle" type="number" step="0.01" id="documentVatAmount" wire:model="selected_document_info.tax" disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="text-success" for="documentCancellationVat">Cancellation VAT %</label>
                                                <input class="halfstyle" type="number" step="0.01" id="documentCancellationVat" value="{{ $hotel_settings->cancellation_vat_tax->vat_option->value ?? 'N/A' }}" disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="text-success" for="documentCityTax">City Tax %</label>
                                                <input class="halfstyle" type="number" step="0.01" id="documentCityTax" value="{{ $hotel_settings->city_tax }}" disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="text-success">Comments</label>
                                                <textarea class="halfstyle" rows="3" wire:model.defer="selected_document_info.comments"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer" style="background-color:#F5F7F9;">
                                    <button type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled" wire:target="generatePrintDocument">Print Document <span wire:loading.inline wire:target="generatePrintDocument"><x-loader width="10px" height="10px" margin="5px 10px" scale="4" /></span></button>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
