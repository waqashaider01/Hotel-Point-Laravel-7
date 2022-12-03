@extends('layouts.master')
@push('styles')
    <style>
        .select2-container--default .select2-selection--single .select2-selection__arrow:after,
        .select2-container--default .select2-selection--multiple .select2-selection__arrow:after {
            font-family: 'Font Awesome 5 Free' !important;
            font-weight: normal;
            font-variant: normal;
            line-height: 1;
            text-decoration: inherit;
            text-rendering: optimizeLegibility;
            text-transform: none;
            -moz-osx-font-smoothing: grayscale;
            -webkit-font-smoothing: antialiased;
            font-smoothing: antialiased;
            content: "\f358" !important;
            font-size: 1rem !important;
            color: #7E8299;
        }
    </style>
@endpush
@section('content')
    @livewire('company-list')
@endsection
