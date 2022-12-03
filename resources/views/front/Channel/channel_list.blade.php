@extends('layouts.master')
@section('content')
    @livewire('channels')
@endsection
@push('scripts')
    <script>
        //document ready
        /* $(document).ready(function () {
            const originalVal = $('#chanrge_days_input').val();
            $('#chanrge_mode_select').on('change', function () {
                var charge_mode = $(this).val();
                if (charge_mode == 'onarrival') {
                    $('#chanrge_days_input').val('0');
                    $('#chanrge_days_input').attr('readonly', true);
                } else {
                    $('#chanrge_days_input').val(originalVal);
                    document.getElementById('chanrge_days_input').removeAttribute('readonly');
                }
            });
        }); */
    </script>   
@endpush
