<?php

namespace App\Http\Controllers;

use App\Helpers\Metatags;
use Illuminate\Support\Facades\View;

abstract class Controller
{
    protected function meta(...$vars)
    {
        View::share('metatags', Metatags::generate(
            $vars[0] ?? null,
            $vars[1] ?? null,
            $vars[2] ?? null,
            $vars[3] ?? null,
            ));
    }
}
