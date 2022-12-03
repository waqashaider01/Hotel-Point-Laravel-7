@extends('layouts.master')
@section('content')
    @livewire('reservations.cancelled-reservation-print-document', ['reservation' => $reservation])
@endsection
