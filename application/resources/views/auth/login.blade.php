@extends('layouts.guest')

@section('content')
<div class="container-fluid">
	<div class="main-page login-page">
		<div class="row justify-content-center">
			<div class="col-12 col-md-5 col-xl-3 col-lg-4 left-col">
				<img src="{{asset('images/logo.png')}} ">
				<form method="POST" class="login-form" action="{{ route('login') }}">
				
				<x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
					<x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
					
					@csrf
					<div>
						<label for="email">Email Address</label>
						<input type="email" id="email" class="block mt-1 w-full input" placeholder="example@gmail.com"  name="email" value="{{old('email')}}" required autofocus />
						
					</div>

					<!-- Password -->
					<div class="mt-3 form-group">
						<label for="password">Password</label>
						<div class="input-group" id="show_hide_password">
						<div class="input-group-addon">
						<input type="password" id="password" class="block mt-1 w-full input form-control" name="password" value="{{old('password')}}" placeholder="Password" required autocomplete="current-password" />
				
        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
      </div>
	  </div>
					
						
					</div>
						
			
					<!-- Remember Me -->
					<div class="block mt-3">
						<label for="remember_me" class="inline-flex items-center">
							<input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
							<span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
						</label>
						@if (Route::has('password.request'))
							<a class="reset text-sm text-black-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
								{{ __('Reset password?') }}
							</a>
						@endif
					</div>

					
					<div class="block mt-4">
						<button class="btn btn-primary ml-3">{{ __('Log in') }}</button>
					</div>
					<div class="pt-4 text-center">
						Don’t have account yet?   <a href="{{route('register')}}">New Account</a>
					</div>
				</form>
			</div>
			<div class="col-9 col-md-7 col-xl-9 col-lg-8 right-col">
				<img class="img-fluid" src="{{asset('images/Illustration.png')}} ">
			</div>
		</div>
	</div>
</div>
@endsection

 <script src='https://code.jquery.com/jquery-3.2.1.slim.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js'></script>

<script src='https://use.fontawesome.com/b9bdbd120a.js'></script><script  src="./script.js"></script>
<script>
$(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });
});
</script>