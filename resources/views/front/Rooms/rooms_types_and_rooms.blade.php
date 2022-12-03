@extends('layouts.master')
@push('styles')
    <style type="text/css">
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

        .dataTables_filter input {
            width: 300px !important;
        }

        .roomcapacity_span,
        .selectedroomtype,
        .editroomType,
        .editRoom,
        .roomStatus,
        .deleteroom,
        .deleteroomType,
        .sortRoomtype {
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    @livewire('rooms.rooms-type-and-rooms')
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            //........disable default order function in room type table and customize toolbar...........
            var roomtypesTable = $("#typesTable").DataTable({

                ordering: false,
                "dom": '<"toolbar">frtip',
                "language": {
                    "emptyTable": "No room types available. Why not create a new one!"
                }
            });
            // $("div.toolbar", roomtypesTable.table().container()).html('<div class=" w-50 float-left"><button onclick="javascript:location.reload();"  class="float-left submit-button btn btn-primary rounded-circle mr-5" ><i style="font-size:18px" class="fa">&#xf021;</i></button><button class="btn btn-primary font-weight-bolder " id="addroomType"><i class="fa fa-plus text-light" aria-hidden="true"></i>&nbsp;New Room Type</button></div>');



            // ........hide occupancy fields by default for add and edit forms...........
            $("#channex_msg").hide();
            $("#adultdiv").hide();
            $("#kidsdiv").hide();
            $("#infantsdiv").hide();
            $("#defaultdiv").hide();
            $("#edit_channex_msg").hide();
            $("#editadultdiv").hide();
            $("#editkidsdiv").hide();
            $("#editinfantsdiv").hide();
            $("#editdefaultdiv").hide();
            $("#roomsTableCard").hide();

            $("#roomtypesTableCard").on('click', '#addroomType', function() {
                $("#addRoomtypeModal").modal('show');
            })

            $("#roomsTableCard").on('click', '#addRoom', function() {
                $("#addRoomModal").modal('show');
            })

            // .........hide show occupancy fields wrt checkbox...........
            $("#confirm_connection").on('change', function() {
                var confirmValue = document.getElementById("confirm_connection");

                if (confirmValue.checked == true) {
                    console.log("value is checked");
                    $("#channex_msg").show();
                    $("#adultdiv").show();
                    $("#kidsdiv").show();
                    $("#infantsdiv").show();
                    $("#defaultdiv").show();

                } else {
                    $("#channex_msg").hide();
                    $("#adultdiv").hide();
                    $("#kidsdiv").hide();
                    $("#infantsdiv").hide();
                    $("#defaultdiv").hide();
                }
            })

            // ........change status of room type..........
            $(".roomtypesTable").on('change', '.roomtypeStatus', function() {
                var currentRoomtypeid = $(this).attr("data-roomtype");
                var typestatus = '';
                if ($(this).is(':checked')) {
                    typestatus = 1;
                } else {
                    typestatus = 0;
                }

                Swal.fire({
                    icon: 'warning',
                    title: 'Are you sure?',
                    text: 'Do you want to change the status of this room type',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('room-type-status.update') }}",
                            type: "POST",
                            data: {
                                "id": currentRoomtypeid,
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

            // ..........show edit room type............

            $(".roomtypesTable").on('click', '.editroomType', function() {
                var this_roomtypeid = $(this).attr("data-value");
                $.ajax({
                    url: "{{ route('room-types-data.fetch') }}",
                    type: "POST",
                    data: {
                        "id": this_roomtypeid
                    },
                    success: function(data) {
                        // console.log(data[0].name);
                        let ctypename = data.name;
                        let cdescription = data.description;
                        let creferenceCode = data.reference_code;
                        let isconnected = (data.channex_room_type_id) ? 'Yes' : 'No';
                        let cadults = data.adults_channex;
                        let ckids = data.kids_channex;
                        let cinfants = data.infants_channex;
                        let default_occupancy = data.default_occupancy_channex;
                        document.getElementById("editroomtypeName").value = ctypename;
                        document.getElementById("editroomtypeDescription").value = cdescription;
                        document.getElementById("editroomtypeReferenceCode").value =
                            creferenceCode;
                        document.getElementById("edit_confirm_connection").innerHTML =
                            isconnected;
                        document.getElementById("editoccAdult").value = cadults;
                        document.getElementById("editoccKids").value = ckids;
                        document.getElementById("editoccInfants").value = cinfants;
                        document.getElementById("editoccdefault").value = default_occupancy;


                        document.getElementById("RoomtypeId").value = this_roomtypeid;
                        if (isconnected == "Yes") {
                            $("#edit_channex_msg").show();
                            $("#editadultdiv").show();
                            $("#editkidsdiv").show();
                            $("#editinfantsdiv").show();
                            $("#editdefaultdiv").show();
                        } else {
                            $("#edit_channex_msg").hide();
                            $("#editadultdiv").hide();
                            $("#editkidsdiv").hide();
                            $("#editinfantsdiv").hide();
                            $("#editdefaultdiv").hide();
                        }
                        $("#editRoomtypeModal").modal('show');

                    }
                })
            })

            // ............edit room type save................
            $("#editRoomtypebtn").on('click', function() {
                let typeid = document.getElementById("RoomtypeId").value;
                let typename = document.getElementById("editroomtypeName").value;
                let typeDescription = document.getElementById("editroomtypeDescription").value;
                let typeReference = document.getElementById("editroomtypeReferenceCode").value;
                let typeconnected = document.getElementById("edit_confirm_connection").innerHTML;
                let adults = document.getElementById("editoccAdult").value;
                let kids = document.getElementById("editoccKids").value;
                let infants = document.getElementById("editoccInfants").value;
                let defaultOccupancy = document.getElementById("editoccdefault").value;

                let data = [];
                let values = {
                    "id": typeid,
                    "name": typename,
                    "description": typeDescription,
                    "reference_code": typeReference,
                    "channex_room_type_id": typeconnected,
                    "adults_channex": adults,
                    "kids_channex": kids,
                    "infants_channex": infants,
                    "default_occupancy_channex": defaultOccupancy
                }
                data = values;
                console.log(data);
                $.ajax({
                    url: "{{ route('room-type.update') }}",
                    type: "POST",
                    data: {
                        data: JSON.stringify(data)
                    },
                    success: function(args) {
                        console.log(args);
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

                                // location.reload();
                            });
                        }
                    }
                })

            })

            // ................delete room type...................
            $(".roomtypesTable").on('click', '.deleteroomType', function() {
                var this_roomtypeid = $(this).attr("data-value");

                Swal.fire({
                    icon: 'warning',
                    // title:'Are you sure?',
                    title: 'If you delete, all data of this room type will be lost. Do you still want to proceed?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('room-type.destroy') }}",
                            type: "POST",
                            data: {
                                "id": this_roomtypeid
                            },
                            success: function(args) {
                                console.log(args);
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

            $(".roomtypesTable").on('click', '.sortRoomtype', function() {
                var this_roomtypeid = $(this).attr("data-value");
                $.ajax({
                    url: "{{ route('room-types-data.fetch') }}",
                    type: "POST",
                    data: {
                        "id": this_roomtypeid
                    },
                    success: function(data) {
                        console.log(data);
                        let roomtypename = data.name;
                        let roomtypeposition = data.position;
                        let roomtypeid = data.id;
                        document.getElementById("sortedRoomtypename").value = roomtypename;
                        document.getElementById("positionRoomtype").value = roomtypeposition;
                        document.getElementById("sortedRoomtypeid").innerHTML = roomtypeid;
                        $("#rtpositionModal").modal('show');
                    }
                })

            })
            $("#updateroomtypePosition").on('click', function() {
                var roomtypeid = document.getElementById("sortedRoomtypeid").innerHTML;
                var typeposition = document.getElementById("positionRoomtype").value;
                $.ajax({
                    url: "{{ route('room-types-position.update') }}",
                    type: "POST",
                    data: {
                        "id": roomtypeid,
                        "position": typeposition
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.result == "OK") {
                            Swal.fire({

                                icon: 'success',
                                text: data.message

                            }).then(function() {

                                location.reload();
                            });
                        } else {
                            Swal.fire({

                                icon: 'error',
                                text: data.message

                            }).then(function() {

                                location.reload();
                            });
                        }
                    }
                })
            })


            // ...........add room function.........
            $("#addRoombtn").on('click', function() {
                let roomnumber = document.getElementById("addroomno").value;
                let doccupancy = document.getElementById("addoccupancy").value;
                let radults = document.getElementById("addadults").value;
                let rkids = document.getElementById("addkids").value;
                let rinfants = document.getElementById("addinfants").value;
                let rroomtypeid = document.getElementById("selected_roomtype_id").innerHTML;
                if (roomnumber === "" || doccupancy === "" || radults === "" || rkids === "" || rinfants ===
                    "") {
                    alert("Please fill all the fields");
                } else {
                    var data = [];
                    var values = {
                        "rid": rroomtypeid,
                        "rno": roomnumber,
                        "occupancy": doccupancy,
                        "adults": radults,
                        "kids": rkids,
                        "infants": rinfants
                    }
                    data = values;
                    $.ajax({
                        url: "{{ route('room.create') }}",
                        type: "POST",
                        data: {
                            data: JSON.stringify(data)
                        },
                        success: function(args) {
                            console.log(args);
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
                }

            })

            // ..........show edit room ............

            $("#roomsTableBody").on('click', '.editRoom', function() {
                var this_roomid = $(this).attr("data-value");
                $.ajax({
                    url: "{{ route('room.fetch') }}",
                    type: "POST",
                    data: {
                        "id": this_roomid
                    },
                    success: function(data) {
                        console.log(data);
                        let croomnumber = data.number;
                        let coccupancy = data.max_capacity;
                        let cadults = data.max_adults;
                        let ckids = data.max_kids;
                        let cinfants = data.max_infants;
                        document.getElementById("editroomno").value = croomnumber;
                        document.getElementById("editoccupancy").value = coccupancy;
                        document.getElementById("editadults").value = cadults;
                        document.getElementById("editkids").value = ckids;
                        document.getElementById("editinfants").value = cinfants;
                        document.getElementById("editroomid").value = this_roomid;

                        $("#editRoomModal").modal('show');

                    }
                })
            })

            // ...........edit room save...............
            $("#editRoombtn").on('click', function() {
                let roomnumber = document.getElementById("editroomno").value;
                let doccupancy = document.getElementById("editoccupancy").value;
                let radults = document.getElementById("editadults").value;
                let rkids = document.getElementById("editkids").value;
                let rinfants = document.getElementById("editinfants").value;
                let rroomid = document.getElementById("editroomid").value;
                if (roomnumber === "" || doccupancy === "" || radults === "" || rkids === "" || rinfants ===
                    "") {
                    alert("Please fill all the fields");
                } else {
                    var data = [];
                    var values = {
                        "rid": rroomid,
                        "roomno": roomnumber,
                        "occupancy": doccupancy,
                        "adults": radults,
                        "kids": rkids,
                        "infants": rinfants
                    }
                    data = values;
                    console.log(data);
                    $.ajax({
                        url: "{{ route('room.update') }}",
                        type: "POST",
                        data: {
                            data: JSON.stringify(data)
                        },
                        success: function(args) {
                            console.log(args);
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
                }

            })

            // ..............delete room........................
            $("#roomsTableBody").on('click', '.deleteroom', function() {
                let currentRoomid = $(this).attr("data-value");
                let currentRoomtypeid = $(this).attr("data-roomtype");
                Swal.fire({
                    icon: 'warning',
                    title: 'If you delete, all data of this room will be lost. Do you still want to proceed?  ',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {

                        $.ajax({
                            url: "{{ route('room.destroy') }}",
                            type: "POST",
                            data: {
                                "roomid": currentRoomid,
                                "roomtypeid": currentRoomtypeid
                            },
                            success: function(args) {
                                console.log(args);
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


            // ........change status of room..........
            $("#roomsTableBody").on('change', '.roomStatus', function() {
                var currentRoomid = $(this).attr("data-room");
                var currentRoomtypeId = $(this).attr("data-roomtype");
                var roomstatus = '';
                if ($(this).is(':checked')) {
                    roomstatus = "Enabled";
                } else {
                    roomstatus = "Disabled";
                }

                Swal.fire({
                    icon: 'warning',
                    title: 'Are you sure?',
                    text: 'Do you want to change status of this room',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.value) {
                        var data = [];
                        var values = {
                            "roomid": currentRoomid,
                            "roomtypeid": currentRoomtypeId,
                            "status": roomstatus
                        }
                        data = values;
                        $.ajax({
                            url: "{{ route('room-status.update') }}",
                            type: "POST",
                            data: {
                                data: JSON.stringify(data)
                            },
                            success: function(args) {
                                console.log(args);
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

            // ..........handle click for room types and showing corresponding rooms..........
            $(".roomtypesTable").on('click', '.selectedroomtype', function() {
                var clickedRoomtypeid = $(this).attr("data-value");
                console.log("y id is " + clickedRoomtypeid);
                showRooms(clickedRoomtypeid);

            })

            // ..........handle click for room occupancy and showing additional occupancy..........
            $("#roomsTableBody").on('click', '.roomcapacity_span', function() {
                var clickedRoomid = $(this).attr("data-value");
                console.log("y id is " + clickedRoomid);
                showCapacityInfo(clickedRoomid);

            })




            $("#addRoomtypebtn").click(function() {
                var room_type_name = document.getElementById("roomtypeName").value;
                var room_type_reference_code = document.getElementById("roomtypeReferenceCode").value;
                var room_type_description = document.getElementById("roomtypeDescription").value;
                var room_type_rooms = document.getElementById("roomtypeRooms").value;
                var occupancy_adults = document.getElementById("occAdult").value;
                var occupancy_kids = document.getElementById("occKids").value;
                var occupancy_infants = document.getElementById("occInfants").value;
                var defaultOccupancy = document.getElementById("occdefault").value;
                var confirmValue = document.getElementById("confirm_connection");

                // ......it will run if want to connect room type to channex.........
                if (confirmValue.checked == true) {

                    if (room_type_name === "" || room_type_description === "" ||
                        room_type_reference_code === "" || room_type_rooms === "" || occupancy_adults ===
                        "" || occupancy_kids === "" || occupancy_infants === "" || defaultOccupancy === ""
                    ) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Missing Data',
                            text: 'Please fill all fields before proceeding'
                        });
                    } else {
                        var data = [];
                        var values = {
                            "typename": room_type_name,
                            "description": room_type_description,
                            "referencecode": room_type_reference_code,
                            "totalrooms": room_type_rooms,
                            "connect_to_channex": "yes",
                            "adults": occupancy_adults,
                            "kids": occupancy_kids,
                            "infants": occupancy_infants,
                            "default_occupancy": defaultOccupancy
                        };
                        console.log(JSON.stringify(data));
                        $.ajax({
                            type: "POST",
                            url: "{{ route('room-type.create') }}",
                            data: values,
                            success: function(args) {
                                console.log(args);
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

                                        // location.reload();
                                    });
                                }


                            }
                        })
                    }

                }
                // ......... it will run when room type will not connect to channex..........
                else {

                    if (room_type_name === "" || room_type_description === "" ||
                        room_type_reference_code === "" || room_type_rooms === "") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Missing Data',
                            text: 'Please fill all fields before proceeding'
                        });
                    } else {
                        var data = [];
                        var values = {
                            "typename": room_type_name,
                            "description": room_type_description,
                            "referencecode": room_type_reference_code,
                            "totalrooms": room_type_rooms,
                            "connect_to_channex": "no"
                        };
                        console.log(JSON.stringify(data));
                        $.ajax({
                            type: "POST",
                            url: "{{ route('room-type.create') }}",
                            data: values,
                            success: function(args) {
                                console.log(args);
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

                                        // location.reload();
                                    });
                                }


                            }
                        })
                    }
                }
            })


            function showRooms(roomtypeid) {
                var thisRoomtypeid = roomtypeid;
                // if ($.fn.DataTable.isDataTable("#roomsTable")) {
                // 	$("#roomsTable").DataTable().destroy();
                // }
                // roomTable.destroy();
                console.log("clicked id is " + thisRoomtypeid);
                $.ajax({
                    url: "{{ route('rooms-for-roomtype.fetch') }}",
                    type: "POST",
                    data: {
                        "id": thisRoomtypeid
                    },
                    success: function(args) {
                        console.log(args);
                        document.getElementById("roomsTableBody").innerHTML = "";
                        document.getElementById("selected_roomtype_name").innerHTML = args.roomtype;
                        document.getElementById("selected_roomtype_id").innerHTML = thisRoomtypeid;
                        for (var i = 0; i < args.rooms.length; i++) {
                            let this_roomid = args.rooms[i].id;

                            let this_roomnumber = args.rooms[i].number;
                            let this_occupancy = args.rooms[i].max_capacity;
                            let adults = args.rooms[i].max_adults;
                            let kids = args.rooms[i].max_kids;
                            let infants = args.rooms[i].max_infants;
                            let this_status = args.rooms[i].status;
                            let this_roomtypeid = args.rooms[i].room_type_id;
                            let checkedValue = '';
                            if (this_status == "Enabled") {
                                checkedValue = 'checked';
                            }
                            let row =
                                "<tr><td class=''>" +
                                this_roomnumber +
                                " </td><td class=''><span class='roomcapacity_span' data-value='" +
                                this_roomid + "'>A:" + adults + " K:" + kids + " I:" + infants +
                                "</span></td><td class='' nowrap='nowrap'>" +
                                "<span class='infbtn'><i class='fas fa-edit editRoom' style='' data-value='" +
                                this_roomid +
                                "'></i></span> " +
                                "<span class='infbtn'><i class='fa fa-trash deleteroom' aria-hidden='true' style='' data-value='" +
                                this_roomid + "' data-roomtype='" + this_roomtypeid +
                                "'></i></span></td><td class=''><Button class='btn '>" +
                                "<input type='checkbox' class='checkbox roomStatus' data-roomtype='" +
                                this_roomtypeid + "' data-room='" +
                                this_roomid + "' id='room" + this_roomid +
                                "' " + checkedValue + "/><label class='label' for='room" + this_roomid +
                                "'><div class='ball'></div></label></Button></td></tr>";
                            document.getElementById("roomsTableBody").innerHTML += row;
                        }

                        $("#roomsTableCard").show();
                        var roomTable = $("#roomsTable").DataTable({

                            ordering: false,
                            destroy: true,
                            "dom": '<"toolbar">frtip',
                            "language": {
                                "emptyTable": "No room available. Why not create a new one!"
                            }
                        });
                        $("div.toolbar", roomTable.table().container()).html(
                            '<div class=" w-50 float-left"><button onclick="javascript:location.reload();" class="float-left submit-button btn btn-primary rounded-circle mr-5" ><i style="font-size:18px" class="fa">&#xf021;</i></button><button class="btn btn-primary font-weight-bolder " id="addRoom"><i class="fa fa-plus text-light" aria-hidden="true"></i>&nbsp;New Room</button></div>'
                        );


                        // roomTable.draw();

                    }
                })
            }

            function showCapacityInfo(roomid) {
                var thisRoomid = roomid;
                $.ajax({
                    url: "get_capacity_info.php",
                    type: "POST",
                    data: {
                        "roomid": thisRoomid
                    },
                    success: function(args) {
                        // console.log(args);
                        $("#maxadults").html(args[0].adults);
                        $("#maxkids").html(args[0].kids);
                        $("#maxinfants").html(args[0].infants);
                        $("#occModal").modal('show');
                    }
                })
            }

        })
    </script>
@endpush
