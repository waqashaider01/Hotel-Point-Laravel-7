<div>
    <div class=" mt-5 ">
        <div class="">
            <div class=" tab-container">
                <ul class="nav nav-pills justify-content-center flex-column flex-sm-row d-print-none mt-5 w-100"
                    id="myTab" role="tablist">
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='commission')?'active':''}}" 
                           wire:click="$set('tab', 'commission')" href="#">Market Commission</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='cancelNight')?'active':''}}"
                           wire:click="$set('tab', 'cancelNight')" href="#">Cancellation Market Nights</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='cancelRevenue')?'active':''}}" 
                           wire:click="$set('tab', 'cancelRevenue')" href="#">Cancelled Market Revenue</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='segmentNight')?'active':''}}" 
                           wire:click="$set('tab', 'segmentNight')" href="#">Segmentation Market Nights</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='guestsSegment')?'active':''}}" 
                           wire:click="$set('tab', 'guestsSegment')" href="#">Guests Market Segentation</a>
                    </li>
                    
                    
                </ul>
            </div>
            <div class="tab-content mt-5" >
                @if($tab == "commission")
                   @livewire('reports.b2b.commission', key(time()))
                @elseif($tab == "cancelNight")
                    @livewire('reports.b2b.cancellation-nights', key(time()))
                @elseif($tab == "cancelRevenue")
                    @livewire('reports.b2b.cancellation-revenue', key(time()))
                 @elseif($tab == "segmentNight")
                    @livewire('reports.b2b.segmentation-nights', key(time()))
                @elseif($tab == "guestsSegment")
                    @livewire('reports.b2b.guests-segmentation', key(time()))
                
                @endif
            </div>
        </div>
    </div>
</div>
