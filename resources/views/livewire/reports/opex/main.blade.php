<div>
    <div class=" mt-5 ">
        <div class="">
            <div class=" tab-container">
                <ul class="nav nav-pills justify-content-center flex-column flex-sm-row d-print-none mt-5 w-100"
                    id="myTab" role="tablist">
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='fb')?'active':''}}" 
                           wire:click="$set('tab', 'fb')" href="#">F&B Opex</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='sm')?'active':''}}"
                           wire:click="$set('tab', 'sm')" href="#">S&M Opex</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='rd')?'active':''}}" 
                           wire:click="$set('tab', 'rd')" href="#">R&D Opex</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='rm')?'active':''}}" 
                           wire:click="$set('tab', 'rm')" href="#">R&M Opex</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='ood')?'active':''}}" 
                           wire:click="$set('tab', 'ood')" href="#">OOD Opex</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='ag')?'active':''}}" 
                           wire:click="$set('tab', 'ag')" href="#">A&G Opex</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='bm')?'active':''}}" 
                           wire:click="$set('tab', 'bm')" href="#">Basic Management Fee</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='noi')?'active':''}}" 
                           wire:click="$set('tab', 'noi')" href="#">Non Operating Items</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='fc')?'active':''}}" 
                           wire:click="$set('tab', 'fc')" href="#">Fixed Charge</a>
                    </li>
                    
                    
                </ul>
            </div>
            <div class="tab-content mt-5" >
                @if($tab == "fb")
                   @livewire('reports.opex.fb')
                @elseif($tab == "sm")
                    @livewire('reports.opex.sm')
                @elseif($tab == "rd")
                    @livewire('reports.opex.rd')
                 @elseif($tab == "rm")
                    @livewire('reports.opex.rm')
                @elseif($tab == "ood")
                    @livewire('reports.opex.ood')
                @elseif($tab == "ag")
                    @livewire('reports.opex.ag')
                @elseif($tab == "bm")
                    @livewire('reports.opex.bm')
                @elseif($tab == "noi")
                    @livewire('reports.opex.noi')
                @elseif($tab == "fc")
                    @livewire('reports.opex.fc')
                
                @endif
            </div>
        </div>
    </div>
</div>
