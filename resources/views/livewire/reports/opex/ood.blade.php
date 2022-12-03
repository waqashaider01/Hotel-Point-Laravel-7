<div>

    <div class="d-flex flex-column-fluid">
       
        <div class="container-fluid mb-10">
            <div class="listcard">
				<div class="" style="background-color:#48BBBE; margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
		             <h2 class="pt-7 pl-3 pb-7"  >OOD Report</h2>
                </div>
		        <canvas id="myCanvas" style="margin-left:45%;margin-top:-8%;" width="80" height="80"></canvas>
			    <form action="#" method="post" style="width:100%;">
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
          
	  
			            <div class="col-6 mt-10 d-print-none">
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
        
        <!-- <div class="row">
			<div class="col">
				<div class="listcard listcard-custom ">
                    <div class="col" id="cardchart" style="margin-left: auto; margin-right: auto;width: 100%px; height: 300px;"></div> 
				</div>
			</div>
			
        </div> -->
		

        <div class="row">
			<div class="col-md-6">
				 <div class="listcard listcard-custom mt-10">
                        <div class="" style=" background-color:#48BBBE;margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
                                <div class="row">
                                        <div class="col-4 "></div>
                                        <div class="col-4 ">
                                            <div class="mt-5 mb-5 text-center" >
                                                <h3>
                                                    MTD 
                                                </h3>
                                            </div>
                                        </div>
                                </div> 
                         </div>
						
                         <div class="table-responsive">
                                <table  class="table " >
                                    <thead>
                                        <tr>
                                            <th ></th>
                                            <th>Actual</th>
                                            <th>Budget</th>
                                            <th>%</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="tabbody">
                                    <tr class="bg-white">
                                                
                                                <td class="idcolor">Spa Operating Expenses<div class="triangle-down-blue mt-2 " type="button" id="soemtd" style="float:right;" ></div></td>
                                                <td>{{showPriceWithCurrency($totalMtdActualSOE)}}</td>
                                                <td>{{showPriceWithCurrency($totalMtdBudgetSOE)}}</td>
                                                <td><i class="fas {{$totalSOEmtdColor=='green'? 'fa-arrow-up':'fa-arrow-down' }} " style="color:{{$totalSOEmtdColor}}"></i> {{$totalSOEmtdVAlue}}%</td>
                                                
                                         </tr>
                                    @foreach($spaOperatingExpenseMTD as $mtd)
                                        <tr class="bg-white soemonth opexall">
                                                
                                                    <td>{{$mtd[0]}}</td>
                                                    <td>{{showPriceWithCurrency($mtd[1])}}</td>
                                                    <td>{{showPriceWithCurrency($mtd[2])}}</td>
                                                    <td><i class="fas {{$mtd[3][1]=='green'? 'fa-arrow-up':'fa-arrow-down' }} " style="color:{{$mtd[3][1]}}"></i> {{$mtd[3][0]}}%</td>
                                                     
                                            </tr>
                                          
                                    @endforeach

                                    <tr class="bg-white">
                                                
                                                <td class="idcolor">Other Income Expenses<div class="triangle-down-blue mt-2 " type="button" id="oiemtd" style="float:right;" ></div></td>
                                                <td>{{showPriceWithCurrency($totalMtdActualOIE)}}</td>
                                                <td>{{showPriceWithCurrency($totalMtdBudgetOIE)}}</td>
                                                <td><i class="fas {{$totalmtdColor=='green'? 'fa-arrow-up':'fa-arrow-down' }} " style="color:{{$totalmtdColor}}"></i> {{$totalmtdValue}}%</td>
                                                
                                         </tr>
                                    @foreach($otherIncomeExpenseMTD as $mtd)
                                        <tr class="bg-white oiemonth opexall">
                                                
                                                    <td>{{$mtd[0]}}</td>
                                                    <td>{{showPriceWithCurrency($mtd[1])}}</td>
                                                    <td>{{showPriceWithCurrency($mtd[2])}}</td>
                                                    <td><i class="fas {{$mtd[3][1]=='green'? 'fa-arrow-up':'fa-arrow-down' }} " style="color:{{$mtd[3][1]}}"></i> {{$mtd[3][0]}}%</td>
                                                    
                                            </tr>
                                          
                                    @endforeach
                                    </tbody>
                                </table> 
                          </div>      
                 </div>
						    
		    </div>
	      
			<div class="col-md-6">
				 <div class="listcard listcard-custom mt-10">
						 <div class="" style=" background-color:#48BBBE; margin-top:-2.1% !important;color:white; margin-bottom:15px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;" >
		
                                <div class="row">
                                    <div class="col-4 "></div>
                                    <div class="col-4 ">
                                        <div class="mt-5 mb-5 text-center" >
                                            <h3>
                                                YTD 
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                         </div>
						 <div class="table-responsive">
                                <table  class="table " >
                                    <thead>
                                        <tr>
                                            <th ></th>
                                            <th>Actual</th>
                                            <th>Budget</th>
                                            <th>%</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="tabbody">
                                    <tr class="bg-white">
                                                
                                                <td class="idcolor">Spa Operating Expense<div class="triangle-down-blue mt-2 " type="button" id="soeytd" style="float:right;" ></div></td>
                                                <td>{{showPriceWithCurrency($totalYtdActualSOE)}}</td>
                                                <td>{{showPriceWithCurrency($totalYtdBudgetSOE)}}</td>
                                                <td><i class="fas {{$totalSOEytdColor=='green'? 'fa-arrow-up':'fa-arrow-down' }} " style="color:{{$totalSOEytdColor}}"></i> {{$totalSOEytdVAlue}}%</td>
                                                
                                         </tr>
                                    @foreach($spaOperatingExpenseYTD as $ytd)
                                        <tr class="bg-white soeyear opexall">
                                                
                                                    <td>{{$ytd[0]}}</td>
                                                    <td>{{showPriceWithCurrency($ytd[1])}}</td>
                                                    <td>{{showPriceWithCurrency($ytd[2])}}</td>
                                                    <td><i class="fas {{$mtd[3][1]=='green'? 'fa-arrow-up':'fa-arrow-down' }} " style="color:{{$mtd[3][1]}}"></i> {{$mtd[3][0]}}%</td>
                                                     
                                            </tr>
                                          
                                    @endforeach

                                    <tr class="bg-white">
                                                
                                                <td class="idcolor">Other Income Expense<div class="triangle-down-blue mt-2 " type="button" id="oieytd" style="float:right;" ></div></td>
                                                <td>{{showPriceWithCurrency($totalYtdActualOIE)}}</td>
                                                <td>{{showPriceWithCurrency($totalYtdBudgetOIE)}}</td>
                                                <td><i class="fas {{$totalytdColor=='green'? 'fa-arrow-up':'fa-arrow-down' }} " style="color:{{$totalytdColor}}"></i> {{$totalytdValue}}%</td>
                                                
                                         </tr>
                                    @foreach($otherIncomeExpenseYTD as $ytd)
                                        <tr class="bg-white oieyear opexall">
                                                
                                                    <td>{{$ytd[0]}}</td>
                                                    <td>{{showPriceWithCurrency($ytd[1])}}</td>
                                                    <td>{{showPriceWithCurrency($ytd[2])}}</td>
                                                    <td><i class="fas {{$mtd[3][1]=='green'? 'fa-arrow-up':'fa-arrow-down' }} " style="color:{{$mtd[3][1]}}"></i> {{$mtd[3][0]}}%</td>
                                                     
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

<script>
    $(document).ready( function() {
	
        $(".opexall").hide();
        $("#soemtd").click(function(){
            $(".soemonth").toggle();
        });
        $("#oiemtd").click(function(){
           $(".oiemonth").toggle();
        });
        $("#soeytd").click(function(){
            $(".soeyear").toggle();
        });
           
        $("#oieytd").click(function(){
            $(".oieyear").toggle();
        });

        document.addEventListener("oodChanged", () => {
                
                $(".opexall").hide();
                        
                 });
    });


</script>

</div>
