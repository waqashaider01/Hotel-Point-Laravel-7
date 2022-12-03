@extends('layouts.master')
@section('content')
    <div class="d-flex flex-column-fluid mt-5">
        <div class="container-fluid">
            <div class="container-fluid">
                @livewire('settings.service-settings')
            </div>
        </div>
    </div>
@endsection
