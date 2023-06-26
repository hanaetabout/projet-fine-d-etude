@extends('layouts.app')
@section('content')

	<div class="main-content">
		
		<div class="row">
		<div class="col-lg-12">
				<div class="card user-data user-tabb">
				  <div class="card-body  ">
				  <a class="btn btn-light add-new-btn float-end"  href="{{route('admin.addUser')}}" role="button"><i class="fa-regular fa-plus"></i> Add User </a>
				   	
					<table id="myTable" class="table  table-responsive display">
					
						<thead>
							<tr>
								<th>S.no</th>
								<th>Name</th>
								<th>Email</th>
								<th>Role</th>
								<th>Last Seen</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody >
							@if(!empty($users))
								@php $i = 1; @endphp
								@foreach($users as $row)
									<tr>
										<td> {{$i}}</td>
										<td>{{$row->name}}</td>
										<td><img src="{{asset('images/Message.png')}}">{{$row->email}}</td>
										<td> {{($row->role_id == 1 ? 'Admin' : 'Client')}}</td>
										<td><img src="{{asset('images/Calendar.png')}}"> {{$row->last_seen}}</td>
										<td><img src="{{asset('images/Calendar.png')}}"> {{$row->created_at}}</td>
										<td>
											<a href="javascript:void(0);" class="approveUser app{{$row->id}}" id="{{$row->id}}">
												<button type="button" class="btn {{($row->approve == 1 ? 'reject' : 'final')}}">{{($row->approve == 1 ? 'Unapprove' : 'Approve')}}</button>
											</a>
											<a href="{{route('admin.editUser',[$row->id])}}"><button type="button" class="btn btn-info">Edit</button></a>
											<a href="{{route('admin.deleteUser',[$row->id])}}"><button type="button" class="btn btn-danger">Delete</button></a>
										</td>
									</tr>
									@php $i++; @endphp
								@endforeach
							@endif
						</tbody>
						
					</table>
					</div>
				
				  </div>
				</div>
		</div>
	</div>
<script>
$(document).ready( function () {
    $('#myTable').DataTable({
		aaSorting: [],
		order: [],
		"columnDefs": [{ 
			"targets": [0], //first column / numbering column
			"orderable": false, //set not orderable
		}],	

  language: { search: '', searchPlaceholder: "Search..." },		
	});
	
	$('body').on('click','.approveUser',function(){
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var user_id = $(this).attr('id');

		$.ajax({
			url: "{{ route('admin.clientsApprove') }}",
			type: 'POST',
			data: {"user_id": user_id},
			beforeSend:function(){
				$('.app'+user_id+' button').text('Please wait...');
			},
			success:function(data){					
				if(data.status == 1){
					if(data.approve == 1){
						$('.app'+user_id+' button').text('Unapprove').addClass('reject').removeClass('final');
					}else{
						$('.app'+user_id+' button').text('Approve').addClass('final').removeClass('reject');
					}
				}else{
					alertify.error('Error while approving.');
				}
			}
		});		
	});
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