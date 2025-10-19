<x-layout>
<div class="max-w-6xl mx-auto p-4">
	<h1 class="text-xl font-bold mb-4">سبد انتظار پرداخت</h1>

	@if($items->isEmpty())
		<div class="p-4 border rounded text-gray-600">سبد شما خالی است.</div>
	@else
		<div class="space-y-3">
			@foreach($items as $row)
				<div class="flex items-center gap-4 p-3 border rounded">
					<img src="{{ $row['product']?->getThumbnailUrl() }}" class="w-16 h-16 object-contain" alt="{{ $row['product']?->title }}">
					<div class="flex-1 min-w-0">
						<div class="font-medium truncate">{{ $row['product']?->title }}</div>
						<div class="text-sm text-gray-500">تعداد: @rial($row['quantity'])</div>
					</div>
					<div class="text-red-600 font-semibold">@rial($row['subtotal']) <span class="text-xs">تومان</span></div>
				</div>
			@endforeach
		</div>
		<div class="mt-4 p-4 border rounded flex justify-between items-center bg-gray-50">
			<div class="text-gray-700">مبلغ کل</div>
			<div class="text-lg font-bold text-red-600">@rial($total) <span class="text-xs">تومان</span></div>
		</div>
	@endif
 </div>
</x-layout>


