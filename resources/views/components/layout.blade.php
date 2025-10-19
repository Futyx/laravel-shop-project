<!DOCTYPE html>
<html x-data="{ sidebarOpen: false }" lang="{{ str_replace('_', '-', app()->getLocale()) }}" lang="fa" dir='rtl'>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ $title ?? 'ChizMart' }}</title>
	<link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	@livewireStyles
	@stack('styles')
</head>

<body class=" dark:bg-slate-700">
	@include('layouts.navigation')
	<main>
		{{ $slot }}
	</main>

	@livewireScripts
	@stack('scripts')
</body>

</html>



