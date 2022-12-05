<div>
 
 <div class="d-flex flex-column-fluid ">
    
    <div class="container-fluid">
          <div class="listcard " >
         	<div class="" style=" background-color:#48BBBE;margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
		       <h2 class="pt-7 pl-3 pb-7" >ADR Report</h2>
               
            </div>
            
            <form  style="width:100%;">
                <div class='row'>
                  <div class='col-md-5'>
			         <table>
                           <tr>
                                <td>
                                    <div class="form-style-6" style="" >
                                        <input wire:change="set_date($event.target.value)" name='selectedDate' type="date"  id="from"  data-date-format="mm-yyyy" 
                                                value="{{$selectedDate}}"/>
                        
                        
                                    </div>
                                </td>
                                <td>
                                
                                </td>
                          </tr>
                     </table>
                 </div>
             
                 <div class="col-md-7 d-print-none form-group" style="margin: 10px auto;">
                        <div style="float:right;" class="print_btn">			
                                
                                    <a href="javascript:if(window.print)window.print()" >
                                            <span class="navi-icon mr-2">
                                                <i class="fa fa-print"></i>
                                            </span>
                                            <span class="" >Print</span>
                                     </a>
                                    
                        </div>
                 </div>
              </div>
          </form>
       </div>
      <div wire:ignore class="row">
            <div class="col">
                   <div class="listcard listcard-custom mt-10 " style="height:350px;" >
                        <div id="adrchart" style="width: 100%; height: 100%;"></div>
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
                                            <select wire:ignore wire:change="set_year($event.target.value)"  id="dropdown1"  class="btn custom-selects" >
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
                        <th id="syear">ADR Index</th>
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
                    <tr class="text-center bg-white">
                                <td class="idcolor">Actual</td>
                                <td>{{$actual[0]}}</td>
                                <td>{{$actual[1]}}</td>
                                <td>{{$actual[2]}}</td>
                                <td>{{$actual[3]}}</td>
                                <td>{{$actual[4]}}</td>
                                <td>{{$actual[5]}}</td>
                                <td>{{$actual[6]}}</td>
                                <td>{{$actual[7]}}</td>
                                <td>{{$actual[8]}}</td>
                                <td>{{$actual[9]}}</td>
                                <td>{{$actual[10]}}</td>
                                <td>{{$actual[11]}}</td>
                        </tr>

                       <tr class="text-center bg-white">
                                <td class="idcolor">Forecast</td>
                                <td>{{$forecast[0]}}</td>
                                <td>{{$forecast[1]}}</td>
                                <td>{{$forecast[2]}}</td>
                                <td>{{$forecast[3]}}</td>
                                <td>{{$forecast[4]}}</td>
                                <td>{{$forecast[5]}}</td>
                                <td>{{$forecast[6]}}</td>
                                <td>{{$forecast[7]}}</td>
                                <td>{{$forecast[8]}}</td>
                                <td>{{$forecast[9]}}</td>
                                <td>{{$forecast[10]}}</td>
                                <td>{{$forecast[11]}}</td>
                        </tr>
                        <tr class="text-center bg-white">
                                <td class="idcolor">%</td>
                                <td style="color:{{$difference[0]['color']}}">{{$difference[0]['value']}}%</td>
                                <td style="color:{{$difference[1]['color']}}">{{$difference[1]['value']}}%</td>
                                <td style="color:{{$difference[2]['color']}}">{{$difference[2]['value']}}%</td>
                                <td style="color:{{$difference[3]['color']}}">{{$difference[3]['value']}}%</td>
                                <td style="color:{{$difference[4]['color']}}">{{$difference[4]['value']}}%</td>
                                <td style="color:{{$difference[5]['color']}}">{{$difference[5]['value']}}%</td>
                                <td style="color:{{$difference[6]['color']}}">{{$difference[6]['value']}}%</td>
                                <td style="color:{{$difference[7]['color']}}">{{$difference[7]['value']}}%</td>
                                <td style="color:{{$difference[8]['color']}}">{{$difference[8]['value']}}%</td>
                                <td style="color:{{$difference[9]['color']}}">{{$difference[9]['value']}}%</td>
                                <td style="color:{{$difference[10]['color']}}">{{$difference[10]['value']}}%</td>
                                <td style="color:{{$difference[11]['color']}}">{{$difference[11]['value']}}%</td>
                        </tr>

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
                populateChart(@this.chartdata, @this.year);
                document.addEventListener("adrChanged", () => {
                    $("#dropdown1").find('option:disabled').remove();
                    let option1="<option selected disabled style='background:#fff; color:#000; padding:10px !important; font-size:20px;'>"+@this.year+"</option>";
                    $("#dropdown1").prepend(option1);
                    populateChart(@this.chartdata);
                    
                    
             });

               
        })
                       

 


function populateChart(chartdata){
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(updateChart);

function updateChart(){
           

           var data = new google.visualization.DataTable( );
            let newdata=chartdata;
              newdata.forEach(function (row, indexRow) {
                  if (indexRow === 0) {
                  row.forEach(function (column, indexCol) {
                      if (indexCol === 0) {
                      data.addColumn('string', column);
                      } else {
                      data.addColumn('number', column);
                      }
                  });
                  } else {
                  data.addRow(row);
                  }
              });

           
         
          
           var options = {
            width:'95%',
              chartArea:{width:'85%'},
              legend:{position:"none"},
              hAxis: {titleTextStyle: {color: '#333'}},
              colors:['#008080','#87CEFA'],
              vAxis:{viewWindow:{min:0}},
              curveType:'function', 
              pointSize:5
            };
           var chart = new google.visualization.LineChart(document.getElementById('adrchart'));
           chart.draw(data, options);
           

}
}






</script>


</div>
