@extends('layouts.master')

@push('styles')
    <style type="text/css">
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

        .fa-list {
            margin-left: 45%;
            margin-top: -8%;
            font-size: 30px;
            background-color: #48BBBE;
            border: 5px solid #F5F7F9;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

    </style>
@endpush

@section('content')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid mt-5">
        <!--begin::Container-->
        <div class="container-fluid">
            <div class="listcard">
                <div class=""
                    style=" background-color:#48BBBE;margin-top:-2.1% !important;color:white;
                        margin-bottom:100px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;">
                    <h2 class="pt-7 pl-3 pb-7">Rate Plans List</h2>
                </div>
                <i class="fas fa-list"></i>
                <div class="">

                    <div class="row">
                        <div class="col-10">
                        </div>
                        <div class="col-2 ">
                            <div style="float:right;">
                                <a href="{{ route('rate-plans.create') }}" id="addnew" name='goo'
                                    style='background-color:#48BD91;padding:2px 12px;color:white;border:none !important;border-radius:2px;'>New
                                    Rate Plan </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
                 <div class="card mt-10">
                        <div class="card-body">
                            <div class="table-responsive" wire:ignore>
                                <table id="dataTableExample" class="table">
                                    <thead>
                                        <tr>
                                            <th>Rate Name</th>
                                            <th>Meal Category</th>
                                            <th>Room Type</th>
                                            <th>Cancellation Policy</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ratetypes as $rate)
                                        <tr>
                                            <td class='idcolor'><a href="{{ route('rate-plans.edit', $rate->rate_id) }}"
                                                    type='button' class='idcolor text-capitalize'>{{ $rate->rate_type_name }}</a>
                                            </td>
                                            <td> {{ $rate->meal_category_name }}
                                            </td>
                                            <td> {{ $rate->room_type_name }}
                                            </td>
                                            <td> {{ $rate->policy_name }}
                                            </td>
                                            <td >
                                                <Button class='btn '>
                                                    <input type='checkbox' class='checkbox ratetypeStatus'
                                                        data-ratetype='{{ $rate->rate_id }}' id='type.{{ $rate->rate_id }}'
                                                        {{ $rate->rate_status ? 'checked' : '' }} />
                                                    <label class='label' for='type.{{ $rate->rate_id }}'>
                                                        <div class='ball'></div>
                                                    </label>
                                                </Button>

                                            </td>
                                            <td nowrap='nowrap'>
                                                <span type='button' onclick='deleteRate({{ $rate->rate_id }})' class=''
                                                    style='background-color:#48BBBE;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;margin-left:3px;'><i
                                                        class='fas fa-trash-alt text-light'></i> </span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--begin: Datatable-->
                    {{-- <div class="table mt-10 text-center " id='reservations-table'>
                        <div>
                            <div class="row th text-center">
                                <div class="col">Rate Name</div>
                                <div class="col">Meal Category</div>
                                <div class="col">Room Type</div>
                                <div class="col">Cancellation Policy</div>
                                <div class="col">Status</div>
                                <div class="col">Action</div>
                            </div>
                        </div>


                        @foreach ($ratetypes as $rate)
                            <div class='row mytr text-center'>
                                <div class='col idcolor'><a href='{{ route('rate-plans.edit', $rate->rate_id) }}'
                                        type='button' class='idcolor text-capitalize'>{{ $rate->rate_type_name }}</a>
                                </div>
                                <div class='col '> {{ $rate->meal_category_name }}
                                </div>
                                <div class='col '> {{ $rate->room_type_name }}
                                </div>
                                <div class='col '> {{ $rate->policy_name }}
                                </div>
                                <div class='col'>
                                    <Button class='btn '>
                                        <input type='checkbox' class='checkbox ratetypeStatus'
                                            data-ratetype='{{ $rate->rate_id }}' id='type.{{ $rate->rate_id }}'
                                            {{ $rate->rate_status ? 'checked' : '' }} />
                                        <label class='label' for='type.{{ $rate->rate_id }}'>
                                            <div class='ball'></div>
                                        </label>
                                    </Button>

                                </div>
                                <div class='col' nowrap='nowrap'>
                                    <span type='button' onclick='deleteRate({{ $rate->rate_id }})' class=''
                                        style='background-color:#48BBBE;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;margin-left:3px;'><i
                                            class='fas fa-trash-alt text-light'></i> </span>
                                </div>
                            </div>
                        @endforeach


                    </div> --}}


            <!--end: Datatable-->
        </div>
    </div>
    </div>
    <!--end::Container-->
    </div>
    <!--end::Entry-->
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        // var minposition = document.getElementById('minposition').innerHTML;
        // var lastposition = document.getElementById('lastposition').innerHTML;
        // var maxposition = document.getElementById('maxposition').innerHTML;
        // if (minposition == '1') {

        //     document.getElementById('pbtn').classList.remove('text-dark');
        // } else {

        //     document.getElementById('pbtn').classList.add('text-dark');
        // }
        // if (lastposition == maxposition) {
        //     document.getElementById('nbtn').classList.remove('text-dark');
        // } else {
        //     document.getElementById('nbtn').classList.add('text-dark');
        // }

        function backfunction() {
            //alert('previous');
            var lastposition = document.getElementById('minposition').innerHTML;
            lastposition = parseInt(lastposition);
            lastposition = lastposition - 10;
            if (lastposition >= 1) {
                location.replace("rate_plans.php?rowno=" + lastposition);
            } else {}
            //alert('previous'+lastposition);
        }

        function nextfunction() {
            var lastposition = document.getElementById('lastposition').innerHTML;
            var maxposition = document.getElementById('maxposition').innerHTML;
            lastposition = parseInt(lastposition);
            maxposition = parseInt(maxposition);
            lastposition = lastposition + 1;
            //alert('next'+lastposition);
            if (lastposition <= maxposition) {
                location.replace("rate_plans.php?rowno=" + lastposition);
            } else {}

        }


        function deleteRate(id) {
            var delid = id;
            Swal.fire({
                icon: 'warning',
                // title:'Are you sure?',
                title: 'Are you sure?. Do you want to delete this rate type?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "delete",
                        url: `/rate-plans/${delid}`,
                        success: function(response) {
                            if (response.result == "OK") {
                                Swal.fire({

                                    icon: 'success',
                                    title: response.message

                                }).then(function() {

                                    location.reload();
                                });
                            } else {
                                Swal.fire({

                                    icon: 'error',
                                    text: response.message

                                }).then(function() {

                                    location.reload();
                                });
                            }

                        }
                    });
                } else {
                    location.reload();
                }
            })
        }


        // ........change status of room type..........
        $(".ratetypeStatus").on('change', function() {
            var currentRatetypeid = $(this).attr("data-ratetype");
            var typestatus = '';
            if ($(this).is(':checked')) {
                typestatus = 1;
            } else {
                typestatus = 0;
            }
            console.log(" id " + currentRatetypeid + " status " + typestatus);

            Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: 'Do you want to change the status of this rate plan',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('rate-plans-status.updates') }}",
                        type: "POST",
                        data: {
                            "id": currentRatetypeid,
                            "status": typestatus
                        },
                        success: function(args) {
                            if (args.result == "OK") {
                                Swal.fire({

                                    icon: 'success',
                                    text: args.message

                                }).then(function() {

                                    location.reload();
                                });
                            } else {
                                Swal.fire({

                                    icon: 'error',
                                    text: args.message

                                }).then(function() {

                                    location.reload();
                                });
                            }
                        }
                    })

                } else {
                    location.reload();
                }
            })


        })
    </script>
@endpush
