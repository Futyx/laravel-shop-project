<!DOCTYPE html>
<html x-data="{ sidebarOpen: false }" lang="fa" dir='rtl' itemscope itemtype="https://schema.org/WebSite">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	@if(isset($seo))
		{!! $seo->generateMetaTags() !!}
	@else
		<title>{{ $title ?? 'ChizMart' }}</title>
		<meta name="description" content="فروشگاه اینترنتی چیزمارت - خرید آنلاین محصولات آرایشی و بهداشتی و خوراکی‌های خاص خارجی">
		<meta name="keywords" content="فروشگاه اینترنتی, خرید آنلاین, محصولات آرایشی, محصولات بهداشتی, چیزمارت">
		<link rel="canonical" href="{{ url()->current() }}">
	@endif
	
	@if(isset($structuredData))
		{!! $structuredData !!}
	@endif
	
	<link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
	<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
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



