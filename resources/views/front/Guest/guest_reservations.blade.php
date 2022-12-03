@extends('layouts.master')
@section('content')
    <div>
        <x-table title='Guest Reservations List'>
            <x-slot name="header">

            </x-slot>
            <x-slot name="heading">
                <th>Booking ID</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Rate Type</th>
                <th>Channel</th>
                <th>Payment</th>
                <th>Overnight</th>
                <th data-orderable="false">Actions</th>
            </x-slot>
            @foreach ($reservations as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->check_in }}</td>
                    <td>{{ $item->check_out }}</td>
                    <td>{{ $item->rate_type->name }}</td>
                    <td>{{ $item->booking_agency->name }}</td>
                    <td>{{ $item->payment_method->name }}</td>
                    <td>{{ $item->overnights }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('guest-payment-folio', ['id' => $item->id]) }}" type="button" class="btn btn-outline-info btn-xs"><i class="fa fa-folder-open"></i></a>

                            <a href="{{ route('edit-reservation', ['id' => $item->id]) }}" type="button" class="btn btn-outline-primary">
                                <i class="fa fa-edit"></i></a>

                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>
@endsection
