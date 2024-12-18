<div class="carousel-container relative overflow-hidden w-full max-w-7xl mx-auto bg-gray-200 my-10 rounded-lg">
    <!-- Images -->
    <div class="carousel-images">
        @foreach($images as $index => $image)
            <img src="{{ $image }}" alt="Image {{ $index + 1 }}"
                 class="carousel-image w-full h-[300px] object-cover {{ $loop->first ? 'active' : 'hidden' }}">
        @endforeach
    </div>
    <!-- Navigation Dots -->
    <div class="carousel-dots absolute bottom-2 left-1/2 transform -translate-x-1/2 flex space-x-2">
        @foreach($images as $index => $image)
            <div class="dot w-3 h-3 bg-gray-400 rounded-full cursor-pointer {{ $loop->first ? 'bg-blue-600' : '' }}"
                 data-index="{{ $index }}"></div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('.carousel-image');
    const dots = document.querySelectorAll('.dot');
    let currentIndex = 0;

    function showImage(index) {
        images.forEach((img, i) => {
            img.classList.toggle('hidden', i !== index);
        });
        dots.forEach((dot, i) => {
            dot.classList.toggle('bg-blue-600', i === index);
            dot.classList.toggle('bg-gray-400', i !== index);
        });
    }

    dots.forEach(dot => {
        dot.addEventListener('click', (e) => {
            currentIndex = parseInt(e.target.dataset.index);
            showImage(currentIndex);
        });
    });

    function startCarousel() {
        return setInterval(() => {
            currentIndex = (currentIndex + 1) % images.length;
            showImage(currentIndex);
        }, 3000);
    }

    let interval = startCarousel();

    const carouselContainer = document.querySelector('.carousel-container');
    carouselContainer.addEventListener('mouseover', () => clearInterval(interval));
    carouselContainer.addEventListener('mouseleave', () => interval = startCarousel());
});
</script>
@endpush
