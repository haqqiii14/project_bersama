@extends('layouts.user')

@section('title', 'About')

@section('contents')
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">
            About Us
        </h1>
    </div>
</header>
<hr />
<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <h2 class="text-2xl font-bold mb-4">Our Mission</h2>
            <p class="mb-4">
                Our mission is to provide innovative solutions that enhance user experience and streamline operations. We aim to empower individuals and organizations with the tools they need to succeed in today's fast-paced environment.
            </p>

            <h2 class="text-2xl font-bold mb-4">Meet Our Team</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <div class="border rounded-lg p-4 text-center">
                    <img src="{{ asset('path/to/team-member-1.jpg') }}" alt="Team Member 1" class="w-32 h-32 rounded-full mx-auto mb-2">
                    <h3 class="font-bold">John Doe</h3>
                    <p>CEO</p>
                </div>
                <div class="border rounded-lg p-4 text-center">
                    <img src="{{ asset('path/to/team-member-2.jpg') }}" alt="Team Member 2" class="w-32 h-32 rounded-full mx-auto mb-2">
                    <h3 class="font-bold">Jane Smith</h3>
                    <p>CTO</p>
                </div>
                <div class="border rounded-lg p-4 text-center">
                    <img src="{{ asset('path/to/team-member-3.jpg') }}" alt="Team Member 3" class="w-32 h-32 rounded-full mx-auto mb-2">
                    <h3 class="font-bold">Alice Johnson</h3>
                    <p>Lead Developer</p>
                </div>
                <div class="border rounded-lg p-4 text-center">
                    <img src="{{ asset('path/to/team-member-4.jpg') }}" alt="Team Member 4" class="w-32 h-32 rounded-full mx-auto mb-2">
                    <h3 class="font-bold">Bob Brown</h3>
                    <p>Designer</p>
                </div>
            </div>

            <h2 class="text-2xl font-bold mb-4 mt-6">Get in Touch</h2>
            <p>If you have any questions or would like to learn more about our services, feel free to contact us!</p>
            <p>Email: <a href="mailto:info@example.com" class="text-blue-500">info@example.com</a></p>
        </div>
    </div>
</main>
@endsection
