<div>
    <div class=" mt-5 ">
        <div class="">
            <div class=" tab-container">
                <ul class="nav nav-pills justify-content-center flex-column flex-sm-row d-print-none mt-5 w-100"
                    id="myTab" role="tablist">
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='arrival')?'active':''}}" 
                           wire:click="$set('tab', 'arrival')" href="#">Arrivals List</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='departure')?'active':''}}"
                           wire:click="$set('tab', 'departure')" href="#">Departure List</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='inhouse')?'active':''}}" 
                           wire:click="$set('tab', 'inhouse')" href="#">In House List</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='availability')?'active':''}}" 
                           wire:click="$set('tab', 'availability')" href="#">Availability Rooms</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='roomsold')?'active':''}}" 
                           wire:click="$set('tab', 'roomsold')" href="#">Room Types Sold</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='roomrate')?'active':''}}" 
                           wire:click="$set('tab', 'roomrate')" href="#">Room Rate Sold</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='country')?'active':''}}" 
                           wire:click="$set('tab', 'country')" href="#">Country Report</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='guests')?'active':''}}" 
                           wire:click="$set('tab', 'guests')" href="#">Total Number of Guests</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='cancelled')?'active':''}}" 
                           wire:click="$set('tab', 'cancelled')" href="#">Cancellation Room Nights</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='breakfast')?'active':''}}" 
                           wire:click="$set('tab', 'breakfast')" href="#">Breakfast Daily</a>
                    </li>
                    <!-- <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='guests')?'active':''}}" 
                           wire:click="$set('tab', 'guests')" href="#">Total Number of Guests</a>
                    </li> -->
                    
                </ul>
            </div>
            <div class="tab-content mt-5" >
                @if($tab == "arrival")
                   @livewire('reports.roomdivision.arrivals', key(time()))
                @elseif($tab == "departure")
                    @livewire('reports.roomdivision.departures', key(time()))
                @elseif($tab == "inhouse")
                    @livewire('reports.roomdivision.inhouse', key(time()))
                 @elseif($tab == "availability")
                    @livewire('reports.roomdivision.availabilities', key(time()))
                @elseif($tab == "roomsold")
                    @livewire('reports.roomdivision.roomsold', key(time()))
                @elseif($tab == "roomrate")
                    @livewire('reports.roomdivision.roomrate', key(time()))
                @elseif($tab == "country")
                    @livewire('reports.roomdivision.country', key(time())) 
                @elseif($tab == "guests")
                    @livewire('reports.roomdivision.guests', key(time()))
                @elseif($tab == "cancelled")
                    @livewire('reports.roomdivision.cancelled-nights', key(time()))
                @elseif($tab == "breakfast")
                    @livewire('reports.roomdivision.daily-breakfast', key(time())) 
                
                @endif
            </div>
        </div>
    </div>
</div>
