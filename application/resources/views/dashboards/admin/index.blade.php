@extends('layouts.app')
@section('content')
<div class="main-content">
	<div class="row admin-row">
		<div class="col-lg-12">
			<div class="dashboard-clmn">
				
					<div class="d-flex justify-content-between align-items-center table-top">
						<h3 class="inner-hdg">Admin Dashboard</h3>
						
						

						<div class="right-side d-flex">
							<div id="partner-table_filter" class="dataTables_filter">
								<label><input type="search" class="search" placeholder="Search property/owner " aria-controls="partner-table"></label>
							</div>
							
					
							<a class="btn btn-light add-new-btn" data-bs-toggle="modal" href="#exampleModalToggle1" role="button"><i class="fa-regular fa-plus"></i> Add New </a>
							<div class="modal fade property-addressModal" id="exampleModalToggle1" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
								<div class="modal-dialog add-new-modal modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body ">
											<form class="new-form">
												<div class="form-group ">
													<label for="comments">Property Address</label>
													<textarea type="text" class="form-control col-12 add-property-field" id="email" placeholder="add property address" rows="2" cols="50"></textarea>
													<div class="invalid-feedback add-property-error" style="display:none;">
														 Please enter property address.
													</div>
												</div>
												<button type="button" class="btn btn-primary addProperty">Submit</button>
											</form>
										</div>
									</div>
								</div>
							</div>
							
							<!---Edit property Model -->
							
							<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
								<div class="modal-dialog add-new-modal modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body ">
											<form class="new-form">
												<div class="form-group ">
													<label for="comments">Update Property Address</label>
													<textarea type="text" class="form-control col-12 update-property-field" id="update_email" placeholder="add property address" rows="2" cols="50"></textarea>
													<p id="pro_id" pro_id=""></p>
													<div class="invalid-feedback add-property-error" style="display:none;">
															
													</div>
												</div>
												<button type="button" class="btn btn-primary updateProperty">Update</button>
											</form>
										</div>
									</div>
								</div>
							</div>
					     </div>
					</div>
			<div class=" table-responsive">
				<table id="partner-table" class="table cstm-data-table table-sortable" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th><input id="selectAll" class="form-check-input" type="checkbox"></th>
							<th>Property address</th>
							<th>Owner</th>
							<th>Email address</th>
							<th>Start date</th>
							<th>NIF #</th>
							<th>History</th>
							<th class="actn-icon">
								<img class="icon-delete deleteProperty" src="{{asset('images/Delete.png')}}">
							</th>
						</tr>
					</thead>
					
					<tbody>				
							@if(!empty($properties)) 
									@foreach($properties as $row)
								<tr>
									<td><input id="mce-group[19]-19-2" class="form-check-input" type="checkbox" name="propertiesEntry[]" value="{{$row->id}}"/></td>
									<td><a id="p_text_{{$row->id}}" href="{{route('admin.propertyDetail',[$row->id])}}">{{$row->address}}</a></td>
									<td>
										@if(!empty($row->owner))
											<span  data-bs-toggle="modal" data-bs-target="#staticBackdrop{{$row->id}}">{{$row->owner->name}}</span>
										@else
											<img class="icon-delete btn modal-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{$row->id}}" src="{{asset('images/bg-plus.png')}}">
										@endif
									</td>
									<td>
										<div class="{{$row->id.'-email'}}">
											@if(!empty($row->owner))
												<img src="{{asset('images/Message.png')}}">
												{{$row->owner->email}}
											@else
												<img class="icon-delete" src="{{asset('images/bg-plus.png')}}">
												<!--<img class="icon-delete toggle-field" src="{{asset('images/bg-plus.png')}}">
												<input type="text" class="property-detail-field saveData" col-id="email"  id="{{$row->id}}">
												<i class="fa fa-times" aria-hidden="true"></i>-->
											@endif
										</div>
									</td>
									<td>
										<div class="{{$row->id.'-start_date'}}">
											@if(!empty($row->start_date))
												<div class="parent_sd float-start me-2">
													<img src="{{asset('images/Calendar.png')}}">
													{{\Carbon\Carbon::parse($row->start_date)->format('Y-m-d')}}
												</div>
												
												<img class="icon-delete toggle-field" src="{{asset('images/bg-plus.png')}}">
												<input type="date" class="property-detail-field saveData" col-id="start_date" id="{{$row->id}}">
												<i class="fa fa-times" aria-hidden="true"></i>
											@else
												<img class="icon-delete toggle-field" src="{{asset('images/bg-plus.png')}}">
												<input type="date" class="property-detail-field saveData" col-id="start_date" id="{{$row->id}}">
												<i class="fa fa-times" aria-hidden="true"></i>
											@endif
										</div>
									</td>
									<td>
										<div class="{{$row->id.'-nif'}}">
											@if(!empty($row->owner))
												#{{$row->owner->nif}}
											@else
												<img class="icon-delete" src="{{asset('images/bg-plus.png')}}">
												<!--<img class="icon-delete toggle-field" src="{{asset('images/bg-plus.png')}}">
												<input type="text" class="property-detail-field saveData" col-id="nif" id="{{$row->id}}">
												<i class="fa fa-times" aria-hidden="true"></i>-->
											@endif
										</div>
									</td>
									<td>
										@php $latestchat = DB::table('chat')->where('property_id',$row->id)->orderBy('created_at','DESC')->first(); @endphp
										<div class="history latest-chat-status-{{$row->id}}">
											<a class="btn btn-light" data-bs-toggle="offcanvas" href="#offcanvasExample{{$row->id}}" role="button" aria-controls="offcanvasExample{{$row->id}}">
												{{(!empty($latestchat) ? 'Last updated'.date('d.m.Y',strtotime($latestchat->created_at)) : 'No history')}} 
											</a>
										</div>
									</td>
									<td>
										<div class="dropdown dot">
											<button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
												<i class="fa-solid fa-ellipsis"></i>
											</button>
											<ul class="dropdown-menu">
												<li><a id="{{$row->address}}" pro_id= "{{$row->id}}" class="dropdown-item edit_property" data-bs-toggle="modal" href="#exampleModalToggle2" role="button">Edit</a></li>
												<li><a class="dropdown-item" href="{{route('admin.propertyDetail',[$row->id])}}">View</a></li>
												<li><a class="dropdown-item deleteSingleProperty" id="{{$row->id}}" href="#">Delete</a></li>
											</ul>
										</div>
									</td>
								</tr>
								

								
								<!-- Owner model start-->
								<div class="modal fade" id="staticBackdrop{{$row->id}}"  tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<div class="modal-body">
												<div class="container mt-3">
													<ul class="nav nav-tabs" id="myTab" role="tablist">
													  <li class="nav-item" role="presentation">
														<button class="nav-link active" id="home-tab{{$row->id}}" data-bs-toggle="tab" data-bs-target="#home{{$row->id}}" type="button" role="tab" aria-controls="home{{$row->id}}" aria-selected="true">{{(empty($row->owner_id) ? 'New Owner' : 'Update Owner')}}</button>
													  </li>
													  @if(empty($row->owner_id))
													  <li class="nav-item" role="presentation">
														<button class="nav-link" id="profile-tab{{$row->id}}" data-bs-toggle="tab" data-bs-target="#profile{{$row->id}}" type="button" role="tab" aria-controls="profile{{$row->id}}" aria-selected="false">Existing Owner</button>
													  </li>
													  @endif
													</ul>
													<div class="tab-content" id="myTabContent">
														<div class="tab-pane fade show active" id="home{{$row->id}}" role="tabpanel" aria-labelledby="home-tab{{$row->id}}">
															<form method="post" action="@if(empty($row->owner_id)){{route('admin.addPropOwner')}}@else{{route('admin.updatePropOwner')}}@endif" class="owner-form">
															@csrf
																<input type="hidden" name="type" value="new">
																<input type="hidden" name="property_id" value="{{$row->id}}">
																@if(!empty($row->owner_id))
																	<input type="hidden" name="user_id" value="{{$row->owner_id}}">
																@endif
																@php //print_r([$row->owner->name,$row->id]);die('asd');  @endphp
																<div class="row jumbotron box8">
																	<div class="col-sm-6 form-group">
																		<label for="name"> Name</label>
																		<input type="text" class="form-control " name="name" id="name-f" placeholder="Ervig " @if(!empty($row->owner)) value="{{$row->owner->name}}" @endif required>
																	</div>
																	<div class="col-sm-6 form-group">
																		<label for="tel">Phone Number</label>
																		<input type="tel" name="phone" class="form-control" id="tel" placeholder="+2342343324234" @if(!empty($row->owner)) value="{{$row->owner->phone}}" @endif required>
																	</div>
																	<div class="col-sm-6 form-group">
																		<label for="number">NIF Number</label>
																		<input type="number" name="nif" class="form-control" id="num" placeholder="#876370" @if(!empty($row->owner)) value="{{$row->owner->nif}}" @endif  required>
																	</div>
																	<!-- Password -->
																	<div class="col-sm-6 form-group password">
																		<label for="password">Password</label>
																		<div class="input-group" id="show_hide_password">
																			<div class="input-group-addon">
																				<input type="password" id="password" class="block mt-1 w-full input form-control" name="password" placeholder="Password" @if(empty($row->owner)) required @endif autocomplete="current-password"/>
																				<a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
																			</div>
																		</div>
																		<x-input-error :messages="$errors->get('password')" class="mt-2" />
																	</div>
																	<div class="col-sm-6 form-group">
																		<label for="email">Email Address</label>
																		<input type="email" class="form-control" name="email" id="email" placeholder="Example@gmail.com" @if(!empty($row->owner)) readonly value="{{$row->owner->email}}" @endif required>
																	</div>
																	<div class="col-sm-6 form-group">
																		<label for="address-1">Tax Address</label>
																		<input type="address" class="form-control" name="tax_address" id="address-1" placeholder="Street" @if(!empty($row->owner)) value="{{$row->owner->tax_address}}" @endif required>
																	</div>
																</div>
																<div class="col-sm-12 form-group">
																	<label class="form-label" for="textAreaExample" placeholder="Add comments...">Message</label>
																	<textarea class="form-control" id="textAreaExample1" name="comment" rows="4">@if(!empty($row->owner)) {{$row->owner->comment}} @endif</textarea>															
																</div>
																<div class="col-sm-12 form-group mb-0">
																	
																	<button type="submit" class="btn save btn-primary float-right">{{(empty($row->owner_id) ? 'Save' : 'Update')}}</button>
																</div>
															</form>
														</div>
														@if(empty($row->owner_id))
														<div class="tab-pane fade" id="profile{{$row->id}}" role="tabpanel" aria-labelledby="profile-tab{{$row->id}}">
															<form method="post" action="{{route('admin.addPropOwner')}}" class="owner-form">
															@csrf
																<input type="hidden" name="type" value="existing">
																<input type="hidden" name="property_id" value="{{$row->id}}">
																<select class="form-control" required name="exist_user" id="exist_user">	
																		@if(!empty($users_exist)) 
																			@foreach($users_exist as $userss)
																			 <option value="{{$userss['id']}}">{{$userss['name'].' ('.$userss['email'].')'}}</option>
																			@endforeach 
																		@endif
																</select>
																<div class="col-sm-12 form-group">
																	<label class="form-label" for="textAreaExample" placeholder="Add comments...">Message</label>
																	<textarea class="form-control" id="textAreaExample1" name="comment" rows="4"></textarea>															
																</div>														
																<div class="col-sm-12 form-group mb-0">															
																	<button type="submit" class="btn save_exting btn-primary float-right">Save</button>
																</div>
															</form>
														</div>
														@endif
                                                    </div>												
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- Owner model end-->
								
								
								<!-- Chat model start-->
								<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample{{$row->id}}" aria-labelledby="offcanvasExampleLabel">
									<div class="offcanvas-header">
										<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-chevron-left"></i></button>
									</div>
									<div class="offcanvas-body">
										<div class="text-area text-center">
											<h5>{{$row->address}}</h5>
											<p>#{{(!empty($row->owner->nif) ? $row->owner->nif : '')}}</p>
										</div>
										
										<div class="chat-section-{{$row->id}}">
											@if(!empty($row->chat))
												@foreach($row->chat as $chat)
													@php $sender = DB::table('users')->where('id',$chat->user_id)->first(); @endphp
													<div class="chtng">
														<p>{{$chat->text}}</p>
														@if(!empty($chat->media))
															<img src="{{asset('storage/'.$chat->media)}}" alt="media" width="40px" height="40px"/>
														@endif
													</div>
													<div class="users">
														<img src="{{asset('images/'.$sender->avatar)}}"/>
														<div class="date">
															<p>{{date('d M, Y / H:i A',strtotime($chat->created_at))}}</p>
															<i class="fa-solid fa-ellipsis"></i>
														</div>
													</div>
												@endforeach
											@endif
										</div>
	                                <div class="data-typing">
										<div class="typing">
											<label>
												<input type="file" style="display: none;">
												<i class="fa fa-paperclip" aria-hidden="true"></i>
											</label>
										
											<input type="text" placeholder="Add update" class="text">	
											<a class="btn sendChat" id="{{$row->id}}" href="javascript:void(0);" role="button"><i class="fa fa-location-arrow" aria-hidden="true"></i></a>
										</div>
										</div>
									
									</div>									
								</div>
								
								<!-- Chat model end-->
								
							@endforeach 
						 @endif
					</tbody>					
				</table>
					</div>	
				<a style="text-decoration: none;" data-bs-toggle="modal" href="#exampleModalToggle1"><p class="property">
					<i class="fa-regular fa-plus"></i> Add New Property
				</p></a>
			</div>
		</div>
	</div>
</div>


<div class=" mob-data-table">
	<div class="row">
		<div class="col-sm-12">
			<div class="card d-flex">
				<div class="card-body mob-card d-flex justify-content-between">
					<div class="left-cntnt">
						<h5 class="card-title"><b>Rua das Mosods</b></h5>
						<p class="card-text">
							Ervig Ervig
						</p>
					</div>
					<div class="right-cntnt">
							<h5 class="card-title">#876987</h5>
					</div>
				</div>
				<div class="card-body mob-card d-flex justify-content-between">
					<div class="left-cntnt">
						<img src="{{asset('images/Message.png')}}"> arroragaur@gmail.com
						<br><img src="{{asset('images/Calendar.png')}}"> 12 Dec, 2020
					</div>
					<div class="right-cntnt">
						<div class="updated">
							<a class="btn btn-light" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
						
							Last updated<br>
							 18.01.2023 </a>
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="card d-flex">
				<div class="card-body mob-card d-flex justify-content-between">
					<div class="left-cntnt">
						<h5 class="card-title"><b>Rua das Mosods</b></h5>
						<p class="card-text">
							Ervig Ervig
						</p>
					</div>
					<div class="right-cntnt">
						<h5 class="card-title">#876987</h5>
					</div>
				</div>
				<div class="card-body mob-card d-flex justify-content-between">
					<div class="left-cntnt">
						<img src="{{asset('images/Message.png')}}"> arroragaur@gmail.com
						<br><img src="{{asset('images/Calendar.png')}}"> 12 Dec, 2020
					</div>
					<div class="right-cntnt">
						<div class="updated">
							<a class="btn btn-light" data-bs-toggle="offcanvas" href="" role="button" aria-controls="offcanvasExample">
							Last updated<br>
							 18.01.2023 </a>
						</div>
				
								<!-- Chat model start-->
								
						<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
							<div class="offcanvas-header">
								<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-chevron-left"></i></button>
							</div>
							<div class="offcanvas-body">
								<div class="text-area text-center">
									<h5>Rua das Mosods</h5>
									<p>#876987</p>
								</div>
								<div class="chtng">
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
								</div>
								<div class="users">
									<img src="{{asset('images/chat.png')}}">
									<div class="date">
										<p>
											10 Dec, 2022 / 09:07 PM
										</p>
										<i class="fa-solid fa-ellipsis"></i>
									</div>
								</div>
								<div class="chtng">
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
								</div>
								<div class="users">
									<img src="{{asset('images/chat.png')}}">
									<div class="date">
										<p>10 Dec, 2022 / 09:07 PM</p>
										<i class="fa-solid fa-ellipsis"></i>
									</div>
								</div>
					
								<div class="typing">
									<label>
										<input type="file" style="display: none;">
										<i class="fa fa-paperclip" aria-hidden="true"></i>
									</label>

									<input type="text" placeholder="Add update" class="text">	
									<a class="btn" href="#" role="button"><i class="fa fa-location-arrow" aria-hidden="true"></i></a>
								</div>
							
							</div>									
						</div>
								<!-- Chat model end-->
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="card d-flex">
				<div class="card-body mob-card d-flex justify-content-between">
					<div class="left-cntnt">
						<h5 class="card-title"><b>Rua das Mosods</b></h5>
						<p class="card-text">
							Ervig Ervig
						</p>
					</div>
					<div class="right-cntnt">
						<h5 class="card-title">#876987</h5>
					</div>
				</div>
				<div class="card-body mob-card d-flex justify-content-between">
					<div class="left-cntnt">
						<img src="{{asset('images/Message.png')}}"> arroragaur@gmail.com
						<br><img src="{{asset('images/Calendar.png')}}"> 12 Dec, 2020
					</div>
					<div class="right-cntnt">
						<div class="updated">
							<a class="btn btn-light" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
							Last updated<br>
							 18.01.2023 </a>
					
						</div>
					 </div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="card d-flex prprty">
				<p class="property sdf">
					<i class="fa-regular fa-plus"></i> Add New Property
				</p>
			</div>
		</div>
	</div>
</div>
	

<script>
$(document).ready(function () {
	$('.fa-times').hide();
 	$('body').on('click','.toggle-field',function(){
		var clas = $(this).parent('div').attr('class').split('-');
		if(clas[1] == 'start_date'){
			$(this).parent('div').find('.parent_sd').hide();
		}
		$(this).next('input').show();
	    $(this).parent('div').find('.fa-times').show();
	 	$(this).closest('.toggle-field').hide();
	}); 
	
 	$('body').on('click','.fa-times',function(){
		var clas = $(this).parent('div').attr('class').split('-');
		if(clas[1] == 'start_date'){
			$(this).parent('div').find('.parent_sd').show();
		}
		$(this).parent('div').find('input').hide();
		$(this).parent('div').find('.fa-times').hide();
        $(this).parent('div').find('.toggle-field').show();
	}); 

	$('body').on('change','.saveData',function(){
		//alert();
		if($(this).attr('type') == 'date'){
			var data = $(this).val();
			var type = $(this).attr('col-id');
			var property_id = $(this).attr('id');	

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: "{{ route('admin.prop_update') }}",
				type: 'POST',
				data: {"data": data,"type":type,'property_id':property_id},
				success:function(response){
					if(response.status == 1){
						if(response.data.type == 'email'){
							$('.'+response.data.id+'-'+response.data.type).html('<img src="http://rambla.pt/crm/images/Message.png">'+response.data.data);
						}else if(response.data.type == 'start_date'){
							$('.'+response.data.id+'-'+response.data.type).html('<div class="parent_sd float-start me-2"><img src="{{asset('images/Calendar.png')}}">'+response.data.data+'</div><img class="icon-delete toggle-field" src="{{asset('images/bg-plus.png')}}"><input type="date" class="property-detail-field saveData" col-id="start_date" id="'+property_id+'"><i class="fa fa-times" aria-hidden="true"></i>');
							$('.'+property_id+'-start_date .fa-times').hide();
						}else{
							$('.'+response.data.id+'-'+response.data.type).text(response.data.data);
						}
					}else{
						alertify.error('Error while saving.');
					}
				}
			});			
		}
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			var data = $(this).val();
			var type = $(this).attr('col-id');
			var property_id = $(this).attr('id');
			console.log();
			 
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: "{{ route('admin.prop_update') }}",
				type: 'POST',
				data: {"data": data,"type":type,'property_id':property_id},
				success:function(response){
					if(response.status == 1){
						if(response.data.type == 'email'){
							$('.'+response.data.id+'-'+response.data.type).html('<img src="{{asset('images/Message.png')}}">'+response.data.data);
						}else if(response.data.type == 'start_date'){
							$('.'+response.data.id+'-'+response.data.type).html('<img src="{{asset('images/Calendar.png')}}">'+response.data.data);
						}else{
							$('.'+response.data.id+'-'+response.data.type).text(response.data.data);
						}
					}else{
						alertify.error('Error while saving.');
					}
				}
			});
		}
		
	}); 
	
	
	$('body').on('click','.addProperty',function(){
		var address = $('.add-property-field').val();
		$('.add-property-error').hide();
		$('.add-property-field').removeClass('is-invalid');
		if(address.length == 0){
			$('.add-property-field').addClass('is-invalid');
			$('.add-property-error').show();
		}else{
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: "{{ route('admin.addProperty') }}",
				type: 'POST',
				data: {"address": address},
				beforeSend:function(){
				},
				success:function(data){
					$('.add-property-field').val('');
					$('#exampleModalToggle1').modal('hide');
					if(data.status == 1){
						var url = "http://rambla.pt/crm/admin/property/"+data.id;
						
						//console.log(url);return false;
						t.row.add(['<input id="mce-group[19]-19-2" type="checkbox" name="group[19][32]" value="32"/>',
							'<a id="p_text_'+data.id+'" href="'+url+'">'+address+'</a>',
							'<img class="icon-delete btn modal-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop'+data.id+'" src="{{asset('images/bg-plus.png')}}">',
							'<div class="'+data.id+'-email"><img class="icon-delete" src="{{asset('images/bg-plus.png')}}"></div>',
							'<div class="'+data.id+'-start_date"><img class="icon-delete toggle-field" src="{{asset('images/bg-plus.png')}}"><input type="date" class="property-detail-field saveData" col-id="start_date" id="'+data.id+'"><i class="fa fa-times" aria-hidden="true"></i></div>',
							'<div class="'+data.id+'-nif"><img class="icon-delete" src="{{asset('images/bg-plus.png')}}"></div>',
							'<div class="history latest-chat-status-'+data.id+'"><a class="btn btn-light" data-bs-toggle="offcanvas" href="#offcanvasExample'+data.id+'" role="button" aria-controls="offcanvasExample'+data.id+'"> No history </a></div>',
							'<div class="dropdown dot"><button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis"></i></button><ul class="dropdown-menu"><li><a id="'+address+'" pro_id= "'+data.id+'" class="dropdown-item edit_property" data-bs-toggle="modal" href="#exampleModalToggle2" role="button">Edit</a></li><li><a class="dropdown-item" href="'+url+'">View</a></li><li><a class="dropdown-item deleteSingleProperty" id="'+data.id+'" href="#">Delete</a></li></ul></div>'
						]).draw();	
						$('.fa-times').hide();

						var opions = '';
						$.each(data.users, function(key,value) {
							opions += '<option value="'+value.id+'">'+value.email+'</option>';
						});
						console.log(opions);
						$('.dashboard-clmn').append('<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample'+data.id+'" aria-labelledby="offcanvasExampleLabel"><div class="offcanvas-header"><button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-chevron-left"></i></button></div><div class="offcanvas-body"><div class="text-area text-center"><h5>'+address+'</h5><p>#</p></div><div class="chat-section-'+data.id+'"></div><div class="typing"><label><input type="file" style="display: none;"><i class="fa fa-paperclip" aria-hidden="true"></i></label><input type="text" placeholder="Add update" class="text"><a class="btn sendChat" id="'+data.id+'" href="javascript:void(0);" role="button"><i class="fa fa-location-arrow" aria-hidden="true"></i></a></div></div></div><div class="modal fade" id="staticBackdrop'+data.id+'"  tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><div class="container mt-3"><ul class="nav nav-tabs" id="myTab" role="tablist"><li class="nav-item" role="presentation"><button class="nav-link active" id="home-tab'+data.id+'" data-bs-toggle="tab" data-bs-target="#home'+data.id+'" type="button" role="tab" aria-controls="home'+data.id+'" aria-selected="true">New Owner</button></li><li class="nav-item" role="presentation"><button class="nav-link" id="profile-tab'+data.id+'" data-bs-toggle="tab" data-bs-target="#profile'+data.id+'" type="button" role="tab" aria-controls="profile'+data.id+'" aria-selected="false">Existing Owner</button></li></ul><div class="tab-content" id="myTabContent"><div class="tab-pane fade show active" id="home'+data.id+'" role="tabpanel" aria-labelledby="home-tab'+data.id+'"><form method="post" action="{{route('admin.addPropOwner')}}" class="owner-form"><input type="hidden" name="_token" value="{{ csrf_token() }}" /><input type="hidden" name="type" value="new"><input type="hidden" name="property_id" value="'+data.id+'"><div class="row jumbotron box8"><div class="col-sm-6 form-group"><label for="name"> Name</label><input type="text" class="form-control " name="name" id="name-f" placeholder="Ervig " required></div><div class="col-sm-6 form-group"><label for="tel">Phone Number</label><input type="tel" name="phone" class="form-control" id="tel" placeholder="+2342343324234" required></div><div class="col-sm-6 form-group"><label for="number">NIF Number</label><input type="number" name="nif" class="form-control" id="num" placeholder="#876370" required></div><div class="col-sm-6 form-group password"><label for="password">Password</label><div class="input-group" id="show_hide_password"><div class="input-group-addon"><input type="password" id="password" class="block mt-1 w-full input form-control" name="password" placeholder="Password" required autocomplete="current-password"/><a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></div></div></div><div class="col-sm-6 form-group"><label for="email">Email Address</label><input type="email" class="form-control" name="email" id="email" placeholder="Example@gmail.com" required></div><div class="col-sm-6 form-group"><label for="address-1">Tax Address</label><input type="address" class="form-control" name="tax_address" id="address-1" placeholder="Street" required></div></div><div class="col-sm-12 form-group"><label class="form-label" for="textAreaExample" placeholder="Add comments...">Message</label><textarea class="form-control" id="textAreaExample1" name="comment" rows="4"></textarea></div><div class="col-sm-12 form-group mb-0"><button type="submit" class="btn save btn-primary float-right">Save</button></div></form></div><div class="tab-pane fade" id="profile'+data.id+'" role="tabpanel" aria-labelledby="profile-tab'+data.id+'"><form method="post" action="{{route('admin.addPropOwner')}}" class="owner-form"><input type="hidden" name="_token" value="{{ csrf_token() }}" /><input type="hidden" name="type" value="existing"><input type="hidden" name="property_id" value="'+data.id+'"><select class="form-control" required name="exist_user" id="exist_user">'+opions+'</select><div class="col-sm-12 form-group"><label class="form-label" for="textAreaExample" placeholder="Add comments...">Message</label><textarea class="form-control" id="textAreaExample1" name="comment" rows="4"></textarea></div><div class="col-sm-12 form-group mb-0"><button type="submit" class="btn save_exting btn-primary float-right">Save</button></div></form></div></div>	</div></div></div></div></div>');
						//console.log(data.users);

					}else{
						alertify.error('Error while saving.');
					}
				}
			});			
		}
	});	
	
	$('body').on('click','.edit_property',function(){			
	
		var pro_id = $(this).attr('pro_id');
		$('#pro_id').attr('pro_id', pro_id);
		
		var title = $('#p_text_'+pro_id).html();		
		$('#update_email').val(title);
	});
	
	$('body').on('click','.updateProperty',function(){
		var address = $('.update-property-field').val();
		var pro_id = $('#pro_id').attr('pro_id');
		
		//$('.update-property-field').hide();
		$('.update-property-field').removeClass('is-invalid');
		if(address.length == 0){
			$('.update-property-field').addClass('is-invalid');
			$('.update-property-field').show();
		}else{
			 $.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: "{{ route('admin.updateProperty') }}",
				type: 'POST',
				data: {"address": address,"pro_id": pro_id},
				beforeSend:function(){
				},
				success:function(data){
					if(data.status == 1){
						$('#p_text_'+pro_id).text(address);
						alertify.success('Sucessfully Updated');
						$('#exampleModalToggle2').modal('hide');
					}
				}
			});	 	
		}
	});	
	
		
    var t=$('#partner-table').DataTable({
			aaSorting: [],
			order: [],
			"columnDefs": [{ 
				"targets": [0,7], //first column / numbering column
				"orderable": false, //set not orderable
			}],
			searching: false,
			paging: false,
			info: false
	});
	
	$(".search").keyup(function () {
		var value = this.value.toLowerCase().trim();

		$("#partner-table tr").each(function (index) {
			if (!index) return;
			$(this).find("td").each(function () {
				var id = $(this).text().toLowerCase().trim();
				var not_found = (id.indexOf(value) == -1);
				$(this).closest('tr').toggle(!not_found);
				return not_found;
			});
		});
	});

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
	
	
	$('body').on('click','.sendChat',function(event){
		event.preventDefault();
		if($(this).prev('input').val().length < 3){
			alertify.error('Write some text.');
			return false;
		}
		var prop_id = $(this).attr('id');
		var media = $(this).parent('div').find('input[type="file"]')[0].files
		var form = new FormData();
		form.append('chat',$(this).parent('div').find('input[type="text"]').val());
		form.append('media',media[0]);
		form.append('property_id',prop_id);
		
		$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});		
		
		$.ajax({
			  url: '{{ route('admin.propertyChat') }}',
			  type: 'POST',
			  data: form,
			  contentType: false,
              processData: false,
			  beforeSend:function(){
			  },
			  success:function(data){
				  if(data.status == 1){
					  $('.chat-section-'+prop_id).append(data.msg);
					  $('.chat-section-'+prop_id).parent('div').find('input[type="text"]').val('');
					  $('.chat-section-'+prop_id).parent('div').find('input[type="file"]').val('');
					  $('.latest-chat-status-'+prop_id).html(data.lateststatus);
				  }else{
					  alertify.error('Error updating.');
				  }  
			  }
		});		
	});
		
		
		
	$('body').on('click','.deleteProperty',function(event){
		event.preventDefault();
		alertify.confirm('Are You Sure?', 'Deleting this property is irreversible. Are you sure you wish to proceed?', function(){ 
			var arr = [];
			  $.each($("input[name='propertiesEntry[]']:checked"), function(){
				  arr.push($(this).val());
			  });
				  
			$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
			$.ajax({
				  url: '{{ route('admin.propBulkAction') }}',
				  type: 'POST',
				  data: {values: arr,type:'delete' },
				  beforeSend:function(){
				  },
				  success:function(data){
					  if(data.status == 1){
						  window.location.reload();
					  }else{
						  alertify.error('Error updating.');
					  }  
				  }
			});			
		},function(){
			alertify.warning('Deletion Canceled')
		});
	});
	
	$('body').on('click','.deleteSingleProperty',function(event){
	var  id = $(this).attr('id');
		event.preventDefault();
		alertify.confirm('Are You Sure?', 'Deleting this property is irreversible. Are you sure you wish to proceed?', function(){ 
			
			var arr = [];			  
				 arr.push(id);
			 
				  
			$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
			$.ajax({
				  url: '{{ route('admin.propBulkAction') }}',
				  type: 'POST',
				  data: {values: arr,type:'delete' },
				  beforeSend:function(){
				  },
				  success:function(data){
					  if(data.status == 1){
						  window.location.reload();
					  }else{
						  alertify.error('Error updating.');
					  }  
				  }
			});			
		},function(){
			alertify.warning('Deletion Canceled')
		});
	});
	
});

</script>

@error('email')
	<script>
		alertify.error("Owner email already exist");
	</script>
@enderror
		
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