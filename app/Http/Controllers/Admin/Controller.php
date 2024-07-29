<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    
    function __construct()
    {
        //$this->middleware('auth');
        $this->setCurrentAdminTab();
    }
    
    function setCurrentAdminTab()
    {
        $url = request()->segments();
        if(!isset($url[1]))  $url[1] = 'dashboard';
        \View::share('adminCurrentTab', $url[1]);
    }
}
