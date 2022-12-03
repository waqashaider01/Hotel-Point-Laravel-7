function createConnection(){
	DayPilot.Http.ajax({
		url:"../includes/connection.php",
		success: function(args){
			alert("Connection created");
		}
	});
	
} 



 function toggleClock() {
    var myClock = document.getElementById('nav');

    var displaySetting = myClock.style.display;

    var clockButton = document.getElementById('clockButton');

    if (displaySetting == 'block') {
      myClock.style.display = 'none';
      clockButton.innerHTML = '';
    }
    else {
      myClock.style.display = 'block';
      clockButton.innerHTML = '';
    }
  }  


function getBookings(){

DayPilot.Http.ajax({
  url:"../api/getUnacknowledgedBookings.php",
  success: function(ajax){
     
      location.reload();
  }

});


}

  var nav = new DayPilot.Navigator("nav");
    nav.selectMode = "Day";
    nav.showMonths = 1;
    nav.skipMonths = 1;
    nav.onTimeRangeSelected = function(args) {
        loadTimeline(args.start);
        loadReservations();
    };
    nav.init(); 

 var roomData=[];
     var singleRooms=[];
     var doubleRooms=[];
     var suiteRooms=[];
     var filter={size:null};
    var dp = new DayPilot.Scheduler("dp");
dp.theme="customcss";
    dp.allowEventOverlap = false;
    dp.treeEnabled="true";
     dp.treePreventParentUsage=true;

    dp.days = dp.startDate.daysInMonth();
    loadTimeline(DayPilot.Date.today().firstDayOfMonth());

    dp.eventDeleteHandling = "Update";
    loadRooms();

	dp.resources=[
    {
        id:"emptyRooms", name:"Empty Rooms", cellsAutoUpdated:"true", children:[
        {id:"singleEmpty", name:"Single", cellsAutoUpdated:"true"},
        {id:"doubleEmpty", name:"Double", cellsAutoUpdated:"true"},
        {id:"suiteEmpty", name:"Suite", cellsAutoUpdated:"true"}
        ]
    },
    {
        id:"single", name:"Single", expanded:"true", children:singleRooms
        
    },
    {
        id:"double", name:"Double", expanded:"true", children:doubleRooms
        
    },
    {
        id:"suite", name:"Suite", expanded:"true", children:suiteRooms
        
    }
   ]

    dp.timeHeaders = [
        { groupBy: "Month", format: "MMMM yyyy" }, 
        { groupBy: "Day", format: "d" }
        
    ];
	
    dp.eventHeight = 20;
    dp.cellWidth = 40;
let c_width=40;
let c_height=20;
let daysToAdd=1;

function zoomin(){
dp.eventHeight=c_height + 2;
dp.cellWidth=c_width+2;
c_height=dp.eventHeight;
c_width=dp.cellWidth;
dp.update();

}

function zoomout(){
dp.eventHeight=c_height - 1;
dp.cellWidth=c_width-1;
c_height=dp.eventHeight;
c_width=dp.cellWidth;

dp.days=dp.startDate.daysInMonth()+daysToAdd;
loadTimeline(DayPilot.Date.today().firstDayOfMonth());
dp.update();

daysToAdd++;
}

var i= DayPilot.Date.today();
dp.onBeforeCellRender=function(args){

    if (args.cell.resource==="singleEmpty" || args.cell.resource==="doubleEmpty" || args.cell.resource==="suiteEmpty") {
      args.cell.disabled=true;
    }

    var singleResources=dp.rows.find("single").children();
     var totalSingleResources=singleResources.length;
     var usedSingleResources = singleResources.filter(function(row) {
            
         return !!row.events.forRange(args.cell.start, args.cell.end).length;
          } ).length;
     var availableSingleResources=totalSingleResources-usedSingleResources;
     if (args.cell.resource==="singleEmpty") {
         args.cell.areas=[];
        args.cell.areas.push({
      html: ""+availableSingleResources,
      style: "text-align: center; font-size: 16px;",
      top: 2,
      left: 0,
      right: 0
    });
     }
      var doubleResources=dp.rows.find("double").children();
     var totalDoubleResources=doubleResources.length;
     var usedDoubleResources = doubleResources.filter(function(row) {
            
         return !!row.events.forRange(args.cell.start, args.cell.end).length;
          } ).length;
     var availableDoubleResources=totalDoubleResources-usedDoubleResources;
     if (args.cell.resource==="doubleEmpty") {
        args.cell.areas=[];
        args.cell.areas.push({
      html: ""+availableDoubleResources,
      style: "text-align: center; font-size: 16px;",
      top: 2,
      left: 0,
      right: 0
    });
     }
      var suiteResources=dp.rows.find("suite").children();
     var totalSuiteResources=suiteResources.length;
     var usedSuiteResources = suiteResources.filter(function(row) {
            
         return !!row.events.forRange(args.cell.start, args.cell.end).length;
          } ).length;
     var availableSuiteResources=totalSuiteResources-usedSuiteResources;
     if (args.cell.resource==="suiteEmpty") {
        args.cell.areas=[];
        args.cell.areas.push({
      html: "" + availableSuiteResources,
      style: "text-align: center; font-size: 16px;",
      top: 2,
      left: 0,
      right: 0
    });
     }


   if (args.cell.start<= i && i < args.cell.end) {
       args.cell.backColor="gray";
   }
}
dp.onBeforeTimeHeaderRender= function(args){
   
   var end= i.addDays(1);
   
   if (args.header.start==i && args.header.end==end) {
      
       args.header.backColor="gray";
	   args.header.color="white";
   }
   
}

    dp.contextMenuResource = new DayPilot.Menu({
        items: [
            { text: "Edit...", onClick: function(args) {
                    var capacities = [
                        {name: "single", id: 1},
                        {name: "double", id: 2},
                        {name: "suite", id: 3},
                    ];

                    var statuses = [
                        {name: "Ready", id: "Ready"},
                        {name: "Cleanup", id: "Cleanup"},
                        {name: "Dirty", id: "Dirty"},
                    ];

                    var form = [
					
                        {name: "Capacity", id: "capacity", options: capacities},
                        {name: "Room Name", id: "name" }
                    ];

                    var data = args.source.data;

                    DayPilot.Modal.form(form, data).then(function(modal) {
                        if (modal.canceled) {
                            return;
                        }

                        var room = modal.result;
                        DayPilot.Http.ajax({
                            url: "backend_room_update.php",
                            data: room,
                            success: function(ajax) {
                                dp.rows.update(room);
                            }
                        });
                    });

                }},
            { text: "Delete", onClick: function (args) {
                    var id = args.source.id;
                    DayPilot.Http.ajax({
                        url: "backend_room_delete.php",
                        data: {id: id},
                        success: function (ajax) {
                            dp.rows.remove(id);
                        }
                    });
                }
            }
        ]
    });

    dp.onEventMoved = function (args) {
        if (/^\d+$/.test(args.e.id())) {
        DayPilot.Http.ajax({
            url: "backend_reservation_move.php",
            data: {
                id: args.e.id(),
                newStart: args.newStart,
                newEnd: args.newEnd,
                newResource: args.newResource
            },
            success: function(ajax) {
                dp.message(ajax.data.message);
				 dp.events.load("backend_reservations.php");
              dp.moveBy = "null";
			  dp.init();
			  
			}
        })
		}else{
			alert("Out of order can't move.");
		}
    };

    
    dp.onEventResized = function (args) {
		if (/^\d+$/.test(args.e.id())) {
        DayPilot.Http.ajax({
            url: "backend_reservation_resize.php",
            data: {
                id: args.e.id(),
                newStart: args.newStart,
                newEnd: args.newEnd
            },
            success: function () {
                dp.message("Resized.");
				 dp.events.load("backend_reservations.php");
				 dp.eventResizeHandling = "Disabled";
			     dp.init();
				 
            }
        });
		}else{
			DayPilot.Http.ajax({
            url: "ooo_resize.php",
            data: {
                id: args.e.id().slice(1),
                newStart: args.newStart,
                newEnd: args.newEnd
            },
            success: function () {
                dp.message("Resized.");
				 dp.events.load("backend_reservations.php");
				 dp.eventResizeHandling = "Disabled";
			     dp.init();
				 
            }
        });
		}
    };

    dp.onEventDeleted = function(args) {
		//alert(args.e.id());
		if (/^\d+$/.test(args.e.id())) {
			//alert("from reservation "+ args.e.id());
           DayPilot.Http.ajax({
            url: "backend_reservation_delete.php",
            data: {
                id: args.e.id()
            },
            success: function () {
                dp.message("Deleted.");
				dp.events.load("backend_reservations.php");
            dp.eventDeleteHandling = "Disabled";
            dp.init();
            }
        });
         }else{
			// alert("from out of order "+ args.e.id());
			 
        DayPilot.Http.ajax({
            url: "ooo_delete.php",
            data: {
                id: args.e.id().slice(1)
            },
            success: function () {
                dp.message("Deleted.");
				dp.events.load("backend_reservations.php");
            dp.eventDeleteHandling = "Disabled";
            dp.init();
            }
        });
	}
    };

   

    dp.onTimeRangeSelected = function (args) {

        var rooms = roomData;
		var selectcountry= [];
		var bagency= [];
		var paidmode = [];
		var ratetype = [];
		
		fetch("country.php").then(result=> result.json()).then(json => show1(json))
		fetch("bookingagency.php").then(result=> result.json()).then(json => show2(json))
		fetch("paidmode.php").then(result=> result.json()).then(json => show3(json))
		fetch("ratetype.php").then(result=> result.json()).then(json => show4(json))
		// 1 
			function show1(emp){for (var i=0; i<emp.length; i++){var id=emp[i].id;var name=emp[i].name;
		selectcountry[i]= {name: name, id: id};}}	
				// 2
			function show2(emp){for (var i=0; i<emp.length; i++){var id=emp[i].id;var name=emp[i].name;
		bagency[i]= {name: name, id: id};}}	
		// 3
			function show3(emp){for (var i=0; i<emp.length; i++){var id=emp[i].id;var name=emp[i].name;
		paidmode[i]= {name: name, id: id};}}	
		// 4
			function show4(emp){for (var i=0; i<emp.length; i++){var id=emp[i].id;var name=emp[i].name;
		ratetype[i]= {name: name, id: id};}}	

		
       
		  
		var paidoptions = [
            {name: "Cash", id: "cash"},
            {name: "Paypal", id: "paypal"},
            {name: "Visa", id: "visa"},
            {name: "Mastercard", id: "mcard"}
        ];
        var form = [
            {name: "Booking Code", id: "code"},
            {name: "Booking Agency", id: "bgncy", options: bagency},
            {name: "Charge Date", id: "cdate", dateFormat: "MM/dd/yyyy"},
            {name: "Payment Method", id: "paid", options: paidoptions},
            {name: "Payment Mode", id: "paidmode", options: paidmode},
            {name: "Rate Type", id: "ratetype", options: ratetype},
            {name: "Check In Date", id: "start", dateFormat: "MM/dd/yyyy"},
            {name: "Check Out Date", id: "end", dateFormat: "MM/dd/yyyy "},
            {name: "Arrival Hour", id: "ahour", dateFormat: "hh:mm:ss"},
            {name: "Adults", id: "adults"},
            {name: "Children", id: "children"},
            {name: "Infants", id: "infants"},
            {name: "Booking Date", id: "bdate", dateFormat: "MM/dd/yyyy"},
            {name: "Room", id: "resource", options: rooms},
            {name: "Guest Name", id: "text"},
            {name: "Guest Email", id: "email"},
            {name: "Guest Telephone", id: "phone"},
            {name: "Select Country", id: "scountry", options: selectcountry},
            {name: "Daily Rate", id: "drate"},
            {name: "Comments", id: "comments"}
        ];

        var data = {
            start: args.start,
            end: args.end,
            resource: args.resource
        };
       if (args.start < DayPilot.Date.today() ) { 
	  alert( "You are not allowed to make reservation on privious date!");
	 
	   }
	   else{
	   DayPilot.Modal.form(form, data).then(function (modal) {
            dp.clearSelection();
            if (modal.canceled) {
                return;
            }
            var e = modal.result;
            DayPilot.Http.ajax({
                url: "backend_reservation_create.php",
                data: e,
                success: function(ajax) {
                    e.id = ajax.data.id;
                    e.paid = ajax.data.paid;
                    e.status = ajax.data.status;
                    dp.events.add(e);
					 dp.events.load("backend_reservations.php");
					
					 dp.timeRangeSelectedHandling = "Disabled";
						dp.init();
						
                }
            });
			
			location.reload();
        });
		}
						
    };
	
	
    dp.onEventClick = function(args) {
		
        if (/^\d+$/.test(args.e.id())) {
	var rooms = roomData;
	 var statuses = [
            {name: "New", id: "New"},
            {name: "Confirmed", id: "Confirmed"},
            {name: "Arrived", id: "Arrived"},
            {name: "CheckedOut", id: "CheckedOut"},
            {name: "Cancelled", id: "Cancelled"}
        ];
			
        var form = [
            {name: "Reservation Status", id: "status", options: statuses}
        ];

        var data = args.e.data;

        DayPilot.Modal.form(form, data).then(function (modal) {
            dp.clearSelection();
            if (modal.canceled) {
                return;
            }
            var e = modal.result;
            DayPilot.Http.ajax({
                url: "backend_reservation_update.php",
                data: e,
                success: function(ajax) {
                    dp.events.update(e);
					 dp.events.load("backend_reservations.php");		
						dp.init();
                }
            });
			
			location.reload();
        });
		}else{
			alert("You can't update status of Out of Order");
		}
		
	};
   


    dp.onBeforeEventRender = function(args) {
        var start = new DayPilot.Date(args.data.start);
        var end = new DayPilot.Date(args.data.end);

        var today = DayPilot.Date.today();
        var now = new DayPilot.Date();                                
         
        args.data.html = DayPilot.Util.escapeHtml(args.data.text) + " (" + args.data.bgncy + ")";

        switch (args.data.status) {
            case "New":
                var in2days = today.addDays(1);

                if (start < in2days) {
                    args.data.barColor = 'black';
                    args.data.toolTip = 'Expired (not confirmed in time)';
                }
                else {
                    args.data.barColor = '#FFF300';
                    args.data.toolTip = 'New';
                }
                break;
            case "Confirmed":
                var arrivalDeadline = today.addHours(18);

                if (start < today || (start.getDatePart() === today.getDatePart() && now > arrivalDeadline)) { // must arrive before 6 pm
                    args.data.barColor = "red";  // red
                    args.data.toolTip = 'Late arrival';
                }
                else {
                    args.data.barColor = "#FF008F";
                    args.data.toolTip = "Confirmed";
                }
                break;
            case 'Arrived': // arrived
                var checkoutDeadline = today.addHours(10);

                if (end < today || (end.getDatePart() === today.getDatePart() && now > checkoutDeadline)) { // must checkout before 10 am
                    args.data.barColor = "#473F37";  // red
                    args.data.toolTip = "Late checkout";
                }
                else
                {
                    args.data.barColor = "#1691f4";  // blue
                    args.data.toolTip = "Arrived";
                }
                break;
            case 'CheckedOut': // checked out
                args.data.barColor = "gray";
                args.data.toolTip = "Checked out";
                break;
				case 'OutOfOrder': // checked out
                args.data.barColor = "black";
                args.data.toolTip = "Out Of Order";
                break;
				case 'Cancelled': // checked out
                args.data.barColor = "red";
                args.data.toolTip = "Cancelled";
                break;
            default:
                args.data.toolTip = "Unexpected state";
                break;
        }
    };

 dp.moveBy="null";
dp.timeRangeSelectedHandling = "Disabled";
dp.eventResizeHandling = "Disabled";
dp.eventDeleteHandling = "Disabled";
    dp.init();
	var ssp=0;
	function eventMove(){
	dp.moveBy="Full";
	dp.init();
	}
	function eventresize(){
	dp.eventResizeHandling = "Update";
	dp.init();
	}
	
	
	function eventedit(){
	ssp=0;
   dp.onEventClick = function(args) {
	if (/^\d+$/.test(args.e.id())) {
	   
        
	if(ssp==0){
	
	var rooms = roomData;
     var selectcountry= [];
		var paidmode = [];
		var ratetype = [];
		
		fetch("country.php").then(result=> result.json()).then(json => show1(json))
		fetch("paidmode.php").then(result=> result.json()).then(json => show3(json))
		fetch("ratetype.php").then(result=> result.json()).then(json => show4(json))
		// 1 
			function show1(emp){for (var i=0; i<emp.length; i++){var id=emp[i].id;var name=emp[i].name;
		selectcountry[i]= {name: name, id: id};}}	
				// 2
			
		// 3
			function show3(emp){for (var i=0; i<emp.length; i++){var id=emp[i].id;var name=emp[i].name;
		paidmode[i]= {name: name, id: id};}}	
		// 4
			function show4(emp){for (var i=0; i<emp.length; i++){var id=emp[i].id;var name=emp[i].name;
		ratetype[i]= {name: name, id: id};}}	
  
			
			
			
         var statuses = [
            {name: "New", id: "New"},
            {name: "Confirmed", id: "Confirmed"},
            {name: "Arrived", id: "Arrived"},
            {name: "CheckedOut", id: "CheckedOut"},
            {name: "Cancelled", id: "Cancelled"}
        ];
		var bstatuses = [
            {name: "Modified", id: "modified"},
            {name: "Canceled", id: "cancelled"}
        ];
		 
		var paidoptions = [
            {name: "Cash", id: "cash"},
            {name: "Paypal", id: "paypal"},
            {name: "Visa", id: "visa"},
            {name: "Mastercard", id: "mcard"}
        ];
			
        var form = [
           {name: "Booking Status", id: "bstatus", options: bstatuses},
            {name: "Reservation Status", id: "status", options: statuses},
            {name: "Booking Code", id: "code"},
            {name: "Charge Date", id: "cdate", dateFormat: "MM/dd/yyyy"},
            {name: "Payment Method", id: "paid", options: paidoptions},
            {name: "Payment Mode", id: "paidmodeid", options: paidmode},
            {name: "Rate Type", id: "ratetypeid", options: ratetype},
            {name: "Check In Date", id: "start", dateFormat: "MM/dd/yyyy"},
            {name: "Check Out Date", id: "end", dateFormat: "MM/dd/yyyy "},
            {name: "Arrival Hour", id: "ahour", Time: "hh:mm:ss"},
            {name: "Adults", id: "adults"},
            {name: "Children", id: "children"},
            {name: "Infants", id: "infants"},
            {name: "Booking Date", id: "bdate", dateFormat: "MM/dd/yyyy"},
            {name: "Room", id: "resource", options: rooms},
            {name: "Guest Name", id: "text"},
            {name: "Guest Email", id: "email"},
            {name: "Guest Telephone", id: "phone"},
            {name: "Select Country", id: "scid", options: selectcountry},
            {name: "Daily Rate", id: "drate"},
            {name: "Comments", id: "comments"}
        ];

        var data = args.e.data;

        DayPilot.Modal.form(form, data).then(function (modal) {
            dp.clearSelection();
            if (modal.canceled) {
                return;
            }
            var e = modal.result;
            DayPilot.Http.ajax({
                url: "backend_reservation_update.php",
                data: e,
                success: function(ajax) {
                    dp.events.update(e);
					 dp.events.load("backend_reservations.php");	
						dp.init();
                }
            });
			
			location.reload();
        });
	ssp=1;
	}else if(ssp==1){
	var rooms = roomData;
	 var statuses = [
            {name: "New", id: "New"},
            {name: "Confirmed", id: "Confirmed"},
            {name: "Arrived", id: "Arrived"},
            {name: "CheckedOut", id: "CheckedOut"},
            {name: "Cancelled", id: "Cancelled"}
        ];
			
        var form = [
            {name: "Reservation Status", id: "status", options: statuses}
        ];

        var data = args.e.data;

        DayPilot.Modal.form(form, data).then(function (modal) {
            dp.clearSelection();
            if (modal.canceled) {
                return;
            }
            var e = modal.result;
            DayPilot.Http.ajax({
                url: "backend_reservation_update.php",
                data: e,
                success: function(ajax) {
                    dp.events.update(e);
					 dp.events.load("backend_reservations.php");
						
                }
            });
			
			location.reload();
        });
	
	}
   }else{
	   alert("You can't update Out of Order");
   }
	
	
	};
	}
	function eventadd(){
		
	 dp.timeRangeSelectedHandling = "Enabled";
	 dp.init();
	
	}
	function eventonlyselect(){
	 dp.timeRangeSelectedHandling = "Disabled";
	 dp.init();
	
	}
	function eventdel(){
dp.eventDeleteHandling = "Enabled";
    dp.init();
	}
	
	function eventsplit(){
	
		
   ssp=0;
    dp.onEventClick = function(args) {
	if (/^\d+$/.test(args.e.id())) {
   var time = dp.getDate(dp.coords.x, false);
  var rooms = roomData;
       
        var form = [
            {name: "Guest Name", id: "text"},
            {name: "Room", id: "resource", options: rooms},
            {name: "Check In Date", id: "start", dateFormat: "MM/dd/yyyy"},
            {name: "Check Out Date", id: "end1", dateFormat:"MM/dd/yyyy"},
            {name: "Room", id: "resource1", options: rooms},
            {name: "Check In Date", id: "start1", dateFormat: "MM/dd/yyyy"},
            {name: "Check Out Date", id: "end", dateFormat: "MM/dd/yyyy "},
            {name: "Daily Rate", id: "drate"}
        ];

      //  var data = args.e.data;
         var data ={
		 id: args.e.data.id,
		 start: args.e.data.start,
		 end:args.e.data.end,
		 start1: time,
		 end1:time,
		 text:args.e.data.text,
		 drate:args.e.data.drate,
		 resource:args.e.data.resource
		 };
        DayPilot.Modal.form(form, data).then(function (modal) {
            dp.clearSelection();
            if (modal.canceled) {
                return;
            }
            var e = modal.result;
            DayPilot.Http.ajax({
                url: "split.php",
                data: e,
                success: function(ajax) {
					 loadReservations();
						
                }
            });
	location.reload();
        });
	}
	else{
		alert("You can't split Out of Order");
	}
	};
	
	}
function eventedit2(){
	//alert("room disable or enable");
	

        //var rooms = roomData;
	var room= [];
		
		fetch("room.php").then(result=> result.json()).then(json => show1(json))
		// 1 
			function show1(emp){for (var i=0; i<emp.length; i++){var id=emp[i].id;var name=emp[i].name;
		room[i]= {name: name, id: id};}}
		
        var statuses = [
            {name: "Disable", id: "Disabled"},
            {name: "Enable", id: "Enabled"}
        ];
		
        var form = [
            {name: "Room", id: "resource", options: room},
           // {name: "Select room", id: "room", options: room},
            {name: "Room Status", id: "status", options: statuses}
        ];

        var data = {
            //resource: rooms;
        };
   
	   
	   DayPilot.Modal.form(form, data).then(function (modal) {
            dp.clearSelection();
            if (modal.canceled) {
                return;
            }
            var e = modal.result;
			
            DayPilot.Http.ajax({
                url: "backend_room_update.php",
                data: e,
                success: function(ajax) {
                   dp.rows.update(e);
						alert(e);
						
                }
            });
			location.reload();
        });
	
	
	
	
	
	}
	
	function eventedit3(){
	//alert("room out of order or in order");
	dp.timeRangeSelectedHandling = "Enabled";
    dp.onTimeRangeSelected = function (args) {

        var rooms = roomData;
		
		
		
        var form = [
            {name: "Room", id: "resource", options: rooms},
            {name: "Start Date of Out of order", id: "start", dateFormat: "MM/dd/yyyy"},
            {name: "End Date of Out of order", id: "end", dateFormat: "MM/dd/yyyy "}
        ];

        var data = {
            start: args.start,
            end: args.end,
            resource: args.resource
        };
       if (args.start < DayPilot.Date.today() ) {
	  var result= window.confirm( "you are making out of order on privious date!");
	  if(result==true){
	    DayPilot.Modal.form(form, data).then(function (modal) {
            dp.clearSelection();
            if (modal.canceled) {
                return;
            }
            var e = modal.result;
            DayPilot.Http.ajax({
                url: "maintenance.php",
                data: e,
                success: function(ajax) {
                    e.id = ajax.data.id;
                    e.paid = ajax.data.paid;
                    e.status = ajax.data.status;
                    dp.events.add(e);
					 dp.events.load("backend_reservations.php");
					
					 dp.timeRangeSelectedHandling = "Disabled";
						dp.init();
                }
            });
			location.reload();
        });
		}else{
		return;
		}
	   }
	   else{
	   DayPilot.Modal.form(form, data).then(function (modal) {
            dp.clearSelection();
            if (modal.canceled) {
                return;
            }
            var e = modal.result;
            DayPilot.Http.ajax({
                url: "maintenance.php",
                data: e,
                success: function(ajax) {
                    e.id = ajax.data.id;
                    e.paid = ajax.data.paid;
                    e.status = ajax.data.status;
                    dp.events.add(e);
					 dp.events.load("backend_reservations.php");
					
					 dp.timeRangeSelectedHandling = "Disabled";
						dp.init();
						
                }
            });
			location.reload();
        });
		}
						
    };
	
	}
    var elements = {
        filter: document.querySelector("#filter"),
        timerange: document.querySelector("#timerange"),
        autocellwidth: document.querySelector("#autocellwidth"),
        addroom: document.querySelector("#addroom"),
        editbtn: document.querySelector("#edit"),
    };

    loadReservations();

    function loadTimeline(date) {
        dp.scale = "Manual";
        dp.timeline = [];
        var start = date.getDatePart().addHours(0);

        for (var i = 0; i < dp.days; i++) {
            dp.timeline.push({start: start.addDays(i), end: start.addDays(i+1)});
        }
        dp.update();
    }

    function loadReservations() {
        dp.events.load("backend_reservations.php");
    }
    

    function loadRoomsOnFilter() {
         dp.rows.filter(filter);
    }
     dp.onRowFilter=function(args){
             if(filter.size!=0){
                var sizeMatched=args.row.data.capacity ==filter.size;
                args.visible=sizeMatched;
             }
             
    
        };

    function loadRooms() {
        DayPilot.Http.ajax({
            url: "backend_rooms.php",
            success: function(args) {
                roomData=args.data;
                
                 for (var i = 0; i < roomData.length; i++) {
                    if (roomData[i].capacity==1) {
                    
                        singleRooms[singleRooms.length]=roomData[i];
                    }
                    else if (roomData[i].capacity==2) {
                       doubleRooms[doubleRooms.length]=roomData[i];
                    }
                    else {
                       suiteRooms[suiteRooms.length]=roomData[i];
                    }
            }
           
        }
        })
    }

    elements.filter.addEventListener("change", function(e) {
        filter.size=elements.filter.value;
        loadRoomsOnFilter();
    });
	
