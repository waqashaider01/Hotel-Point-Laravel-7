<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ChannexApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChannelController extends Controller
{
   public function list(Request $request)
    {
        $channels = getHotelSettings()->booking_agencies;
        return view('front.Channel.channel_list')->with([
            'channels' => $channels
        ]);
    }

    public function show_inventory()
    {
        return view('front.Channel.inventory');
    }
    public function show_channel()
    {
        return view('front.Channel.channel');
    }
    public function show_room_rate()
    {
        return view('front.Channel.room_rate');
    }

    public function channex_otp()
    {
        $response = generateChannexOneTimeToken();

        if($response['status'] == 'success'){
            return [
                "onetimeToken" => $response['token'],
                "propertyid" => getHotelSettings()->active_property()->property_id
            ];
        } else {
            return false;
        }
    }
}
