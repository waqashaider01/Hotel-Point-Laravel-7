<div>
 
    <div id="hotelbudget" class="d-flex flex-column-fluid mt-5">
            <!--begin::Container-->
            <div class="container-fluid">

                <div class="row" style="">
                    <div class="col">
                        <div class=" shadow-sm bg-white" style="padding:1%; border-radius:5px;">
                        <div class="row w-100" >
                                
                                <div class="col-4">
                                    <div class="" >
                                            <h1 style="text-align:left;">Hotel Actual</h1>
                                    
                                    </div>
                                </div>
                               
                                <div class="col-8">
                                    <div style="width:100%;">
                                            <span type="button" class="infbtn opexbtn" style=""  >Opex</span>
                                            <span type="button" class="infbtn revenuebtn" style=""  >Revenue</span>
                                            <select wire:ignore wire:change="setyears($event.target.value)" class="infbtn" style="background-color:white !important; max-width:70px;" id="dropdown">
                                            
                                            </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-8" id="revenuerow">
                <div class="row mt-8 " id="">
                        <div class="col">
                                <div class=" shadow-sm" style="padding:1%; border-radius:5px; background:white;">
                                        <div class="row">
                                            <div class="col">
                                                <h4 class="idcolor">Statistics</h4>
                                            </div>
                                            
                                        </div>
                                        
                                        <hr style="border: 1px solid #48BBBE;margin-left:0%;margin-right:0%;">
                                        <div class="table-responsive">
                                            <table class="table " style="border: 2px solid #48BBBE;">
                                                <thead>
                                                    
                                                </thead>
                                                <tbody>
                                                <tr class="text-center">
                                                        <th class="headingdata"></th>
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
                                                        <th>Year</th>
                                                    </tr>
                                                    @foreach($statistics as $statistic)
                                                      <tr class="bg-white text-center">
                                                        @foreach($statistic as $stat)
                                                         @if($loop->index==0)
                                                         <th class="headingdata">{{$stat}}</th>
                                                         @elseif($loop->index==13)
                                                         <td class="budget-total-data">{{$stat}}</td>
                                                         @else
                                                         <td>{{$stat}}</td>
                                                         @endif

                                                        @endforeach
                                                    </tr>

                                                        
                                                        @endforeach

                                                </tbody>
                                            </table>

                                        </div>


                            
                                </div>
                        </div>
                </div>
          <!-- </div> -->
          <div class="row mt-8">
                        <div class="col">
                        <div class="bg-white shadow-sm" style="padding:1%; border-radius:5px;">
                                        <div class="row">
                                            <div class="col">
                                                <h4 class="idcolor">Rooms Department Revenue</h4>
                                            </div>
                                            
                                        </div>
                                        
                                        <hr style="border: 1px solid #48BBBE;margin-left:0%;margin-right:0%;">
                                        <div class="table-responsive">
                                            <table class="table " style="border: 2px solid #48BBBE;">
                                                    <thead></thead>
                                                    <tbody>
                                                            <tr class="text-center">
                                                                <th class="headingdata" ></th>
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
                                                                <th>Year</th>
                                                            </tr>
                                                            @foreach($roomDeptData as $roomdept)
                                                               @if($loop->index==0)
                                                               <tr class="bg-white text-center">
                                                                        <th class="headingdata">{{$roomdept[0]}}</th>
                                                                        <td>{{$roomdept[1]}}</td>
                                                                        <td>{{$roomdept[2]}}</td>
                                                                        <td>{{$roomdept[3]}}</td>
                                                                        <td>{{$roomdept[4]}}</td>
                                                                        <td>{{$roomdept[5]}}</td>
                                                                        <td>{{$roomdept[6]}}</td>
                                                                        <td>{{$roomdept[7]}}</td>
                                                                        <td>{{$roomdept[8]}}</td>
                                                                        <td>{{$roomdept[9]}}</td>
                                                                        <td>{{$roomdept[10]}}</td>
                                                                        <td>{{$roomdept[11]}}</td>
                                                                        <td>{{$roomdept[12]}}</td>
                                                                        <td class="budget-total-data">{{$roomdept[13]}}</td>
                                                                </tr>
                                                               @elseif($loop->index==1)
                                                                    <tr class="bg-white text-center" >
                                                                            <th class="headingdata">{{$roomdept[0]}}<div class="triangle-down-blue mt-2" type="button" id="roomdeptbtn" style="float:right;" ></div></th>
                                                                            <td>{{$roomdept[1]}}</td>
                                                                            <td>{{$roomdept[2]}}</td>
                                                                            <td>{{$roomdept[3]}}</td>
                                                                            <td>{{$roomdept[4]}}</td>
                                                                            <td>{{$roomdept[5]}}</td>
                                                                            <td>{{$roomdept[6]}}</td>
                                                                            <td>{{$roomdept[7]}}</td>
                                                                            <td>{{$roomdept[8]}}</td>
                                                                            <td>{{$roomdept[9]}}</td>
                                                                            <td>{{$roomdept[10]}}</td>
                                                                            <td>{{$roomdept[11]}}</td>
                                                                            <td>{{$roomdept[12]}}</td>
                                                                            <td class="budget-total-data">{{$roomdept[13]}}</td>
                                                                    </tr>
                                                                @else
                                                                    <tr class="bg-white text-center hiddenrow roomdept">
                                                                            <td class="headingdata">{{$roomdept[0]}}</td>
                                                                            <td>{{$roomdept[1]}}</td>
                                                                            <td>{{$roomdept[2]}}</td>
                                                                            <td>{{$roomdept[3]}}</td>
                                                                            <td>{{$roomdept[4]}}</td>
                                                                            <td>{{$roomdept[5]}}</td>
                                                                            <td>{{$roomdept[6]}}</td>
                                                                            <td>{{$roomdept[7]}}</td>
                                                                            <td>{{$roomdept[8]}}</td>
                                                                            <td>{{$roomdept[9]}}</td>
                                                                            <td>{{$roomdept[10]}}</td>
                                                                            <td>{{$roomdept[11]}}</td>
                                                                            <td>{{$roomdept[12]}}</td>
                                                                            <td class="budget-total-data">{{$roomdept[13]}}</td>
                                                                    </tr>
                                                                  

                                                                 
                                                               @endif
                                                            @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                            
                            </div>
                        </div>
                    </div>
                    <div class="row mt-8">
                        <div class="col">
                        <div class="bg-white shadow-sm" style="padding:1%; border-radius:5px;">
                                        <div class="row">
                                            <div class="col">
                                                <h4 class="idcolor">F&B Department Revenue</h4>
                                            </div>
                                            
                                        </div>
                                        
                                        <hr style="border: 1px solid #48BBBE;margin-left:0%;margin-right:0%;">
                                        <div class="table-responsive">
                                            <table class="table " style="border: 2px solid #48BBBE;">
                                                    <thead></thead>
                                                    <tbody>
                                                            <tr class="text-center">
                                                                <th class="headingdata" ></th>
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
                                                                <th>Year</th>
                                                            </tr>
                                                            @foreach($fbdept as $fb)
                                                               @if($loop->index==0)
                                                               <tr class="bg-white text-center">
                                                                        <th class="headingdata">{{$fb[0]}}<div class="triangle-down-blue mt-2" type="button" id="fbdeptbtn" style="float:right;" ></div></th>
                                                                        <td>{{$fb[1]}}</td>
                                                                        <td>{{$fb[2]}}</td>
                                                                        <td>{{$fb[3]}}</td>
                                                                        <td>{{$fb[4]}}</td>
                                                                        <td>{{$fb[5]}}</td>
                                                                        <td>{{$fb[6]}}</td>
                                                                        <td>{{$fb[7]}}</td>
                                                                        <td>{{$fb[8]}}</td>
                                                                        <td>{{$fb[9]}}</td>
                                                                        <td>{{$fb[10]}}</td>
                                                                        <td>{{$fb[11]}}</td>
                                                                        <td>{{$fb[12]}}</td>
                                                                        <td class="budget-total-data">{{$fb[13]}}</td>
                                                                </tr>
                                                               @elseif($loop->index==1)
                                                               <tr class="bg-white text-center hiddenrow fbdept">
                                                                        <td class="headingdata">
                                                                             <div class="row">
                                                                                    <div class="col-md-4">Breakfast</div>
                                                                                    <div class="col-md-2"></div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="" style="max-width:50px !important; background:#dfdfdf; border-radius:2px;">
                                                                                            <input wire:change="setBreakfastPercentage($event.target.value)" class="littlestyle"  id="breakfast_percentage" type="number" value='{{$breakfastPercentage}}'>
                                                                                            
                                                                                                <span class="">%</span>
                                                                                            
                                                                                        </div>
                                                                                        </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>{{$fb[1]}}</td>
                                                                            <td>{{$fb[2]}}</td>
                                                                            <td>{{$fb[3]}}</td>
                                                                            <td>{{$fb[4]}}</td>
                                                                            <td>{{$fb[5]}}</td>
                                                                            <td>{{$fb[6]}}</td>
                                                                            <td>{{$fb[7]}}</td>
                                                                            <td>{{$fb[8]}}</td>
                                                                            <td>{{$fb[9]}}</td>
                                                                            <td>{{$fb[10]}}</td>
                                                                            <td>{{$fb[11]}}</td>
                                                                            <td>{{$fb[12]}}</td>
                                                                            <td class="budget-total-data">{{$fb[13]}}</td>
                                                                    </tr>
                                                                @elseif($loop->index==2)
                                                                    <tr class="bg-white text-center hiddenrow fbdept">
                                                                            <td class="headingdata">{{$fb[0]}}</td>
                                                                            <td>{{$fb[1]}}</td>
                                                                            <td>{{$fb[2]}}</td>
                                                                            <td>{{$fb[3]}}</td>
                                                                            <td>{{$fb[4]}}</td>
                                                                            <td>{{$fb[5]}}</td>
                                                                            <td>{{$fb[6]}}</td>
                                                                            <td>{{$fb[7]}}</td>
                                                                            <td>{{$fb[8]}}</td>
                                                                            <td>{{$fb[9]}}</td>
                                                                            <td>{{$fb[10]}}</td>
                                                                            <td>{{$fb[11]}}</td>
                                                                            <td>{{$fb[12]}}</td>
                                                                            <td class="budget-total-data">{{$fb[13]}}</td>
                                                                    </tr>
                                                                @else
                                                                    <tr class="bg-white text-center">
                                                                            <th class="headingdata">{{$fb[0]}}</th>
                                                                            <td>{{$fb[1]}}</td>
                                                                            <td>{{$fb[2]}}</td>
                                                                            <td>{{$fb[3]}}</td>
                                                                            <td>{{$fb[4]}}</td>
                                                                            <td>{{$fb[5]}}</td>
                                                                            <td>{{$fb[6]}}</td>
                                                                            <td>{{$fb[7]}}</td>
                                                                            <td>{{$fb[8]}}</td>
                                                                            <td>{{$fb[9]}}</td>
                                                                            <td>{{$fb[10]}}</td>
                                                                            <td>{{$fb[11]}}</td>
                                                                            <td>{{$fb[12]}}</td>
                                                                            <td class="budget-total-data">{{$fb[13]}}</td>
                                                                    </tr>
                                                                  

                                                                 
                                                               @endif
                                                            @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                            
                            </div>
                        </div>
                    </div>
                    <div class="row mt-8">
                        <div class="col">
                        <div class="bg-white shadow-sm" style="padding:1%; border-radius:5px;">
                                        <div class="row">
                                            <div class="col">
                                                <h4 class="idcolor">Other Operated Department </h4>
                                            </div>
                                            
                                        </div>
                                        
                                        <hr style="border: 1px solid #48BBBE;margin-left:0%;margin-right:0%;">
                                        <div class="table-responsive">
                                            <table class="table " style="border: 2px solid #48BBBE;">
                                                    <thead></thead>
                                                    <tbody>
                                                            <tr class="text-center">
                                                                <th class="headingdata" ></th>
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
                                                                <th>Year</th>
                                                            </tr>
                                                            @foreach($oodData as $ood)
                                                               @if($loop->index==0 || $loop->index==10)
                                                               <tr class="bg-white text-center">
                                                                        <th class="headingdata">{{$ood[0]}}</th>
                                                                        <td>{{$ood[1]}}</td>
                                                                        <td>{{$ood[2]}}</td>
                                                                        <td>{{$ood[3]}}</td>
                                                                        <td>{{$ood[4]}}</td>
                                                                        <td>{{$ood[5]}}</td>
                                                                        <td>{{$ood[6]}}</td>
                                                                        <td>{{$ood[7]}}</td>
                                                                        <td>{{$ood[8]}}</td>
                                                                        <td>{{$ood[9]}}</td>
                                                                        <td>{{$ood[10]}}</td>
                                                                        <td>{{$ood[11]}}</td>
                                                                        <td>{{$ood[12]}}</td>
                                                                        <td class="budget-total-data">{{$ood[13]}}</td>
                                                                </tr>
                                                               
                                                                @elseif($loop->index==1)
                                                                    <tr class="bg-white text-center">
                                                                            <th class="headingdata">{{$ood[0]}}<div  class="triangle-down-blue mt-2" type="button" id="oibtn" style="float:right;" ></div></th>
                                                                            <td>{{$ood[1]}}</td>
                                                                            <td>{{$ood[2]}}</td>
                                                                            <td>{{$ood[3]}}</td>
                                                                            <td>{{$ood[4]}}</td>
                                                                            <td>{{$ood[5]}}</td>
                                                                            <td>{{$ood[6]}}</td>
                                                                            <td>{{$ood[7]}}</td>
                                                                            <td>{{$ood[8]}}</td>
                                                                            <td>{{$ood[9]}}</td>
                                                                            <td>{{$ood[10]}}</td>
                                                                            <td>{{$ood[11]}}</td>
                                                                            <td>{{$ood[12]}}</td>
                                                                            <td class="budget-total-data">{{$ood[13]}}</td>
                                                                    </tr>
                                                                @else
                                                                    <tr class="bg-white text-center hiddenrow oidept">
                                                                            <td class="headingdata">{{$ood[0]}}</td>
                                                                            <td>{{$ood[1]}}</td>
                                                                            <td>{{$ood[2]}}</td>
                                                                            <td>{{$ood[3]}}</td>
                                                                            <td>{{$ood[4]}}</td>
                                                                            <td>{{$ood[5]}}</td>
                                                                            <td>{{$ood[6]}}</td>
                                                                            <td>{{$ood[7]}}</td>
                                                                            <td>{{$ood[8]}}</td>
                                                                            <td>{{$ood[9]}}</td>
                                                                            <td>{{$ood[10]}}</td>
                                                                            <td>{{$ood[11]}}</td>
                                                                            <td>{{$ood[12]}}</td>
                                                                            <td class="budget-total-data">{{$ood[13]}}</td>
                                                                    </tr>
                                                                  

                                                                 
                                                               @endif
                                                            @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-8" id="opexrow">
                <div class="row mt-8">
                        <div class="col">
                        <div class="bg-white shadow-sm" style="padding:1%; border-radius:5px;">
                                        <div class="row">
                                            <div class="col">
                                                <h4 class="idcolor">Operating Expenses</h4>
                                            </div>
                                            
                                        </div>
                                        
                                        <hr style="border: 1px solid #48BBBE;margin-left:0%;margin-right:0%;">
                                        <div class="table-responsive">
                                            <table class="table " style="border: 2px solid #48BBBE;">
                                                    <thead></thead>
                                                    <tbody>
                                                            <tr class="text-center">
                                                                <th class="headingdata" ></th>
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
                                                                <th>Year</th>
                                                            </tr>
                                                            @foreach($opexData as $opex)
                                                              @if($opex['class']=='mainType' )
                                                            
                                                                <tr class="bg-white text-center">
                                                                    <th class="headingdata">{{$opex['name']}}<div class="triangle-down-blue mt-2" type="button" id="{{$opex['id']}}" style="float:right;" ></div></th>
                                                                            <td>{{$opex['january']}}</td>
                                                                            <td>{{$opex['february']}}</td>
                                                                            <td>{{$opex['march']}}</td>
                                                                            <td>{{$opex['april']}}</td>
                                                                            <td>{{$opex['may']}}</td>
                                                                            <td>{{$opex['june']}}</td>
                                                                            <td>{{$opex['july']}}</td>
                                                                            <td>{{$opex['august']}}</td>
                                                                            <td>{{$opex['september']}}</td>
                                                                            <td>{{$opex['october']}}</td>
                                                                            <td>{{$opex['november']}}</td>
                                                                            <td>{{$opex['december']}}</td>
                                                                            <td class="budget-total-data">{{$opex['total']}}</td>
                                                                </tr>
                                                              
                                                                 @else
                                                                 <tr class="bg-white text-center hiddenrow {{$opex['class']}}">
                                                                            <td class="headingdata">{{$opex['name']}}</td>
                                                                            <td>{{$opex['january']}}</td>
                                                                            <td>{{$opex['february']}}</td>
                                                                            <td>{{$opex['march']}}</td>
                                                                            <td>{{$opex['april']}}</td>
                                                                            <td>{{$opex['may']}}</td>
                                                                            <td>{{$opex['june']}}</td>
                                                                            <td>{{$opex['july']}}</td>
                                                                            <td>{{$opex['august']}}</td>
                                                                            <td>{{$opex['september']}}</td>
                                                                            <td>{{$opex['october']}}</td>
                                                                            <td>{{$opex['november']}}</td>
                                                                            <td>{{$opex['december']}}</td>
                                                                            <td class="budget-total-data">{{$opex['total']}}</td>
                                                                    </tr>
                                                             
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                            
                            </div>
                        </div>
                    </div>
            </div>

          



          </div>
    </div>

    <script>

       

        $(document).ready(function(){
            document.addEventListener("contentChanged", () => {
                
                    $('#opexrow').css('display', 'none');
                    $(".hiddenrow").hide();
            
                
            });

            $('#opexrow').css('display', 'none');
            $('.revenuebtn').click(function(){
                $('#revenuerow').css('display', 'block');
                $('#opexrow').css('display', 'none');
            });

            $('.opexbtn').click(function(){
		 
                $('#opexrow').css('display', 'block');
                $('#revenuerow').css('display', 'none');
            });
            $(".hiddenrow").hide();
            fetch("{{route('getMinDate')}}").then(result=> result.json()).then(json => show1(json));
            function show1(emp)
                {
                    var minyear=emp.minyear;
                    var currentyear=(new Date()).getFullYear();
                    var futureyear=currentyear;
                    for (var i = minyear; i<= futureyear; i++) {
                    var option='<option value="'+i+'" >'+i+'</option>';
                    $("#dropdown").append(option);
                    
                    }
                    $("#dropdown").val(currentyear);
                

                }
           

            $('#roomdeptbtn').on('click', function(){
                $(".roomdept").toggle();
            })

            $('#fbdeptbtn').on('click', function(){
                $(".fbdept").toggle();
            })

            $('#oibtn').on('click', function(){
                $(".oidept").toggle();
            })

            $('#opex1').on('click', function(){
                $(".opex1").toggle();
            })
            $('#opex2').on('click', function(){
                $(".opex2").toggle();
            })
            $('#opex3').on('click', function(){
                $(".opex3").toggle();
            })
            $('#opex4').on('click', function(){
                $(".opex4").toggle();
            })
            $('#opex5').on('click', function(){
                $(".opex5").toggle();
            })
            $('#opex6').on('click', function(){
                $(".opex6").toggle();
            })
            $('#opex7').on('click', function(){
                $(".opex7").toggle();
            })
            $('#opex8').on('click', function(){
                $(".opex8").toggle();
            })
            $('#opex9').on('click', function(){
                $(".opex9").toggle();
            })

           

        })

        

        </script>
    
</div>
