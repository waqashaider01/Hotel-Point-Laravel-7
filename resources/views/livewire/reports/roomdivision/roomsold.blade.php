<div>
 
 <div class="d-flex flex-column-fluid ">
   
    <div class="container-fluid">
          <div class="listcard " >
         	<div class="" style=" background-color:#48BBBE;margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
		       <h2 class="pt-7 pl-3 pb-7" >Room Types Sold Report</h2>
               
            </div>
           
                <div class='row'>
                     <div class='col-6'>
                            <table>
                                <tr>
                                    <td>
                                        <div class="form-style-6" style="" >
                                        <input wire:change="setdate($event.target.value)" class="form-control1"  name='date' type="date"  id="from"  value="{{$selectedDate}}"/>
            
                                        </div>
                                    </td>
                                    <td>
                                        
                                    </td>
                                </tr>
                            </table>
            
                       </div>
			        
                 
             
                 <div class="col-6 mt-11 d-print-none">
                        <div style="float:right;" >			
                               
                                    <a href="javascript:if(window.print)window.print()" class="  " style='background-color:black;padding:2px 12px;color:white;border-radius:2px;'>
                                            <span class="navi-icon">
                                                <i class="fa fa-print" style="color:white !important;"></i>
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
                        <div id="roomsold_chart" style="width: 100%; height: 100%;"></div>
                   </div>
             </div>
	   </div>
	  
                        
               
   	   <div  class="listcard listcard-custom mt-10 mb-4">
			  <div  class="" style="background-color:#48BBBE;margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
		
					<div class="inner ">
						<div class="form-row row">
                            <div class="form-holder col-4 "></div>
                            <div class="form-holder col-4 ">
                                <div class="text-center" style="">
                                <label class="form-row-inner">
                                    
                                            <select wire:ignore wire:change="setyear($event.target.value)"  id="dropdown1"  class="btn custom-selects ">
                                            </select>  
                                </label>
                                </div>	
                            </div>
                        </div>
                    </div>
             </div>
             <div class="table-responsive">
                <table  class="table " >
                    <thead>
                    <tr class="text-center">
                        <th>{{$year}}</th>
                        <th>Jan</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>Apr</th>
                        <th>May</th>
                        <th>Jun</th>
                        <th>Jul</th>
                        <th>Aug</th>
                        <th>Sep</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        <th>Dec</th>
                        
                    </tr>
                    </thead>
                    <tbody id="tabbody">
                    @forelse($roomsold as $room)
                        <tr class="text-center thin-bottom-border bg-white">
                            
                                <td><div class="idcolor" >{{$room[0]}}</div></td>
                                <td>{{$room[1]}}</td>
                                <td>{{$room[2]}}</td>
                                <td>{{$room[3]}}</td>
                                <td>{{$room[4]}}</td>
                                <td>{{$room[5]}}</td>
                                <td>{{$room[6]}}</td>
                                <td>{{$room[7]}}</td>
                                <td>{{$room[8]}}</td>
                                <td>{{$room[9]}}</td>
                                <td>{{$room[10]}}</td>
                                <td>{{$room[11]}}</td>
                                <td>{{$room[12]}}</td>
                               
                          
                        </tr>
                        @empty
                          <tr class="mytr text-center" >
                            <td colspan="13">No room type sold</td>
                          </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            
        </div>

    </div>

</div>



    <script type="text/javascript">
        
        $(document).ready(function(){
           
            fetch("{{route('getMinDate')}}").then(result=> result.json()).then(json => show1(json))

                function show1(emp)
                    {
                       
                    var maxyear=emp.maxyear;
                    var minyear=emp.minyear;
                    var dropdown=document.getElementById("dropdown1");
                    dropdown.innerHTML="";
                    for(minyear; minyear<=maxyear; minyear++ ){ 

                        var option="<option class='custom-select-option' value='"+minyear+"' >"+minyear+"</option>";
                        
                        dropdown.innerHTML+=option;

                        }
                        let option1="<option selected disabled class='custom-select-disabled'>"+@this.year+"</option>";
                        $("#dropdown1").prepend(option1);
                        

                } 
                populateChart();
    document.addEventListener("roomsoldChanged", () => {
                
                populateChart();
                $("#dropdown1").find('option:disabled').remove();
                let option1="<option selected disabled class='custom-select-disabled'>"+@this.year+"</option>";
                $("#dropdown1").prepend(option1);
                
        
    });
                

               
        })
                       

 


function populateChart(){
    
          google.charts.load("current", {packages:["corechart"]});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {
           
            var data = google.visualization.arrayToDataTable(@this.chartdata);
          
            var options = {
                            width:'100%',
                            chartArea:{width:'90%'},
                            
                            hAxis: {title: '',  titleTextStyle: {color: '#333'}},
                            colors:['#008080','#87CEFA'],
                            vAxis:{viewWindow:{min:0}},
                            legend:{position:"none"},
                            curveType:'function', 
                            pointSize:5
              
                        };

            var chart = new google.visualization.AreaChart(document.getElementById('roomsold_chart'));
            chart.draw(data, options);
           

          }
}






</script>


</div>
