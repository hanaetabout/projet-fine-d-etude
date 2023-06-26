<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500&display=swap" rel="stylesheet">
        <!-- Scripts
		
		<link rel="stylesheet" href="{{ asset('public/build/assets/app-67dcdfd2.css') }}"> --> 
		@vite(['resources/sass/app.scss', 'resources/js/app.js'])
		<link rel="stylesheet" href="{{ asset('css/custom-style.css') }}"> 
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"> 
		<link rel="stylesheet" href="{{ asset('css/alertify.min.css') }}"/>
		
		<!--<script src="{{ asset('public/build/assets/app-903266c5.js') }}"></script>-->
		<!-- Scripts -->
		
		
		<script src="{{ asset('js/jquery-3.6.3.js') }}"></script>
		
		<script src="https://kit.fontawesome.com/a6ba34a382.js" crossorigin="anonymous"></script>
		
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
		<script src="{{ asset('js/alertify.min.js') }}"></script>
		
		<script src="{{ asset('js/custom-js.js') }}"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                @yield('content')
            </div>
        </div>
    </body>
	<script>
		alertify.defaults.transition = "slide";
		alertify.defaults.theme.ok = "btn btn-sm btn-primary";
		alertify.defaults.theme.cancel = "btn btn-sm btn-danger";
		alertify.defaults.theme.input = "form-control";
	</script>
</html>
