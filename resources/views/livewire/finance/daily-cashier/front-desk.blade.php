<div class="row mt-8">
    <div class="col-12">
        <div class="row" id="">
            <div class="col">
                <div class="cashier-info-card bg-white shadow-sm" style="padding:1%;">
                    <h3 style="text-align:center;">Front Desk</h3>
                </div>
            </div>
        </div>
        <div class="row mt-4" id="">
            <x-simple-table title="Deposit">
                <x-slot name="thead">
                    <th>ID Booking</th>
                    <th>Guest Name</th>
                    <th>Amount</th>
                    <th>Payment Type</th>
                </x-slot>
                @foreach ($deposits as $item)
                    <tr>
                        <td>{{ $item->reservation_id }}</td>
                        <td>{{ $item->reservation->guest->full_name }}</td>
                        <td>{{ showPriceWithCurrency($item->value) }}</td>
                        <td>{{ $item->payment_method->name }}</td>
                    </tr>
                @endforeach
            </x-simple-table>
        </div>
        <div class="row mt-4" id="">
            <x-simple-table title="Cash">
                <x-slot name="thead">
                    <th>ID Booking</th>
                    <th>Guest Name</th>
                    <th>Amount</th>
                    <th>Comments</th>
                </x-slot>
                @foreach ($cash as $item)
                    <tr>
                        <td>{{ $item->reservation_id }}</td>
                        <td>{{ $item->reservation->guest->full_name }}</td>
                        <td>{{ showPriceWithCurrency($item->value) }}</td>
                        <td>{{ $item->comments }}</td>
                    </tr>
                @endforeach
            </x-simple-table>
        </div>
        <div class="row mt-4" id="">
            <x-simple-table title="Credit Card">
                <x-slot name="thead">
                    <th>ID Booking</th>
                    <th>Guest Name</th>
                    <th>Amount</th>
                    <th>Credit Type</th>
                    <th>Comments</th>
                </x-slot>
                @foreach ($credit_cards as $item)
                    <tr>
                        <td>{{ $item->reservation_id }}</td>
                        <td>{{ $item->reservation->guest->full_name }}</td>
                        <td>{{ showPriceWithCurrency($item->value) }}</td>
                        <td>{{ $item->payment_method->name }}</td>
                        <td>{{ $item->comments }}</td>
                    </tr>
                @endforeach
            </x-simple-table>

        </div>
        <div class="row mt-4" id="">
            <x-simple-table title="Debtor">
                <x-slot name="thead">
                    <th>ID Booking</th>
                    <th>Guest Name</th>
                    <th>Amount</th>
                    <th>Receipt Number</th>
                    <th>Comments</th>
                </x-slot>
                @foreach ($debtors as $item)
                    <tr>
                        <td>{{ $item->reservation_id }}</td>
                        <td>{{ $item->reservation->guest->full_name }}</td>
                        <td>{{ showPriceWithCurrency($item->value) }}</td>
                        <td>{{ $item->payment_method->name }}</td>
                        <td>{{ $item->comments }}</td>
                    </tr>
                @endforeach
            </x-simple-table>

        </div>
    </div>
    <div class="col-12 mt-8">
        <div class="row" id="">
            <div class="col">
                <div class="cashier-info-card bg-white shadow-sm" style="padding:1%;">
                    <h3 style="text-align:center;">Services</h3>
                </div>
            </div>
        </div>
        <div class="row mt-4" id="">
            <x-simple-table id="Cash2" title="Cash">
                <x-slot name="thead">
                    <th>ID Booking</th>
                    <th>Guest Name</th>
                    <th>Amount</th>
                    <th>Comments</th>
                </x-slot>
                @foreach ($service_cash as $item)
                    <tr>
                        <td>{{ $item->reservation_id }}</td>
                        <td>{{ $item->reservation->guest->full_name }}</td>
                        <td>{{ showPriceWithCurrency($item->value) }}</td>
                        <td>{{ $item->comments }}</td>
                    </tr>
                @endforeach
            </x-simple-table>

        </div>
        <div class="row mt-4" id="">
            <x-simple-table id="Credit-Card2" title="Credit Card">
                <x-slot name="thead">
                    <th>ID Booking</th>
                    <th>Guest Name</th>
                    <th>Amount</th>
                    <th>Credit Type</th>
                    <th>Comments</th>
                </x-slot>
                @foreach ($service_credit_cards as $item)
                    <tr>
                        <td>{{ $item->reservation_id }}</td>
                        <td>{{ $item->reservation->guest->full_name }}</td>
                        <td>{{ showPriceWithCurrency($item->value) }}</td>
                        <td>{{ $item->payment_method->name }}</td>
                        <td>{{ $item->comments }}</td>
                    </tr>
                @endforeach
            </x-simple-table>

        </div>
        <div class="row mt-4" id="">
            <x-simple-table title="Room Charge">
                <x-slot name="thead"> 
                    <th>ID Booking</th>
                    <td>Product</td>
                    <td>Units</td>
                    <td>Amount</td>
                    <td>Time</td>
                    <td>Receipt Number</td>
                </x-slot>
                @foreach ($room_charges as $item)
                    <tr>
                        <td>{{ $item->reservation_id }}</td>
                        <td>{{ $item->extra_charge?->product }}</td>
                        <td>{{ $item->units }}</td>
                        <td>{{ $item->extra_charge_total - $item->extra_charge_discount }}</td>
                        <td>{{ $item->time }}</td>
                        <td>{{ $item->receipt_number }}</td>
                    </tr>
                @endforeach
            </x-simple-table>

        </div>
    </div>
</div>
