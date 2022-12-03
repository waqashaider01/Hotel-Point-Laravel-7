<div>
    <x-table title='Suppliers List'>
        <x-slot name="header">
            <a href="#" type="button" data-toggle="modal" data-target="#addEditModal" wire:click="newSupplier"
               class="btn btn-primary  float-right">
                <i class="link-icon" data-feather="plus"></i>New Supplier
            </a>
        </x-slot>
        <x-slot name="heading">
            <th>ID</th>
            <th>Company's Name</th>
            <th>Tax Number</th>
            <th>Address</th>
            <th>Category</th>
            <th>Email</th>
            <th>Phone</th>
            <th data-orderable="false">Actions</th>
        </x-slot>
        @foreach($suppliers as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->tax_number}}</td>
                <td>{{$item->address}}</td>
                <td>{{$item->category}}</td>
                <td>{{$item->email}}</td>
                <td>{{$item->phone}}</td>
                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="#" type="button" data-toggle="modal" data-target="#addEditModal"
                           wire:click="setSupplier({{$item->id}})"
                           class="btn btn-outline-info btn-xs">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button type="button" wire:click="deleteSupplier({{$item->id}})"
                                class="btn btn-outline-danger btn-xs">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-table>
    <div class="modal fade" id="addEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header mb-5" style="background-color:#48BBBE;z-index:0;">
                    <h4 class="modal-title text-light">Update Supplier</h4>
                </div>
                <div class="modal-body"
                     style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-3%;">
                    <div class="mt-0">
                        <div class="form-style-6">
                            <div class="row">
                                <div class="col">
                                    <label>Company's Name</label>
                                    <input type="text" class="form-control"
                                           wire:model.defer="selected_supplier.name">
                                    <x-error field="selected_supplier.name"/>
                                </div>
                                <div class="col">
                                    <label>Tax Number</label>
                                    <input type="text" class="form-control"
                                           wire:model.defer="selected_supplier.tax_number">
                                    <x-error field="selected_supplier.tax_number"/>
                                </div>
                                <div class="col">
                                    <label>Address</label>
                                    <input type="text" class="form-control"
                                           wire:model.defer="selected_supplier.address">
                                    <x-error field="selected_supplier.address"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Category</label>
                                    <select class="form-select" wire:model.defer="selected_supplier.category">
                                        <option selected disabled>Choose...</option>
                                        <option value="A&G">A&G</option>
                                        <option value="F&B">F&B</option>
                                        <option value="S&M">S&M</option>
                                        <option value="R&D">R&D</option>
                                        <option value="R&M">R&M</option>
                                        <option value="Management Fee">Management Fee</option>
                                        <option value="Non Operating Items">Non Operating Items</option>
                                        <option value="Fixed Charges">Fixed Charges</option>
                                        <option value="OOD">OOD</option>
                                    </select>
                                    <x-error field="selected_supplier.category"/>
                                </div>
                                <div class="col">
                                    <label>Email</label>
                                    <input type="text" class="form-control"
                                           wire:model.defer="selected_supplier.email">
                                    <x-error field="selected_supplier.email"/>
                                </div>
                                <div class="col">
                                    <label>Phone</label>
                                    <input type="text" class="form-control"
                                           wire:model.defer="selected_supplier.phone">
                                    <x-error field="selected_supplier.phone"/>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn btn-primary" wire:click="saveSupplier" style='background-color:#48BBBE;padding:2px 12px;color:white;border-radius:2px;
	  border:none;'>{{($editing_supplier)?'Update':'Create'}}
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"
                                    style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

