<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title')</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body>
    <div x-data="{ mobileMenuOpen: false }">
        <!-- Navbar -->
        <nav class="bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo and Links -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0 text-white">
                            E-Koran
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 mt-4 flex items-baseline space-x-4">
                                <a href="{{ url('/home') }}" class="{{ Request::is('/home') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">Home</a>
                                <a href="{{ route('cart.index') }}" class="{{ Request::routeIs('cart.index') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">Keranjang</a>
                                <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Library</a>
                                <a href="{{ route('user.langganan') }}" class="{{ Request::routeIs('user.langganan') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">Langganan</a>
                                <!-- Form pencarian -->
                                <form method="GET" action="{{ route('home') }}" class="flex items-center gap-0 mb-4">
                                    <input
                                        type="text"
                                        name="search"
                                        value="{{ request()->query('search') }}"
                                        placeholder="Cari produk..."
                                        class="border border-gray-300 p-2 rounded-l-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-600"
                                    />
                                    <button
                                        type="submit"
                                        class="bg-blue-600 text-white p-2 rounded-r-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600"
                                    >
                                        Cari
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>

                    <!-- User Profile -->
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                        @if (Route::has('login'))
                            @auth
                            <button class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                <span class="sr-only">View notifications</span>
                                <!-- Heroicon name: outline/bell -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </button>
                            <!-- Profile dropdown -->
                            <div x-data="{show: false}" x-on:click.away="show = false" class="ml-3 relative">
                                <div>
                                    <button x-on:click="show = !show" type="button" class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="sr-only">Open user menu</span>
                                        <img class="h-8 w-8 rounded-full" src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('storage/profile_pictures/profile_pictures.png') }}" alt="">
                                    </button>
                                </div>
                                <div x-show="show" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                    <a href="{{ url('/profile') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>

                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>

                                    <a href="{{ url('logout') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
                                </div>
                            </div>
                            @else
                            <a href="{{ route('login') }}" class="font-semibold text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                            @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                            @endif
                            @endauth
                            @endif
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="-mr-2 flex md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                            <span class="sr-only">Open main menu</span>
                            <!-- Icons -->
                            <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg x-show="mobileMenuOpen" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" class="md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-2 sm:px-3 flex flex-col">
                    <a href="{{ url('/home') }}" class="{{ Request::is('/home') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">Home</a>
                    <a href="{{ route('cart.index') }}" class="{{ Request::routeIs('cart.index') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">Keranjang</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Library</a>
                    <a href="{{ route('user.langganan') }}" class="{{ Request::routeIs('user.langganan') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">Langganan</a>
                    <!-- Form pencarian -->
                    <form method="GET" action="{{ route('home') }}" class="flex items-center gap-0 mb-4">
                    <input
                        type="text"
                        name="search"
                        value="{{ request()->query('search') }}"
                        placeholder="Cari produk..."
                        class="border border-gray-300 p-2 rounded-l-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-600"
                    />
                    <button
                        type="submit"
                        class="bg-blue-600 text-white p-2 rounded-r-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600"
                        >
                        Cari
                    </button>
                    </form>
                </div>
                <div class="px-2 pt-2 pb-3 space-y-2 sm:px-3 flex flex-col border-t border-gray-700">
                            @if (Route::has('login'))
                            @auth
                            <button class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                <span class="sr-only">View notifications</span>
                                <!-- Heroicon name: outline/bell -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </button>
                            <!-- Profile dropdown -->
                            <div x-data="{show: false}" x-on:click.away="show = false" class="ml-3 relative">
                                <div>
                                    <button x-on:click="show = !show" type="button" class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="sr-only">Open user menu</span>
                                        <img class="h-8 w-8 rounded-full" src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('storage/profile_pictures/profile_pictures.png') }}" alt="">
                                    </button>
                                </div>
                                <div x-show="show" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                    <a href="{{ url('/profile') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>

                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>

                                    <a href="{{ url('logout') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
                                </div>
                            </div>
                            @else
                            <a href="{{ route('login') }}" class="font-semibold text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                            @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                            @endif
                            @endauth
                            @endif
                </div>
            </div>
        </nav>


        <!-- Main Content -->
        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <div>@yield('contents')</div>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-200 dark:bg-gray-900">
        <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
            <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0">
                <a href="https://flowbite.com/" class="flex items-center">
                    <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 me-3" alt="FlowBite Logo" />
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Flowbite</span>
                </a>
            </div>
            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-2">
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Metode Pembarayan</h2>
                    <div class="grid grid-cols-3 gap-5 p-2 bg-gray-100 max-w-sm mx-auto rounded-lg">
                        <!-- Kolom Gambar 1 -->
                        <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded-lg overflow-hidden">
                            <img src="https://minang.geoparkrun.com/wp-content/uploads/2022/11/bca-logo.png" alt="Image 1" class="w-full h-full object-cover">
                        </div>
                        <!-- Kolom Gambar 2 -->
                        <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded-lg overflow-hidden">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRUA2kqUQIf_RTz3evvjkgAjnKC_piTxR0RUg&s" alt="Image 2" class="w-full h-full object-cover">
                        </div>
                        <!-- Kolom Gambar 3 -->
                        <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded-lg overflow-hidden">
                            <img src="https://cdn3.iconfinder.com/data/icons/banks-in-indonesia-logo-badge/100/BNI-512.png" alt="Image 3" class="w-full h-full object-cover">
                        </div>
                        <!-- Kolom Gambar 4 -->
                        <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded-lg overflow-hidden">
                            <img src="https://cdn.freebiesupply.com/logos/thumbs/2x/bank-mandiri-logo.png" alt="Image 4" class="w-full h-full object-cover">
                        </div>
                        <!-- Kolom Gambar 5 -->
                        <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded-lg overflow-hidden">
                            <img src="https://i.pinimg.com/originals/f5/8c/a3/f58ca3528b238877e9855fcac1daa328.jpg" alt="Image 5" class="w-full h-full object-cover">
                        </div>
                        <!-- Kolom Gambar 6 -->
                        <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded-lg overflow-hidden">
                            <img src="https://i.pinimg.com/originals/94/3c/97/943c971903518e53ffd324dd51e46a90.png" alt="Image 6" class="w-full h-full object-cover">
                        </div>
                        <!-- Kolom Gambar 7 -->
                        <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded-lg overflow-hidden">
                            <img src="https://bucket.utua.com.br/img/2021/05/27718b01-design-sem-nome-442x332.png" alt="Image 7" class="w-full h-full object-cover">
                        </div>
                        <!-- Kolom Gambar 8 -->
                        <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded-lg overflow-hidden">
                            <img src="https://vectorez.biz.id/wp-content/uploads/2023/12/Logo-Link-Aja-1.png" alt="Image 8" class="w-full h-full object-cover">
                        </div>
                        <!-- Kolom Gambar 9 -->
                        <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded-lg overflow-hidden">
                            <img src="https://logowik.com/content/uploads/images/580_visa.jpg" alt="Image 9" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Contact</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li class="mb-4">
                            <a href="#" class="hover:underline">Hubungi Kami</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline">Faq</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-black-500 sm:text-center dark:text-gray-400">© 2024 <a href="https://bangsaonline.com/" class="hover:underline">E-Koran BangsaOnline</a>. All Rights Reserved.
            </span>
            <div class="flex mt-4 sm:justify-center sm:mt-0">
                <a href="https://www.facebook.com/bangsaonline/?locale=id_ID" class="text-gray-500 hover:text-gray-900 dark:hover:text-white mr-3">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
                            <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
                        </svg>
                    <span class="sr-only">Facebook page</span>
                </a>
                <a href="https://x.com/bangsaonline?lang=en" class="text-gray-500 hover:text-gray-900 dark:hover:text-white mr-3">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 17">
                        <path fill-rule="evenodd" d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z" clip-rule="evenodd"/>
                    </svg>
                    <span class="sr-only">Twitter page</span>
                </a>
                <a href="https://www.tiktok.com/@bangsaonline?lang=en" class="text-gray-500 hover:text-gray-900 dark:hover:text-white mr-3">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 448 512">
                            <path fill-rule="evenodd" d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="sr-only">Tiktok</span>
                </a>
                <a href="https://www.youtube.com/@BANGSAONLINETV" class="text-gray-500 hover:text-gray-900 dark:hover:text-white mr-3">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 576 512">
                        <path fill-rule="evenodd" d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z" clip-rule="evenodd"/>
                    </svg>
                    <span class="sr-only">You Tube</span>
                </a>
            </div>
        </div>
        </div>
    </footer>

</body>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

</html>
