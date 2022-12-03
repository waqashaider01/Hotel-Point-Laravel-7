<div class="mb-30">
    <div class="row mt-8" id="">
        <div class="col">
            <div class="row" id="">
                <div class="col">
                    <div class="cashier-info-card bg-white shadow-sm" style="padding:1%;">
                        <h3 style="text-align:center;">Summary</h3>
                    </div>
                </div>
            </div>
            <div class="row mt-4" id="">
                <div class="col-md-6" id="">
                    <div class="row" id="">
                        <div class="col">
                            <div class="cashier-info-card bg-white shadow-sm" style="padding:1%;margin-bottom:-1%;">
                                <h4 style="" class="idcolor">Front Desk</h4>
                                <hr>
                                <div class="mt-1 ml-5 table" id='' style="background-color:white !important;max-width:95% !important;">
                                    <div>
                                        <div class="row th" style="background-color:white !important;">
                                            <div class="col">Deposit</div>
                                            <div class="col">Cash</div>
                                            <div class="col">Credit Card</div>
                                            <div class="col">Debtor</div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class='row mytr'>
                                            <div class='col'>{{ showPriceWithCurrency($deposit_sum ?? 0) }}</div>
                                            <div class='col'>{{ showPriceWithCurrency($cash_sum ?? 0) }}</div>
                                            <div class='col'>{{ showPriceWithCurrency($card_sum ?? 0) }}</div>
                                            <div class='col'>{{ showPriceWithCurrency($debtor_sum ?? 0) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" id="">
                    <div class="row" id="">
                        <div class="col">
                            <div class="cashier-info-card bg-white shadow-sm" style="padding:1%;">
                                <h4 style="" class="idcolor">Services</h4>
                                <hr>
                                <div class="mt-1 ml-5 table" id='' style="background-color:white !important;max-width:90% !important;">
                                    <div>
                                        <div class="row th" style="background-color:white !important;">
                                            <div class="col">Cash</div>
                                            <div class="col">Credit Card</div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class='row mytr'>
                                            <div class='col'>{{ showPriceWithCurrency($service_cash_sum ?? 0) }}</div>
                                            <div class='col'>{{ showPriceWithCurrency($service_card_sum ?? 0) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" id="">
                    <div class="row" id="">
                        <div class="col">
                            <div class="cashier-info-card bg-white shadow-sm" style="padding:1%;">
                                <h4 style="" class="idcolor">Overnight Tax</h4>
                                <hr>
                                <div class="mt-1 ml-5 table" id='' style="background-color:white !important;max-width:90% !important;">
                                    <div>
                                        <div class="row th" style="background-color:white !important;">
                                            <div class="col">Cash</div>
                                            <div class="col">Credit Card</div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class='row mytr'>
                                            <div class='col'>{{ showPriceWithCurrency($overnight_cash_sum ?? 0) }}</div>
                                            <div class='col'>{{ showPriceWithCurrency($overnight_card_sum ?? 0) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 mb-5">
        <div class="row">
            <div class="col-md-6 mytr d-flex text-center" style="transform: scaleX(0.97);">
                <div class="col idcolor">Cash Register</div>
                <div class='col'>{{ showPriceWithCurrency($register_cash) }}</div>
            </div>
            <div class="col-md-6 mytr d-flex text-center" style="transform: scaleX(0.97);">
                <div class="col idcolor">Balance To Delivery</div>
                <div class='col'>{{ showPriceWithCurrency($register_balance) }}</div>
            </div>
        </div>
        @if ($is_open_register)
            <div class="row d-print-none">
                <div class="col d-flex justify-content-end">
                    <button type="button" style="padding: 10px;color: white;background-color: red;opacity: 1;border-radius: 4px;font-weight: 400;margin-top: 10px;letter-spacing: 2px;" class="btn btn-danger" data-toggle="modal"
                            data-target="#close_cashier">Close Cashier
                    </button>
                </div>
            </div>
        @endif
        @if ($is_close_register)
            <div class="row d-print-none">
                <div class="col d-flex justify-content-center mt-2">
                    <span style="color: red">
                        Cashier Closed for {{ $date }}
                    </span>
                </div>
            </div>
        @endif

    </div>

    <div class="modal fade" id="close_cashier" style="border-radius:0px !important;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable" style="max-width:300px !important;min-width:300px !important;">
            <div class="modal-content rounded-0">
                <div class="modal-header shadow-sm" style="border-radius:0px !important;z-index:10;">
                    <h5 style="text-align:center;margin-left:25%;" class="modal-title text-dark text-center">
                        Insert Password</h5>
                </div>
                <div class="modal-body" style="position:relative;background-color:#fff;">
                    <div class="form-style-6" id="">
                        <div style="">
                            <input type="password" placeholder="Enter Password for close cashier..." wire:model="password" />
                            <x-error field="password" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color:#fff;">
                    <span type="button" class="infbtn close" wire:click="closeRegister" style="color:green;">Confirm</span>
                    <span type="button" class="infbtn close" style="color:red;" data-dismiss="modal">Close</span>
                </div>
            </div>
        </div>
    </div>
</div>
