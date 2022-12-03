<div>

    <div>
        <div class="d-flex flex-column-fluid mt-5">
            <div class="container-fluid">
                <div class="listcard">
                    <div class="header-div">
                        <h2 class="pt-7 pl-3 pb-7">Opex Form</h2>
                    </div>
                    <div class="row mt-0 ">
                        <div class="col-md-8">
                            <div class="form-style-6">
                                <div class="row">
                                    <div class="col">
                                        <label class="">Date</label>
                                        <input id="date" type="text" wire:model="date" placeholder="Choose date" class="form-control1">
                                        <x-error field="date"/>
                                    </div>
                                    <div class="col">
                                        <label class="">Invoice Number</label>
                                        <input type="text" wire:model="invoice_number" placeholder="Invoice Number"
                                               id="invoiceNumber" class="form-control1" required="">
                                        <x-error field="invoice_number"/>
                                    </div>
                                    <div class="col">
                                        <label class="">Invoice Type</label>
                                        <select class="form-control1" wire:model="invoice_type">
                                            <option value="0" selected >Choose...</option>
                                            <option value="Invoice">Invoice</option>
                                            <option value="Receipt">Receipt</option>
                                            <option value="Credit note">Credit note</option>
                                        </select>
                                        <x-error field="invoice_type"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label class="">Cost Of Sales</label>
                                        <select class="form-control1 cos" wire:model="cos">
                                            <option value="0" selected >Choose...</option>
                                            @foreach($coses as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <x-error field="cos"/>
                                    </div>
                                    <div class="col">
                                        <label class="">Category</label>
                                        <select class="form-control1 cat" wire:model="category">
                                            <option value="0" selected >Choose...</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                        <x-error field="category"/>
                                    </div>
                                    <div class="col">
                                        <label class="">Descriptions</label>
                                        <select class="form-control1 desc" wire:model="description">
                                            <option value="0" selected >Choose...</option>
                                            @foreach($descriptions as $description)
                                                <option value="{{$description->id}}">{{$description->name}}</option>
                                            @endforeach
                                        </select>
                                        <x-error field="description"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label class="">Amount</label>
                                        <input type="number" wire:model="amount"
                                               class="form-control1 amount"
                                               placeholder='Enter Amount'/>
                                        <x-error field="amount"/>
                                    </div>
                                    <div class="col">
                                        <label class="">VAT</label>
                                        <input type="number" wire:model="vat" class="form-control1 vat"
                                               placeholder='Enter VAT'>
                                        <x-error field="vat"/>
                                    </div>
                                    <div class="col">
                                        <label class="">Payment</label>
                                        <select class="form-control1" wire:model="payment">
                                            <option value="0" selected >Choose...</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Credit Card">Credit Card</option>
                                            <option value="Bank Transfer">Bank Transfer</option>
                                            <option value="Debtor">Debtor</option>
                                        </select>
                                        <x-error field="payment"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label class="">Supplier</label>
                                        <select class="form-control1" wire:model="supplier">
                                            <option value="0" selected >Choose...</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                            @endforeach
                                        </select>
                                        <x-error field="supplier"/>
                                    </div>
                                    <div class="col"></div>
                                    <div class="col"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-style-6">
                                <div class="row">
                                    <div class="col">
                                        <label class="">Upload Document</label>
                                        <div class="mb-3 form-control1 border border-2" id="embedDiv"
                                             style="height:265px !important; ">
                                            @if($file)
                                                <iframe src="{{ $file->temporaryUrl() }}" height="100%" width="100%"
                                                        scrolling="auto"></iframe>
                                            @endif
                                        </div>
                                        <input type="file" id="formFile" wire:model="file"
                                               accept=".pdf, .png, .jpg, .jpeg"
                                               class="form-control1" required="">
                                        <x-error field="file"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @for($i = 0; $i < count($cos_array) ; $i++ )
                    <div class="listcard listcard-custom mt-10" wire:key="cos_array.{{$i}}">
                        <div class="form-style-6">
                            <div class=" row">
                                <div class="col">
                                    <label class="">Cost Of Sales</label>
                                    <select class="form-control1 cos" wire:model="cos_array.{{$i}}.cos"
                                            style="min-width:100%;" name="cos" id="cos'+index+'"
                                            required>
                                        <option value="0" selected >Choose...</option>
                                        @foreach($coses as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    <x-error field="cos_array.{{$i}}.cos"/>
                                </div>
                                <div class="col">
                                    <label class="">Category</label>
                                    <select class="form-control1 cat" wire:model="cos_array.{{$i}}.category"
                                            style="min-width:100%;">
                                        <option value="0" selected >Choose...</option>
                                        @foreach($cos_array[$i]['cats'] as $cat)
                                            <option value="{{$cat['id']}}">{{$cat['name']}}</option>
                                        @endforeach
                                    </select>
                                    <x-error field="cos_array.{{$i}}.category"/>
                                </div>
                                <div class="col">
                                    <label class="">Descriptions</label>
                                    <select class="form-control1 desc" wire:model="cos_array.{{$i}}.description"
                                            style="min-width:100%;">
                                        <option value="0" selected >Choose...</option>
                                        @foreach($cos_array[$i]['desc'] as $desc)
                                            <option value="{{$desc['id']}}">{{$desc['name']}}</option>
                                        @endforeach
                                    </select>
                                    <x-error field="cos_array.{{$i}}.description"/>
                                </div>
                                <div class="col">
                                    <label class="">Amount</label>
                                    <input type="number" placeholder="Enter Amount" wire:model="cos_array.{{$i}}.amount"
                                           class="form-control1 amount"/>
                                    <x-error field="cos_array.{{$i}}.amount"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label class="">VAT</label>
                                    <input type="number" placeholder="Enter VAT" wire:model="cos_array.{{$i}}.vat"
                                           class="form-control1 vat">
                                    <x-error field="cos_array.{{$i}}.vat"/>
                                </div>
                                <div class="col"></div>
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                        </div>
                    </div>
                @endfor
                <div class="listcard listcard-custom mt-10 ">
                    <div class="ml-5 mr-4">
                        <h4 class="text-center">Total</h4>
                        <div class="table  text-center " id='reservations-table'>
                            <div>
                                <div class="row th text-center">
                                    <div class="col">Amount</div>
                                    <div class="col">VAT</div>
                                    <div class="col">Action</div>
                                </div>
                            </div>
                            <div class="row mytr text-center" style="height:50px !important;">
                                <div class="col">{{showPriceWithCurrency($cosAmount + $totalAmount)}}</div>
                                <div class="col">{{showPriceWithCurrency($cosVat + $totalVat)}}</div>
                                <div class="col text-center ">
                                    <button type="button" wire:click="addCos" title="Add"
                                            style='background-color:#48BD91;border:none !important;padding:5px 12px;color:white;border-radius:2px;'>
                                        <i class="fa fa-plus text-light" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" wire:click="save" title="Save"
                                            style='background-color:#48BD91;border:none !important;padding:5px 12px;color:white;border-radius:2px;margin-right:5px;'>
                                           <i class="fas fa-download text-light"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    
    <script>
        $("#date").flatpickr()
    </script>

</div>
