@extends('layouts.app') 
@section('content')
<div class="main-content">
	<div class="row admin-row">
		<div class="col-lg-8 col-12">
			<div class="chart-sec">
				<div class="d-flex justify-content-between align-items-center user-dashboard table-top">
					<h2 class="inner-hdg">Hello {{Auth::user()->name}}</h2>
				</div>
				
				<div class="chart">
					<div class="left-img">
						<div class="txt">
							<img src="{{asset('images/money.png')}}">
							<h5>Total Revenue<br><span class="total">
                            @if(!empty($property_ids))
                            @php $revenue = DB::table('transaction')->whereIn('property_id',explode(',',$property_ids))->where('type',1)->sum('price'); @endphp
						   
                            {{$revenue}} @endif</span></h5>
						</div>
					</div>
					<div class="right-img">
						<div class="txt">
							<img src="{{asset('images/icon.png')}}">
							<h5>Total Expenses<br><span class="total">
							@if(!empty($property_ids))
                          	@php $expenses = DB::table('transaction')->whereIn('property_id',explode(',',$property_ids))->where('type',2)->sum('price'); @endphp 
						
							{{$expenses}} @endif</span></h5>
						</div>
					</div>
				</div>
				
				<div class="user-table data-table">
					<table id="example" class="table table-striped" style="width:100%">
					<thead>
						<tr class="see-more">
							<th class="hdg">Properties</th>
							<th></th>
							<th></th>
							<th></th>
							<th><a href="{{route('user.properties')}}">See More</a></th>
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
									<td>
										@php $revenue = DB::table('transaction')->where(['property_id'=>$propertyy->id,'type'=>1])->sum('price'); @endphp
									   {{$revenue}}€
									</td>
									<td>
										@php $expense = DB::table('transaction')->where(['property_id'=>$propertyy->id,'type'=>2])->sum('price'); @endphp
										<span style="color:red;">{{$expense}}€</span>
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
				
				<div class="col-lg-4 col-12">
					<div class="data-table chart-bars">
						<h3 class="hdg">Income By Month (<?php echo date("Y"); ?>)</h3>
							@if(!empty($property)) 
								@foreach($months as $key=>$month)
									@php $totalrev = DB::table('transaction')->where(['year'=>date("Y"),'month'=>$key,'type'=>1])->whereIn('property_id',explode(',',$property_ids))->sum('price');
										$totalexp = DB::table('transaction')->where(['year'=>date("Y"),'month'=>$key,'type'=>2])->whereIn('property_id',explode(',',$property_ids))->sum('price'); 
										$total = $totalrev - $totalexp ;
										//print_r($totalrev);
										//	print_r(max($totalrev->price));
									@endphp
									<div class="single-bar">
										<div class="progress">
											<label>{{$month}}</label>
												<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{(!empty($totalrev && $totalrev >$totalexp))? round(($total/$totalrev)*100):0}}"
										   aria-valuemin="0" aria-valuemax="100" style="width:{{(!empty($totalrev && $totalrev >$totalexp))? round(($total/$totalrev)*100):0}}%"></div>
											 <!--<p>{{(!empty($totalrev && $totalrev >$totalexp ))? round(($total/$totalrev)*100):0}}%</p>-->
											 <p>{{(!empty($totalrev) && $totalrev >$totalexp) ? round($total): 0}}</p>
										</div>
									</div>
								@endforeach
							@endif
					</div>
				</div>
			</div>
		</div>

				<div class=" mob-data-table">
				<h5 class="hdg">Properties</h5>
					<div class="row">
					  <div class="col-sm-12">
						   <div class="card d-flex">
							  <div class="card-body mob-card d-flex justify-content-between">
								  <div class="left-cntnt">
									 <h5 class="card-title"><b>Rua das Mosods</b></h5>
									 <p class="card-text">Ervig Ervig</p>
								  </div>
								 <div class="right-cntnt">
								   <h5 class="card-title"><img src="{{asset('images/dollar.png')}}">34,666€</h5>
								   <p class="card-text europe"><img src="{{asset('images/europe.png')}}">346€</p>
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
										<p class="card-text">Ervig Ervig</p>
									</div>
									<div class="right-cntnt">
									   <h5 class="card-title"><img src="{{asset('images/dollar.png')}}">34,666€</h5>
										<p class="card-text europe"><img src="{{asset('images/europe.png')}}">346€</p>
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
									<p class="card-text ">Ervig Ervig</p>
								</div>
								 <div class="right-cntnt">
								    <h5 class="card-title"><img src="{{asset('images/dollar.png')}}">34,666€</h5>
									<p class="card-text europe"><img src="{{asset('images/europe.png')}}">346€</p>
							    </div>
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