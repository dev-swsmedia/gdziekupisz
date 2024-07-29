<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pos;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }
    
    function index()
    {
        $data = [];
        $data['pos'] = Pos::with(['category'])->orderBy('city', 'asc')->get();
        $data['admin'] = true;
                                        
        return view('admin.dashboard', $data);
    }
    
}
