<div class="d-flex flex-column-fluid mt-5 ">
    <div class="container-fluid">
        <div class="row mb-10 m-0" style="margin-bottom:50%;">
            <div class="col p-0">
                <div class="tax_settings shadow-sm bg-white">
                    <h1>Operation Settings</h1>
                    <hr>
                    <div class="row">
                        <div class="col-3">
                            <div class="">
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="row">
                                <div class="col">
                                    <label>Check In Hour</label></br>
                                    <span class="font-weight-bold">{{ $operation->ordered_checkin_hour }}</span>
                                </div>
                                <div class="col">
                                    <label>Check Out Hour</label></br>
                                    <span class="font-weight-bold">{{ $operation->ordered_checkout_hour }}</span>
                                </div>
                                <div class="col">
                                    <label>House Keeping Cleaning</label></br>
                                    <span class="font-weight-bold">{{ $operation->housekeeping }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 text-right">
                            <i class="fas fa-edit fa-2x" data-toggle="modal" data-target="#editOperation" id=""
                                aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-10 m-0" style="margin-bottom:50%;">
            <div class="col p-0">
                <div class="infocard shadow-sm bg-white">
                    <div class="row">
                        <div class="col-11">
                            <h1 style="margin-left:12%;">Registration Template</h1>
                        </div>
                        <div class="col-1">
                        </div>
                    </div>
                    <hr>
                    <form class="" wire:submit.prevent="saveTemplate">
                        <div class="card-body p-3 mb-2 bg-light text-white rounded" style="
line-height:2em; margin: 10px 0 10px; margin-top:2em; margin-bottom:2em;
background-size: 600% 400%;">
                            <div class="row mb-4">
                                <div class="col-2">
                                    <label for="texttamplate" class=" col-form-label"
                                        style="color:black;font-weight:bold;">Template Name:</label>
                                </div>
                                <div class="col-9">
                                    <div class="control-group">
                                        <input class="form-control" wire:model.defer="template_name"
                                            placeholder="Enter Template Name.." type="text" />
                                        <x-error field="template_name" />
                                    </div>
                                </div>
                                <div class="col d-flex justify-content-end">
                                    <button class="btn btn-outline-info short_code_btn" data-toggle="modal" data-target="#shortCodeModal">Short Codes</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="control-group">
                                        <div class="controls">
                                            <p style="display:none;">
                                                <select name="lang">
                                                    <option value="en">English</option>
                                                </select>
                                            </p>
                                            <input type="hidden" id="templateContent" wire:model.defer="template_content" class="d-none">
                                            <div id="template" style="width:100%; background-color: #fff;" data-livewire-input="#templateContent" x-init='$wire.emit("initQuill", "#template", "", {placeholder:  "Enter Template content here..."})'></div>
                                        </div>
                                        <x-error field="template_content" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-10"></div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-success mr-2">Save Template
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Modals --}}
        <div class="modal fade" id="editOperation" style="border-radius:0px !important;" tabindex="-1"
            aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog  modal-dialog-scrollable">
                <div class="modal-content rounded-0">
                    <div class="modal-header shadow-sm " style="border-radius:0px !important;z-index:10;">
                        <h5 style="margin-left:10%;margin-right:23%;" class="modal-title text-dark"
                            id="exampleModalLabel">
                            Operation Settings</h5>
                        <button type="submit" wire:click="saveOperation"
                            class="float-right btn btn-outline-primary">Update
                        </button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                    </div>
                    <div class="modal-body" style="position:relative;background-color:#fff;">
                        <div class="form-style-6">
                            <div class="row">
                                <div class="col">
                                    <label>Check In Hour</label></br>
                                    <input type="time" wire:model.defer="operation.ordered_checkin_hour"
                                        placeholder="Enter check in" />
                                    <x-error field="operation.ordered_checkin_hour" />
                                </div>
                                <div class="col">
                                    <label>Check Out Hour</label>
                                    <input type="time" wire:model.defer="operation.ordered_checkout_hour"
                                        placeholder="Enter check out" />
                                    <x-error field="operation.ordered_checkout_hour" />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col">
                                    <label>House Keeping Cleaning</label>
                                    <select wire:model.defer="operation.housekeeping">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                                <div class="col">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    {{-- <script>
        window.editor = KindEditor.create('#template', {
            items: [
                "undo", "redo", "|", "preview", "print", "cut", "copy", "paste",
                "plainpaste", "wordpaste", "|",
                "justifyleft", "justifycenter", "justifyright", "justifyfull",
                "insertorderedlist",
                "insertunorderedlist", "indent", "outdent", "quickformat", "selectall",
                "|", "fullscreen",
                "unlink", "/", "formatblock", "fontname", "fontsize", "|", "forecolor",
                "hilitecolor", "bold",
                "italic", "underline", "strikethrough", "lineheight", "removeformat",
                "|", "image",
                "multiimage", "flash", "insertfile", "table", "hr", "emoticons",
                "pagebreak", "link"
            ],
            afterCreate: function() {
                console.log('Loaded KEditor')
            },
            afterBlur: function() {
                window.livewire.emit('setTemplate', window.editor.html())
            }
        });
        console.log('editor created!');

        $(function() {
            //Get the Data from a JSON or Hidden Feild
            var availableTags = [
                "[id]",
                "[reservation_status]",
                "[booking_agency]",
                "[charge_date]",
                "[checkin_date]",
                "[checkout_date]",
                "[arrival_date]",
                "[departure_date]",
                "[actual_checkin]",
                "[actual_checkout]",
                "[nights]",
                "[arrival_hour]",
                "[guest_country]",
                "[adults]",
                "[kids]",
                "[infants]",
                "[booking_date]",
                "[comment]",
                "[guest_name]",
                "[guest_phone]",
                "[guest_email]",
                "[room_number]",
                "[room_type]",
                "[guest_id]",
                "[channex_guest_city]",
                "[channex_guest_address]",
                "[channex_guest_language]",
                "[channex_guest_zip]",
                "[channex_booking_room_id]",
                "[channex_virtual_card]",
                "[checkin_time]",
                "[checkout_time]",
                "[overnight_tax]"

            ]; // array of autocomplete words
            var minWordLength = 2;

            function split(val) {
                return val.split(' ');
            }

            function extractLast(term) {
                return split(term).pop();
            }
            console.log($("#tx"))
            $("#tx").bind("keydown", function(event) {
                //console.log('hey');
                if (event.keyCode === $.ui.keyCode.TAB && $(this).data("ui-autocomplete").menu.active) {
                    event.preventDefault();
                }
            }).autocomplete({
                minLength: minWordLength,
                source: function(request, response) {
                    // delegate back to autocomplete, but extract the last term
                    var term = extractLast(request.term);
                    if (term.length >= minWordLength) {
                        response($.ui.autocomplete.filter(availableTags, term));
                    }
                },
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                select: function(event, ui) {
                    var terms = split(this.value);
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
        });
        $(document).ready(function() {
            $("#hu").click(function() {
                copyToClipboard(document.getElementById("tx"));

                $('#tx').val('');
            });
        });

        function copyToClipboard(elem) {
            // create hidden text element, if it doesn't already exist
            var targetId = "_hiddenCopyText_";
            var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
            var origSelectionStart, origSelectionEnd;
            if (isInput) {
                // can just use the original source element for the selection and copy
                target = elem;
                origSelectionStart = elem.selectionStart;
                origSelectionEnd = elem.selectionEnd;
            } else {
                // must use a temporary form element for the selection and copy
                target = document.getElementById(targetId);
                if (!target) {
                    var target = document.createElement("textarea");
                    target.style.position = "absolute";
                    target.style.left = "-9999px";
                    target.style.top = "0";
                    target.id = targetId;
                    document.body.appendChild(target);
                }
                target.textContent = elem.textContent;
            }
            // select the content
            var currentFocus = document.activeElement;
            target.focus();
            target.setSelectionRange(0, target.value.length);

            // copy the selection
            var succeed;
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
    </script> --}}


<script>
    $('.short_code_btn').on("click",function(e){
            e.preventDefault();
    });
</script>
