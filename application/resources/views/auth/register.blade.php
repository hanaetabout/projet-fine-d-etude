@extends('layouts.guest')

@section('content')
<div class="container-fluid">
<div class="main-page register-page">
    <div class="row justify-content-center">
	<div class="col-12 col-md-5 col-lg-4  col-xl-3 left-col">
	<img src="{{asset('images/logo.png')}} ">
	<form method="POST" class="login-form" action="{{ route('register') }}">
	
	     <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
	     <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger"  />
		 <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
		 <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />
	   
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <input type="text" id="name" class="block mt-1 w-full input" placeholder="Name"  name="name" value="{{old('name')}}"  required autofocus />
          
        </div>

        <!-- Email Address -->
        <div class="mt-3">
            <x-input-label for="email" :value="__('Email')" />
            <input type="email" id="email" class="block mt-1 w-full input" placeholder="example@gmail.com" name="email" value="{{old('email')}}" required />
         
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
						
		
		

        <!-- Confirm Password -->
        <div class="mt-3">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <input type="password" id="password_confirmation" class="block mt-1 w-full input"
                           
                            name="password_confirmation" value="{{old('password_confirmation')}}"  required />

            
        </div>

        <div class="register-btn flex items-center justify-end mt-3">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
	</div>
		<div class="col-9 col-md-7 col-lg-8 col-xl-9 right-col">
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