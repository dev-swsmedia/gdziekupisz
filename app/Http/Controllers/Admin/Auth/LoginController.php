<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordRequest;
use Carbon\Exceptions\Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Support\Renderable;
use App\Models\Administrator;
use App\Mail\PasswordRecovery;

class LoginController extends Controller
{
	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';
	
	/**
	 * Display login page.
	 *
	 * @return Renderable
	 */
	public function show() : Renderable
	{ 
		return view('admin.auth.login');
	}
	

	public function resetPasswordShow()
	{		
		return view('admin.auth.reset_password');
	}
	
	public function newPasswordShow($code)
	{
		$data = explode('_', $code);

		$user = Administrator::find($data[0]);
		
		if($user == NULL)
		{
			return redirect(route('admin.password.reset'))->with('message', 'Nie udało się rozpoznać użytkownika.');
		}
		
		$ctrl = hash('sha512', $user->email.$user->password);
		
		if($ctrl !== $data[1])
		{
			return redirect(route('admin.password.reset'))->with('message', 'Niepoprawny token zmiany hasła.');
		}
		
		if(round(abs(time() - $data[2]) / 60) > 10)
		{
			return redirect(route('admin.password.reset'))->with('message', 'Token zmiany hasła stracił ważność.');
		}
		
		$vdata['email'] = $user->email;
		
		return view('admin.auth.new_password', $vdata);
	}
	
	/**
	 * Handle account login request
	 *
	 * @param LoginRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function login(Request $request)
	{
		if ($request->query('redirect') !== null) {
		    $this->redirectTo = $request->query('redirect');
		}

		$user = Administrator::where('email', $request->user_email)->first();
		
		if($user == NULL)
		{
		    return back()->withErrors('Nazwa użytkownika lub hasło są niepoprawne.');
		}
		
		if($user->is_old == 1)
		{
		    if($user->password == hash('sha512', $request->user_password))
			{
			    Administrator::where('id', $user->id)->update(['is_old' => 0, 'password' => Hash::make($request->user_password)]);
				Auth::guard('admin')->loginUsingId($user->id);
				
				return redirect()->route('admin.index');
			}
			else 
			{
				return back()->withErrors('Nazwa użytkownika lub hasło są niepoprawne.');
			}
		}
		else 
		{
		    if (Hash::check($request->user_password, $user->password))
			{
				Auth::guard('admin')->loginUsingId($user->id);
				
				return redirect()->route('admin.index');
			}
			else 
			{
			    return back()->withErrors('Nazwa użytkownika lub hasło są niepoprawne.');
			}
		}
		
	}
	
	
	public function resetPassword(Request $request)
	{
		
		try {
			$user = Administrator::where('email', $request->email)->first();
			
			if($user == null) return redirect(route('admin.password.reset'))->with('message', 'Podany adres nie istnieje.');
			
			$code = $user->id.'_'.hash('sha512', $user->email.$user->password).'_'.time();
			
			$data['url'] = route('admin.password.new', $code);
			
			Mail::to($request->email)
					->send(new PasswordRecovery($data));
			
			return redirect(route('admin.password.reset'))->with('message', 'Na Twój adres e-mail wysłaliśmy wiadomość z linkiem potrzebnym do zresetowania hasła.');
			
			
		} catch (Exception $e) {
			return redirect(route('admin.password.reset'))->with('message', 'Nie udało się wysłać wiadomości z linkiem potrzebnym do zresetowania hasła. Spróbuj ponownie.');
			
		}		
	}
	
	public function newPassword(PasswordRequest $request)
	{
		try {
			$update = Administrator::where('email', $request->email)->update(['password' => Hash::make($request->password), 'is_old' => 0]);

			if($update)
			{
				return redirect(route('login'));
			}
			else
			{
				return redirect(route('admin.password.reset'))->with('message', 'Nie udało się zmienić hasła.');
			}
		} catch (Exception $e) {
			return redirect(route('admin.password.reset'))->with('message', 'Nie udało się zmienić hasła. <br /><small>'.$e->getCode().'</small>');
		}
	}
	
	public function confirm_message(Request $request)
	{
		return view('admin.auth.confirm_message');
	}
	
	/**
	 * Validate the user login request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return void
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	protected function validateLogin(Request $request)
	{
		$request->validate([
				'username' => 'required|string',
				'password' => 'required|string',
		]);
	}
	
}