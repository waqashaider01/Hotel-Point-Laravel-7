@extends('layouts.master')
@push('styles')
    <style>
        .infocard {
            background-color: white;
            width: 100%;
            height: 100%;
            padding: 2%;
        }

        label {
            color: #D5D8DC;
            font-size: 12px;
        }

        span {
            font-size: 14px;

        }

        .infbtn {
            border: 1px solid #D5D8DC;
            border-radius: 7px;
            padding: 3px 10px 3px 10px;
            font-size: 14px;
            margin-right: 5px;

        }

        .infbtn i {
            font-size: 20px;
            color: #ABB2B9;
        }

        i {
            font-size: 20px;
            color: #ABB2B9;
        }

        .togglegreen {
            color: white;
            background-color: #3F8843;
            padding: 3px;
            border-radius: 4px;
            font-size: 12px;
        }

        hr {
            border: 1px solid #D5D8DC;
            margin-left: -2%;
            margin-right: -2%;
        }

        .darker {
            background-color: #EAECEE;
            border-radius: 5px 5px 0px 0px;
            font-size: 14px;
            padding: 10px;
        }

        .lighter {
            border: 1px solid #D5D8DC;
            border-radius: 0px 0px 5px 5px;
            font-size: 14px;
            padding: 10px;
        }

        a {
            text-decoration: none;
            color: black;
        }

        a:hover {
            color: black !important;
        }

        .paymentdisplay {
            display: block !important;
        }

        h1 {
            text-align: center;
        }

        .form-control2 {
            border-radius: 3px;
            height: 30px;
            width: 170px !important;
            border: 1px solid gray;
            background-color: #F5F7F9 !important;

        }

        .checkbox {
            opacity: 0;
            position: absolute;
        }

        .label {
            background-color: #111;
            border-radius: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 5px;
            position: relative;
            height: 18px;
            width: 40px;
            transform: scale(1.5);
        }

        .label .ball {
            background-color: #fff;
            border-radius: 50%;
            position: absolute;
            top: 2px;
            left: 2px;
            height: 14px;
            width: 15px;
            transform: translateX(0px);
            transition: transform 0.2s linear;
        }

        .checkbox:checked+.label .ball {
            transform: translateX(20px);
        }

        .checkbox:checked+.label {
            background-color: #3cb371;
        }

        .checkbox:not(:checked)+.label {
            background-color: #dedede;
        }


        .infocard {
            background-color: white;
            width: 100%;
            height: 100%;
            padding: 2%;
            /* margin-bottom: 7%; */
        }

        label {
            color: #D5D8DC;
            font-size: 12px;
        }

        span {
            font-size: 14px;

        }

        .infbtn {
            border: 1px solid #D5D8DC;
            border-radius: 7px;
            padding: 3px 10px 3px 10px;
            font-size: 14px;
            margin-right: 5px;

        }

        .infbtn i {
            font-size: 20px;
            color: #ABB2B9;
        }

        i {
            font-size: 20px;
            color: #ABB2B9;
        }

        .togglegreen {
            color: white;
            background-color: #3F8843;
            padding: 3px;
            border-radius: 4px;
            font-size: 12px;
        }

        hr {
            border: 1px solid #D5D8DC;
            margin-left: -2%;
            margin-right: -2%;
        }

        .hr {
            margin-left: 0px !important;
            margin-right: 0px !important;
            margin-bottom: 0px !important;
            margin-top: 30px !important;
        }

        .darker {
            background-color: #EAECEE;
            border-radius: 5px 5px 0px 0px;
            font-size: 14px;
            padding: 10px;
        }

        .lighter {
            border: 1px solid #D5D8DC;
            border-radius: 0px 0px 5px 5px;
            font-size: 14px;
            padding: 10px;
        }

        a {
            text-decoration: none;
            color: black;
        }

        a:hover {
            color: black !important;
        }

        .paymentdisplay {
            display: block !important;
        }

        h1 {
            text-align: center;
        }

        .form-control2 {
            border-radius: 3px;
            height: 30px;
            width: 170px !important;
            border: 1px solid gray;
            background-color: #F5F7F9 !important;

        }

        .mainboxdiv {
            width: 100%;
            height: 100%;
            /*background-color:red;*/
            border: 2px solid #D5D8DC;
            ;
            border-radius: 2px;
            padding-top: 30px;
        }

        ::-webkit-datetime-edit-year-field:not([aria-valuenow]),
        ::-webkit-datetime-edit-month-field:not([aria-valuenow]),
        ::-webkit-datetime-edit-day-field:not([aria-valuenow]) {
            color: transparent;
        }

        input[type=date]:required:invalid::-webkit-datetime-edit {
            color: transparent;
        }

        input[type=date]:focus::-webkit-datetime-edit {
            color: black !important;
        }




        .body {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        span.switcher {
            position: relative;
            width: 100px;
            height: 25px;
            border-radius: 13px;
            margin: 10px 0;
        }

        span.switcher input {
            appearance: none;
            position: relative;
            width: 100px;
            height: 25px;
            border-radius: 13px;
            background-color: #48BBBE;
            outline: none;
            font-family: 'Oswald', sans-serif;
        }

        span.switcher input:before,
        body span.switcher input:after {
            z-index: 2;
            position: absolute;
            top: 25%;
            transform: translateY(-50%);
            color: #fff;
        }

        span.switcher input:before {
            bottom: 5px;
            content: 'ON';
            left: 10px;
        }

        span.switcher input:after {
            bottom: 5px;
            content: 'OFF';
            right: 10px;
        }

        span.switcher label {
            z-index: 1;
            position: absolute;
            top: 3px;
            bottom: -1px;
            border-radius: 10px;
        }

        span.switcher.switcher-1 input {
            transition: 0.25s -0.1s;
        }

        span.switcher.switcher-1 input:checked {
            background-color: #fff;
        }

        span.switcher.switcher-1 input:checked:before {
            color: #fff;
            transition: color 0.5s 0.2s;
        }

        span.switcher.switcher-1 input:checked:after {
            color: #ccc;
            transition: color 0.5s;
        }

        span.switcher.switcher-1 input:checked+label {
            left: 5px;
            right: 50px;
            background: #48BBBE;
            transition: left 0.5s, right 0.4s 0.2s;
        }

        span.switcher.switcher-1 input:not(:checked) {
            background: #48BBBE;
            transition: background 0.5s -0.1s;
        }

        span.switcher.switcher-1 input:not(:checked):before {
            color: #ccc;
            transition: color 0.5s;
        }

        span.switcher.switcher-1 input:not(:checked):after {
            color: #48BBBE;
            transition: color 0.5s 0.2s;
        }

        span.switcher.switcher-1 input:not(:checked)+label {
            left: 50px;
            right: 5px;
            background: #fff;
            transition: left 0.4s 0.2s, right 0.5s, background 0.35s -0.1s;
        }

        span.switcher.switcher-2 {
            overflow: hidden;
        }

        span.switcher.switcher-2 input {
            transition: background-color 0s 0.5s;
        }

        span.switcher.switcher-2 input:before {
            color: #48BBBE;
        }

        span.switcher.switcher-2 input:after {
            color: #fff;
        }

        span.switcher.switcher-2 input:checked {
            background-color: #fff;
        }

        span.switcher.switcher-2 input:checked+label {
            background: #fff;
            animation: turn-on 0.5s ease-out;
        }

        @keyframes turn-on {
            0% {
                left: 100%;
            }

            100% {
                left: 0%;
            }
        }

        span.switcher.switcher-2 input:not(:checked) {
            background: #48BBBE;
        }

        span.switcher.switcher-2 input:not(:checked)+label {
            background: #48BBBE;
            animation: turn-off 0.5s ease-out;
        }

        @keyframes turn-off {
            0% {
                right: 100%;
            }

            100% {
                right: 0%;
            }
        }

        span.switcher.switcher-2 label {
            top: 0px;
            width: 100px;
            height: 25px;
            border-radius: 25px;
        }
    </style>
@endpush
@section('content')
    @livewire('settings.main', ['hotel' => $hotel->id])
@endsection
