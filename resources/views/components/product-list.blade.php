<!-- Product List Section -->
<section aria-labelledby="product-section-heading" class="product-list-section py-6">
    <h1 id="product-section-heading" class="text-2xl font-bold text-red-600 mb-4">{{ $title }}</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="product-card bg-white shadow-md rounded-lg overflow-hidden">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default-product.png') }}"
                     alt="{{ $product->title }}" class="w-full h-[300px] object-cover" loading="lazy">
                <div class="p-4">
                    <h2 class="font-bold text-lg">{{ $product->title }}</h2>
                    <p class="text-yellow-600 font-bold">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="text-gray-600">Total Views: {{ $product->views ?? 0 }}</p>
                    <div class="mt-4 flex justify-between items-center">
                        {{-- <a href="{{ route('product.detail', $product->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition"
                           aria-label="View details of {{ $product->title }}">
                            Lihat Detail
                        </a>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" value="1" min="1" max="10" class="w-16">
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition"
                                    aria-label="Add {{ $product->title }} to cart">
                                Add to Cart
                            </button>
                        </form> --}}
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-600 col-span-full">Tidak ada produk yang tersedia.</p>
        @endforelse
    </div>
</section>
