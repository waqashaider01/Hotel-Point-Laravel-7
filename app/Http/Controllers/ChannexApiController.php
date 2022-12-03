<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

class ChannexApiController extends Controller
{
    public function test_api()
    {
        /**
         * @var \App\Models\HotelSetting
         */
        $settings = getHotelSettings();

        //Oxygen API Testing
        $endpoint = config('services.oxygen.api_base') . '/payment-methods';

        try {
            $response = Http::asJson()->withToken($settings->oxygen_api_key)->post($endpoint);
            $response->throw();

            return response()->json($response->json());
        } catch (\Throwable $e) {
            $response = [
                'result' => 'error',
                'message' => $e->getMessage()
            ];
            return $response;
        }

        // Channex API Testing
        $property = $settings->properties()->first();

        $endpoint = config('services.channex.api_base') . '/room_types/';

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'user-api-key' => config('services.channex.api_key'),
            ])->get($endpoint, [
                "filter[property_id]" => $property->property_id
            ]);
            $response->throw();

            return response()->json($response->json());
        } catch (\Throwable $e) {
            $response = [
                'result' => 'error',
                'message' => $e->getMessage()
            ];
            return $response;
        }
    }
}
