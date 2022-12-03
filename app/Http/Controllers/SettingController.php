<?php

namespace App\Http\Controllers;

use App\Models\HotelSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {

        return view('front.Settings.index');
    }

    public function hotel_settings(Request $request, HotelSetting $hotel = null)
    {
        if($hotel == null){
            $hotel = getHotelSettings();
        }
        session()->put('selected_hotel', $hotel->id);
        return view('front.Settings.hotel_settings', ['hotel' => $hotel]);
    }

    public function serviceSettings(Request $request)
    {
        return view('front.Settings.services_settings');
    }

}
