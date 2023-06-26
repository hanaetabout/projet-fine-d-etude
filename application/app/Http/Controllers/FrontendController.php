<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Artisan;

class FrontendController extends Controller
{
	public function index()
	{
		return view('index');
	}
	

	
	
	public function clearCache()
	{
		return \Artisan::call('optimize:clear');
	}
	
	
	
 	public function dash()
	{
	 if(Auth::user()->role_id == 1){
				return redirect()->route('admin.dashboard');
			} if(Auth::user()->role_id == 2){
				return redirect()->route('user.dashboard');
			}
	} 
}