<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Register</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>

    <style>
        .header {
            background: linear-gradient(to right, #1e3c72, #2a5298); /* Warna gradien */
            color: white; /* Warna teks */
            text-align: center; /* Teks berada di tengah */
            padding: 10px; /* Ruang di dalam elemen */
            font-size: 24px; /* Ukuran font */
            font-weight: bold; /* Membuat teks tebal */
            width: 100%; /* Membuat elemen selebar elemen induknya */
            box-sizing: border-box; /* Termasuk padding dalam width */
            margin: 0; /* Menghilangkan margin */
        }
    </style>
</head>
<body>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                Register
            </div>
            <div class="w-full bg-white rounded-lg shadow dark:border sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <!-- Bagian 1: Email dan Password -->
                <div>
                    <h1 class="header">
                        Create Account
                    </h1>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Bagian 1: Email dan Password -->
                    <form action="{{ route('register.save') }}" method="POST" class="space-y-4 md:space-y-6">
                        @csrf
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">E-Mail</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="E-Mail" required>
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Password" required>
                        </div>
                    </form>
                </div>
                <hr class="border-gray-300 dark:border-gray-700">
                <!-- Bagian 2: Fullname, Phone, dan Birthday -->
                <div>
                    <h1 class="header">
                        Personal Info
                    </h1>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Bagian 2: Personal Information -->
                    <form action="{{ route('register.save') }}" method="POST" class="space-y-4 md:space-y-6">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fullname</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Fullname" required>
                        </div>
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                            <input type="text" name="phone" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Phone" required>
                        </div>
                        <div>
                            <label for="birthday" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Birthday</label>
                            <input type="date" name="birthday" id="birthday" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        </div>
                        <!-- Terms and Conditions -->
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name="terms" id="terms" class="text-indigo-600 focus:ring-0" required>
                            <label for="terms" class="text-sm text-gray-900 dark:text-white">
                                I agree to the <a href="#" class="text-indigo-600 hover:underline">Terms and Conditions</a>
                            </label>
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-500">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>