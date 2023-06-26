@extends('layouts.guest') 
@section('content')

	<div class="content-area">
	<div class="success">

		
				<img src="{{asset('images/thumb.png')}} ">
				<p>Your account successfully created.</p>
		
							 <a href="{{ route('user.dashboard')}}" type="submit" class="login">Go to Home</a>
			</div>
			</div>
		
	@endsection