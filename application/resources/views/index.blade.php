@extends('layouts.guest')

@section('content')

<!--HEADER HEADER HEADER-->
<header>
<div class="container">
<nav class="navbar navbar-expand-lg">
  
    <a class="navbar-brand" href="#"><img src="{{asset('images/header-logo.png')}}"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      
        
        <button class="btn" type="submit">Work with us <i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
		<a class="nav-link" href="#" style="color:#fff;">PT</a>
        <button class="btn-en" type="submit">EN</button>

    </div>
  
</nav>
</div>
</header>

<!--BANNER BANNER BANNER-->
<section class="banner-sec">
<div class="container">
<div class="banner-content">
<h1>Rambla is the first and only<br> property management <br>
that’s pays you – The owner</h1>
<p>The leading property management<br> agency for foreign landlords.</p>
<a class="btn" href="#" role="button">Learn More <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
</div>
</div>
</section>
  <!-- SERVICE SERVICE SERVICE -->
  <section class="service">
  <div class="container text-left my-3">
      <div class="row  mx-auto my-auto justify-content-center">
	   <div class="col-lg-4 col-md-6 col-12">
	   </div>
	   <div class="col-lg-4 col-md-6 col-12">
	   </div>
	   <div class="col-lg-4 col-md-6 col-12">
	   </div>
	  </div>
	  </div>
	  </section>
  <!-- ABOUT ABOUT ABOUT -->
<section class="about">
<h2>Who we are</h2>
<div class="about-main">
<div class="container text-left">
      <div class="row align-items-center">
        <div class="col-md-5 col-12 left-text">
<img src="{{asset('images/about-img.jpg')}}">
</div>
   <div class="col-md-7 col-12 py-0 right-text ">
<h2>You’re in good hands</h2>
<p>Torquatos nostros? quos dolores eos, qui dolorem ipsum per se texit, ne ferae quidem se repellere, idque instituit docere sic: omne animal, simul atque integre iudicante itaque aiunt hanc quasi involuta aperiri, altera occulta quaedam et voluptatem accusantium doloremque.</p>
<a class="btn1" href="#" role="button">Learn More <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
</div>
</div>
</div>
</div>
</section>
@endsection