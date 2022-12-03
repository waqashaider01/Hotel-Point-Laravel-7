<div class="row mt-8">
    <div class="col">
        <div class="row" id="">
            <div class="col">
                <div class="cashier-info-card bg-white shadow-sm" style="padding:1%;">
                    <h3 style="text-align:center;">Overnight Tax</h3>
                </div>
            </div>
        </div>
        <div class="row mt-4" id="">
            <x-simple-table id="overnight-cash" title="Cash">
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
            <x-simple-table id="overnight-credit-card" title="Credit Card">
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
    </div>
</div>
