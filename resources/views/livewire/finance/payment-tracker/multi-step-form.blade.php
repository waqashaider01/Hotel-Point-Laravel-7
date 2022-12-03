<div>
    <div style="height: 90px;"> 

        <div class="progress connecting-line" style="height: 5px;">
            <div class="progress-bar {{($currentStep==1?'firststep':'')}} {{($currentStep==2?'secondstep':'')}} {{($currentStep==3?'thirdstep':'')}}" role="progressbar" style="background: skyblue;"
                aria-valuemin="0" aria-valuemax="100">
            </div>
        </div> 

        <ul id="progressbar" class="nav nav-fill bg-transparent">
            <li id="verify_user" class="nav-item {{$currentStep==1? 'active':''}}">Verification</li>
            <li id="process_payment" class="nav-item {{$currentStep==2? 'active':''}}">Payments</li>
            <li id="finish" class="nav-item {{$currentStep==3? 'active':''}}">Finish</li>
        </ul> 
    </div>

    <div class="container {{ $currentStep!= 1 ? 'display-none':'' }}" id="step1">

        <div class="row">
            <div class="col-md-12 text-center alert alert-light">
                
                    <img id="verify_logo" src="../images/logo/mobile_verfi.png" />
                    <h3>Please enter your password  to verify</h3>
                    <input type="hidden" id="otp_code">
                    <div id="verification_form" class="justify-content-center">
                        <div class="row justify-content-center mb-2">
                        <input type="password" class="w-80" wire:model.defer="password">
                        </div>
                        <div class="row justify-content-center">
                            <button type="button" class="btn btn-primary" data-value=""
                                id="self_verify" wire:click="firstStepSubmit()">Verify</button>
                            <button type="button" class="btn btn-secondary" wire:click="cancel()" >Go
                                Back</button>
                        </div>
                       
                    </div>
               
            </div>
        </div>
   </div>
      <div class="container justify-content-center {{ $currentStep != 2 ? 'display-none' : '' }}" id="step2">
          
            <div class="row mb-3 mt-3">
                <h1 class="text-center w-100" style="color: black;">Payment Details</h1>
            </div>
            <div class=" row col-md-12">
                <div class="col-md-3"><img src="../images/logo/paypal.png"
                        style="width: 60px; height: 60px;" /></div>
                <div class="col-md-3"><img src="../images/logo/visas.png"
                        style="width: 60px; height: 60px;" /></div>
                <div class="col-md-3"><img src="../images/logo/mstrcard.png"
                        style="width: 60px; height: 60px;" /></div>
                <div class="col-md-3"><img src="../images/logo/unionpay.png"
                        style="width: 60px; height: 60px;" /></div>
            </div>
            <div class="{{empty($pciUrl)? 'display-none':'' }}">
                <div class="row mt-5 " id="payment_charge_div">
                    <label class="col-md-12">Charge Amount</label>
                    <input wire:model.defer="balance" id="chargeAmount" class="col-md-12 form-control" type="number">
                    <x-error field="balance"/>
                </div>
                <div class="row mt-5 " id="carddiv">
                    <div class=" text-center" style="height: 400px;">
                        <iframe id="cardframe" frameBorder="0" hspace="0" vspace="0"
                            style="min-width: 100% !important; height: auto !important; min-height: 90%;  border: none; margin-right: -20px; margin-left: -20px; padding: 0px !important;"
                            src="{{$pciUrl}}"></iframe>
                    
                    </div>
                </div>
                
                <div class="row justify-content-center mt-3" >
                    <button wire:click="submitSecondStep()" type="submit" class="btn btn-primary w-40 m-5">Process
                        Payment</button>
                    <button wire:click="cancel()" type="submit" class="btn btn-primary w-40 m-5">Cancel</button>
                
                </div>
            </div>
            <div class="row mt-10 {{empty($pciUrl)? '':'display-none' }}" id="nocarddiv">
                <div class="w-100 text-center" style="height: 100px;">
                    <h1 id="nocardtext">This reservation does not have payment card</h1>
                    <button class="btn btn-primary mt-5 end_process"
                        style="width: 40% !important" wire:click="cancel()">Cancel</button>
                </div>
            </div>
           
        </div>
        <div class="container {{ $currentStep != 3 ? 'display-none' : '' }}" id="step3">
            <div class="row">
                <div class="col-md-12 text-center alert alert-light">
                    <svg class="checkmark" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 52 52">
                        <circle class="checkmark__circle" cx="26" cy="26" r="25"
                            fill="none" />
                        <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                    </svg>
                    <h1>You have successfully made payment</h1>
                    <button class="btn btn-primary w-100 mt-3 end_process" wire:click="cancel()" >Finish</button>
                </div>
            </div>
     </div> 

    
   
</div>
