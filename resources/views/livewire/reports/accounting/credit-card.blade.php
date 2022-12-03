<div>

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <div class="listcard">
				<div class="" style="background-color:#48BBBE; margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
		             <h2 class="pt-7 pl-3 pb-7"  >Credit Card Report</h2>
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
			<div class="col">
				<div class="listcard listcard-custom ">
                    <div class="col" id="cardchart" style="margin-left: auto; margin-right: auto;width: 100%px; height: 300px;"></div> 
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
                                                        <select wire:ignore wire:change="setyear($event.target.value)"  id="dropdown1"  class="btn btn-default" style=" font-size: 24px !important; background-color:transparent; border:none; color:#fff; ">
                                                        </select>
                                                    </label>
                                                </div>
                                        </div>
                                </div> 
                         </div>
						
                         <div class="table-responsive">
                                <table  class="table " >
                                    <thead>
                                        <tr>
                                            <th >Credit Card</th>
                                            <th>Today</th>
                                            <th>MTD</th>
                                            <th>YTD</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="tabbody">
                                    @foreach($cCards as $card)
                                       
                                            <tr class="bg-white">
                                                
                                                    <td class="idcolor">{{$card[0]}}</td>
                                                    <td>{{$card[1]}}</td>
                                                    <td>{{$card[2]}}</td>
                                                    <td>{{$card[3]}}</td>
                                                    
                                            </tr>
                                          
                                    @endforeach
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
                                                <select wire:ignore wire:change="setyear2($event.target.value)"  id="dropdown2"  class="btn btn-default" style=" font-size: 24px !important; background-color:transparent; border:none; color:#fff; ">
                                                </select> 
                                            </label>
                                        </div>
                                    </div>
                                </div>
                         </div>
						 <div class="table-responsive">
                                <table  class="table " >
                                    <thead>
                                        <tr>
                                            <th >Credit Card</th>
                                            <th>Today</th>
                                            <th>MTD</th>
                                            <th>YTD</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="tabbody">
                                    @foreach($pCards as $pcard)
                                        
                                            <tr class="bg-white">
                                                
                                                    <td class="idcolor">{{$pcard[0]}}</td>
                                                    <td>{{$pcard[1]}}</td>
                                                    <td>{{$pcard[2]}}</td>
                                                    <td>{{$pcard[3]}}</td>
                                                    
                                            </tr>
                                      
                                    @endforeach
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

                        var option="<option style='background:#fff; color:#000; padding:10px !important; font-size:20px;' value='"+minyear+"' >"+minyear+"</option>";
                        
                        dropdown.innerHTML+=option;

                        }
                        for(lastminyear; lastminyear<=lastmaxyear; lastminyear++ ){ 

                            var option="<option style='background:#fff; color:#000; padding:10px !important; font-size:20px;' value='"+lastminyear+"' >"+lastminyear+"</option>";
                        
                           dropdown2.innerHTML+=option;


                                }
                        dropdown.value=@this.year;
                        dropdown2.value=@this.pastyear;
                        let option1="<option selected disabled style='background:#dfdfdf; color:#000; padding:10px !important; font-size:20px;'>"+@this.year+"</option>";
                        $("#dropdown1").prepend(option1);
                        let option2="<option selected disabled style='background:#dfdfdf; color:#000; padding:10px !important; font-size:20px;'>"+@this.pastyear+"</option>";
                        $("#dropdown2").prepend(option2);
                
                
                        

                } 
        showChart(@this.chartdata, @this.selectedYear);
        document.addEventListener("creditChanged", () => {
                showChart(@this.chartdata, @this.selectedYear);
                $("#dropdown1").find('option:disabled').remove();
                let option1="<option selected disabled style='background:#dfdfdf; color:#000; padding:10px !important; font-size:20px;'>"+@this.year+"</option>";
                $("#dropdown1").prepend(option1);
                $("#dropdown2").find('option:disabled').remove();
                let option2="<option selected disabled style='background:#dfdfdf; color:#000; padding:10px !important; font-size:20px;'>"+@this.pastyear+"</option>";
                $("#dropdown2").prepend(option2);
                    
                    
             });
       
       
    
    })

    function showChart(chartdata, year){
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(updateChart);

        function updateChart(){
                

            var data = google.visualization.arrayToDataTable(chartdata);
                    
                
                var options = {
                    width:'95%',
                    chartArea:{width:'85%'},
                    hAxis: {title: year,  titleTextStyle: {color: '#333'}},
                    colors:['#DC7633','#87CEFA', '#58D68D'],
                    vAxis:{viewWindow:{min:0}},
                    curveType:'function', 
                    pointSize:5
                    };
                var chart = new google.visualization.LineChart(document.getElementById('cardchart'));
                chart.draw(data, options);
                

        }
    }
      

    </script>
</div>
