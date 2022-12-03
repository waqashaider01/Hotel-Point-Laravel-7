<div>
    <div>
        <x-table title='User List'>
            <x-slot name="header">
                <a href="#" type="button" data-toggle="modal" data-target="#addEditUser"
                   class="btn btn-primary  float-right">
                    <i class="link-icon" data-feather="plus"></i>New User
                </a>
            </x-slot>
            <x-slot name="heading">
                <td>First Name</td>
                <td>Last Name</td>
                <td>Email</td>
                <td>Role</td>
                <th data-orderable="false">Actions</th>
            </x-slot>
            @foreach($users as $item)
                <tr id="tr_{{$item->id}}">
                    <td>{{$item->first_name}}</td>
                    <td>{{$item->last_name}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->role}}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button"
                                    wire:click="setUser({{$item->id}})"
                                    class="btn btn-outline-info btn-xs">
                                <i class="fa fa-edit"></i></button>
                            <button type="button" wire:click="confirmDeleteUser({{$item->id}})"
                                    class="btn btn-outline-danger btn-xs">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>
    <div class="modal fade" id="addEditUser" style="border-radius:0px !important;" tabindex="-1"
         data-backdrop="static"
         data-keyboard="false" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
                    <h5 style="margin-left:45%;margin-right:32%;" class="modal-title text-dark"
                        id="exampleModalLabel">
                        {{($editing_user)?'Edit':'Add'}} User</h5>
                    <button type="button" class="float-right btn btn-outline-primary" wire:click="saveUser" wire:loading.attr="disabled" wire:target="saveUser">
                        Submit
                    </button>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal" style=''>Close
                    </button>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;">
                    <div class="d-none justify-content-center align-items-center" wire:loading.class="d-flex" wire:target="saveUser">
                        <x-loader color="#333"/>
                    </div>
                    <form action="" method="POST" wire:loading.remove wire:target="saveUser">
                        <div class="">
                            <div class="mt-4 row" style="">
                                <div class="inner col-md-2"></div>
                                <div class="inner col-md-5">
                                    <table>
                                        <tr>
                                            <td><b>PERSONAL INFORMATION</b></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control"
                                                       placeholder="First Name"
                                                       wire:model.defer='first_name' required>
                                                <div>
                                                    @error('first_name')
                                                    <span class="invalid-input-data"
                                                          role="alert"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input class="form-control" placeholder="Last Name"
                                                       wire:model.defer='last_name' type="text" required="">
                                                <div>
                                                    @error('last_name')
                                                    <span class="invalid-input-data"
                                                          role="alert"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="margin-top:25px !important ;"></div>
                                                <b>ADDRESS</b></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select class="form-control" wire:model='country' required>
                                                    <option value="">Select Country</option>
                                                    @foreach($countries as $country)
                                                        <option
                                                            value="{{$country->id}}">{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div>
                                                    @error('country')
                                                    <span class="invalid-input-data"
                                                          role="alert"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input class="form-control" wire:model.defer='address'
                                                       placeholder="Address" type="text" required="">
                                                <div>
                                                    @error('address')
                                                    <span class="invalid-input-data"
                                                          role="alert"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="margin-top:25px !important ;"></div>
                                                <b>CONTACT INFORMATION</b></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input class=" form-control" placeholder="Email"
                                                       wire:model.defer='email' type="email" required/>
                                                <div>
                                                    @error('email')
                                                    <span class="invalid-input-data"
                                                          role="alert"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">
                                                            {{ $country_code }}
                                                        </span>
                                                    </div>
                                                    <input class="form-control" placeholder="Phone Number"
                                                    type="text"
                                                    wire:model.defer='phone'>
                                                </div>
                                                <div>
                                                    @error('phone')
                                                    <span class="invalid-input-data"
                                                          role="alert"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="margin-top:25px !important ;"></div>
                                                <b>ROLE INFORMATION</b></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select wire:model='role' class="form-control">
                                                    <option value="">Select User Role</option>
                                                    @foreach ($user_roles as $role)
                                                        <option value="{{ $role }}">{{ $role }}</option>
                                                    @endforeach
                                                </select>
                                                <div>
                                                    @error('role')
                                                    <span class="invalid-input-data"
                                                          role="alert"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="margin-top:25px !important ;"></div>
                                                <b>SECURITY INFORMATION
                                                    <i class="fa fa-info-circle text-dark" data-toggle="tooltip" data-placement="right"
                                                       title="The password needs to contain at least 8 characters, at least one number, one capital letter and one lowercase letter."
                                                       aria-hidden="true"></i>
                                                </b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input class="form-control" style="" id='userpass'
                                                       placeholder="Enter Password" wire:model.defer='password'
                                                       type="password"/>
                                                <div>
                                                    @error('password')
                                                    <span class="invalid-input-data"
                                                          role="alert"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input class="form-control" placeholder="Confirm Password"
                                                       wire:model.defer='password_confirmation'
                                                       type="password"/>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class=" col-md-4" style="border:1px solid #F5F7F9;max-height:100%;">
                                    <h3 class="text-center">Permissions</h3>
                                    @error('selected_permissions')
                                        <div class="invalid-input-data mb-2"
                                        role="alert"><strong>{{ $message }}</strong></div>
                                    @enderror
                                    <div class="" style="overflow-y:auto;height: 500px;">
                                        <div class="checkbox-group">
                                            <div class="mb-3">
                                                <button type="button" class="btn btn-sm btn-outline-info" wire:click="selectAllPermission">Select All</button>
                                            </div>
                                            @foreach($permissions as $permission)
                                            <div class="form-check-custom">
                                                <input class="form-check-input"
                                                    type="checkbox"
                                                    wire:model="selected_permissions"
                                                    value="{{ $permission->id }}"
                                                    id="check_{{ $permission->id }}"
                                                >
                                                <label class="form-check-label" for="check_{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="background-color:#fff;"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function () {
            @this.on('closeModal', function () {
                $('.modal').modal('hide')
                $('.modal-backdrop').remove()
            });
            $('.modal').on('hidden.bs.modal', function () {
                @this.emit('resetModalEvent');
            });

        });
    </script>
</div>
