<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
		
        $request->authenticate();

        $request->session()->regenerate();
			$user = User::find(Auth::user()->id);
			$user->last_seen = date("Y-m-d h:i:sa");
			$user->update();
		
		if(Auth::user()->approve == 0){		
			auth()->logout();
			return abort(403, 'The account you have on this site was not approved yet!.');
		} 
			
				
        if(Auth::user()->role_id == 1){
			return redirect()->route('admin.dashboard');
		}
		
		if(Auth::user()->role_id == 2){
			return redirect()->route('user.dashboard');
		}
        //return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
