<!-- Navbar -->
<nav class="bg-gray-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <!-- Logo or Home Link -->
                    <a href="{{ url('/') }}" class="text-white font-bold">MyApp</a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ url('/home') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Home</a>
                        <a href="{{ url('/about') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">About</a>
                        <a href="{{ url('/services') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Services</a>
                        <a href="{{ url('/contact') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Contact</a>
                    </div>
                </div>
            </div>
            <div class="md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    <!-- Authentication Links -->
                    @guest
                        <a href="{{ route('login') }}" class="px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 px-3 py-2 rounded-md text-sm font-medium">Register</a>
                        @endif
                    @else
                        <span>{{ Auth::user()->name }}</span>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</nav>
