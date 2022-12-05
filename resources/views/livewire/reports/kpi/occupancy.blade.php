<div>
 
 <div class="d-flex flex-column-fluid ">
    
    <div class="container-fluid">
          <div class="listcard " >
         	<div class="" style=" background-color:#48BBBE;margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
		       <h2 class="pt-7 pl-3 pb-7" >Occupancy Report</h2>
               
            </div>
           
                <div class='row'>
                  <div class='col-md-10'>
			         <table>
                           <tr>
                                {{-- <td>
                                    <div class="form-style-6" style="" >
                                        <input type="date"  id="from_date" value="{{$startDate}}"/>
                                     </div>
                                </td>
                                <td>
                                    <span class="text-center" >-To-</span>
                                        
                                </td>
                                
                                <td>
                                    <div class="form-style-6" style="" >
                                        <input type="date"  id="to_date" value="{{$endDate}}" />
                                     </div>
                                </td> --}}
                                <td>
                                
                  <input type="text" style="margin-top: -10px" name="daterange" class="custom_date_style" value="01/01/2018 - 01/15/2018" />
                                   </td>
                                <td>
                                
                                    <div class="form-style-6" style="" >
                                            <select id="roomtype " class="all_filter_field">
                                                    <option value="all">All</option>
                                                    @foreach($roomtypeCollection as $roomtype)
                                                      <option value="{{$roomtype->id}}">{{$roomtype->name}}</option>
                                                    @endforeach
                                                </select>
                                     </div>
                                </td>
                                <td>
                                    <div class=" d-print-none  form-style-6" style="" >		
                                            <button type="button" id="submit"  class="run_btn">Run</button>
                                            
                                    </div>
                                </td>
                          </tr>
                     </table>
                 </div>
             
                <div class="col-md-2 d-print-none form-group" style="margin: 10px auto;">
                        <div style="float:right; " class="print_btn">			
                                
                                    <a href="javascript:if(window.print)window.print()" class="">
                                            <span class="navi-icon mr-2">
                                                <i class="fa fa-print"></i>
                                            </span>
                                            <span class="" >Print</span>
                                     </a>
                                    
                        </div>
                 </div>
              </div>
         
       </div>
      <div wire:ignore class="row">
            <div class="col">
                   <div class="listcard listcard-custom mt-10 " style="height:350px;" >
                        <div id="occChart" style="width: 100%; height: 100%;"></div>
                   </div>
             </div>
	   </div>
	  
                        
               
   	   <div  class="listcard listcard-custom mt-10 mb-4">
			  
             <div class="table-responsive">
                <table  class="table " >
                    <thead>
                    <tr class="text-center">
                        <th>Date</th>
                        <th>Total Rooms</th>
                        <th>Sold Rooms</th>
                        <th>Out of Order Rooms</th>
                        <th>Occupancy Rate</th>
                    </tr>
                    </thead>
                    <tbody id="tabbody">
                        @foreach($statistics as $occ)
                            <tr class="text-center bg-white">
                                        <td class="idcolor">{{$occ[0]}}</td>
                                        <td>{{$occ[1]}}</td>
                                        <td>{{$occ[2]}}</td>
                                        <td >{{$occ[3]}}</td>
                                        <td class="idcolor">{{$occ[4]}}%</td>
                                        
                                </tr>
                        @endforeach

                       <tr class="text-center bg-white">
                                <th></th>
                                <th>Total No. of Rooms</th>
                                <th>Total Sold Rooms</th>
                                <th>Total Out of Order Rooms</th>
                                <th>Average Occupancy Rate</th>
                                
                        </tr>
                        <tr class="text-center bg-white">
                                <th></th>
                                <th>{{$totalRooms}}</th>
                                <th>{{$totalSoldRooms}}</th>
                                <th>{{$totalOutOfOrder}}</th>
                                <th>{{$averageOccupancy}}%</th>
                        </tr>

                    </tbody>
                </table>
            </div>
            
        </div>

    </div>

           
</div>

    <script type="text/javascript">
        $(document).ready(function(){
            setMinMax();

            function setMinMax(){
                    let selectedDate=$("#from_date").val();
                    let start=new Date(selectedDate);
                    let days=30;
                    start.setDate(start.getDate()+ days);
                    let final_val=start.getFullYear()+"-"+('0'+(start.getMonth()+1)).slice(-2)+"-"+('0'+start.getDate()).slice(-2);
                    
                    $("#to_date").attr('min', selectedDate);
                    $("#to_date").attr('max', final_val);
                    
            }

              $("#submit").on('click', function(){
                  let startDate=$("#from_date").val();
                  let endDate=$("#to_date").val();
                  let roomtype=$("#roomtype").val();
                  console.log(roomtype);
                  if (startDate=="" || endDate=="" || roomtype=="") {
                    
                  }else{
                    @this.setValues(startDate, endDate, roomtype);
                   
                  }
              })
            
                populateChart();

                $("#from_date").on('change', function(){
                    setMinMax();
                    $("#to_date").val('');
                })

                document.addEventListener("occcontentChanged", () => {
                    populateChart();
                   
                    
             });
                                
                  
        })
                       

 


function populateChart(){
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(updateChart);

function updateChart(){
           
            let startDate=$("#from_date").val();
            let endDate=$("#to_date").val();
            let startdate=new Date(startDate);
            let enddate=new Date(endDate);
            var charttitle=("0"+startdate.getDate()).slice(-2)+" "+
                            startdate.toLocaleString('default', {month:'short'})+" "+startdate.getFullYear()+
                            " to "+
                            ("0"+enddate.getDate()).slice(-2)+" "+
                            enddate.toLocaleString('default', {month:'short'})+" "+enddate.getFullYear();

           var data = google.visualization.arrayToDataTable(@this.chartdata);
           var formatter= new google.visualization.NumberFormat({ suffix:' %'});
            formatter.format(data, 1);
            formatter.format(data, 2);

                var options = {
                width:'95%',
                chartArea:{width:'95%'},
                hAxis: {title: charttitle,  titleTextStyle: {color: '#333'}, textPosition:'none'},
                colors:['#87CEFA', '#008080'],
                    vAxis:{viewWindow:{min:0}},
                legend:{position:"none"},
                seriesType:'bars',
                series:{1:{type:'line', curveType:'function', pointSize:5}}

                };
                
                var chart = new google.visualization.ComboChart(document.getElementById('occChart'));
                chart.draw(data, options);
           

}
}





</script>

 <script>
$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'right'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});
</script>


</div>
