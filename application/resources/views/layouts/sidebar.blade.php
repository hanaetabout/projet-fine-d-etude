<div class="cstm-row toggle-menu">
	<img class="dash" src="{{asset('images/dash.png')}}">
	<a href="#" class="sidebar-logo"><img src="{{asset('images/black-logo.png')}}"></a>
	<i class="fa-solid fa-magnifying-glass"></i>
</div>
<div class="sidebar">

	<div class="side-logo-div text-center">

		<a href="{{(Auth::user()->role_id == 1)?route('admin.dashboard'): route('user.dashboard')}}" class="sidebar-logo"><img src="{{asset('images/black-logo.png')}}"></a>
	
	</div>
	<div id="partner-table_filter" class="dataTables_filter side-search">
		<label><input type="search" class="search" placeholder="Search property/owner " aria-controls="partner-table"></label>
	</div>
	<ul class="side-menu">
		<li class="{{ Route::currentRouteName()=='admin.dashboard' || Route::currentRouteName()=='user.dashboard' || Route::currentRouteName()=='admin.propertyDetail' || Route::currentRouteName()=='user.propertyDetail' ? 'active' : '' }}">
		
			<a href="{{(Auth::user()->role_id == 1)?route('admin.dashboard'): route('user.dashboard')}}" class="dashboard "><img src="{{asset('images/dash.png')}}">
			Dashboard </a>
			
		</li>
		
		@if(Auth::user()->role_id == 1)
		<li class="{{ Route::currentRouteName()=='admin.clients'? 'active' : '' }}">
			<a href="{{route('admin.clients')}}" class="dashboard "><i class="fa-solid fa-users"></i>Clients </a>
		</li>
		
		<li class="{{ Route::currentRouteName()=='admin.users' || Route::currentRouteName()=='admin.addUser' ? 'active' : '' }}">
			<a href="{{route('admin.users')}}" class="dashboard "><i class="fa-solid fa-user"></i>
			Users </a>
		</li>
		@endif
	  
		<li class="{{ Route::currentRouteName()=='admin.settings' || Route::currentRouteName()=='user.settings' ? 'active' : '' }}">
			<a href="{{(Auth::user()->role_id == 1) ? route('admin.settings'): route('user.settings')}}" class="dashboard"><i class="fa-solid fa-gear"></i>Settings</a>
		</li>
		
		<li class="logout">
			<img src="{{asset('images/'.Auth::user()->avatar)}}">{{Auth::user()->name}} <i class="fa-solid fa-right-from-bracket" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" src="{{asset('images/Logout.png')}}"></i>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				 {{ csrf_field() }}
			</form>
		</li>
	</ul>
</div>