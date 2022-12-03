<div>
    <div class="d-flex flex-column-fluid mt-5 ">
        <div class="container-fluid">
            <div class="row mb-10 m-0" style="margin-bottom:50%;">
                <div class="col p-0">
                    <div class="tax_settings shadow-sm bg-white">
                        <h1>Template Settings</h1>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <div class="form-style-6">
                                    <table>
                                        <tr>
                                            <td>
                                                <select class="form-control1" wire:model="type">
                                                    <option value="" selected disabled>Choose Template type...
                                                    </option>
                                                    <option value="email">Email Template</option>
                                                    <option value="checkin">Registration Template</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control1" wire:model="select_template"
                                                    style="max-width:250px !important;min-width:250px !important;">
                                                    <option value="" disabled>Choose Template...</option>
                                                    @foreach ($templates as $template)
                                                        <option value="{{ $template->id }}">{{ $template->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <i class="fa fa-trash ml-2 mb-1" style="font-size: 1.5em;"
                                                    wire:click="deleteTemplate" type="button"></i>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-10 m-0" style="margin-bottom:50%;">
                <div class="col p-0">
                    <form class="infocard shadow-sm bg-white" wire:submit.prevent="saveTemplate">
                        <div class="row">
                            <div class="col-11">
                                <h1 style="margin-left:12%;">Edit Template</h1>
                            </div>
                            <div class="col-1">
                            </div>
                        </div>
                        <hr>
                        <div class="card-body p-3 mb-2 bg-light text-white rounded"
                            style="
                                line-height:2em; margin: 10px 0 10px; margin-top:2em; margin-bottom:2em;
                                    background-size: 600% 400%;">
                            <div class="row mb-4">
                                <div class="col-2">
                                    <label for="texttamplate" class=" col-form-label"
                                        style="color:black;font-weight:bold;">Template Name:</label>
                                </div>
                                <div class="col-9">
                                    <div class="control-group">
                                        <input class="form-control" wire:model.defer="selected_template.name"
                                            placeholder="Enter Template Name.." type="text" />
                                        <x-error field="selected_template.name" />
                                    </div>
                                </div>
                                <div class="col d-flex justify-content-end">
                                    <button class="btn btn-outline-info short_code_btn" data-toggle="modal" data-target="#shortCodeModal">Short Codes</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="control-group">
                                        <input type="hidden" id="templateContent" wire:model.defer="selected_template.template" class="d-none">
                                        <div class="controls" wire:ignore.self>
                                            <div id="template" style="width:100%; background-color: #fff;" data-livewire-input="#templateContent" x-init='$wire.emit("initQuillReadOnly", "#template", "", {placeholder: "Select a template from the above dropdown"})'></div>
                                        </div>
                                        <x-error field="selected_template.template" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-10"></div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-success mr-2">Update
                                        Template
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- <script>
        //Get the Data from a JSON or Hidden Feild
        let availableTags = [
            "[id]",
            "[booking_code]",
            "[channex_status]",
            "[reservation_status]",
            "[booking_agency]",
            "[total_daily_rate]",
            "[charge_date]",
            "[payment_method]",
            "[discount]",
            "[payments_mode]",
            "[checkin_date]",
            "[checkout_date]",
            "[arrival_date]",
            "[departure_date]",
            "[actual_checkin]",
            "[actual_checkout]",
            "[nights]",
            "[arrival_hour]",
            "[cancellation_date]",
            "[guest_country]",
            "[adults]",
            "[kids]",
            "[infants]",
            "[booking_date]",
            "[comment]",
            "[guest_name]",
            "[guest_phone]",
            "[guest_email]",
            "[rate_type]",
            "[room_number]",
            "[room_type]",
            "[guest_id]",
            "[reservation_amount]",
            "[commission_amount]",
            "[channex_guest_city]",
            "[channex_guest_address]",
            "[channex_guest_language]",
            "[channex_guest_zip]",
            "[channex_revision_id]",
            "[channex_system_id]",
            "[channex_inserted_at]",
            "[channex_payment_collect]",
            "[channex_booking_room_id]",
            "[channex_unique_id]",
            "[channex_ota_code]",
            "[channex_virtual_card]",
            "[notif_status]",
            "[checkin_time]",
            "[checkout_time]",
            "[overnight_tax]"

        ]; // array of autocomplete words
        let minWordLength = 2;

        function split(val) {
            return val.split(' ');
        }

        function extractLast(term) {
            return split(term).pop();
        }

        function copyToClipboard(elem) {
            // create hidden text element, if it doesn't already exist
            let targetId = "_hiddenCopyText_";
            let isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
            let origSelectionStart, origSelectionEnd;
            let target;
            if (isInput) {
                // can just use the original source element for the selection and copy
                target = elem;
                origSelectionStart = elem.selectionStart;
                origSelectionEnd = elem.selectionEnd;
            } else {
                // must use a temporary form element for the selection and copy
                target = document.getElementById(targetId);
                if (!target) {
                    let target = document.createElement("textarea");
                    target.style.position = "absolute";
                    target.style.left = "-9999px";
                    target.style.top = "0";
                    target.id = targetId;
                    document.body.appendChild(target);
                }
                target.textContent = elem.textContent;
            }
            // select the content
            let currentFocus = document.activeElement;
            target.focus();
            target.setSelectionRange(0, target.value.length);

            // copy the selection
            let succeed;
            try {
                succeed = document.execCommand("copy");
            } catch (e) {
                succeed = false;
            }
            // restore original focus
            if (currentFocus && typeof currentFocus.focus === "function") {
                currentFocus.focus();
            }

            if (isInput) {
                // restore prior selection
                elem.setSelectionRange(origSelectionStart, origSelectionEnd);
            } else {
                // clear temporary content
                target.textContent = "";
            }
            return succeed;
        }

        document.addEventListener('livewire:load', function () {
            $("#tx") // jQuery Selector
                // don't navigate away from the field on tab when selecting an item
                .bind("keydown", function(event) {
                    //console.log('hey');
                    if (event.keyCode === $.ui.keyCode.TAB && $(this).data("ui-autocomplete").menu.active) {
                        event.preventDefault();
                    }
                }).autocomplete({
                    minLength: minWordLength,
                    source: function(request, response) {
                        // delegate back to autocomplete, but extract the last term
                        let term = extractLast(request.term);
                        if (term.length >= minWordLength) {
                            response($.ui.autocomplete.filter(availableTags, term));
                        }
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function(event, ui) {
                        let terms = split(this.value);
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push(ui.item.value);
                        // add placeholder to get the comma-and-space at the end
                        terms.push("");
                        this.value = terms.join(" ");
                        return false;
                    }
                });
            $("#hu").click(function() {
                copyToClipboard(document.getElementById("tx"));

                $('#tx').val('');
            });
        });


    </script> --}}
    <script>
        
        $('.short_code_btn').on("click",function(e){
                e.preventDefault();
            });
    </script>
</div>
