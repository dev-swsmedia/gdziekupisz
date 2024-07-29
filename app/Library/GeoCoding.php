<?php
namespace App\Library;

use Illuminate\Support\Facades\Http;

class GeoCoding {
    
    private static $url = 'https://nominatim.openstreetmap.org';
    
    public static function reverseGeocoding($lat, $lng)
    {
        $response = Http::get(self::$url.'/reverse', [
           'lat' => $lat,
           'lng' => $lng,
           'format' => 'json'
        ]);
        
        if($response->successful()) {
            return response($response, 200);
        } else {
            return response('error', 500);
        }
    }
    
    public static function geocode($address, $city)
    {
        $response = Http::acceptJson()->get(self::$url.'/search', [
            'street' => $address,
            'city' => $city,
            'format' => 'json'
        ]);

        if($response->successful()) {
            return $response->object();
        } else {
            return $response->body();
        }
    }
    
}