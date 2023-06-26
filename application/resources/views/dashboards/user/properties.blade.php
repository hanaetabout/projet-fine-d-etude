@extends('layouts.app') 
@section('content')
<div class="main-content">
	<div class="row admin-row">
		<div class="col-lg-12 col-12">
			<div class="chart-sec">
				<div class="d-flex justify-content-between align-items-center user-dashboard table-top">
					<h2 class="inner-hdg">Hello Robert</h2>
				</div>
				<div class="user-table data-table">
					<table id="example" class="table table-striped" style="width:100%">
					<thead>
						<tr class="see-more">
							<th class="hdg">Properties</th>
							<th></th>
							<th></th>
							<th></th>
							<th><a href="#">See More</a></th>
						</tr>
						<tr>
							<th>S.no</th>
							<th>Property address</th>
							<th>NIF #</th>
							<th>Revenue</th>
							<th>Expenses</th>
						</tr>
					</thead>
					<tbody class="data">
						<!---<tr>
							<td>1</td>
							<td class="data-hdg">Rua das Mosods</td>
							<td>#876987</td>
							<td>34,666€</td>
							<td class="expns">346€</td>
						</tr> --->
						@if(!empty($property))
				        @php $i = 1; @endphp
						@foreach($property as $propertyy)
						<tr>
						<td>{{$i}}</td>
						<td><a href="{{route('user.propertyDetail',[$propertyy->id])}}"target="_blank">{{$propertyy->address}}</a></td>
						<td>#{{$propertyy->owner->nif}}</td>
						<td>@php $revenue = DB::table('transaction')->where(['property_id'=>$propertyy->id,'type'=>1])->sum('price'); @endphp
							
						{{$revenue }}</td>
						<td>@php $expense = DB::table('transaction')->where(['property_id'=>$propertyy->id,'type'=>2])->sum('price'); @endphp
						{{$expense}}</td>
						
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
	$(document).ready(function () {
		$('#example').DataTable({
			searching: false, paging: false, info: false
		});
	});
</script>
@endsection