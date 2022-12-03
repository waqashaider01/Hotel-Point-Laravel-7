<div>
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid mt-5">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Card-->

            <div class="listcard " style="">
                <div class=""
                    style="max-height:100% !important; background-color:#48BBBE;margin-top:-2.1% !important;color:white;margin-bottom:100px;with:100%;margin-left:-2.1% !important;margin-right:-2.1%;border-radius:5px 5px 0px 0px;">
                    <h2 class="pt-7 pl-3 pb-7">Meal Categories List</h2>
                </div>


                <i class="fas fa-utensils meal-icon-rounded"></i>

                <div class="">

                    <div class="row">
                        <div class="col-10">
                        </div>
                        <div class="col-2 ">
                            <div style="float:right;">
                                <span type="button" data-toggle="modal" data-target="#addMealCategoryModal"
                                    style='background-color:#48BD91;padding:2px 12px;color:white;border:none !important;border-radius:2px;'>New
                                    Meal Category</span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>



                        <div class="card mt-10">
                            <div class="card-body">
                                <div class="table-responsive" wire:ignore>
                                    <table id="dataTableExample"  class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Derived Precentage</th>
                                                <th>Description To Document</th>
                                                <th>VAT (%)</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $rowno1 = '';
                                                $mymaxrowno1 = 0;
                                                if (isset($_GET['rownosrvs'])) {
                                                    $rowno1 = $_GET['rownosrvs'];
                                                    $rowno1 = (int) $rowno1;
                                                    $mymaxrowno1 = $rowno1 + 9;
                                                } else {
                                                    $rowno1 = 1;
                                                    $mymaxrowno1 = $rowno1 + 9;
                                                }

                                                $crl1 = 0;
                                                $ctrl1 = 0;
                                                $lsr1 = 0;
                                            @endphp
                                            @foreach ($rateTypeCategories as $rateTypeCategory)
                                                @php
                                                    $crl1 = $crl1 + 1;
                                                    $ctrl1 = $ctrl1 + 1;
                                                @endphp
                                                @if ($ctrl1 >= $rowno1 && $ctrl1 <= $mymaxrowno1)
                                                    @php
                                                        $lsr1 = $ctrl1;
                                                    @endphp
                                                    <tr >
                                                        <td class='idcolor text-capitalize'>
                                                            {{ $rateTypeCategory->name }}
                                                        </td>
                                                        <td >{{ $rateTypeCategory->charge_percentage }}
                                                        </td>
                                                        <td >{{ $rateTypeCategory->desc_to_document }}
                                                        </td>
                                                        <td >{{ $rateTypeCategory->vat }}</td>
                                                        <td >
                                                            <span type='button' name='view'
                                                                style='background-color:#48BBBE;margin-top:-3px !important;padding:5px 10px;color:white;border:none !important;border-radius:2px;'
                                                                value='Edit' id=''
                                                                onClick='editcat({{ $rateTypeCategory->id ?? 0 }})'
                                                                class='editBtn'><i class='far fa-edit text-light'
                                                                    style="font-size: 14px"
                                                                    aria-hidden='true'></i></span>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--begin: Datatable-->
                        {{-- <div class="table mt-10 text-center " id='reservations-table'>

                            <div>
                                <div class="row th">
                                    <div class="col">Name</div>
                                    <div class="col">Derived Precentage</div>
                                    <div class="col">Description To Document</div>
                                    <div class="col">VAT (%)</div>
                                    <div class="col">Action</div>
                                </div>
                            </div>
                            <div>

                                @php
                                    $rowno1 = '';
                                    $mymaxrowno1 = 0;
                                    if (isset($_GET['rownosrvs'])) {
                                        $rowno1 = $_GET['rownosrvs'];
                                        $rowno1 = (int) $rowno1;
                                        $mymaxrowno1 = $rowno1 + 9;
                                    } else {
                                        $rowno1 = 1;
                                        $mymaxrowno1 = $rowno1 + 9;
                                    }

                                    $crl1 = 0;
                                    $ctrl1 = 0;
                                    $lsr1 = 0;
                                @endphp
                                @foreach ($rateTypeCategories as $rateTypeCategory)
                                    @php
                                        $crl1 = $crl1 + 1;
                                        $ctrl1 = $ctrl1 + 1;
                                    @endphp
                                    @if ($ctrl1 >= $rowno1 && $ctrl1 <= $mymaxrowno1)
                                        @php
                                            $lsr1 = $ctrl1;
                                        @endphp
                                        <div class='row mytr'>
                                            <div class='col idcolor text-capitalize'>{{ $rateTypeCategory->name }}
                                            </div>
                                            <div class='col'>{{ $rateTypeCategory->charge_percentage }}</div>
                                            <div class='col'>{{ $rateTypeCategory->desc_to_document }}</div>
                                            <div class='col'>{{ $rateTypeCategory->vat }}</div>
                                            <div class='col'>
                                                <span type='button' name='view'
                                                    style='background-color:#48BBBE;margin-top:-3px !important;padding:5px 10px;color:white;border:none !important;border-radius:2px;'
                                                    value='Edit' id=''
                                                    onClick='editcat({{ $rateTypeCategory->id ?? 0 }})'
                                                    class='editBtn'><i class='far fa-edit text-light'
                                                        style="font-size: 14px" aria-hidden='true'></i></span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="row mytr">
                                <div class="col">
                                    @if ($lsr1 == 0)
                                        <span>No Record Found</span>
                                        <span style="display:none;">Showing
                                            <span class="ml-1 mr-1" id="minpositionacc"><?php //echo $rowno;
                                            ?></span>
                                            to<span class="ml-1 mr-1"
                                                id="lastpositionacc"><?php //echo $lsr;
                                                ?></span>
                                            of<span class="ml-1 mr-1"
                                                id="maxpositionacc"><?php //echo $crl;
                                                ?></span>
                                            entries</span>
                                    @else
                                        <span>Showing
                                            <span class="ml-1 mr-1" id="minpositionacc"><?php echo $rowno1; ?></span>
                                            to<span class="ml-1 mr-1"
                                                id="lastpositionacc"><?php echo $lsr1; ?></span>
                                            of<span class="ml-1 mr-1"
                                                id="maxpositionacc"><?php echo $crl1; ?></span>
                                            entries</span>
                                    @endif
                                </div>
                                <div class="col">
                                    <div class="" style="margin-top:-3px;float:right;">
                                        <span type="button" id="previousbutton1" onclick="backfunctionacc()"
                                            style='background-color:#F5F7F9;padding:2px 8px;color:white;border-radius:2px;border:1px solid #e8e8e8;'>
                                            <i class="fa fa-chevron-left" id="pbtnacc" aria-hidden="true"></i></span>
                                        <span type="button" onclick="nextfunctionacc()"
                                            style='background-color:#F5F7F9;padding:2px 8px;color:white;border-radius:2px;border:1px solid #e8e8e8;'>
                                            <i class="fa fa-chevron-right" id="nbtnacc" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

        </div>
    </div>
    <!--end::Container-->
    <!--end::Entry-->
    <!-- </div> -->
    <!--end::Content-->



    <!-- Modal -->

    <div class="modal fade" id="addMealCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" id="exampleModalLabel">New Meal Category</h5>
                </div>
                <div class="modal-header" style="z-index:1;border:none;background-color:#F5F7F9;">
                    <i class="fas fa-utensils meal-icon-rounded"></i>

                </div>
                <div class="modal-body"
                    style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-3%;">
                    <form action="{{ route('meal-category.store') }}" method="POST">
                        @csrf
                        <div class="">
                            <div class="" style="margin-top:-5%;">
                                <div class="form-style-6">
                                    <div class="row">
                                        <div class="col">
                                            <label>Name</label>
                                            <input name='meal_category_name' type="text" class="form-control1"
                                                placeholder="Name" value='' required="">
                                        </div>
                                        <div class="col">
                                            <label>Derived Precentage</label>
                                            <input class="form-control1" style=""
                                                placeholder="Reservation Daily Charge" name='meal_category_daily_charge'
                                                type="text" value='' required="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label>VAT (%)</label>
                                            <input class="form-control1" style="" placeholder="VAT"
                                                name='meal_category_vat' type="text" value='' required="">

                                        </div>
                                        <div class="col">
                                            <label>Description To Document</label>
                                            <input class="form-control1" style="" placeholder="Description To Document"
                                                name='meal_category_description' type="text" value='' required="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label>Has Breakfast</label>
                                            <input class="form-control1" style="" placeholder="VAT"
                                                name='meal_category_breakfast' type="checkbox" value='1'>

                                        </div>
                                        <div class="col">

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer" style="background-color:#F5F7F9;">
                    <button type="submit" name="create-meal_category" class="float-right" style='background-color:#48BBBE;padding:2px 12px;color:white;border-radius:2px;
 border:none;'>Insert</button>
                    <button type="button" class="" data-dismiss="modal"
                        style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal -->

    <div class="modal fade" id="editMealCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#48BBBE;z-index:0;">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Edit Meal Category</h5>
                </div>
                <div class="modal-header" style="z-index:1;border:none;background-color:#F5F7F9;">
                    <i class="far fa-edit meal-icon-rounded" style="margin-top: -14%"></i>

                </div>
                <div class="modal-body"
                    style="z-index:1004;position:relative;background-color:#F5F7F9;margin-top:-3%;">
                    <form action="{{ route('meal-category.update', $rateTypeCategory->id ?? 0) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="">
                            <div class="" style="margin-top:-5%;">
                                <div class="form-style-6" id="editMealCategoryModalBody">

                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer" style="background-color:#F5F7F9;">
                    <button type="submit" name="update-meal-category" class="float-right"
                        style='background-color:#48BBBE;padding:2px 12px;color:white;border-radius:2px;border:none;'>Update</button>
                    <button type="button" class="" data-dismiss="modal"
                        style='background-color:red;border:none !important;padding:2px 12px;color:white;border-radius:2px;margin-bottom:5px;'>Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>





    <!-- Edit Meal Category Modal-->

    <div class="modal fade" id="editMealCategoryModal1" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header table table-primary">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Meal Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="../includes/update_meal_category.php" method="POST">

                    <div class="modal-body" id="editMealCategoryModalBody">


                    </div>


                    <div class="modal-footer">
                        <button type="submit" name="update-meal-category" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
