<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use App\Models\Pos;
use App\Models\BlogPosts;
use App\Library\GeoCoding;
use Illuminate\Support\Facades\Redirect;

class EmbedController extends Controller
{
    public function map(Request $request) : View 
    {
        $vdata['pos'] = Cache::remember('pos', now()->addHours(1), function () {
            return Pos::with(['category'])->get();
        });

        return view('web.embed.map', $vdata);
    }
}
