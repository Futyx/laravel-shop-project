<x-app-layout>


<div class="mt-2 px-4  lg:flex ">
    <div class="hidden  lg:block w-52 text-[14px] font-semibold text-wrap p-4">
        <div class="border p-4 shadow-sm ">
            <p class="bg-red-200 p-1">فیلتر بر اساس وضعیت موجودی</p>
            <div class="mt-2">
                <div>
                    <input type="checkbox" id="myCheckbox" name="myOption" class="h-3 w-3 bg-gray-100 border-gray-200 border-2">
                    <label for="myCheckbox">فروش ویژه</label>
                </div>
                <div class="mt-2">
                    <input type="checkbox" id="myCheckbox" name="myOption" class="h-3 w-3 bg-gray-100 border-gray-200 border-2">
                    <label for="myCheckbox">موجود در انبار</label>
                </div>
            </div>
        </div>
        <div class="border p-4 shadow-sm mt-6">
            <p class="bg-red-200 p-1">فیلتر بر اساس قیمت</p>


        </div>
    </div>
    <div>
        <div>
            <x-product-header />

        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-[14px]">
            @foreach ($products as $product)


            <x-product-card :product="$product" />

            @endforeach


        </div>
    </div>


</div>


<footer>
    <div class="mt-20 bg-black text-[14px] ">
        <div class="p-4 text-white">
            <p class="text-red-600 font-semibold"> تماس با چیزمارت: 09022593643</p>
            <p class="mt-2">شنبه تا پنج شنبه از ساعت ۹:۰۰ تا ۲۱:۰۰</p>
            <p class="text-center mt-4 font-semibold">از تخفیف های چیزمارت باخبر شوید
            </p>
            <p class="mt-8 font-semibold">چیزمارت در شبکه های اجتماعی
            </p>
            <div></div>
        </div>
    </div>
    <div class="bg-red-100 py-12">
        <div class="w-[380px] m-auto ">
            <img src="{{ asset('images/logo.png') }}" alt="logo">
        </div>
        <div class="p-4  text-[14px] mt-8">
            <p class="hyphens-auto"> <span class="font-semibold">چیزمارت</span>، یک فروشگاه اینترنتی تخصصی در حوزه محصولات<span class="font-semibold">آرایشی و بهداشتی و خوراکی‌های خاص خارجی </span> است که با هدف ایجاد تجربه‌ای متفاوت از خرید آنلاین، فعالیت خود را آغاز کرده است. ما در چیزمارت تلاش کرده‌ایم مجموعه‌ای متنوع و
                به‌روز از برندهای معتبر داخلی و خارجی را گردآوری کنیم تا مشتریان بتوانند با اطمینان خاطر، محصولات مورد نیاز خود را انتخاب و تهیه کنند. یک خرید اینترنتی مطمئن،
                نیازمند فروشگاهی است که بتواند کالاهایی متنوع، باکیفیت و دارای قیمت مناسب را در مدت زمانی کوتاه به دست مشتریان خود برساند و ضمانت بازگشت کالا هم داشته باشد؛
                ویژگی‌هایی که فروشگاه اینترنتی چیز مارکت سال‌هاست بر روی آن‌ها کار کرده و توانسته از این طریق مشتریان ثابت خود را داشته باشد. همگی با وسواس در انتخاب و تضمین اصالت، در اختیار شما قرار گرفته‌اند.</p>
        </div>

    </div>
    <div class="p-4 bg-red-200 text-[12px] text-center">
        <p>فروشگاه چیزمارت | کلیه حقوق مادی و معنوی محفوظ است.</p>
    </div>
</footer>

</x-app-layout>
