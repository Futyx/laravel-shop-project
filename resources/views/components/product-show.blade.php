@props(['product'])

<article class="mb-24 m-auto" itemscope itemtype="https://schema.org/Product">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="m-4">
        <ol class="flex items-center space-x-2 space-x-reverse text-sm" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="{{ url('/') }}" itemprop="item" class="text-blue-600 hover:text-blue-800">
                    <span itemprop="name">خانه</span>
                </a>
                <meta itemprop="position" content="1">
            </li>
            <li class="mx-2">/</li>
            @if($product->category)
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name">{{ $product->category->name }}</span>
                <meta itemprop="position" content="2">
            </li>
            <li class="mx-2">/</li>
            @endif
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name">{{ $product->title }}</span>
                <meta itemprop="position" content="{{ $product->category ? '3' : '2' }}">
            </li>
        </ol>
    </nav>

    <div class="lg:flex gap-4 m-1 px-2">
        <div class="lg:w-1/3 mb-4 lg:mb-0">
            <div class="w-full">
                <img 
                    src="{{ $product->getFirstImageUrl() }}" 
                    alt="{{ $product->title }} - چیزمارت" 
                    title="{{ $product->title }}"
                    itemprop="image"
                    class="w-full rounded-lg object-contain"
                    loading="eager"
                >
            </div>
            @if($product->hasImages() && $product->getMedia('product_images')->count() > 1)
            <div class="flex gap-2 mt-4 overflow-x-auto pb-2" role="list" aria-label="گالری تصاویر محصول">
                @foreach ($product->getMedia('product_images') as $media)
                <img 
                    src="{{ $media->getUrl('thumb') }}" 
                    alt="{{ $product->title }} - تصویر {{ $loop->iteration }}" 
                    title="{{ $product->title }}"
                    class="border-2 border-gray-300 rounded cursor-pointer hover:border-blue-500 transition min-w-[80px] h-20 object-cover"
                    loading="lazy"
                    role="listitem"
                >
                @endforeach
            </div>
            @endif
        </div>
        <div class="lg:w-2/3 flex flex-col lg:flex-row lg:justify-between gap-4">
            <div class="flex-1 mt-4 lg:mt-6 mx-2">
                <h1 class="text-red-600 border-r-4 font-semibold border-red-600 pr-1 text-xl sm:text-2xl mb-4" itemprop="name">{{ $product->title }}</h1>
                <div class="mt-4 text-sm leading-relaxed" itemprop="description">{{ $product->description }}</div>
            </div>
            <div class="bg-gray-100 mt-4 lg:mt-0 border p-4 rounded-lg border-gray-300 w-full lg:w-auto lg:max-w-xs lg:flex-shrink-0" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                <div class="text-left text-xl font-semibold mb-4">
                    <meta itemprop="price" content="{{ $product->price }}">
                    <meta itemprop="priceCurrency" content="IRR">
                    <meta itemprop="availability" content="https://schema.org/InStock">
                    <span>@rial($product->price)</span><span class="mr-2 font-extrabold">تومان</span>
                </div>
                <div class="flex flex-col gap-3">
                    <div>
                        @livewire('counter', ['productId' => $product->id, 'initialQuantity' => 1], key('product-counter-' . $product->id))
                    </div>
                    @livewire('cart.add-to-cart', ['productId' => $product->id], key('product-add-' . $product->id))
                </div>
            </div>
        </div>
    </div>
</article>