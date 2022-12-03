@extends('layouts.master')
@section('content')
        @livewire('reservations.edit-create',['reservation_id'=>$id])
@endsection
