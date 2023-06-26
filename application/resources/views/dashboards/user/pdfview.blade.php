@extends('layouts.pdflayout')

@section('content')

<style>


 th,td{
    padding:10px 5px;

}

.table-main{
	background:#fff;
	border: 4px solid rgba(58,54,219,0.2);
	padding:10px 5px ;
	border-radius:5px;
	
}
.two{
	margin-top:30px;
	border: 4px solid rgba(209,26,42,0.2);
}
</style>



				<div class="card" style="margin-bottom :30px;">
					
						<p class="card-text">
							 Property Address<br>

								<div class="info-txt">
									Full name :- {{$property->PropertyMeta->fullname}}
								</div>
								
								<div class="info-txt">
									Floor :- {{$property->PropertyMeta->floor}}
								</div>
							  
								<div class="info-txt">
									Apartment number  :- {{$property->PropertyMeta->apartment_number}}
								</div>
							  <br>
							 Tenant + contact details
						 </p>
							
						 <div class="info-txt">
							 <a href="" class="link" ><i class="fa-light fa-at"></i>{{$property->PropertyMeta->email}}</a>
						 </div>

						 <div class="data-info">
							 <a href="" class="link"><i class="fa-light fa-m"></i>{{$property->PropertyMeta->phone}}</i></a>
						</div>
					</div>
					
				
				
						<div class="table-main">
		  <h5 class="card-title heading" style="color:blue;">Revenues {{($revenueY ? $revenueY : date("Y"))}} </h5>
				<table>
				  <tr>
					  @if(!empty($property)) 
						@foreach($months as $key=>$month)
						<th>{{ $month }}</th>
					 @endforeach 
						@endif
				 </tr>
				 
			      <tr>
						 @if(!empty($property)) 
						@foreach($months as $key=>$month)
					   <td>@php $yr = ($revenueY ? $revenueY : date("Y"));
								$Transaction = DB::table('transaction')->where(['property_id'=>$property->id,'year'=>$yr,'month'=>$key,'type'=>1])->first(); @endphp
								
							<span>@if(!empty($Transaction->price)){{$Transaction->price}}@endif</span>
					   </td>
					@endforeach 
						@endif
			   </tr> 
				</table>
		</div>


<div class="table-main two">
			  <h5 class="card-title heading" style="color:red;">Expenses {{($expenseY ? $expenseY : date("Y"))}}</h5>
			<table>
					<tr>
						  @if(!empty($property)) 
							@foreach($months as $key=>$month)
							<th>{{ $month }}</th>
						 @endforeach 
							@endif
					</tr>
					<tr>
			 
						   @if(!empty($property)) 
												@foreach($months as $key=>$month)

							<td>@php $yr = ($expenseY ? $expenseY : date("Y"));
								$Transaction = DB::table('transaction')->where(['property_id'=>$property->id,'year'=>$yr,'month'=>$key,'type'=>2])->first(); @endphp
								<span>@if(!empty($Transaction->price)){{$Transaction->price}}@endif</span>
							</td>
						  @endforeach 
						  @endif
				   </tr> 
</table>
</div>



@endsection