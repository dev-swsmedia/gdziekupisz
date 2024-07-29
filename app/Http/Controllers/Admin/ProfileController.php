<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Support\Renderable;
use App\Models\Administrator;
use App\Http\Requests\AdminPasswordRequest;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }
    
    function index() : Renderable
    {
        $vdata['user'] = Administrator::find(auth()->user()->id);
        
        return view('admin.profile.index', $vdata);
    }
    
    function save(AdminPasswordRequest $request) : RedirectResponse
    {   
        $update['is_old'] = 0;
        $update['user_display_name'] = $request->user_display_name;
        
        if($request->password !== null) $update['password'] = Hash::make($request->password);
        
        $update = Administrator::find(auth()->user()->id)->update($update);
                    
        if(!$update)
        {
            return redirect(route('admin.profile'))->withErrors('Nie udało się zmienić danych.');
            
        }
            
        return redirect(route('admin.profile'))->with('message', 'Dane zostały zmienione.');
        
        
    }
}
