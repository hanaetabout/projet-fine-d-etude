@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<div class="main-content">
<div class="col-8" style="margin:auto;">
		<form method="post" action="{{route('admin.create_user')}}" class="owner-form">
						@csrf
							
							<div class="row jumbotron box8">
								<div class="col-sm-6 form-group">
									<label for="name"> Name</label>
									<input type="text" class="form-control " name="name" id="name-f" value="{{old('name')}}" placeholder="Ervig">
				    @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
								</div>
								<div class="col-sm-6 form-group">
									<label for="tel">Phone Number</label>
									<input type="tel" name="phone" class="form-control" id="tel" value="{{old('phone')}}" placeholder="+2342343324234">
									
                    @error('phone')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
								</div>
								<div class="col-sm-6 form-group">
									<label for="number">NIF Number</label>
									<input type="number" name="nif" class="form-control" value="{{old('nif')}}" id="num" placeholder="#876370">
															 
		            @error('nif')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
								</div>
								<div class="col-sm-6 form-group">
									<label for="number">User Role</label>
									  <select class="form-select"  name="role_id" id="inputGroupSelect01">
										<option value="1" {{ old('role_id') == 1 ? "selected" : "" }}>Admin</option>
										<option value="2" {{ old('role_id') == 2 ? "selected" : "" }}>User</option>
									 </select>
																	
                      @error('role_id')
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
								
								
								
								
								<div class="col-sm-6 form-group">
									<label for="email">Email Address</label>
									<input type="email" class="form-control" name="email" id="email" value="{{old('email')}}" placeholder="Example@gmail.com">
					 @error('email')
                  <span class="text-danger">{{$message}}</span>
                    </span>
                @enderror
							</div>
							<div class="col-sm-12 form-group">
								<label for="address-1">Tax Address</label>
								<input type="address" class="form-control" name="tax_address" value="{{old('tax_address')}}" id="address-1" placeholder="Street">
					 @error('tax_address')
                   <span class="text-danger">{{$message}}</span>
                @enderror
							</div>
							
							
					
							</div>
															
							<div class="col-sm-12 form-group mb-0">
								
								<button type="submit" class="btn save btn-primary float-right add_user">Add user</button>
							</div>
						</form>
						
						</div>
						</div>
										

	
	<script>
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
	
  </script>

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