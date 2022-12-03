@extends('layouts.master')
@section('content')
    <div class="d-flex flex-column-fluid mt-5">
        <div class="container-fluid">
            @livewire('reservations.create-service',['r_id'=>$reservation_id, 'receipt_number'=>$receipt_number])
        </div>
    </div>
@endsection

