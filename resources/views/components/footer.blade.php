<!-- Footer -->
<footer class="bg-gray-800 text-white mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex justify-between items-center">
            <p>© {{ now()->year }} MyApp. All rights reserved.</p>
            <div>
                <a href="{{ url('/privacy') }}" class="hover:underline">Privacy Policy</a>
                <a href="{{ url('/terms') }}" class="ml-4 hover:underline">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
