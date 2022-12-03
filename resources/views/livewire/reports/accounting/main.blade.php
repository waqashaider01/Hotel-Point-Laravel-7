<div>
    <div class=" mt-5 ">
        <div class="">
            <div class=" tab-container">
                <ul class="nav nav-pills justify-content-center flex-column flex-sm-row d-print-none mt-5 w-100"
                    id="myTab" role="tablist">
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='vat')?'active':''}}" 
                           wire:click="$set('tab', 'vat')" href="#">VAT</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='card')?'active':''}}"
                           wire:click="$set('tab', 'card')" href="#">Credit Card</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='cash')?'active':''}}" 
                           wire:click="$set('tab', 'cash')" href="#">Cash</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='deptor')?'active':''}}" 
                           wire:click="$set('tab', 'deptor')" href="#">Deptor</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='bank')?'active':''}}" 
                           wire:click="$set('tab', 'bank')" href="#">Bank Transfer</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='overnight')?'active':''}}" 
                           wire:click="$set('tab', 'overnight')" href="#">Overnight Tax</a>
                    </li>
                    <li class="nav-item" role="presentation" >
                        <a class="nav-link flex-sm-fill text-sm-center {{($tab=='city')?'active':''}}" 
                           wire:click="$set('tab', 'city')" href="#">City Tax</a>
                    </li>
                    
                    
                </ul>
            </div>
            <div class="tab-content mt-5" >
                @if($tab == "vat")
                   @livewire('reports.accounting.vat', key(time()))
                @elseif($tab == "card")
                    @livewire('reports.accounting.credit-card', key(time()))
                @elseif($tab == "cash")
                    @livewire('reports.accounting.cash', key(time()))
                 @elseif($tab == "deptor")
                    @livewire('reports.accounting.deptor', key(time()))
                @elseif($tab == "bank")
                    @livewire('reports.accounting.bank', key(time()))
                @elseif($tab == "overnight")
                    @livewire('reports.accounting.overnight', key(time()))
                @elseif($tab == "city")
                    @livewire('reports.accounting.city', key(time()))
                
                @endif
            </div>
        </div>
    </div>
</div>
