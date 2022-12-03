@extends('layouts.master')
@push('styles')
    <link href="{{ asset('css/calendar.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .mycstm {
            width: unset !important;
            height: unset !important;
            padding: .15em 1.1em;
        }

        .form-style-6 input[type="text"].date-inputs {
            display: inline-block;
            width: unset;
            min-width: 152px;
            margin-bottom: 0;
            height: 35px !important;
        }
        #calendar {
            border-collapse: collapse;
        }
        #tabbody td {
            min-width: 25px !important;
            max-width: unset !important;
            width: auto !important;
        }
        .reservdiv {
            position: relative !important;
            text-align: left;
            margin-top: 0 !important;
            margin-left: 0;
            font-size: 14px;
            text-indent: .5em;
            width: 100%;
            height: 37px;
            line-height: 37px;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            cursor: pointer;
        }
        .reservdiv::after {
            content: "";
            z-index: 1;
            position: absolute;
            top: 0;
            left: 0;
            width: 0%;
            height: 1000%;
            background: rgba(255, 255, 255);
            opacity: 0;
            transition: all 250ms ease;
        }
        .reservdiv:hover::after {
            opacity: 0.5;
            width: 100%;
        }
        .reservdiv .reservation-text {
            z-index: 2;
        }
        .reservdiv.out-of-order {
            background-color: rgb(0, 0, 0);
            color: rgb(255, 255, 255);
        }
        .reservdiv.badge-info {
            background-color: #007bff;
            color: #fff;
        }
        .reservdiv.badge-new,
        .reservdiv.badge-confirmed {
            background-color: #0b6623;
            color: #fff;
        }

        .reservdiv.badge-cancelled,
        .reservdiv.badge-no-show {
            background-color: #ff0000;
            color: #fff;
        }

        .reservdiv.badge-arrived {
            background-color: #fbc312;
            color: #333;
        }

        .reservdiv.badge-complimentary{
            background-color: #8950FC;
            color: #fff;
        }

        .reservdiv.badge-offer {
            background-color: #800080;
            color: #fff;
        }

        .reservdiv.badge-checked-out {
            background-color: #2f4f4f;
            color: #fff;
        }
        .nav.nav-pills .nav-link.active {
            background-color: #007bff !important;
            color: #fff;
        }
    </style>
@endpush
@section('content')
    @if(isset($calendar) && $calendar == 'super')
        @livewire('reservations.super-calendar')
    @else
        @livewire('reservations.calendar')
    @endif
@endsection
