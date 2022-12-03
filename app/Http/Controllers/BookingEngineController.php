<?php

namespace App\Http\Controllers;

use App\Models\BookingAgency;
use Illuminate\Http\Request;

class BookingEngineController extends Controller
{
    public function index()
    {
        $agencies = getHotelSettings()->booking_agencies()->OSA()->select('channex_channel_id')->get();
        return view('front.BookingEngine.index',compact('agencies'));
    }
}
