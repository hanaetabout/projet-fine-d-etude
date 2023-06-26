@extends('layouts.app') 
@section('content')
<div class="main-content">
	<div class="col-8" style="margin:auto;">
		<form method="post" action="{{route('user.saveSettings')}}" class="owner-form">
		<input type="hidden" name="user_id" value="{{Auth::user()->id}}">
		@csrf
			<div class="row jumbotron box8">
				<div class="col-sm-6 form-group">
					<label for="name"> Name</label>
					<input type="text" class="form-control " name="name" id="name-f" value="{{Auth::user()->name}}" placeholder="Ervig">
				    @error('name')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
				</div>
				<div class="col-sm-6 form-group">
					<label for="tel">Phone Number</label>
					<input type="tel" name="phone" class="form-control" id="tel" value="{{Auth::user()->phone}}" placeholder="+2342343324234">				
                    @error('phone')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
				</div>
				<div class="col-sm-6 form-group">
					<label for="number">NIF Number</label>
					<input type="number" name="nif" class="form-control" value="{{Auth::user()->nif}}" id="num" placeholder="#876370">										 
		            @error('nif')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
				</div>
				<!-- Password -->
				<div class="col-sm-6 form-group password">
					<label for="password">Password</label>
					<div class="input-group" id="show_hide_password">
						<div class="input-group-addon">
							<input type="password" id="password" class="block mt-1 w-full input form-control" name="password" placeholder="Password">
							<a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
							@error('password')
								<span class="text-danger">{{$message}}</span>
							@enderror
						</div>
					</div>
				</div>
								
				<div class="col-sm-12 form-group">
					<label for="email">Email Address</label>
					<input type="email" class="form-control" name="email" id="email" disabled value="{{Auth::user()->email}}" placeholder="Example@gmail.com">
					@error('email')
						<span class="text-danger">{{$message}}</span></span>
					@enderror
				</div>
				<div class="col-sm-12 form-group">
					<label for="address-1">Tax Address</label>
					<input type="address" class="form-control" name="tax_address" value="{{Auth::user()->tax_address}}" id="address-1" placeholder="Street">
					@error('tax_address')
						<span class="text-danger">{{$message}}</span>
					@enderror
				</div>	
			</div>
			<div class="col-sm-12 form-group mb-0">
				<button type="submit" class="btn save btn-primary float-right add_user">Update user</button>
			</div>
		</form>
	</div>
</div>

@if(session()->has('success'))
	<script>
		alertify.success("{{ session()->get('success') }}");
	</script>
@endif	
@if(session()->has('error'))
	<script>
		alertify.error("{{ session()->get('error') }}");
	</script>
@endif
@endsection