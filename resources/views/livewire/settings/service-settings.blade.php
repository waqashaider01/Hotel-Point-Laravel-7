<div class="d-flex flex-column-fluid mt-5">
    <div class="container-fluid" wire:ignore>
        <div class="w-auto">
            <ul class="nav nav-pills justify-content-center flex-column flex-sm-row bg-transparent" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active flex-sm-fill text-sm-center" data-toggle="tab"
                       href="#services_tab" style="color: grey">Services</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link flex-sm-fill text-sm-center" data-toggle="tab" href="#services_type_tab"
                       style="color: grey">Services Types</a>
                </li>
                <li class="nav-item dropdown" role="presentation">
                    <a class="nav-link flex-sm-fill text-sm-center" data-toggle="tab" href="#services_cat_tab"
                       style="color: grey">Services Categories</a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="services_tab" role="tabpanel"
                 aria-labelledby="kt_tab_pane_7_1">
                <div class="container-fluid">
                    <div>
                        <x-table title='Service List'>
                            <x-slot name="header">
                                <div class="float-right">
                                    <a href="#" type="button" class="float-right btn btn-primary m-3"
                                       data-toggle="modal" data-target="#addExtraChargeModal" wire:click="setService">
                                        <i class="fa fa-plus"></i>Add Service
                                    </a>
                                </div>
                            </x-slot>
                            <x-slot name="heading">
                                <td>ID</td>
                                <td>Product</td>
                                <td>Price</td>
                                <td>Category</td>
                                <td>Type</td>
                                <td>VAT</td>
                                <td>Actions</td>
                            </x-slot>
                            @foreach($services as $item)
                                <tr wire:key="tr_{{$item->id}}">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->product}}</td>
                                    <td>{{showPriceWithCurrency($item->unit_price)}}</td>
                                    <td>{{$item->extra_charge_category->name}}</td>
                                    <td>{{$item->extra_charge_type->name}}</td>
                                    <td>{{$item->vat}} %</td>
                                    <td>
                                        <div class="col">
                                            <button
                                                style="background-color:#48BBBE;margin-top:-3px !important;padding:2px 12px;color:white;border:none !important;border-radius:2px;"
                                                class="editBtn" data-toggle="modal" data-target="#addExtraChargeModal"
                                                wire:click="setService({{$item->id}})">
                                                Edit
                                            </button>
                                            <span class="ml-5" wire:click="changeStatus({{$item->id}})">
                                                @if($item->status == 'Enabled')
                                                    <i class="far fa-circle" style="color:green;"></i>
                                                @else
                                                    <i class="fa fa-power-off" style="color:red;"></i>
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </x-table>
                    </div>

                </div>
            </div>
            <div class="tab-pane fade show" id="services_type_tab" role="tabpanel"
                 aria-labelledby="kt_tab_pane_7_1">
                <div class="container-fluid">
                    <div>
                        <x-table title='Service Types'>
                            <x-slot name="header">
                            </x-slot>
                            <x-slot name="heading">
                                <td style="text-align: center">Type</td>
                            </x-slot>
                            @foreach($service_types as $item)
                                <tr wire:key="tr_{{$item->id}}" style="text-align: center">
                                    <td>{{$item->name}}</td>
                                </tr>
                            @endforeach
                        </x-table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show" id="services_cat_tab" role="tabpanel"
                 aria-labelledby="kt_tab_pane_7_1">
                <div class="container-fluid">
                    <div>
                        <x-table title='Service Categories' id="services">
                            <x-slot name="header">
                                <div class="float-right">
                                    <a href="#" type="button" class="float-right btn btn-primary m-3" wire:click="setCategory"
                                       data-toggle="modal" data-target="#addExtraChargeCategoryModal">
                                        <i class="fa fa-plus"></i>Add Service Category
                                    </a>
                                </div>
                            </x-slot>
                            <x-slot name="heading">
                                <td style="text-align: center">Type</td>
                                <td style="text-align: center">Actions</td>
                            </x-slot>
                            @foreach($service_categories as $item)
                                <tr wire:key="tr_{{$item->id}}">
                                    <td style="text-align: center">{{$item->name}}</td>
                                    <td style="text-align: center">
                                        <div class="col">
                                            <button
                                                style="background-color:#48BBBE;margin-top:-3px !important;padding:2px 12px;color:white;border:none !important;border-radius:2px;"
                                                data-toggle="modal" data-target="#addExtraChargeCategoryModal"
                                                wire:click="setCategory({{$item->id}})">
                                                Edit
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </x-table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{--    modals --}}
    <div class="modal fade" id="addExtraChargeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" id="exampleModalLabel">New Service</h5></div>
                <div class="modal-body" style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-3%;">
                    <div class="">
                        <div class="" style="margin-top:-5%;">
                            <div class="form-style-6">
                                <div class="row">
                                    <div class="col">
                                        <label>Service Category</label>
                                        <select class="form-control1"
                                                wire:model.defer="selected_service.extra_charge_category_id">
                                                <option value="">Select Category</option>
                                            @foreach($service_categories as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <x-error field="selected_service.extra_charge_category_id"></x-error>
                                    </div>
                                    <div class="col">
                                        <label>Service Type</label>
                                        <select wire:model.defer="selected_service.extra_charge_type_id">
                                        <option value="">Select Service Type</option>
                                            @foreach($service_types as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <x-error field="selected_service.extra_charge_type_id"></x-error>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col" id="dynamic_service">
                                        <label>Service Name</label>
                                        <input type="text" wire:model.defer="selected_service.product"
                                               class="form-control1"
                                               placeholder="Service Name">
                                        <x-error field="selected_service.product"></x-error>
                                    </div>
                                    <div class="col">
                                        <label>Service Unit Price</label>
                                        <input class="form-control1" placeholder="Service Unit Price" type="text"
                                               wire:model.defer="selected_service.unit_price">
                                        <x-error field="selected_service.unit_price"></x-error>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <label>VAT</label>
                                        <input type="Number" min="0" class="form-control1" placeholder="Enter VAT"
                                               wire:model.defer="selected_service.vat" required="">
                                        <x-error field="selected_service.vat"></x-error>
                                    </div>
                                    <div class="col"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color:#F5F7F9;">
                        <button type="submit" wire:click="saveService" class="float-right"
                                style='background-color:#48BBBE;padding:2px 12px;color:white;border-radius:2px;
	  border:none;'>Insert
                        </button>
                        <button type="button" class="" data-dismiss="modal"
                                style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addExtraChargeCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" id="exampleModalLabel">New Service Category</h5>
                </div>
                <div class="modal-body"
                     style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-3%;">
                    <div class="">
                        <div class="" style="margin-top:-5%;">
                            <div class="form-style-6">
                                <div class="row">
                                    <div class="col">
                                        <label>Service Category Name</label>
                                        <input class="form-control1"
                                               placeholder="Service Category Name" wire:model.defer="selected_category.name"
                                               type="text">
                                        <x-error field="selected_category.name"></x-error>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color:#F5F7F9;">
                    <button type="submit" wire:click="saveServiceCategory" class="float-right"
                            style='background-color:#48BBBE;padding:2px 12px;color:white;border-radius:2px;
	  border:none;'>Insert
                    </button>
                    <button type="button" class="" data-dismiss="modal"
                            style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>


