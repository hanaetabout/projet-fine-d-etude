@extends('layouts.app') 
@section('content')
	<div class="main-content">
		<div class="row">
			<div class="col-lg-12">
				<div class="card  user-data client-data">
				  <div class="card-body">
				  <a class="btn btn-light add-new-btn float-end"  href="{{route('admin.addClient')}}" role="button"><i class="fa-regular fa-plus"></i> Add Client </a>
				  
					<table id="myTable" class="table table-responsive  display">
						<thead>
							<tr>
								<th>S.no</th>
								<th>Name</th>
								<th>Email</th>
								<th>Phone Number </th>
								<th>Nif </th>
								<th>Tax Address</th>
								<th>Created at</th>
								
							</tr>
						</thead>
						<tbody>
							@if(!empty($clients))
								@php $i = 1; @endphp
								@foreach($clients as $row)
									<tr>
										<td> {{$i}}</td>
										<td>{{$row->name}}</td>
										<td><img src="{{asset('images/Message.png')}}"> {{$row->email}}</td>
										<td><i class="fa-solid fa-phone"></i> {{$row->phone}}</td>
										<td>{{$row->nif}}</td>
										<td><i class="fa-sharp fa-solid fa-location-dot"></i> {{$row->tax_address}}</td>
										<td><img src="{{asset('images/Calendar.png')}}"> {{$row->created_at}}</td>
										
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
	
});
</script>

@endsection