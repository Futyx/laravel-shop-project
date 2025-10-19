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
                <x-product-header  />

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







    <!-- <div>
        <div class="">

            <div class="bg-[rgb(251,252,252)] h-[120px] py-8 px-6 ">
                <div class="absolute p-1 w-32 top-1 left-0 ">
                    <img src="{{ asset('images/logo.png') }}" alt="">

                </div>


                <div class="">
                    <form class="mt-0 mx-auto max-w-xl py-2 px-6 rounded-full bg-gray-200 border flex focus-within:border-gray-400">
                        <input type="text" placeholder="Search anything" class="bg-transparent w-full focus:outline-none pr-4 font-semibold border-0 focus:ring-0 px-0 py-0" name="topic"><button class="flex flex-row items-center justify-center min-w-[130px] rounded-full font-medium tracking-wide border disabled:cursor-not-allowed disabled:opacity-50 transition ease-in-out duration-150 text-base bg-[#F6843E] text-white font-medium tracking-wide border-transparent py-1.5 h-[36px] -mr-3">
                            Search
                        </button>
                    </form>


                </div>

            </div>
            <div class="bg-[#B9CE5B] min-h-[60-px] text-white  flex">

                <div class="flex pt-2 p-2  max-w-[280px] flex-nowrap border ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mt-[2px] mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <div>Browse Categories</div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mt-[8px] ml-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>


                </div>
                <div class="flex px-4 pt-2 justify-between grow-2 w-1/2 ml-28">
                    <div>Store List</div>
                    <div>About Us</div>
                    <div>Contact Us</div>
                    <div>BestSeller</div>
                    <div>Shop</div>
                </div>
            </div>
        </div>
        <div class="mt-8 px-8 flex justify-between">
           
            @foreach ($products as $product)
            <div class="bg-slate-500 w-[3صص20px] h-80 rounded-lg p-2">
                <div class="h-12 bg-white ">image</div>
                <h2>{{ $product->title}}</h1>

            </div>
            @endforeach
        </div>
    </div> -->
</x-app-layout>