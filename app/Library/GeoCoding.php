<?php
namespace App\Library;

use Illuminate\Support\Facades\Http;

class GeoCoding {
    
    private static $url = 'https://api.mapbox.com';
    
    public static function reverseGeocoding($lat, $lng)
    {
        $response = Http::get(self::$url.'/search/geocode/v6/reverse', [
           'latitude' => $lat,
           'longitude' => $lng,
            'access_token' => env('MAPBOX_ACCESS_TOKEN')
        ]);
        
        if($response->successful()) {
            return response($response, 200);
        } else {
            return response('error', 500);
        }
    }
    
    public static function geocode($address, $city)
    {
        $response = Http::acceptJson()->get(self::$url.'/search/geocode/v6/forward', [
            'q' => $address.', '.$city,
            'access_token' => config('mapbox.access_token')
        ]);

        if($response->successful()) {
            $res = $response->object();
            $return = [];
            if($res !== null && $res->features !== null) {
                foreach($res->features as $f) {
                    $tmp = new \stdClass();
                    $tmp->lat = $f->properties->coordinates->latitude;
                    $tmp->lon = $f->properties->coordinates->longitude;
                    $return[] = $tmp;
                }
                return $return;
            } else {
                return 'no_data';
            }
            
        } else {
            return $response->body();
        }
    }
    
}