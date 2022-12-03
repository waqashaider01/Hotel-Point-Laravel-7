<div>
 
 <div class="d-flex flex-column-fluid ">
    
    <div class="container-fluid">
          <div class="listcard " >
         	<div class="" style=" background-color:#48BBBE;margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
		       <h2 class="pt-7 pl-3 pb-7" >Cancellation Market Nights Report</h2>
               
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
             
                 <div class="col-md-7 mt-11 d-print-none form-group">
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
          </form>
       </div>
      <div wire:ignore class="row">
            <div class="col">
                   <div class="listcard listcard-custom mt-10 " style="height:350px;" >
                        <div id="linechart" style="width: 100%; height: 100%;"></div>
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
                                            <select wire:ignore wire:change="set_year($event.target.value)"  id="dropdown1"  class="btn btn-default" style=" font-size: 24px !important; background-color:transparent; border:none; color:#fff; ">
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
                        <th id="syear">{{$year}}</th>
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
                    @foreach($channels as $channel)
                        <tr class="text-center bg-white">
                            
                                <td class="idcolor">{{$channel['channel']}}</td>
                                <td>{{$channel['1']}}</td>
                                <td>{{$channel['2']}}</td>
                                <td>{{$channel['3']}}</td>
                                <td>{{$channel['4']}}</td>
                                <td>{{$channel['5']}}</td>
                                <td>{{$channel['6']}}</td>
                                <td>{{$channel['7']}}</td>
                                <td>{{$channel['8']}}</td>
                                <td>{{$channel['9']}}</td>
                                <td>{{$channel['10']}}</td>
                                <td>{{$channel['11']}}</td>
                                <td>{{$channel['12']}}</td>
                          
                        </tr>
                    @endforeach
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

                        var option="<option style='background:#fff; color:#000; padding:10px !important; font-size:20px;' value='"+minyear+"' >"+minyear+"</option>";
                        
                        dropdown.innerHTML+=option;

                        }
                        let option1="<option selected disabled style='background:#dfdfdf; color:#000; padding:10px !important; font-size:20px;'>"+@this.year+"</option>";
                        $("#dropdown1").prepend(option1);
                        

                } 
                populateChart(@this.chartdata, @this.year);
        document.addEventListener("cnightChanged", () => {
                
                populateChart(@this.chartdata, @this.year);
                $("#dropdown1").find('option:disabled').remove();
                let option1="<option selected disabled style='background:#dfdfdf; color:#000; padding:10px !important; font-size:20px;'>"+@this.year+"</option>";
                $("#dropdown1").prepend(option1);
                
         });

               
        })
                       

 


function populateChart(chartdata, year){
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
              hAxis: {title: year,  titleTextStyle: {color: '#333'}},
              colors:['#DC7633','#87CEFA', '#58D68D'],
              vAxis:{viewWindow:{min:0}},
              curveType:'function', 
              pointSize:5
            };
           var chart = new google.visualization.LineChart(document.getElementById('linechart'));
           chart.draw(data, options);
           

}
}






</script>


</div>
