<div id="sendEmailModal" class="modal" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-content" style="width:60%;margin-left:20% !important;margin-top:5%;border-radius:0px;">
        <div class="modal-header" style="background-color:#EAECEE;">
            <h5 class="modal-title text-dark"
                style="margin-left:45% !important;padding:0px;font-size:25px;margin-top:-10px;margin-bottom:-10px;">
                Email &nbsp;<i class="fa fa-paper-plane text-dark" aria-hidden="true"></i></h5>
        </div>
        <div class="modal-body" id="agency_detail">
            <div class="row " style="margin-left:-2% !important;margin-right:-2% !important;">
                <div class='col form-style-6 '>
                    <div class=""><label>Template</label>
                        <select class="form-control1" wire:model="selected_template">
                            <option value="" selected>Choose Template...</option>
                            @foreach ($templates as $template)
                                <option value="{{ $template->id }}">{{ $template->name }}</option>
                            @endforeach
                        </select>
                        <x-error field="selected_template"></x-error>
                    </div>
                </div>
                <div class="col form-style-6 " style="">
                    <label>Subject:</label>
                    <input class="form-control1" placeholder="Enter Email Subject..." wire:model.defer="email_subject"
                        type="text" />
                    <x-error field="email_subject"></x-error>
                </div>
                <div class=" col form-style-6 " style="">
                    <label>To: </label>
                    <input class="form-control1" wire:model="guest_email" type="email" placeholder="jhon_doe@mail.com" />
                    <x-error field="guest_email"></x-error>
                </div>
            </div>
            <div class="row"
                style="background-color:#F2EFEA;border:1px solid #CBCBCB;height:300px ; overflow-y: scroll;">
                <div class='col-md-12'>
                    <div>
                        {!! $email_body !!}
                    </div>
                    <div class="mt-2">
                        @foreach ($attachments as $item)
                            <p class="alert alert-success">Attached File {{ $item->getClientOriginalName() }}
                                <i class="fa fa-paperclip" style="color:black;"></i>
                            </p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row ">
                <div class='col'>
                    <div style="float:left;margin-right:3px;">
                        <label class="btn btn-success">
                            <i class="fa fa-paperclip" style="color:#fff;"></i>
                            <input type="file" style="display: none" wire:model="attachment" />
                        </label>
                    </div>
                    <button type="button" class="btn btn-success" wire:click="sendEmail" wire:loading.remove><i
                            class="fa fa-paper-plane text-light" aria-hidden="true"></i></button>
                    <button class="btn btn-success" type="button" disabled wire:loading wire:target="sendEmail">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Sending Email...
                    </button>
                    <button type="button" class="btn btn-light-danger font-weight-bold hide" data-dismiss="modal">Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('livewire:load', function () {
        @this.on('closeModal', function () {
            $('#sendEmailModal').modal('hide');
        });
        @this.on('emailSent', function(message){
            Swal.fire({
                icon: 'success',
                title: message,
                timer: 2000
            })
        });
    });
</script>
