<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\PosCategory;

class POSCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $vdata['categories'] = PosCategory::orderBy('id', 'DESC')->get();
        return view('admin.pos.categories', $vdata);
    }
    
    public function save(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
            ],
        ]);
        
        $attributeNames = array(
            'name' => 'Nazwa kategorii',
        );
        
        $validator->setAttributeNames($attributeNames);

        try {
            PosCategory::updateOrCreate(
                [
                    'id' => $request->id
                    
                ],
                [
                    'name' => $request->name
                ]
                );
            return redirect(route('admin.pos.categories'))->with('message', 'Zapisano zmiany');
            
        } catch(\Exception $e) {
            return redirect()->back()->withError(['message' => $e->getMessage()])->withInput();            
        }
    }
    
    public function delete($id): RedirectResponse
    {
        try {
            PosCategory::findOrFail($id)->delete();
            return redirect(route('admin.pos.categories.index'))->with('message', 'Usunięto kategorię');
        } catch(\Exception $e) {
            return redirect()->back()->withError(['message' => $e->getMessage()])->withInput();
        }
    }
}
