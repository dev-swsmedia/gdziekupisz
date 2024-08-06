<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use App\Models\Pos;
use App\Models\BlogPosts;
use App\Library\GeoCoding;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->meta();
    }
    
    public function index(Request $request) : View | RedirectResponse 
    {
        if($request->address !== null && $request->city !== null) {

            $validator = Validator::make($request->all(), [
                'address' => [
                    'required',
                    'max:255',
                ],
                'city' => [
                    'required',
                    'max:255',
                ],
                'distance' => [
                    'required',
                    'integer',
                ],
            ]);
            
            $attributeNames = array(
                'address' => 'Adres',
                'city' => 'Miejscowość',
                'distance' => 'Odległość'
            );
            
            $validator->setAttributeNames($attributeNames);
            
            if ($validator->fails()) {
                $errors = 'Wystąpiły następujące błędy: <ul>';
                
                foreach($validator->errors()->all() as $err)
                {
                    $errors .= '<li>'.$err.'</li>';
                }
                
                $errors .= '</ul>';
                
                return redirect()->back()->with('message', $errors)->withInput();
            }
            
            if($request->lat !== null && $request->lng !== null) {
                $lat = $request->lat;
                $lng = $request->lng;
            } else {
                $geo = GeoCoding::geocode($request->address, $request->city);

                if(!is_array($geo) || !isset($geo[0])) return redirect()->back()->withErrors(['message' => 'Nie udało się określić danych geograficznych wskazanego miejsca.']); 
                
                $lat = $geo[0]->lat;
                $lng = $geo[0]->lon;
            }           

            $request->merge(['lat' => $lat, 'lng' => $lng]);
            
            $vdata['pos'] = Pos::with(['category'])
                                ->select('*')
                                ->selectRaw('6371 * 2 * ASIN(SQRT(POWER(SIN((? - abs(lat)) * pi()/180 / 2), 2)
                                               + COS(? * pi()/180 ) * COS(abs(lat) * pi()/180)
                                               * POWER(SIN((? - lng) * pi()/180 / 2), 2) )) as  distance', [$lat, $lat, $lng])
                                ->having('distance', '<=', $request->distance)
                                ->orderBy('city', 'ASC')
                                ->get();
        } else {   
            if(App::environment('production')) {            
                $vdata['pos'] = Cache::remember('pos', now()->addHours(1), function () {
                    return Pos::with(['category'])->orderBy('city', 'asc')->get();
                });
            } else {
                $vdata['pos'] = Pos::with(['category'])->orderBy('city', 'asc')->get();
            }
        }

        
        
        
        $vdata['blog'] = BlogPosts::active()->orderBy('id', 'DESC')->take(2)->get();

        return view('web.home.index', $vdata);
    }
}
