@props(['product'])

<article class="p-2 border rounded shadow-md flex flex-col h-full" itemscope itemtype="https://schema.org/Product">
   
    <a href="{{ route('product.show', $product) }}" itemprop="url">
        <img 
            src="{{ $product->getFirstMediaUrl('product_images') }}" 
            alt="{{ $product->title }} - چیزمارت" 
            title="{{ $product->title }}"
            itemprop="image"
            class="w-full h-36 object-contain image-cover m-1 mb-2 rounded-t"
            loading="lazy"
        >

        <div class="min-h-[2rem] mb-1">
            <h3 class="font-semibold text-gray-800 line-clamp-2" itemprop="name">{{ $product->title }}</h3>
        </div>

        <div class="text-[14px] font-bold text-red-600 mb-2 gap-1 flex" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
            <meta itemprop="price" content="{{ $product->price }}">
            <meta itemprop="priceCurrency" content="IRR">
            <span>@rial($product->price)</span><span>تومان</span>
        </div>
    </a>
    @livewire('cart.add-to-cart', ['productId' => $product->id])

</article>