<div>
 
 <div class="d-flex flex-column-fluid ">
    
    <div class="container-fluid">
          <div class="listcard " >
         	<div class="" style=" background-color:#48BBBE;margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
		       <h2 class="pt-7 pl-3 pb-7" >Availability Report</h2>
               
            </div>
           
                <div class='row'>
                  <div class='col-md-10'>
			         <table>
                           <tr>
                                <td>
                                    <div class="form-style-6" style="" >
                                        <input type="date"  id="from_date"  data-date-format="mm-yyyy" 
                                                value="{{$startDate}}"/>
                                     </div>
                                </td>
                                <td>
                                    <span class="text-center" >-To-</span>
                                        
                                </td>
                                
                                <td>
                                    <div class="form-style-6" style="" >
                                        <input type="date"  id="to_date"  data-date-format="mm-yyyy" 
                                                value="{{$endDate}}" />
                                     </div>
                                </td>
                                <td>
                                    <div class="form-style-6" style="" >
                                            <select id="roomtype">
                                                    <option value="all">All</option>
                                                    @foreach($roomtypeCollection as $roomtype)
                                                      <option value="{{$roomtype->id}}">{{$roomtype->name}}</option>
                                                    @endforeach
                                                </select>
                                     </div>
                                </td>
                                <td>
                                    <div class=" d-print-none  form-style-6" style="" >		
                                            <button type="button" id="submit"  style='background-color:#48BD91;border:none !important;padding:2px 12px;color:white;border-radius:2px;'>Run</button>
                                            
                                    </div>
                                </td>
                          </tr>
                     </table>
                 </div>
             
                 <div class="col-md-2 mt-11 d-print-none form-group">
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
               
   	   <div  class="listcard listcard-custom mt-10 mb-4">
			  
             <div class="table-responsive">
                <table  class="table " >
                    <thead>
                    <tr class="text-center no-border">
                        {!!$headcol!!}
                    </tr>
                    </thead>
                    <tbody id="tabbody">
                       {!!$roomtypeRow!!}

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
                  if (startDate=="" || endDate=="" || roomtype=="") {
                    
                  }else{
                    @this.setValues(startDate, endDate, roomtype);
                   
                  }
              })
            
                $("#from_date").on('change', function(){
                    setMinMax();
                    $("#to_date").val('');
                })
                                
                  
        })
                       



</script>


</div>
