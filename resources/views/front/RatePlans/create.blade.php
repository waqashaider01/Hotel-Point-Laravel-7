@extends('layouts.master')

@push('styles')
    <style type="text/css">
        .form-style-6 input[type="text"], .form-style-6 input[type="date"], .form-style-6 input[type="month"], .form-style-6 input[type="datetime"], .form-style-6 input[type="email"], .form-style-6 input[type="number"], .form-style-6 input[type="search"], .form-style-6 input[type="time"], .form-style-6 input[type="url"], .form-style-6 input[type="password"], .form-style-6 textarea, .form-style-6 select {
            margin-bottom: 0;
        }
        .infocard {
            background-color: white;
            width: 100%;
            height: 100%;
            padding: 0%;
            border-radius: 0px;
        }

        hr {
            border: 1px solid #D5D8DC;
            margin-left: 0%;
            margin-right: 0%;
        }

        .littlestyle {
            max-width: 170px !important;
            min-width: 170px !important;
        }

        .infbtn {
            border: 1px solid #D5D8DC;
            border-radius: 2px;
            padding: 3px 10px 3px 10px;
            font-size: 14px;
            margin-right: 5px;

        }

        .infbtn i {
            font-size: 20px;
            color: #ABB2B9;
        }

        a {
            text-decoration: none;
            color: black;
        }

        a:hover {
            color: black !important;
        }

        .ratebtn {
            background-color: white;
            border: 1px solid #ABB2B9;
            border-radius: 1px;
            min-width: 100%;
            text-align: center;
            max-width: 100%;
            padding-top: 5%;
            padding-bottom: 5%;
            color: black;
        }

        .ratebtn.active,
        .ratebtn:focus {
            box-shadow: 0 0 5px #43D1AF;
            border: 1px solid #43D1AF;
        }

        .littlestyle {
            max-width: 30% !important;
            min-width: 30% !important;
        }

        .perstyle {
            max-width: 60% !important;
            min-width: 60% !important;
        }

        .tooltip .tooltip-arrow {
            border-top-color: #4adede;
        }

    </style>
@endpush


@section('content')
    @livewire('rate-plan.create-rate-plan', array('rate_plan'=>null))
@endsection


