@extends('layouts.master')
@section('content')
    @livewire('finance.budget.hotel-actual', key(time()))
@endsection

