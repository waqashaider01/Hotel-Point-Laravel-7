<?php

namespace App\Http\Controllers;

use App\Models\RateTypeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoomTypeCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.RateTypeCategories.rate_type_categories');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rate_type_caterory = RateTypeCategory::create([
            'name' => $request->meal_category_name,
            'charge_percentage' => $request->meal_category_daily_charge,
            'vat' => $request->meal_category_vat,
            'desc_to_document' => $request->meal_category_description,
            'has_breakfast' => $request->meal_category_breakfast ?? '0',
            'hotel_settings_id' => getHotelSettings()->id,
        ]);
        if ($rate_type_caterory) {
            session('status', 'Meal Category was Successfully Inserted.');
            session('status_code', 'success');
            return redirect()->route('meal-category.index');
        }
        $_SESSION['status'] = "There was an error on inserting The Meal Category.";
        $_SESSION['status_code'] = "error";
        return redirect()->route('meal-category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rate_type_caterory = RateTypeCategory::find($id);

        $output = '

        <input type="hidden" name="meal_category_id" id="meal-category-id" value=' . $rate_type_caterory->id . ' />

        <div class="row"><div class="col">
        <label>Name</label>
                <input class="form-control1" name="meal_category_name" id="meal-category-name" type="text" value= "' . $rate_type_caterory->name . '" id=""/>
              </div><div class="col">
              <label>Derived Precentage</label>
              <input class="form-control1" name="meal_category_charge" id="meal-category-charge" type="text" value= ' . $rate_type_caterory->charge_percentage . ' id=""/>
              </div></div><div class="row"><div class="col">
              <label>VAT (%)</label>
              <input class="form-control1" name="meal_category_vat" id="meal-category-charge" type="text" value= ' . $rate_type_caterory->vat . ' id=""/>

              </div><div class="col">
              <label>Description To Document</label>
              <input class="form-control1" name="meal_category_description" id="meal-category-document-description" type="text" value= "' . $rate_type_caterory->desc_to_document . '" id=""/>
              </div></div>
              <div class="row">
                  <div class="col">
                  <label>Has Breakfast</label>
                  <input  class="form-control1" style=""  placeholder="VAT" value="on" name="meal_category_breakfast" type="checkbox" ' . ($rate_type_caterory->has_breakfast == '1' ? 'checked' : '') . '  >

                  </div>
                  <div class="col">

                  </div>
                  </div>

                  ';
        return ($output);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rate_type_caterory = RateTypeCategory::find($request->meal_category_id)->update([
            'name' => $request->meal_category_name,
            'charge_percentage' => $request->meal_category_charge,
            'vat' => $request->meal_category_vat,
            'desc_to_document' => $request->meal_category_description,
            'has_breakfast' => $request->meal_category_breakfast == 'on' ? '1' : '0',
        ]);
        if ($rate_type_caterory) {
            Session::flash('message', 'Meal category updated successfully!');
            Session::flash('alert-class', 'success');
            return redirect()->route('meal-category.index');
        }
        Session::flash('message', 'Meal category updation failed!');
        Session::flash('alert-class', 'error');
        return redirect()->route('meal-category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd($id);
    }
}
