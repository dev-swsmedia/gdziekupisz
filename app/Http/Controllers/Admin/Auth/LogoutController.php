<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Admin\Controller;


class LogoutController extends Controller
{
	/**
	 * Log out account user.
	 *
	 * @return \Illuminate\Routing\Redirector
	 */
	public function perform(Request $request)
	{
		Session::flush();					
		
		Auth::logout();
				
		return redirect('/adminsws');
	}
}