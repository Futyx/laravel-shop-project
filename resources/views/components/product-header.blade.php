{{-- If a page provides a $product, render a simple header with gallery --}}
@if(isset($product))
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
	<x-product-gallery :product="$product" />
	<div class="space-y-3">
		<h1 class="text-2xl font-bold text-gray-800">{{ $product->title }}</h1>
		<p class="text-red-600 font-semibold">{{ $product->price }} <span class="text-sm">تومان</span></p>
		<p class="text-gray-600">{{ $product->description }}</p>
	</div>
</div>
@endif