@extends('layouts.master')
@section('content')
    <div>
        <x-table title='Guests List'>
            <x-slot name="header">
            </x-slot>
            <x-slot name="heading">
                <th>Name</th>
                <th>Email</th>
                <th>Country</th>
                <th data-orderable="false">Actions</th>
            </x-slot>
            @foreach ($guests as $item)
                <tr>
                    <td>{{ $item->full_name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ optional($item->country)->name ?? 'N/A' }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('guest-reservations', ['id' => $item->id]) }}" type="button" class="btn btn-outline-info btn-xs"> View Reservations</a>
                            <a href="#" data-toggle="modal" data-target="#exampleModal{{ $item->id }}" type="button" class="btn btn-outline-primary">Edit</a>
                        </div>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#48BBBE;">
                                <h5 class="modal-title" style="color: white" id="exampleModalLabel{{ $item->id }}">Edit Guest</h5>
                                <button type="button" class="btn p-0" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-1x fa-times" style="color: white;opacity: 1;text-shadow: none;"></i>
                                </button>
                            </div>
                            <div class="modal-body form-style-6" style="margin: 1.75rem">
                                {{-- full_name;email;email_2;country_id;city;address;language;phone;mobile;postal_code --}}
                                <form action="{{ route('guest-update', ['id' => $item->id]) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="full_name">Full Name</label>
                                            <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $item->full_name }}">
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{ $item->email }}">
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="email_2">Email 2</label>
                                            <input type="text" class="form-control" id="email_2" name="email_2" value="{{ $item->email_2 }}">
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="country_id">Country</label>
                                            <select class="form-control" id="country_id" name="country_id">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}" {{ $item->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" id="city" name="city" value="{{ $item->city }}">
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control" id="address" name="address" value="{{ $item->address }}">
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="language">Language</label>
                                            <input type="text" class="form-control" id="language" name="language" value="{{ $item->language }}">
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="phone">Phone</label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $item->phone }}">
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="mobile">Mobile</label>
                                            <input type="text" class="form-control" id="mobile" name="mobile" value="{{ $item->mobile }}">
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="postal_code">Postal Code</label>
                                            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ $item->postal_code }}">
                                        </div>
                                    </div>
                                    <div class="form-group d-flex justify-content-end">
                                        <button type="submit" class="float-right" style="background-color:#48BBBE;padding:5px 12px;color:white;border-radius:2px;border:none;">
                                            Update
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </x-table>
    </div>
@endsection
