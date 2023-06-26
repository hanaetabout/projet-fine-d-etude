@extends('layouts.guest') 
@section('content')

<div class="content-area">
    <form method="POST" class="forgot" action="{{ route('password.email') }}">
        @csrf
		<div class="reset-pswd">
<a href="#" class="sidebar-logo"><img src="{{asset('images/black-logo.png')}}"></a>
        <!-- Email Address -->
        <div class="mail">
            <x-input-label  for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" placeholder="example@gmail.com" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Your Password') }}
            </x-primary-button>
        </div>
		</div>
    </form>
	</div>
	

@endsection