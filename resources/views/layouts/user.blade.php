<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>@yield('title', 'Jawa Pos Digital Edition')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper@9/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/new.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</head>

<body class="bg-gray-100">

    <!-- Mobile Header -->
    <div class="md:hidden custom-color text-white py-4 px-4 sticky top-0 z-10">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('homepage') }}" class="flex items-center">
                <img src="https://bangsaonline.com/img/logo.png?rand=140" alt="BangsaOnline Logo" class="h-8 w-auto">
            </a>
            <div class="mt-2 flex items-center space-x-2">
                <input type="text" placeholder="Search..." class="w-full p-2 rounded text-gray-700">
                <a href="#" class="text-gray-700 block">
                    <i class="fas fa-search"></i> <!-- Font Awesome Search Icon -->
                </a>
            </div>

        </div>
    </div>

    <!-- Desktop Header -->
    <div class="desktop-header color-band-top max-w-screen-xl mx-auto flex justify-between items-center py-4 px-6">
        <div href="{{ route('homepage') }}" class="logo">
            <a href="#">
                <img href="{{ route('homepage') }}" src="https://bangsaonline.com/img/logo.png?rand=140" alt="BangsaOnline Logo">
            </a>
        </div>
        <button type="button" class="button-outline">
            <div id="current-time" class="text-lg font-medium"></div>
        </button>
        <!-- Social Profile Icons -->
        <div class="social-profile">
            <ul class="social-share-two">
                <li><a target="_blank" href="https://www.facebook.com/bangsaonline">
                        <ion-icon name="logo-facebook"></ion-icon>
                    </a></li>
                <li><a target="_blank" href="https://www.tiktok.com/@bangsaonline">
                        <ion-icon name="logo-tiktok"></ion-icon>
                    </a></li>
                <li><a target="_blank" href="https://twitter.com/bangsaonline">
                        <ion-icon name="logo-twitter"></ion-icon>
                    </a></li>
                <li><a target="_blank" href="https://instagram.com/bangsaonline">
                        <ion-icon name="logo-instagram"></ion-icon>
                    </a></li>
                <li><a target="_blank" href="https://bangsaonline.com/feed/">
                        <ion-icon name="logo-rss"></ion-icon>
                    </a></li>
                <li><a target="_blank" href="https://bangsaonline.com/live">
                        <ion-icon name="tv-outline"></ion-icon>
                    </a></li>
            </ul>
        </div>
    </div>
    <div class="hidden md:block custom-color text-white sticky top-0 z-10">
        <div class="max-w-screen-xl mx-auto flex justify-between items-center py-4 px-6">
            <!-- Search Bar -->
            <div class="relative search-bar">
                <input 
                    type="text" 
                    id="search-input" 
                    placeholder="Search..." 
                    onkeyup="fetchSuggestions()" 
                    class="rounded-full px-4 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-600"
                    style="border-radius: 30px;">
                <ion-icon name="search-outline" class="absolute top-1/2 right-4 transform -translate-y-1/2 text-gray-500"></ion-icon>
                <div id="suggestions-box" class="suggestions"></div>
            </div>
            <!-- <div class="relative search-bar">
                <input type="text" id="search-input" placeholder="Search..." onkeyup="fetchSuggestions()">
                <ion-icon name="search-outline"></ion-icon>
                <div id="suggestions-box" class="suggestions"></div>
            </div> -->

            <!-- Navigation Links -->
            <div class="flex space-x-4">
                <a href="{{ route('homepage') }}" class="hover:underline">
                    <ion-icon name="home-sharp"></ion-icon>
                </a>
                <a href="#" class="hover:underline">
                    <ion-icon name="library-sharp"></ion-icon>
                </a>
                <a href="{{ route('cart.index') }}" class="hover:underline">
                    <ion-icon name="cart-sharp"></ion-icon>
                </a>
                @if (Auth::check())
                <!-- User is logged in -->
                <div class="relative inline-block text-left">
                    <button 
                        id="profile-menu-button"
                        class="rounded-full px-4 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-600"
                        style="border-radius: 30px;"
                        onclick="toggleDropdown()">
                        
                        {{ Auth::user()->email }}
                    </button>

                    <!-- Dropdown menu -->
                    <div 
                        id="dropdown-menu" 
                        class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20">
                        <a 
                            href="" 
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-t-md">
                            Profil
                        </a>
                        <a 
                            href="" 
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Histori
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="block">
                            @csrf
                            <button 
                                type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-b-md">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
                    
                @else
                    <!-- User is not logged in -->
                    <a href="{{ route('login') }}" class="btn text-white">Login</a>
                    <a href="{{ route('register') }}" class="btn text-white">Register</a>
                @endif

            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-6">
        @yield('content')


        <!-- Bottom Navigation for Mobile -->
        <div class="fixed bottom-0 left-0 w-full bg-white border-t md:hidden">
            <div class="flex justify-around py-2">
                <a href="#" class="text-custom text-center">
                    <ion-icon name="home-outline" class="text-2xl"></ion-icon>
                    <p class="text-xs">Home</p>
                </a>
                <a href="#" class="text-gray-500 text-center">
                    <ion-icon name="book-outline" class="text-2xl"></ion-icon>
                    <p class="text-xs">Library</p>
                </a>
                <a href="#" class="text-gray-500 text-center">
                    <ion-icon name="cart-outline" class="text-2xl"></ion-icon>
                    <p class="text-xs">Cart</p>
                </a>
                <a href="#" class="text-gray-500 text-center">
                    <ion-icon name="person-outline" class="text-2xl"></ion-icon>
                    <p class="text-xs">Account</p>
                </a>
            </div>
        </div>

        {{-- <footer class="md:hidden mt-0 bg-white dark:bg-gray-900">

        </footer> --}}
        <footer class="bg-white dark:bg-gray-900 desktop-header">
            <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
                <div class="md:flex md:justify-between">
                    <div class="mb-6 md:mb-0">
                        <a href="https://bangsaonline.com" class="flex items-center">
                            <img src="https://bangsaonline.com/img/logo.png?rand=140" class="h-15 me-3"
                                alt="bangsaonline Logo" />
                            <ul class="social-share-two">
                                <li><a target="_blank" href="https://www.facebook.com/bangsaonline">
                                        <ion-icon name="logo-facebook"></ion-icon>
                                    </a></li>
                                <li><a target="_blank" href="https://www.tiktok.com/@bangsaonline">
                                        <ion-icon name="logo-tiktok"></ion-icon>
                                    </a></li>
                                <li><a target="_blank" href="https://twitter.com/bangsaonline">
                                        <ion-icon name="logo-twitter"></ion-icon>
                                    </a></li>
                                <li><a target="_blank" href="https://instagram.com/bangsaonline">
                                        <ion-icon name="logo-instagram"></ion-icon>
                                    </a></li>
                                <li><a target="_blank" href="https://bangsaonline.com/feed/">
                                        <ion-icon name="logo-rss"></ion-icon>
                                    </a></li>
                                <li><a target="_blank" href="https://bangsaonline.com/live">
                                        <ion-icon name="tv-outline"></ion-icon>
                                    </a></li>
                            </ul>
                        </a>
                    </div>
                    <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
                        <div>
                            <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Resources
                            </h2>
                            <ul class="text-gray-500 dark:text-gray-400 font-medium">
                                <li class="mb-4">
                                    <a href="https://flowbite.com/" class="hover:underline">Flowbite</a>
                                </li>
                                <li>
                                    <a href="https://tailwindcss.com/" class="hover:underline">Tailwind CSS</a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Kontak Kami
                            </h2>
                            <ul class="text-gray-500 dark:text-gray-400 font-medium">
                                <li class="mb-4">
                                    <a href="https://github.com/themesberg/flowbite"
                                        class="hover:underline ">Github</a>
                                </li>
                                <li>
                                    <a href="https://discord.gg/4eeurUVvTy" class="hover:underline">Discord</a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Legal</h2>
                            <ul class="text-gray-500 dark:text-gray-400 font-medium">
                                <li class="mb-4">
                                    <a href="#" class="hover:underline">Privacy Policy</a>
                                </li>
                                <li>
                                    <a href="#" class="hover:underline">Terms &amp; Conditions</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
                <div class="sm:flex sm:items-center sm:justify-between">
                    <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a
                            href="https://bangsaonline.com/" class="hover:underline">BangsaOnline</a>. All Rights
                        Reserved.
                    </span>
                </div>
            </div>
        </footer>


</body>
<!-- Swiper Script -->
<script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown-menu');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown if clicked outside
        document.addEventListener('click', function (event) {
            const dropdown = document.getElementById('dropdown-menu');
            const button = document.getElementById('profile-menu-button');
            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>

<script>
    function updateCurrentTime() {
        const timeElement = document.getElementById("current-time");

        // Mendapatkan waktu saat ini
        const now = new Date();

        // Hari dalam bahasa Indonesia
        const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        const dayName = days[now.getDay()];

        // Bulan dalam bahasa Indonesia
        const months = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
        const monthName = months[now.getMonth()];

        // Format waktu
        const date = now.getDate();
        const year = now.getFullYear();
        const hours = String(now.getHours()).padStart(2, '0'); // Format jam 2 digit
        const minutes = String(now.getMinutes()).padStart(2, '0'); // Format menit 2 digit

        // Menyusun string waktu
        const formattedTime = `${dayName}, ${date} ${monthName} ${year} ${hours}:${minutes}`;

        // Menampilkan waktu di elemen
        timeElement.textContent = formattedTime;
    }

    // Memperbarui waktu setiap menit
    setInterval(updateCurrentTime, 60000);

    // Memanggil fungsi saat halaman dimuat
    updateCurrentTime();
</script>

<script>
    function fetchSuggestions() {
        const input = document.getElementById('search-input').value;
        const suggestionsBox = document.getElementById('suggestions-box');

        if (input.trim() === "") {
            suggestionsBox.style.display = "none";
            return;
        }

        fetch(`/search?query=${input}`)
            .then(response => response.json())
            .then(data => {
                suggestionsBox.innerHTML = "";

                if (data.length > 0) {
                    data.forEach(item => {
                        const div = document.createElement("div");
                        div.textContent = item.title;

                        // Tambahkan event redirect ke URL produk detail
                        div.onclick = () => {
                            window.location.href = item.url; // Arahkan ke halaman detail
                        };

                        suggestionsBox.appendChild(div);
                    });
                    suggestionsBox.style.display = "block";
                } else {
                    suggestionsBox.style.display = "none";
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>
<script src="https://unpkg.com/swiper@9/swiper-bundle.min.js"></script>
<script>

    document.addEventListener('DOMContentLoaded', function() {
        var swiper = new Swiper('.swiper-container', {
            loop: true,
            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    });
</script>

</html>
