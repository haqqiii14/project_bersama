<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.0.0/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body class="bg-gray-100">

    <!-- Header -->
    <header class="bg-gray-900 text-gray-200 shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <!-- Logo -->
                <span class="text-xl font-bold text-blue-500">Admin Panel</span>
                <!-- Search Bar -->
                <div class="relative hidden md:block">
                    <input type="text" placeholder="Search..." class="pl-10 py-2 bg-gray-800 text-gray-300 rounded-full focus:outline-none focus:bg-gray-700 w-64">
                    <svg class="absolute top-2.5 left-3 w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M21 21l-4.35-4.35"></path></svg>
                </div>
            </div>

            <!-- Icons and Dropdown -->
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <a href="{{ route('admin/notifications') }}" class="relative focus:outline-none hover:text-gray-300">
                    <button>
                        <i class="bi bi-bell-fill text-lg"></i>
                        <span class="absolute -top-1 -right-2 px-1.5 py-0.5 bg-red-600 text-white text-xs rounded-full">3</span>
                    </button>
                </a>

                <!-- Profile Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center focus:outline-none">
                        <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('storage/profile_pictures/profile_pictures.png') }}" alt="Profile" class="h-8 w-8 rounded-full mr-2">
                        <span class="text-sm hidden md:block">Admin</span>
                        <i class="bi bi-chevron-down ml-2"></i>
                    </button>
                    <!-- Dropdown Items -->
                    <div x-show="open" @click.away="open = false" class="absolute right-0 w-48 bg-white text-gray-700 mt-2 rounded-lg shadow-lg">
                        <a href="#" class="block px-4 py-2 hover:bg-gray-200">My Profile</a>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-200">Settings</a>
                        <a href="{{ route('logout') }}" class="block px-4 py-2 hover:bg-gray-200">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Layout -->
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-gray-200 min-h-screen">
            <div class="p-4 font-bold text-center text-blue-400">Admin Dashboard</div>
            <nav class="mt-5">
                <a href="{{ route('admin/AdminHome') }}" class="block py-3 px-4 hover:bg-gray-700 hover:text-blue-500">
                    <i class="bi bi-speedometer2 mr-2"></i>Dashboard
                </a>
                <a href="{{ route('admin.koran') }}" class="block py-3 px-4 hover:bg-gray-700 hover:text-blue-500">
                    <i class="bi bi-newspaper mr-2"></i>Koran
                </a>
                <a href="{{ route('admin/products') }}" class="block py-3 px-4 hover:bg-gray-700 hover:text-blue-500">
                    <i class="bi bi-bell-fill mr-2"></i>Langganan
                </a>
                <a href="{{ route('admin.subscriptions.index') }}" class="block py-3 px-4 hover:bg-gray-700 hover:text-blue-500">
                    <i class="bi bi-bell-fill mr-2"></i>Pembayaran Langganan
                </a>
                <a href="{{ route('admin.subscriptions.history') }}" class="block py-3 px-4 hover:bg-gray-700 hover:text-blue-500">
                    <i class="bi bi-bell-fill mr-2"></i>History Transaksi
                </a>
                <a href="{{ route('admin/profile') }}" class="block py-3 px-4 hover:bg-gray-700 hover:text-blue-500">
                    <i class="bi bi-person-circle mr-2"></i>Profile
                </a>
                <a href="{{ route('logout') }}" class="block py-3 px-4 mt-6 border-t border-gray-700 hover:bg-gray-700 hover:text-blue-500">
                    <i class="bi bi-box-arrow-in-right mr-2"></i>Logout
                </a>
            </nav>
        </aside>

        <!-- Content Area -->
        <main class="flex-1 p-6 bg-gray-50">
            <div class="container mx-auto">
                @yield('contents')
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-center py-4 text-gray-500">
        <p>&copy; 2024 E-koran BangsaOnline | All rights reserved.</p>
    </footer>

</body>
</html>
