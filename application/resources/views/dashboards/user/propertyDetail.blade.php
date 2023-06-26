@extends('layouts.app')
 @section('content')

<div class="main-content">
	<div class="properties">
		<div class="txt">
			<h2 class="card-title">Property 
			             @if(!empty($property))
                   #{{(!empty($property->owner->nif))? $property->owner->nif : "" }}  <br> <b>-{{(!empty($property->address))? $property->address : "" }}    </b></h2>
					     @endif
			<div class="right-img">
					<a href="{{route('user.downloadpdfview',[$property->id,($revenueY ? $revenueY : \Carbon\Carbon::now()->format('Y')),($expenseY ? $expenseY : \Carbon\Carbon::now()->format('Y'))])}}"><img class="img" src="{{asset('images/download.png')}}"></a>
				<img src="{{asset('images/printer.png')}}"  type='button' id='btn' value='Print' onclick='printDiv();'>
			</div>
		</div>
		<div class="card ">
			<div class="row">
				<div class="col-6 col-md-12 col-lg-6 d-flex">
					<div class="card-body DivIdToPrint contentt" >
						<p class="card-text ">
						@if(!empty($property)) 
							 Property Address :- {{(!empty($property->address))? $property->address : "" }}<br>
							
							 Floor :- {{$property->PropertyMeta->floor}} <br>
							 Apartment number :- {{$property->PropertyMeta->apartment_number}}<br>
							<br>
							 Tenant + contact details
						</p>
						<br>
						 Full name :- {{$property->PropertyMeta->fullname}} <br>
						<a href="mailto:{{  $property->PropertyMeta->email }}" class="link"><i class="fa-light fa-at"></i>{{(!empty($property->PropertyMeta->email))? $property->PropertyMeta->email :"" }}</a>
						<br>
						<a href="tel:{{  $property->PropertyMeta->phone }}" class="link"><i class="fa-light fa-m"></i>{{(!empty($property->PropertyMeta->phone)) ? $property->PropertyMeta->phone : ""}}</i></a>
						@endif
					</div>
		
				
			
					<div class="card-body">
						<div class="gallery-popup">
						  <div class="row22">
							 <div class="column">
								<img src="{{asset('images/gallary.png')}}" @if(count($property->propertyGallery) > 0) onclick="openModal();currentSlide(1)" @else onclick="emptyGallery()" @endif>
							 </div>
						  </div>
					  
							  
							<div id="myModal" class="modal">
								<span class="close cursor" onclick="closeModal()">&times;</span>
								<div class="modal-content">
									@if(!empty($property))
										@foreach($property->propertyGallery as $key=>$img)
											@if(pathinfo(parse_url($img->media, PHP_URL_PATH),PATHINFO_EXTENSION) != 'pdf')
												<div class="mySlides">
												  <img src="{{asset('storage/'.$img->media)}}" style="width:100%">
												</div>
											@endif
										@endforeach
									@endif

									<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
									<a class="next" onclick="plusSlides(1)">&#10095;</a>

									<div class="caption-container">
										<p id="caption"></p>
									</div>

									<div class="slidee">
										@if(!empty($property->propertyGallery))
											@foreach($property->propertyGallery as $key=>$img)
												@if(pathinfo(parse_url($img->media, PHP_URL_PATH),PATHINFO_EXTENSION) != 'pdf')
													<div class="column">
													  <img class="demo cursor" src="{{asset('storage/'.$img->media)}}" style="width:100%" onclick="currentSlide({{$key}})">
													</div>
													
												@endif
											@endforeach
										@endif
									</div>
								</div>
							</div>
                        </div>
					</div>
	            </div>
				<div class="col-sm-6 pdf-data">
					<div class="card-body pdf">
						@foreach($docs as $key=>$doc)
							<div class="col-txt">
								 <a data-bs-toggle="modal" data-bs-target="#exampleModal{{$key}}" target="_blank">
										<img src="{{asset('images/pdf.png')}}">
										<p>{{$doc}}</p>
								 </a>
							</div>
								
							<!-- Modal start -->
							<div class="modal fade documents-modal" id="exampleModal{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Documents</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								  </div>
								  <div class="modal-body">
										@if(!empty($property->propertyDocuments))
											@foreach($property->propertyDocuments as $docc)
												@if($docc->category == $key)
													<div class="col-txt">
														<a href ="{{asset('storage/'.$docc->document)}}" target="_blank">
															<img src="{{asset('images/pdf.png')}}">
															<p class="pdf-text">{{$docc->document_name}}</p>
														</a>
													</div>
												@endif
											@endforeach
										@endif
								  </div>
								  <div class="modal-footer">
									 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
								  </div>
								</div>
							  </div>
							</div>
												 <!-- Modal end -->
						@endforeach
							
						@if(!empty($property->propertyDocuments))
							@foreach($property->propertyDocuments as $doc)
								@if($doc->category == 5)
									<div class="col-txt">
										<a href="{{asset('storage/'.$doc->document)}}" target="_blank">
										<img src="{{asset('images/pdf.png')}}">
										<p> {{$doc->document_name}}</p>
										</a>
									</div>
								@endif
							@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>
				
				<div class="card second-row DivIdToPrint contentt">
				<h5 class="card-title heading">Revenues {{($revenueY ? $revenueY : date("Y"))}}
					
					<span class="float-end">
					@if($revenueY == 2022)
						<a href="{{route('user.propertyDetail',['id'=>$property->id,'revenueY'=>$revenueY,'expenseY'=>($expenseY ? $expenseY : \Carbon\Carbon::now()->format('Y'))])}}"><i class="fa fa-caret-left"></i></a> 
					@else
						<a href="{{route('user.propertyDetail',['id'=>$property->id,'revenueY'=>(($revenueY ? $revenueY : \Carbon\Carbon::now()->format('Y')) - 1),'expenseY'=>($expenseY ? $expenseY : \Carbon\Carbon::now()->format('Y'))])}}"><i class="fa fa-caret-left"></i></a> 
					@endif
					<a href="{{route('user.propertyDetail',['id'=>$property->id,'revenueY'=>(($revenueY ? $revenueY : \Carbon\Carbon::now()->format('Y')) + 1),'expenseY'=>($expenseY ? $expenseY : \Carbon\Carbon::now()->format('Y'))])}}"><i class="fa fa-caret-right"></a></i>
				</span></h5>
					<div class="pdf-data">
					<div class="card-body pdf">
					<div class="row">
						
						@if(!empty($property)) 
							@foreach($months as $key=>$month)
								@php $yr = ($revenueY ? $revenueY : date("Y"));
								$Transaction = DB::table('transaction')->where(['property_id'=>$property->id,'year'=>$yr,'month'=>$key,'type'=>1])->first(); @endphp
									<div class=" col-lg-1 col-4 col-md-3 single-col">
										<h5>{{$month}}</h5>
										  <p class="value">
										  {{ (!empty($Transaction->price)) ? $Transaction->price:""}}
										 </p>
									
									<div class="d-print-none">
									<div class="first-row fonts">
										@if(!empty($Transaction->document))
										<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#documentModaldocs{{$key}}">
											 <br>
											  <img src="{{asset('images/pdf.png')}}">
											 <br>
											  <p>Payment Proof</p>
										  	</a>
										@else
										
										      <img src="{{asset('images/g-pdf.png')}}">
							            
										@endif
									 </div>
										   <img class="jan" src="{{asset('images/jan.png')}}" style="background:#fff;">
										</div>
									 </div>
									 
									 	<div class="modal fade documents-modal" id="documentModaldocs{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog">
									<div class="modal-content">
									  <div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Documents</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									  </div>
									  <div class="modal-body">
										@if(!empty($Transaction->document))
											@php $sn = 1; @endphp
											@foreach(json_decode($Transaction->document) as $split)
												<div class="col-txt">
													<a href="{{asset('storage/'.$split)}}" target="_blank">
														<img src="{{asset('images/pdf.png')}}">
														<p class="pdf-text"> {{__('Payment Proof')}} ({{$sn}})</p>
													</a>
												</div>
												@php $sn++; @endphp												
											@endforeach
										@endif
									  </div>
									  <div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
									  </div>
									</div>
								  </div>
								</div>	
								@endforeach
							  @endif  
							</div>
						</div>
					</div>
				</div>
				<div class="card third-row DivIdToPrint contentt">
					<h5 class="card-title heading" style="color:#D11A2A!important;">Expenses {{($expenseY ? $expenseY : date("Y"))}}  
						<span class="float-end">
							@if($expenseY == 2022)
								<a href="{{route('user.propertyDetail',['id'=>$property->id,'revenueY'=>($revenueY ? $revenueY : \Carbon\Carbon::now()->format('Y')),'expenseY'=>$expenseY])}}"><i class="fa fa-caret-left"></i></a> 
							@else
								<a href="{{route('user.propertyDetail',['id'=>$property->id,'revenueY'=>($revenueY ? $revenueY : \Carbon\Carbon::now()->format('Y')),'expenseY'=>(($expenseY ? $expenseY : \Carbon\Carbon::now()->format('Y')) - 1)])}}"><i class="fa fa-caret-left"></i></a> 
							@endif
							<a href="{{route('user.propertyDetail',['id'=>$property->id,'revenueY'=>($revenueY ? $revenueY : \Carbon\Carbon::now()->format('Y')),'expenseY'=>(($expenseY ? $expenseY : \Carbon\Carbon::now()->format('Y')) + 1)])}}"><i class="fa fa-caret-right"></a></i>
						</span>
					</h5>
					<div class=" pdf-data">
						<div class="card-body pdf">
						  <div class="row">
							@if(!empty($property)) 
							   @foreach($months as $key=>$month)
								  @php $yr = ($expenseY ? $expenseY : date("Y"));
								  $Transaction = DB::table('transaction')->where(['property_id'=>$property->id,'year'=>$yr,'month'=>$key,'type'=>2])->first(); @endphp
									<div class="col-lg-1 col-4 col-md-3  single-col">
										<h5>{{$month}}</h5>
										<p class="value">
										   {{ (!empty($Transaction->price)) ? $Transaction->price:" " }}
										</p>
										
										@if($key == 1)<h4>ELECTRICITY</h4>@endif
										<div class="d-print-none">
											<div class="first-row fonts">
												@if(!empty($Transaction->document))
													<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#documentModaldocsedocument{{$key}}">
														<img src="{{asset('images/pdf.png')}}" >
														<p>Invoices</p>
													</a>
												@else
													<img src="{{asset('images/g-pdf.png')}}">
												@endif
											</div>
											<img class="jan" src="{{asset('images/jan.png')}}" style="background:#fff;">
										</div>
										
					
										@if($key == 1)<h4>CONDOMINIUM</h4>@endif
										<div class="d-print-none">
											<div class="first-row fonts">
												@if(!empty($Transaction->condominium))
													<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#documentModaldocsecondominium{{$key}}">
														<img src="{{asset('images/pdf.png')}}" >
														<p>Invoices</p>
													</a>
												@else
													<img src="{{asset('images/g-pdf.png')}}">
												@endif
											</div>
											<img class="jan" src="{{asset('images/jan.png')}}" style="background:#fff;">
										</div>
										
										
										@if($key == 1)<h4>OTHER</h4>@endif
										<div class="d-print-none">
											<div class="first-row fonts">
												@if(!empty($Transaction->other))
													<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#documentModaldocseother{{$key}}">
														<img src="{{asset('images/pdf.png')}}" >
														<p>Invoices</p>
													</a>
												@else
													<img src="{{asset('images/g-pdf.png')}}">
												@endif
											</div>
											<img class="jan" src="{{asset('images/jan.png')}}" style="background:#fff;">
										</div>
									</div>
									
									<div class="modal fade documents-modal" id="documentModaldocsedocument{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
									  <div class="modal-dialog">
										<div class="modal-content">
										  <div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Documents</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										  </div>
										  <div class="modal-body">
											@if(!empty($Transaction->document))
												@php $snn = 1; @endphp
												@foreach(json_decode($Transaction->document) as $split)
													<div class="col-txt">
														<a href="{{asset('storage/'.$split)}}" target="_blank">
															<img src="{{asset('images/pdf.png')}}">
															<p class="pdf-text"> {{__('Invoices')}} ({{$snn}})</p>
														</a>
													</div>
													@php $snn++; @endphp	
												@endforeach
											@endif
										  </div>
										  <div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
										  </div>
										</div>
									  </div>
									</div>	

									<div class="modal fade documents-modal" id="documentModaldocsecondominium{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
									  <div class="modal-dialog">
										<div class="modal-content">
										  <div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Documents</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										  </div>
										  <div class="modal-body">
											@if(!empty($Transaction->condominium))
												@php $snn = 1; @endphp
												@foreach(json_decode($Transaction->condominium) as $split)
													<div class="col-txt">
														<a href="{{asset('storage/'.$split)}}" target="_blank">
															<img src="{{asset('images/pdf.png')}}">
															<p class="pdf-text"> {{__('Invoices')}} ({{$snn}})</p>
														</a>
													</div>
													@php $snn++; @endphp	
												@endforeach
											@endif
										  </div>
										  <div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
										  </div>
										</div>
									  </div>
									</div>

									<div class="modal fade documents-modal" id="documentModaldocseother{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
									  <div class="modal-dialog">
										<div class="modal-content">
										  <div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Documents</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										  </div>
										  <div class="modal-body">
											@if(!empty($Transaction->other))
												@php $snn = 1; @endphp
												@foreach(json_decode($Transaction->other) as $split)
													<div class="col-txt">
														<a href="{{asset('storage/'.$split)}}" target="_blank">
															<img src="{{asset('images/pdf.png')}}">
															<p class="pdf-text"> {{__('Invoices')}} ({{$snn}})</p>
														</a>
													</div>
													@php $snn++; @endphp	
												@endforeach
											@endif
										  </div>
										  <div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
										  </div>
										</div>
									  </div>
									</div>									
							   @endforeach
							@endif 
						  </div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script>
	function emptyGallery(){
		alertify.error('Gallery is empty.');
	}
	function openModal() {
	  document.getElementById("myModal").style.display = "block";
	}

	function closeModal() {
	  document.getElementById("myModal").style.display = "none";
	}

	var slideIndex = 1;

	function plusSlides(n) {
	  showSlides(slideIndex += n);
	}

	function currentSlide(n) {
	  showSlides(slideIndex = n);
}

		function showSlides(n) {
		  var i;
		  var slides = document.getElementsByClassName("mySlides");
		  var dots = document.getElementsByClassName("demo");
		  var captionText = document.getElementById("caption");
		  if (n > slides.length) {slideIndex = 1}
		  if (n < 1) {slideIndex = slides.length}
		  for (i = 0; i < slides.length; i++) {
			  slides[i].style.display = "none";
		  }
		  for (i = 0; i < dots.length; i++) {
			  dots[i].className = dots[i].className.replace(" active", "");
		  }
		  slides[slideIndex-1].style.display = "block";
		  dots[slideIndex-1].className += " active";
		  captionText.innerHTML = dots[slideIndex-1].alt;
		}
		</script>
		
@if(count($property->propertyGallery) > 0)				
<script>
	showSlides(slideIndex);
</script>
@endif
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script>
function printDiv() 

{ 
	
    var divsToPrint = document.getElementsByClassName('DivIdToPrint');
    var printContents = "";
    for (n = 0; n < divsToPrint.length; n++) 
    {
       printContents += divsToPrint[n].innerHTML+"<br>";
    }
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents; 
	

}</script>



		@endsection