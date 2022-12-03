@extends('layouts.master')
@section('content')
    <div class="d-flex flex-column-fluid mt-5">
        <div class="container-fluid">
            <div class="row mb-10">
                <div class="col">
                    @livewire('finance.home.reservation-fee', ['reservationId' => $reservationId])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).click(function(event) {

                if ($(event.target).hasClass("print-document-btn")) {
                    console.log("Click");
                    livewire.emit("loading", true);
                }
            });
        });
    </script>
@endpush
