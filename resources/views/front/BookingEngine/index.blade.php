@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid mt-5">
        <!--begin::Container-->
        <div class="container-fluid">

            <div class="card card-custom" style=" margin:0px; padding: 0px;">
                <div class="container-fluid" style=" margin:0px; padding: 0px;">
                    @if (count($agencies))
                        @foreach ($agencies as $agency)
                            <div id="iframecontainer1" style="width: 100%; min-height: 90vh; aspect-ratio: 16/9; background:white;">
                                <div class="row w-100 d-flex justify-content-center mt-3 mb-3">
                                    <h5 class="mr-3 mt-3">Booking Engine Link</h5><input id="linkinput" type="text"
                                        value="{{ config('services.booking_engine.url') }}/{{ $agency->channex_channel_id }}"
                                        style="width:35%; text-align:left;" class="btn btn-light" disabled />
                                    <button class="btn btn-dark mr-5" id="linkcopyicon" data-toggle="tooltip"
                                        data-placement="top" data-html="true" title="Copy the link"
                                        onclick="copyLinkToClipboard()" onmouseout="loadDefaultText()"><i
                                            class="fas fa-copy"></i></button>
                                </div>

                                <iframe id="bookingengineframe" frameBorder="0" hspace="0" vspace="0"
                                    style="min-width: 100% !important; height: auto !important; min-height: 100%;  border: none;  padding: 0px !important;"
                                    src="{{ config('services.booking_engine.url') }}/{{ $agency->channex_channel_id }}">

                                </iframe>
                            </div>
                        @endforeach
                    @else
                        <div style='width:100%; height:35vh; ' class=' bg-white text-center mb-5'>
                            <h1 style='margin-top:40vh;'>Oops!!!</h1>
                            <p>You don't have any instant booking page channel. Create channel first.</p>
                        </div>
                    @endif
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Entry-->
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        function copyLinkToClipboard() {

            var copiedText = document.getElementById("linkinput");
            copiedText.select();
            navigator.clipboard.writeText(copiedText.value);

            $("#linkcopyicon").attr('data-original-title', "Link copied!");
            $('[data-toggle="tooltip"]').tooltip('show');
        }

        function loadDefaultText() {

            $("#linkcopyicon").attr('data-original-title', "Copy the link");


        }
    </script>
@endpush
