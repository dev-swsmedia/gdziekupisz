<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\PosCategory;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;

class POSController extends Controller
{
    public function index(Request $request) : View
    {
        return view('admin.pos.index');
    }
    
    public function edit(Request $request, $id = null) : View | RedirectResponse
    {
        try {
            if($id !== null) $vdata['pos'] = Pos::findOrFail($id);
            $vdata['categories'] = PosCategory::all();
            return view('admin.pos.editor', $vdata);
        } catch (\Exception $e) {
            return redirect()->back()->withError(['message' => $e->getMessage()]);
        }
    }
    
    public function save(Request $request, $id = null) : View | RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
            ],
            'city' => [
                'required',
                'max:255',
            ],
            'street' => [
                'required',
                'max:255',
            ],
            'lat' => [
                'required',
                'numeric',
                'between:-90,90',
            ],
            'lng' => [
                'required',
                'numeric',
                'between:-180,180',
            ],
            'number' => [
                'max:255',
            ],
        ]);
        
        $attributeNames = array(
            'name' => 'Nazwa POS',
            'city' => 'Miejscowość',
            'street' => 'Ulica',
            'number' => 'Numer',
            'lat' => 'Latitude',
            'lng' => 'Longitude'
        );
        
        $validator->setAttributeNames($attributeNames);
        
        if ($validator->fails()) {
            $errors = '<ul>';
            
            foreach($validator->errors()->all() as $err)
            {
                $errors .= '<li>'.$err.'</li>';
            }
            
            $errors .= '</ul>';
            
            return redirect()->back()->withErrors(['message' => $errors])->withInput();
        }
        
        try {
            Pos::updateOrCreate(
                [
                    'id' => $id
                    
                ],
                [
                    'name' => $request->name,
                    'city' =>  $request->city,
                    'street' => $request->street,
                    'number' => $request->number,
                    'postcode' => $request->postcode,
                    'pos_category' => $request->pos_category,
                    'lat' => $request->lat,
                    'lng' => $request->lng
                ]
                );
            
            return redirect(route('admin.pos.index'))->with('message', 'Zapisano zmiany');            
        } catch (\Exception $e) {
            return redirect()->back()->withError(['message' => $e->getMessage()])->withInput();
        } 
    }
    
    public function delete($id): RedirectResponse
    {
        try {
            Pos::find($id)->delete();
            return redirect(route('admin.pos.index'))->with('message', 'Usunięto POS');
        } catch(\Exception $e) {
            return redirect(route('admin.pos.index'))->withErrors(['message' => 'Nie zapisano zmian ['.$e->getMessage().']']);
        } 
    }
    
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => [
                'required',
                'mimes:csv,txt',
            ],
        ]);
        
        if ($validator->fails()) {
            $errors = '<ul>';
            
            foreach($validator->errors()->all() as $err)
            {
                $errors .= '<li>'.$err.'</li>';
            }
            
            $errors .= '</ul>';
            
            return redirect()->back()->withErrors(['message' => $errors])->withInput();
        }
        
        
        try {
        $categories = [];
            
            foreach(PosCategory::all() as $c) {
                $categories[$c->name] = $c->id;
            }
    
            $content = file_get_contents($request->file->getRealPath());
            
            $lines = explode(PHP_EOL, $content);
            
            $insertArr = [];
            
            foreach($lines as $l) {
                $fields = explode(';', $l);

                if(count($fields) < 8) continue;

                $category = trim($fields[7], '"');
                
                if(isset($categories[$category])) {
                    $pos_category = $categories[$category];
                } else {
                    $cat = new PosCategory();
                    $cat->name = $category;
                    $cat->save();
                    $pos_category = $cat->id;
                }
                
                $insertArr[] = [
                    'name'          => trim($fields[0], '"'),
                    'postcode'      => trim($fields[1], '"'),
                    'city'          => trim($fields[2], '"'),
                    'street'        => trim($fields[3], '"'),
                    'number'        => trim($fields[4], '"'),
                    'lat'           => trim($fields[5], '"'),
                    'lng'           => trim($fields[6], '"'),
                    'pos_category'  => $pos_category
                ];
            }

            Pos::insert($insertArr);
            
            return redirect(route('admin.pos.index'))->with('message', 'Plik został zaimportowany');            
        } catch (\Exception $e) {
            return redirect(route('admin.pos.index'))->withErrors(['message' => 'Nie udało się zaimportować pliku z powodu błedów ['.$e->getMessage().']']);            
        }
    
    }
    
    function __dt_Get(Request $request) : JsonResponse
    {
        $columns = array(
            0 => 'id',
            1 => 'category_name',
            2 => 'name',
            3 => 'city',
            4 => 'street',
            5 => 'postcode',
            6 => 'lat',
            7 => 'lng'
        );
        
        $orderBy = $columns[$request->query('order')[0]['column']];
        $order = $request->query('order')[0]['dir'];
        
        $records = Pos::orderBy($orderBy, $order);
        
        // append search query if needed
        if ($request->query('search')['value'] !== NULL && !empty($request->query('search')['value']))
        {
            $records = $records->where('name', 'LIKE', '%'.$request->query('search')['value'].'%')
                                ->orWhere('city', 'LIKE', '%'.$request->query('search')['value'].'%')
                                ->orWhere('street', 'LIKE', '%'.$request->query('search')['value'].'%')
                                ->orWhere('postcode', 'LIKE', '%'.$request->query('search')['value'].'%')
                                ->orWhereHas('category', function ($query) use ($request) { $query->where('name', 'LIKE', $request->query('search')['value'].'%'); });
        }
        
        // count total number of messages
        $total = $records->count();
        
        // get items for current page
        $records = $records->skip($request->query('start'))
                        ->take($request->query('length'));
        
        // count total number of filtered messages
        $filtered = $records->count();
        
        // execute query
        $records = $records->get();
        
        // make a return array
        $return = array();
        
        $return['recordTotal'] = $total;
        $return['recordsFiltered'] = $total;
        
        $return['data'] = array();
        
        foreach($records as $r)
        {            
            $tmp = array();
            $tmp[] = $r->id;
            $tmp[] = $r->category->name;
            $tmp[] = $r->name;
            $tmp[] = $r->city;
            $tmp[] = $r->street.' '.$r->number;
            $tmp[] = $r->postcode;
            $tmp[] = $r->lat;
            $tmp[] = $r->lng; 
            $tmp[] = '<button class="btn-outline-danger btn btn-xs delete" data-title="'.$r->name.', '.$r->city.','.$r->street.'" data-href="'.route('admin.pos.delete', $r->id).'"><i class="fa fa-trash"></i></button>';
            
            $return['data'][] = $tmp;
        }
        
        return Response::json($return);
    }
}
