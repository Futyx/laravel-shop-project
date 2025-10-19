@props(['product'])


<div class=" mb-24  m-auto">

    <div class="bg-blue-400">خانه/{{ $product->category->name }}</div>
    <div class="lg:flex  bg-red-300 m-1 ">
        <div class="lg:flex  bg-red-500 lg:w-1/3">
            <div>
                <img src="{{ $product->getFirstImageUrl() }}" alt="{{ $product->title }}" class="w-full">
            </div>
            <div class="h-24 bg-gray-600">
            عکس ها
                @foreach ($product->getMedia('images') as $media)
                <img src="{{ $media->getUrl() }}" alt="{{ $product->title }}" class="border-2">
                @endforeach
            </div>
        </div>
        <div class="md:flex md:justify-between   ">
            <div class="mt-6 mx-2 ">
                <div class="text-red-600 border-r-4 font-seminbold border-red-600 pr-1">{{ $product->title }}</div>
                <div class="mt-4  text-sm">{{ $product->description }}</div>
            </div>
            <div class="bg-gray-100 mt-4 lg:mr-auto border p-4 rounded-lg border-gray-300 md:w-1/2 md:mx-2 lg:max-w-44 ">
                <div class="text-left text-xl font-semibold">
                    <span>@rial($product->price)</span><span class="mr-2 font-extrabold">تومان</span>

                </div>
                <div class="flex gap-3 my-4 items-center lg:block">
                    <div>
                        @livewire('counter')
                    </div>
                    <button class="bg-blue-700 lg:mt-2  md:text-[14px] items-center text-white py-2 w-full rounded-md text-[16px] font-semibold">افزودن به سبد خرید</button>

                </div>
            </div>
        </div>
    </div>