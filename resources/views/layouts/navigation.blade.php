<div x-data="{ sidebarOpen: false }">

    <nav>
        <div>
            <div class="text-[10px] lg:text-[12px] bg-[rgb(224,224,224)]  flex items-center justify-center gap-x-4 lg:items-start lg:justify-start lg:pr-2  border-b border-gray-300 py-1">
                <a href="/guest" class="hidden  lg:block md:block ">صفحه اصلی</a>
                <a href="/terms-and-conditions" class=" md:pr-2 md:border-r md:border-gray-400 ">قوانین و شرایط سایت</a>
                <a href="#" class="pr-2 border-r border-gray-400"> سوالات متداول</a>
                <a href="#" class="pr-2 border-r border-gray-400">تماس با ما</a>
            </div>
        </div>
        <div class="bg-[rgb(224,224,224)] w-full h-12 py-2 px-4 flex justify-between items-center lg:h-20">
            <div class="lg:hidden">
                <button
                    @click="sidebarOpen = true"
                    class="lg:hidden flex  py-1 px-4 bg-red-600  rounded-3xl text-white ">
                    &#9776;
                    <div class="mr-1 pt-1 text-xs font-semibold">منو</div>
                </button>
                <x-side-bar />

            </div>
            <div>
                <a href="/guest">
                    <img class="w-36 lg:w-[320px]  " src="{{ asset( 'images/logo.png')}}" alt="لوگوی سایت">
                </a>
            </div>
            <div class="hidden lg:block -mr-32 lg:w-1/3">
                @livewire(name: 'search.navbar-search')
            </div>
            <div>
                <a>
                    <div class="bg-white rounded-full w-9 h-9   border-[3px] border-red-600 p-1 lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>

                    </div>
                </a>



                <div class="hidden items-center  lg:flex lg:gap-4">

                    <div class="rounded-full flex items-center p-2 gap-1 border border-gray-300"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <p class="text-[13px]">ورود / ثبت نام</p>
                    </div>
                    <div class="px-2 border-r border-gray-300">
                        @livewire('cart.cart-badge')
                    </div>

                </div>
            </div>

        </div>
        <div class=" flex h-[50px] justify-between px-4 w-full gap-x-8 items-center lg:hidden border-b">
            <div class="flex-grow max-w-3xl mx-auto   ">
                @livewire('search.navbar-search')
            </div>

            <div class="bg-red-600 rounded-full h-9 w-9 flex-shrink-0 flex items-center justify-center text-white">
                @livewire('cart.cart-badge')
            </div>
        </div>

        <div class="h-[50px] justify-between border-b px-4 w-full gap-x-8 items-center hidden lg:flex">


            <x-navigation.category-dropdown />
            <div class="flex gap-1 mt-1 ">

                <a href="#" class="bg-blue-200 text-blue-500 h-[38px] text-[14px] px-2 text-center flex items-center justify-center">
                    رهگیری مرسولات
                </a>

                <a href="#" class="bg-red-200 text-red-500 h-[38px] text-[14px] px-2 flex items-center justify-center">
                    فروش ویژه
                </a>

            </div>
        </div>


    </nav>
</div>