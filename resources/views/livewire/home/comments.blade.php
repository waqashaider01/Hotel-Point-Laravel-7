<div class="comments_card" style="">
    <style>
        .form-style-6 select:focus {
            padding: 0 !important;
            padding-inline: 3% !important;
        }
    </style>
    <div class="comments_div">
        <h2 class="pt-7 pl-3 pb-7">Comments</h2>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="form-style-6">
                <div class="row">
                    <div class="col">
                        <select id="" wire:model.defer="type">
                            <option value="hk">HouseKeeping Comments</option>
                            <option value="fd">Front Desk Comments</option>
                            <option value="fb">F & B Comments</option>
                        </select>
                        <x-error field="type" />
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <label>Room Number</label>
                        <select wire:model.defer="room" >
                            <option value="">Select Room</option>
                            @foreach($rooms as $room)
                              <option value='{{$room->id}}'>{{$room->number}}</option>
                            @endforeach
                        <x-error field="room" />
                    </div>
                    <div class="col">
                        <label>Date</label>
                        <input id="" wire:model.defer="date" type="date">
                        <x-error field="date" />
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label>Comment</label>
                        <textarea id="" wire:model.defer="comment" style="min-height:80px !important;" type="text"></textarea>
                        <x-error field="comment" />
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div style="float:right;margin-top:1%;">
                            <button type="button" wire:click="saveComment" style='margin-top:6%;background-color:#48BD91;border:none !important;padding:5px 12px;color:white;border-radius:2px;'>
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
</div>
