<div>

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <div class="listcard">
				<div class="" style="background-color:#48BBBE; margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
		             <h2 class="pt-7 pl-3 pb-7"  >Accommondation Revenue Report</h2>
                </div>
		        <canvas id="myCanvas" style="margin-left:45%;margin-top:-8%;" width="80" height="80"></canvas>
			    <form action="#" method="post" style="width:100%;">
                    <div class='row'>
                        <div class='col-md-3'>
			                <table>
                                <tr>
                                    <td>
			                            <div class="form-style-6" style="" >
                                           <input wire:change="setdate($event.target.value)" class="form-control1"  name='date' type="date"  id="from"  value="{{$date}}"/>
            
                                        </div>
                                    </td>
                                    <td>
			                             
                                    </td>
                                </tr>
                            </table>
             
                        </div>
          
	  
			            <div class="col-md-9 mt-10 d-print-none form-group">
                            <div style="float:right;" >			
						        <!--begin::Dropdown-->
								<a href="javascript:if(window.print)window.print()" class="  " style='background-color:black;padding:2px 12px;color:white;border-radius:2px;'>
                                    <span class="navi-icon">
                                        <i class="fa fa-print" style="color:white !important;"></i>
                                    </span>
                                    <span class="" >Print</span>
                                </a>
						        <!--end::Dropdown-->
							
				
					        </div>
			          </div>
                 </div>
             </form>
         </div>
         <div class="row">
			  <div class="col-3">
			  </div>
			  <div class="col-3">
				   <div class="listcard listcard-custom " style="height:150px;">
			             <h3>Total Room Revenue</h3>
                         <div class="text-center font-weight-bold mt-8" >
                            <h1 style="font-size:35px;" id="totalyearset">{{$totalYearRevenue}}</h1>
                        </div>
                        <h6 class="text-center text-success" id="showpercent" ></h6>
			         <div class="progress mb-10">
			        	  <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" id="pbar" style="width:{{$diffPercentage}}%;background-color:green !important;"></div>
			         </div>
				 </div>
			 </div>
			 <div class="col-3">
				  <div class="listcard listcard-custom " style="height:150px;">
                            <h3>Forecast Room Revenue</h3>
                            <div class="text-center font-weight-bold mt-8" ><h1 style="font-size:35px;" id="totalforcastset" >{{$totalForecastRevenue}}</h1>
                            </div>
                            <div class="row  ">
                                <div class="col-4">
                                    <div class="{{$activeClass}} " id="differcolor" style="float:right;" ></div>
                                </div>
                                <div class="col-8">
                                    <div style="float:left;font-size:17px;margin-top:-7px;" id="differ" >{{$difference}}</div>
                                </div>
                            </div>
				    </div>
			 </div>
         </div>
        <div class="row">
			<div class="col">
				<div class="listcard listcard-custom ">
                    <div class="col" id="columnchart_material" style="margin-left: auto; margin-right: auto;width: 100%px; height: 300px;"></div> 
				</div>
			</div>
			<div class="col">
				<div class="listcard listcard-custom">      
                    <div class="col" id="piechart_3d" style="margin-left: 0px; width: auto; height: 300px;"></div>
				</div>
			</div>
        </div>
		

        <div class="row">
			<div class="col">
				 <div class="listcard listcard-custom mt-10">
                        <div class="" style=" background-color:#48BBBE;margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
                                <div class="row">
                                        <div class="col-4 "></div>
                                        <div class="col-4 ">
                                                <div class="mt-1 text-center" >
                                                    <label class="form-row-inner">
                                                        <select wire:ignore wire:change="setyear($event.target.value)"  id="dropdown1"  class="btn custom-selects"  >
                                                        </select>
                                                    </label>
                                                </div>
                                        </div>
                                </div> 
                         </div>
						
                         <div class="table-responsive">
                                <table  class="table " >
                                    <thead>
                                        <tr class="text-center">
                                            <th >Room Type</th>
                                            <th>Today</th>
                                            <th>MTD</th>
                                            <th>YTD</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="tabbody">
                                    @forelse($cRoomTypes as $type)
                                       @if($type['roomtype']=='Total')
                                            <tr class="text-center bg-white">
                                                    
                                                    <td class="idcolor" style='color:black !important;'>{{$type['roomtype']}}</td>
                                                    <td>{{$type['today']}}</td>
                                                    <td>{{$type['mtd']}}</td>
                                                    <td>{{$type['ytd']}}</td>
                                                    
                                            </tr>
                                            @else
                                            <tr class="text-center bg-white">
                                                
                                                    <td class="idcolor">{{$type['roomtype']}}</td>
                                                    <td>{{$type['today']}}</td>
                                                    <td>{{$type['mtd']}}</td>
                                                    <td>{{$type['ytd']}}</td>
                                                    
                                            </tr>
                                            @endif
                                            @empty
                                              <tr class="text-center bg-white"><td colspan="4">No Roomtype found </td></tr>
                                    @endforelse
                                    </tbody>
                                </table> 
                          </div>      
                 </div>
						    
		    </div>
	       <!-- </div> -->
			<div class="col">
				 <div class="listcard listcard-custom mt-10">
						 <div class="" style=" background-color:#48BBBE; margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
		
                                <div class="row">
                                    <div class="col-4 "></div>
                                    <div class="col-4 ">
                                        <div class="mt-1 text-center" >
                                            <label class="form-row-inner">
                                                <select wire:ignore wire:change="setyear2($event.target.value)"  id="dropdown2"  class="btn custom-selects" >
                                                </select> 
                                            </label>
                                        </div>
                                    </div>
                                </div>
                         </div>
						 <div class="table-responsive">
                                <table  class="table " >
                                    <thead>
                                        <tr class="text-center">
                                            <th >Room Type</th>
                                            <th>Today</th>
                                            <th>MTD</th>
                                            <th>YTD</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="tabbody">
                                    @forelse($pRoomTypes as $ptype)
                                        @if($ptype['roomtype']=='Total')
                                            <tr class="text-center bg-white">
                                                    
                                                    <td class="idcolor" style='color:black !important;'>{{$ptype['roomtype']}}</td>
                                                    <td>{{$ptype['today']}}</td>
                                                    <td>{{$ptype['mtd']}}</td>
                                                    <td>{{$ptype['ytd']}}</td>
                                                    
                                            </tr>
                                            @else
                                            <tr class="text-center bg-white">
                                                
                                                    <td class="idcolor">{{$ptype['roomtype']}}</td>
                                                    <td>{{$ptype['today']}}</td>
                                                    <td>{{$ptype['mtd']}}</td>
                                                    <td>{{$ptype['ytd']}}</td>
                                                    
                                            </tr>
                                        @endif
                                        @empty
                                              <tr class="text-center bg-white"><td colspan="4">No Roomtype found </td></tr>
                                    @endforelse
                                    </tbody>
                                </table> 
                          </div> 
				</div>
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
                        let lastminyear=minyear;
                        let lastmaxyear=maxyear;
                        if (minyear==maxyear) {
                            lastmaxyear=lastminyear=maxyear-1;
                        }else{
                            lastmaxyear=maxyear-1;
                        }
                        var dropdown=document.getElementById("dropdown1");
                        dropdown.innerHTML="";
                        var dropdown2=document.getElementById("dropdown2");
                        dropdown2.innerHTML="";
                        for(minyear; minyear<=maxyear; minyear++ ){ 

                            var option="<option class='custom-select-option' value='"+minyear+"' >"+minyear+"</option>";
                            
                            dropdown.innerHTML+=option;

                            }
                            for(lastminyear; lastminyear<=lastmaxyear; lastminyear++ ){ 

                                var option="<option class='custom-select-option' value='"+lastminyear+"' >"+lastminyear+"</option>";
                            
                            dropdown2.innerHTML+=option;


                                    }
                        let option1="<option selected disabled class='custom-select-disabled'>"+@this.year+"</option>";
                        $("#dropdown1").prepend(option1);
                        let option2="<option selected disabled class='custom-select-disabled'>"+@this.pastyear+"</option>";
                        $("#dropdown2").prepend(option2);
                
                        

                } 
        showpiechart(@this.pieChartData, @this.year);
        showColumnchart(@this.columnChartData);

        document.addEventListener("accomChanged", () => {
                showpiechart(@this.pieChartData, @this.year);
                showColumnchart(@this.columnChartData);
                $("#dropdown1").find('option:disabled').remove();
                let option1="<option selected disabled class='custom-select-disabled'>"+@this.year+"</option>";
                $("#dropdown1").prepend(option1);
                $("#dropdown2").find('option:disabled').remove();
                let option2="<option selected disabled class='custom-select-disabled'>"+@this.pastyear+"</option>";
                $("#dropdown2").prepend(option2);
                
                    
                    
             });

        
    
    })
      
function showpiechart(chartdata, year){
    google.charts.load("current", {packages:["corechart"]});
        
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable(
            chartdata);

        var options = {
          
          title: "Total Revenue "+year,
          is3D: true,
          
          colors:['#87CEFA','#088080','#498860','#999080','#009980', '#2E8B57','#87CFAF'],
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
        

      }
    }

    function showColumnchart(chartdata){
                  google.charts.load('current', {'packages':['corechart']});
                   google.charts.setOnLoadCallback(drawCharts);

                   function drawCharts() {
                     
                     var data = google.visualization.arrayToDataTable(chartdata);

                       var options = {
                         is3D: true,
                         colors: ['#87CEFA', '#008080', '#2E8B57']
                         };

                      

                       var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_material'));
                       chart.draw(data, options);
                         

                       }
     }
    </script>
</div>
