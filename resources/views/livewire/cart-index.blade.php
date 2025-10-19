<div>

    @if($items->isEmpty())

    <div class="p-4 border rounded text-gray-600">سبد شما خالی است.</div>

    @else

    <div class="space-y-3">

        @foreach($items as $row)

        <div class="flex items-center gap-4 p-2 w-full   border-b-2 border-gray-200">

            <div><img src="{{ $row['product']?->getThumbnailUrl() }}" class="w-16 h-16 object-cover flex-2 " alt="{{ $row['product']?->title }}"></div>

            <div class=" w-full flex-1">

                <h2 class="mv-2">{{ $row['product']?->title }}</h2>

                <div class="flex justify-between border-b font-thin "><span>قیمت</span><span>@rial($row['price'])<span class="text-xs mr-1 font-semibold">تومان</span></span></div>

                <div class="flex justify-between border-b mt-4 pb-2 font-thin"><span>تعداد</span>

                    <div>@livewire('counter', ['productId' => $row['product_id'], 'initialQuantity' => $row['quantity']], key($row['product_id']))</div>

                </div>

                <div class="flex justify-between mt-4 font-thin"><span>جمع جزء</span><span>@rial($row['subtotal']) <span class="text-xs  font-semibold">تومان</span></span></div>



            </div>



        </div>

        @endforeach

    </div>



    <div class="mt-4 p-4 border rounded flex justify-between items-center bg-gray-50">

        <div class="text-gray-700">مبلغ کل</div>

        <div class="text-lg font-bold text-red-600">@rial($total) <span class="text-xs">تومان</span></div>

    </div>

    @endif

</div>