@extends('layouts.app')

@section('content')
<div class="main-content">
	<div class="properties">
		<div class="txt">
		
			<h2 class="card-title">Property {{ (!empty($properties->owner) ? $properties->owner->nif : '') }}<br> <b>- {{ ($properties->address) }}</b></h2>
			<div class="right-img">
				<a href="{{route('admin.downloadpdfview',[$properties->id,($revenueY ? $revenueY : \Carbon\Carbon::now()->format('Y')),($expenseY ? $expenseY : \Carbon\Carbon::now()->format('Y'))])}}"><img class="img" src="{{asset('images/download.png')}}"></a>
				<img src="{{asset('images/printer.png')}}"type='button' id='btn' value='Print' onclick='printDiv();'>
			</div>
		</div>
		<div class="card ">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-6 d-flex">
					<div class="card-body DivIdToPrint">
						<i class="fas fa-edit editPropMeta"></i>
						<form id="prop-meta">
							<input type="hidden" value="{{$properties->PropertyMeta->id}}" name="id">
							<p class="card-text">
								 Property Address<br>

								
								<div class="data-info">
									<div class="info-txt">
										Floor :- {{$properties->PropertyMeta->floor}}
									</div>
									<input class="form-control editPropMetaField" type="text" name="floor" value="{{$properties->PropertyMeta->floor}}" placeholder="floor">
								</div>
								<div class="data-info">
									<div class="info-txt">
										Apartment number  :- {{$properties->PropertyMeta->apartment_number}}
									</div>
									<input class="form-control editPropMetaField" type="text" name="apartment_number" value="{{$properties->PropertyMeta->apartment_number}}" placeholder="Apartment number">
									<br>
								 Tenant + contact details
								</div>
							</p>
							<div class="data-info">
									<div class="info-txt">								 
										Full name :- {{$properties->PropertyMeta->fullname}}
									</div>
									<input class="form-control editPropMetaField" type="text" name="fullname" value="{{$properties->PropertyMeta->fullname}}" placeholder="fullname">
								</div>
							<div class="data-info">
								<div class="info-txt">
									<a href="" class="link"><i class="fa-light fa-at"></i>{{$properties->PropertyMeta->email}}</a>
								</div>
								<input class="form-control editPropMetaField" type="email" name="email" value="{{$properties->PropertyMeta->email}}" placeholder="Email">
							</div>
							<div class="data-info">
								<div class="info-txt"> 
									<a href="" class="link"><i class="fa-light fa-m"></i>{{$properties->PropertyMeta->phone}}</i></a>
								</div>
								<input type="tel" name="phone" class="form-control editPropMetaField" id="tel" value="{{$properties->PropertyMeta->phone}}" placeholder="+2342343324234">
							</div>
						</form>
					</div>
					
					<div class="card-body gallery">
						<div class="gallery-popup">
							<div class="row22">
								<div class="column">
									<img src="{{asset('images/gallary.png')}}" @if(count($properties->propertyGallery) > 0) onclick="openModal();currentSlide(1)" @else onclick="emptyGallery()" @endif>
									<label class="form__container" id="upload-container">
										<form method="post" action="{{route('admin.addPropGallery')}}" enctype="multipart/form-data">
											@csrf
											<input type="hidden" name="property_id" value="{{$properties->id}}">
											<input type="file" style="display:none;" class="form__file" id="upload-files" name="media[]" multiple accept="image/jpeg,image/png" onchange="this.form.submit()">
										</form>
										<!--<img class="jan" src="{{asset('images/grey-plus.png')}}">-->
										<div class="jan">+</div>
									</label>
								</div>
							</div>
					  
							<div id="myModal" class="modal">
								<span class="close cursor" onclick="closeModal()">&times;</span>
								<div class="modal-content">
									@if(!empty($properties->propertyGallery))
										@foreach($properties->propertyGallery as $doc)
											<div class="mySlides">
											  <img src="{{asset('storage/'.$doc->media)}}" style="width:100%">
											</div>
										@endforeach
									@endif

									<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
									<a class="next" onclick="plusSlides(1)">&#10095;</a>

									<div class="caption-container">
										<p id="caption"></p>
									</div>

									<div class="slidee">
										@if(!empty($properties->propertyGallery))
											@php $s = 1; @endphp
											@foreach($properties->propertyGallery as $doc)
												<div class="column">
												  <img class="demo cursor" src="{{asset('storage/'.$doc->media)}}" style="width:100%" onclick="currentSlide({{$s}})">
												</div>
												@php $s++; @endphp
											@endforeach
										@endif
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				
				<div class="col-md-12 col-lg-6 pdf-data">
				
					<div class="card-body pdf">
						@foreach($docs as $key=>$doc)
							<div class="single-col">
								<div class="col-txt">
									<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#documentModal{{$key}}">
										<img src="{{asset('images/pdf.png')}}">
										<p> {{$doc}}</p>
									</a>
								</div>
								<label class="form__container" id="upload-container">
									<form method="post" action="{{route('admin.addPropDocument')}}" enctype="multipart/form-data">
										@csrf
										<input type="hidden" name="property_id" value="{{$properties->id}}">
										<input type="hidden" name="type" value="1">
										<input type="hidden" name="category" value="{{$key}}">
										<input class="form__file" id="upload-files" name="prop_doc[]" type="file" accept="application/pdf" multiple onchange="this.form.submit()"/>
									</form>
									<div class="jan">+</div>
								</label>
							</div>
							
							<div class="modal fade documents-modal" id="documentModal{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Documents</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								  </div>
								  <div class="modal-body">
									@if(!empty($properties->propertyDocuments))
										@foreach($properties->propertyDocuments as $docc)
											@if($docc->category == $key)
												<div class="col-txt cross-css">
													<div class="doc-cross deleteDocumentJs" id="{{$properties->id}}" data="1" row-id="{{$docc->id}}"><i class="fa fa-times" aria-hidden="true"></i></div>
													<a href="{{asset('storage/'.$docc->document)}}" target="_blank">
														<img src="{{asset('images/pdf.png')}}">
														<p class="pdf-text"> {{$docc->document_name}}</p>
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
						@endforeach
						
						@if(!empty($properties->propertyDocuments))
							@foreach($properties->propertyDocuments as $doc)
								@if($doc->category == 5)
									<div class="col-txt">
										<div class="doc-cross deleteDocumentJs" id="{{$properties->id}}" data="2" row-id="{{$doc->id}}"><i class="fa fa-times" aria-hidden="true"></i></div>
										<a href="{{asset('storage/'.$doc->document)}}" target="_blank">
											<img src="{{asset('images/pdf.png')}}">
											<p> {{$doc->document_name}}</p>
										</a>
									</div>
								@endif
							@endforeach
						@endif
				
		
						<div class="col-txt" style="border:1px dashed #D6DFF0!important;">
							<label class="form__container" id="upload-container">
								<form method="post" action="{{route('admin.addPropDocument')}}" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="property_id" value="{{$properties->id}}">
									<input type="hidden" name="type" value="1">
									<input type="hidden" name="category" value="5">
									<input type="file" style="display:none;" class="form__file" id="upload-files" name="prop_doc[]" multiple accept="application/pdf" onchange="this.form.submit()">
								</form>
								<img src="{{asset('images/bg-plus.png')}}">
								<p style="color:#D6DFF0">
									 Add <br>
									 documents
								</p>
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card second-row DivIdToPrint">
			<h5 class="card-title heading">Revenues {{($revenueY ? $revenueY : date("Y"))}} 
				<span class="float-end">
					@if($revenueY == 2022)
						<a href="{{route('admin.propertyDetail',['id'=>$properties->id,'revenueY'=>$revenueY,'expenseY'=>($expenseY ? $expenseY : \Carbon\Carbon::now()->format('Y'))])}}"><i class="fa fa-caret-left"></i></a> 
					@else
						<a href="{{route('admin.propertyDetail',['id'=>$properties->id,'revenueY'=>(($revenueY ? $revenueY : \Carbon\Carbon::now()->format('Y')) - 1),'expenseY'=>($expenseY ? $expenseY : \Carbon\Carbon::now()->format('Y'))])}}"><i class="fa fa-caret-left"></i></a> 
					@endif
					<a href="{{route('admin.propertyDetail',['id'=>$properties->id,'revenueY'=>(($revenueY ? $revenueY : \Carbon\Carbon::now()->format('Y')) + 1),'expenseY'=>($expenseY ? $expenseY : \Carbon\Carbon::now()->format('Y'))])}}"><i class="fa fa-caret-right"></a></i>
				</span>
			</h5>
			<div class="pdf-data">
			
				<div class="card-body pdf">
					<div class="row">
						@if(!empty($properties)) 
							@foreach($months as $key=>$month)
								<div class=" col-xl-1 col-4 col-md-3 col-lg-2 single-col">
									<h5>{{ $month }}</h5>
									@php $yr = ($revenueY ? $revenueY : date("Y"));
									$Transaction = DB::table('transaction')->where(['property_id'=>$properties->id,'year'=>$yr,'month'=>$key,'type'=>1])->first(); @endphp
									<input type="text" value="@if(!empty($Transaction->price)){{$Transaction->price}}@endif" id="r_{{ $yr.'_'.$key }}" data-id="{{$properties->id}}" style="width:70px;" class="value"/>
										<div class="d-print-none">
									@if(empty($Transaction->document))									
										<div class="first-row">
											<img src="{{asset('images/g-pdf.png')}}">
										</div>
										<!--<img class="jan" src="{{asset('images/jan.png')}}">-->
										<label class="form__container" id="upload-container">
											<form method="post" action="{{route('admin.addPropDocument')}}" enctype="multipart/form-data">
												@csrf
												<input type="hidden" name="property_id" value="{{$properties->id}}">
												<input type="hidden" name="type" value="2">
												<input type="hidden" name="data" value="r_{{ $yr.'_'.$key }}_document">
												<input class="form__file" id="upload-files" name="doc" type="file" accept="application/pdf" onchange="this.form.submit()"/>
											</form>
											<div class="jan">+</div>
										</label>
									@else
										<div class="first-row fonts">
											<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#documentModaldocs{{$key}}">
												<img src="{{asset('images/pdf.png')}}">
												<p>Payment Proof</p>
											</a>
										</div>
										<!--<img class="jan" src="{{asset('images/jan.png')}}"style="background:#fff;">-->
										<label class="form__container" id="upload-container">
											<form method="post" action="{{route('admin.addPropDocument')}}" enctype="multipart/form-data">
												@csrf
												<input type="hidden" name="property_id" value="{{$properties->id}}">
												<input type="hidden" name="type" value="2">
												<input type="hidden" name="data" value="r_{{ $yr.'_'.$key }}_document">
												<input class="form__file" id="upload-files" name="doc" type="file" accept="application/pdf" onchange="this.form.submit()"/>
											</form>
											<div class="jan">+</div>
										</label>
									@endif
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
											@foreach(json_decode($Transaction->document) as $k => $split)
												<div class="col-txt">
													<div class="doc-cross deleteDocumentJs" id="{{$properties->id}}" data="3" row-id="{{$Transaction->id}}_{{$k}}_document"><i class="fa fa-times" aria-hidden="true"></i></div>
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
		<div class="card third-row DivIdToPrint">
		
			<h5 class="card-title heading" style="color:#D11A2A!important;">Expenses {{($expenseY ? $expenseY : date("Y"))}}  
				<span class="float-end">
					@if($expenseY == 2022)
						<a href="{{route('admin.propertyDetail',['id'=>$properties->id,'revenueY'=>($revenueY ? $revenueY : \Carbon\Carbon::now()->format('Y')),'expenseY'=>$expenseY])}}"><i class="fa fa-caret-left"></i></a> 
					@else
						<a href="{{route('admin.propertyDetail',['id'=>$properties->id,'revenueY'=>($revenueY ? $revenueY : \Carbon\Carbon::now()->format('Y')),'expenseY'=>(($expenseY ? $expenseY : \Carbon\Carbon::now()->format('Y')) - 1)])}}"><i class="fa fa-caret-left"></i></a> 
					@endif
					<a href="{{route('admin.propertyDetail',['id'=>$properties->id,'revenueY'=>($revenueY ? $revenueY : \Carbon\Carbon::now()->format('Y')),'expenseY'=>(($expenseY ? $expenseY : \Carbon\Carbon::now()->format('Y')) + 1)])}}"><i class="fa fa-caret-right"></a></i>
				</span>
			</h5>
			<div class=" pdf-data">
				<div class="card-body pdf">
				
					<div class="row">
					
						@if(!empty($properties)) 
							@foreach($months as $key=>$month)
								<div class=" col-xl-1 col-4 col-lg-2  col-md-3 single-col">
									<h5>{{ $month }}</h5>
									@php $yr = ($expenseY ? $expenseY : date("Y"));
									$Transaction = DB::table('transaction')->where(['property_id'=>$properties->id,'year'=>$yr,'month'=>$key,'type'=>2])->first(); @endphp
									
									<input type="text" value="@if(!empty($Transaction->price)){{$Transaction->price}}@endif" id="e_{{ $yr.'_'.$key }}" data-id="{{$properties->id}}" style="width:70px;" class="value"/>
										@if($key == 1) <h4>ELECTRICITY</h4> @endif
										<div class="d-print-none">	
											@if(empty($Transaction->document))	
												<div class="first-row">
													<img src="{{asset('images/g-pdf.png')}}">
												</div>
												<!--<img class="jan" src="{{asset('images/jan.png')}}">-->
												<label class="form__container" id="upload-container">
													<form method="post" action="{{route('admin.addPropDocument')}}" enctype="multipart/form-data">
														@csrf
														<input type="hidden" name="property_id" value="{{$properties->id}}">
														<input type="hidden" name="type" value="2">
														<input type="hidden" name="data" value="e_{{ $yr.'_'.$key }}_document">
														<input class="form__file" id="upload-files" name="doc" type="file" accept="application/pdf" onchange="this.form.submit()"/>
													</form>
													<div class="jan">+</div>
												</label>
											@else
												<div class="first-row elect fonts">
													<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#documentModaldocsedocument{{$key}}">
														<img src="{{asset('images/pdf.png')}}" >
														<p>Invoices</p>
													</a>
												</div>
												<!--<img class="jan" src="{{asset('images/jan.png')}}"style="background:#fff;">-->
												<label class="form__container" id="upload-container">
													<form method="post" action="{{route('admin.addPropDocument')}}" enctype="multipart/form-data">
														@csrf
														<input type="hidden" name="property_id" value="{{$properties->id}}">
														<input type="hidden" name="type" value="2">
														<input type="hidden" name="data" value="e_{{ $yr.'_'.$key }}_document">
														<input class="form__file" id="upload-files" name="doc" type="file" accept="application/pdf" onchange="this.form.submit()"/>
													</form>
													<div class="jan">+</div>
												</label>
											@endif
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
													@foreach(json_decode($Transaction->document) as $k => $split)
														<div class="col-txt">
															<div class="doc-cross deleteDocumentJs" id="{{$properties->id}}" data="3" row-id="{{$Transaction->id}}_{{$k}}_document"><i class="fa fa-times" aria-hidden="true"></i></div>
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

										@if($key == 1) <h4>CONDOMINIUM</h4> @endif
										<div class="d-print-none">	
											@if(empty($Transaction->condominium))	
												<div class="first-row sec">
													<img src="{{asset('images/g-pdf.png')}}">
												</div>
												<!--<img class="jan" src="{{asset('images/jan.png')}}">-->
												<label class="form__container" id="upload-container">
													<form method="post" action="{{route('admin.addPropDocument')}}" enctype="multipart/form-data">
														@csrf
														<input type="hidden" name="property_id" value="{{$properties->id}}">
														<input type="hidden" name="type" value="2">
														<input type="hidden" name="data" value="e_{{ $yr.'_'.$key }}_condominium">
														<input class="form__file" id="upload-files" name="doc" type="file" accept="application/pdf" onchange="this.form.submit()"/>
													</form>
													<div class="jan">+</div>
												</label>
											@else
												<div class="first-row fonts">
													<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#documentModaldocsecondominium{{$key}}">
														<img src="{{asset('images/pdf.png')}}" >
														<p>Invoices</p>
													</a>
												</div>
												<!--<img class="jan" src="{{asset('images/jan.png')}}"style="background:#fff;">-->
												<label class="form__container" id="upload-container">
													<form method="post" action="{{route('admin.addPropDocument')}}" enctype="multipart/form-data">
														@csrf
														<input type="hidden" name="property_id" value="{{$properties->id}}">
														<input type="hidden" name="type" value="2">
														<input type="hidden" name="data" value="e_{{ $yr.'_'.$key }}_condominium">
														<input class="form__file" id="upload-files" name="doc" type="file" accept="application/pdf" onchange="this.form.submit()"/>
													</form>
													<div class="jan">+</div>
												</label>
											@endif
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
													@foreach(json_decode($Transaction->condominium) as $k => $split)
														<div class="col-txt">
															<div class="doc-cross deleteDocumentJs" id="{{$properties->id}}" data="3" row-id="{{$Transaction->id}}_{{$k}}_condominium"><i class="fa fa-times" aria-hidden="true"></i></div>
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


										@if($key == 1) <h4>OTHER</h4> @endif
										<div class="d-print-none">	
											@if(empty($Transaction->other))	
												<div class="first-row other">
													<img src="{{asset('images/g-pdf.png')}}">
												</div>
												<!--<img class="jan" src="{{asset('images/jan.png')}}">-->
												<label class="form__container" id="upload-container">
													<form method="post" action="{{route('admin.addPropDocument')}}" enctype="multipart/form-data">
														@csrf
														<input type="hidden" name="property_id" value="{{$properties->id}}">
														<input type="hidden" name="type" value="2">
														<input type="hidden" name="data" value="e_{{ $yr.'_'.$key }}_other">
														<input class="form__file" id="upload-files" name="doc" type="file" accept="application/pdf" onchange="this.form.submit()"/>
													</form>
													<div class="jan">+</div>
												</label>
											@else
												<div class="first-row fonts">
													<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#documentModaldocseother{{$key}}">
														<img src="{{asset('images/pdf.png')}}" >
														<p>Invoices</p>
													</a>
												</div>
												<!--<img class="jan" src="{{asset('images/jan.png')}}"style="background:#fff;">-->
												<label class="form__container" id="upload-container">
													<form method="post" action="{{route('admin.addPropDocument')}}" enctype="multipart/form-data">
														@csrf
														<input type="hidden" name="property_id" value="{{$properties->id}}">
														<input type="hidden" name="type" value="2">
														<input type="hidden" name="data" value="e_{{ $yr.'_'.$key }}_other">
														<input class="form__file" id="upload-files" name="doc" type="file" accept="application/pdf" onchange="this.form.submit()"/>
													</form>
													<div class="jan">+</div>
												</label>
											@endif
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
													@foreach(json_decode($Transaction->other) as $k => $split)
														<div class="col-txt">
															<div class="doc-cross deleteDocumentJs" id="{{$properties->id}}" data="3" row-id="{{$Transaction->id}}_{{$k}}_other"><i class="fa fa-times" aria-hidden="true"></i></div>
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
	$('.value').focusout(function() {
		var currentM  = $(this).attr('id');
		//console.log($('#'+currentM).val());
		if($('#'+currentM).val().length > 0){
			if(!$.isNumeric($('#'+currentM).val())){
				alertify.error('Wrong value entered.');
				return false;
			}
		}

		var price = $('#'+currentM).val();
		var property_id = $(this).attr('data-id');
		
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url: "{{ route('admin.addTransaction') }}",
			type: 'POST',
			data: {"property_id": property_id,"currentM":currentM,"price":price},
			beforeSend:function(){
			},
			success:function(data){					
				if(data.status == 1){
					alertify.success('Sucessfully Saved');
				}else{
					alertify.error('Error while saving.');
				}
			}
		});	
	});	
	
	$('body').on('click','.editPropMeta',function(){
		if($(this).hasClass('fa-edit')){
			$(this).removeClass('fa-edit').addClass('fa-save');
			$(this).parent('div').find('.info-txt').hide();
			$(this).parent('div').find('input').show();
		}else{
			var formData = new FormData(document.querySelector('#prop-meta'));
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});			
			
			$.ajax({
				url: "{{ route('admin.updatePropMeta') }}",
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				beforeSend:function(){
				},
				success:function(data){					
					if(data.status == 1){
						$('.editPropMeta').removeClass('fa-save').addClass('fa-edit');
						$('.editPropMeta').parent('div').find('.info-txt').show();
						$('.editPropMeta').parent('div').find('input').hide();
						
						$('.editPropMeta').parent('div').find('.info-txt').eq(0).text('Full name :- '+data.data.fullname);
						$('.editPropMeta').parent('div').find('.info-txt').eq(1).text('Floor :- '+data.data.floor);
						$('.editPropMeta').parent('div').find('.info-txt').eq(2).text('Apartment number  :- '+data.data.apartment_number);
						$('.editPropMeta').parent('div').find('.info-txt').eq(3).html('<a href="" class="link"><i class="fa-light fa-at"></i>'+data.data.email+'</a>');
						$('.editPropMeta').parent('div').find('.info-txt').eq(4).html('<a href="" class="link"><i class="fa-light fa-m"></i>'+data.data.phone+'</a>');
						alertify.success('Sucessfully Saved');
					}else{
						alertify.error('Error while saving.');
					}
				}
			});				
		}
	});
	
	
	$('body').on('click','.deleteDocumentJs',function(){
		var property_id = $(this).attr('id');
		var data_id = $(this).attr('row-id');
		var type = $(this).attr('data');
		alertify.confirm('Are you sure?, you want to delete this document.', function(){
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});	

			$.ajax({
				url: "{{ route('admin.deleteDocument') }}",
				type: 'POST',
				data: {"property_id": property_id,"type":type,"data_id":data_id},
				beforeSend:function(){
				},
				success:function(data){					
					if(data.status == 1){
						window.location.reload();
					}else{
						alertify.error('Error while deleting.');
					}
				}
			});				
		}, function(){ alertify.error('Cancel')}).set({title:"Confirm"});
	});
</script>
@if(count($properties->propertyGallery) > 0)				
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