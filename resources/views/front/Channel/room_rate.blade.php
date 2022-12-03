@extends('layouts.master')
@section('content')
<div class="container-fluid">

    <div class="card card-custom" style="background: transparent; margin:0px; padding: 0px;">

        <div class="container-fluid" style="background: transparent; margin:0px; padding: 0px;">

            <div id="iframecontainer" style="width: 100%; height: 100vh;">


                <!--------------------------- begin iframe ------------------------------>
                <iframe id="rrframe" frameBorder="0" hspace="0" vspace="0" style="min-width: 100% !important; height: auto !important; min-height: 100%;  border: none;  padding: 0px !important;" src="">

                </iframe>
            </div>
        </div>
    </div>
    <!--end::Card-->

</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {

        $.ajax({
            url: "{{ route('channex-otp.get') }}",
            type: "get",
            success: function(args) {
                if (args == 'reload')
                        window.location.reload();
                var propertyid = args.propertyid;
                var accesstoken = args.onetimeToken;
                var iframeRef = "https://staging.channex.io/auth/exchange?oauth_session_key=" + accesstoken +
                    " &app_mode=headless&redirect_to=/rooms&property_id=" + propertyid;

                $("#rrframe").attr("src", iframeRef);
            }
        })

    })
</script>
@endpush
