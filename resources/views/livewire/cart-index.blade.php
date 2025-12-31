<div class="cart-wrapper">

    @if($items->isEmpty())

    <div class="p-4 border rounded text-gray-600">سبد شما خالی است.</div>

    @else

    <div class="space-y-3">

        @foreach($items as $item)

        <div class="flex items-center gap-4 p-2 w-full   border-b-2 border-red-200">

            <div>
                <img class="w-16 h-16 object-cover flex-2" src="{{ $item['image_url']}}" alt="{{ $item['product']?->title }}">
            </div>

            <div class=" w-full flex-1">
                <div class="flex justify-between">
                    <h2 class="mv-2 font-semibold">{{ $item['product']?->title }}</h2>

                    <button
                        wire:click="remove({{ $item['product_id'] }})"
                        class="text-red-500 hover:text-red-700 text-sm p-1">
                        حذف
                    </button>

                </div>



                <div class="flex justify-between border-b font-thin "><span>قیمت</span><span>@rial($item['price'])<span class="text-xs mr-1 font-semibold">تومان</span></span></div>


                <div class="flex justify-between border-b mt-4 pb-2 font-thin"><span>تعداد</span>

                    <div>@livewire('counter', ['productId' => $item['product_id'], 'initialQuantity' => $item['quantity']], key($item['product_id']))</div>

                </div>

                <div class="flex justify-between mt-4 font-thin"><span>جمع جزء</span><span>@rial($item['subtotal']) <span class="text-xs  font-semibold">تومان</span></span></div>


            </div>



        </div>

        @endforeach

    </div>
    <div class="mt-10  items-center mx-auto border-dashed border-2 rounded-md p-4">
        <input class="w-full text-[14px] rounded-md border-2 border-gray-200 px-2 py-1" type="text" placeholder="کد تخفیف">
        <div><button class="w-full mt-2 bg-blue-600 text-[14px]  font-semibold text-white py-2 rounded hover:bg-blue-700 transition duration-150">اعمال تخفیف</button></div>
    </div>


    <div class=" border-2 font-bold border-gray-200 p-4 rounded-md mt-6">
        <div>مجموع کل سبد خرید</div>
        <div class="text-[14px] flex justify-between border-b py-2">
            <span>جمع جزء</span>
            <span class="text-[18px] font-bold">@rial($total)<span class="  mr-2">تومان</span></span>
        </div>
        <div class="flex text-[14px] gap-8 py-2 border-b ">
            <span>ارسال</span>
            <span class="text-xs text-red-600 ">@rial(1200000)<span class="  mr-2">تومان</span></span>
        </div>
        <div class="flex justify-between py-2">
            <span>مجموع</span>
            <span class="text-red-600 ">@rial($total+120000)<span class="  mr-2">تومان</span></span>
        </div>

        <div class="w-full mt-2 bg-blue-600 text-sm  font-semibold text-white py-2 rounded hover:bg-blue-700 transition duration-150">
            <form action="{{ route('order.store') }}" method="POST">
                @csrf
                <button type="submit" class="  w-full  transition duration-300">
                    پرداخت
                </button>
            </form>
        </div>

    </div>

    <!-- <div class="mt-4 p-4 border rounded flex justify-between items-center bg-gray-50">

        <div class="text-gray-700">مبلغ کل</div>

        <div class="text-lg font-bold text-red-600">@rial($total) <span class="text-xs">تومان</span></div>

    </div> -->

    @endif


</div>