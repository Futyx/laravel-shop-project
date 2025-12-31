@props(['products'])

<div class="relative ">
  <div class="carousel max-w-full flex overflow-x-scroll snap-x snap-mandatory scrollbar-hide pb-4 mt-10">
    <!-- Carousel items -->
    @foreach ($products as $product)
    <div class=" carousel-item flex-shrink-0 w-full snap-start">
      <img src="{{ $product->getFirstMediaUrl('product_images') }}" alt="{{ $product->title }}" class="w-full h-[400px] object-contain image-cover m-1 mb-2 rounded-t ">
    </div>
    @endforeach


    <!-- Carousel controls -->
    <div class="absolute inset-y-0 left-0 flex items-center justify-start pl-4">
      <button
        class="carousel-control-prev bg-gray-800 hover:bg-gray-700 text-white rounded-full p-2 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
      </button>
    </div>
    <div class="absolute inset-y-0 right-0 flex items-center justify-end pr-4">
      <button
        class="carousel-control-next bg-gray-800 hover:bg-gray-700 text-white rounded-full p-2 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
      </button>
    </div>
  </div>
  


  <script>
    const carousel = document.querySelector('.carousel');
    const prevButton = document.querySelector('.carousel-control-prev');
    const nextButton = document.querySelector('.carousel-control-next');
    const itemsPerSlide = 2;

    prevButton.addEventListener('click', () => {
      const scrollAmount = carousel.offsetWidth / itemsPerSlide;
      carousel.scrollBy({
        left: -scrollAmount * itemsPerSlide, 
        behavior: 'smooth'
      });
    });

    nextButton.addEventListener('click', () => {
      const scrollAmount = carousel.offsetWidth / itemsPerSlide;
      carousel.scrollBy({
        left: scrollAmount * itemsPerSlide, 
        behavior: 'smooth'
      });
    });
  </script>

  <!-- End Slider -->