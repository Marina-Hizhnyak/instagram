<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex">
        <!-- Sidebar for Desktop -->
        <aside class="w-1/4 bg-white border-r p-4 hidden md:block">
            <div class="flex flex-col items-start">
                <div>
                    <a href="{{ route('home') }}"
                        class="group font-bold text-3xl flex items-center space-x-4 hover:text-emerald-600 transition">
                        <x-application-logo
                            class="w-10 h-10 fill-current text-gray-500 group-hover:text-emerald-500 transition" />
                        <span>Mini Instagram</span>
                    </a>
                </div>

                <nav class="flex flex-col space-y-4 pt-8">
                    <!-- Menu Links -->
                    <a href="{{ route('home') }}"
                        class="flex items-center space-x-2 text-gray-700 hover:text-black {{ request()->routeIs('home') ? 'text-black font-semibold' : '' }}">
                        <i class="fas fa-home"></i><span>Home</span>
                    </a>
                    <a href="{{ route('chat.list') }}"
                        class="flex items-center space-x-2 text-gray-700 hover:text-black">
                        <i class="fas fa-envelope"></i><span>Messages</span>
                    </a>
                    <a href="{{ route('profile.index') }}"
                        class="flex items-center space-x-2 text-gray-700 hover:text-black {{ request()->routeIs('profile.index') ? 'text-black font-semibold' : '' }}">
                        <i class="fas fa-user"></i><span>Profile</span>
                    </a>
                    <a href="{{ route('my.posts') }}"
                        class="flex items-center space-x-2 text-gray-700 hover:text-black">
                        <i class="fas fa-user-edit"></i><span>My Posts</span>
                    </a>
                    <a href="{{ route('posts.create') }}"
                        class="flex items-center space-x-2 text-gray-700 hover:text-black">
                        <i class="fas fa-plus"></i><span>Create post</span>
                    </a>
                    <a href="{{ route('posts.index') }}"
                        class="flex items-center space-x-2 text-gray-700 hover:text-black">
                        <i class="fas fa-th-list"></i><span>All posts</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="pt-4">
                        @csrf
                        <button type="submit"
                            class="text-white bg-red-500 hover:bg-red-700 px-4 py-2 rounded-lg w-full">
                            Logout
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        <!-- Mobile menu button -->
        <div class="block md:hidden p-4">
            <button id="menu-toggle" class="text-gray-700 focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>

        <!-- Sidebar for Mobile -->
        <aside id="mobile-menu" class="fixed top-0 left-0 w-full bg-white border-b p-4 hidden z-50">
            <div class="flex flex-col items-start">
                <div>
                    <a href="{{ route('home') }}"
                        class="group font-bold text-3xl flex items-center space-x-4 hover:text-emerald-600 transition">
                        <x-application-logo
                            class="w-10 h-10 fill-current text-gray-500 group-hover:text-emerald-500 transition" />
                        <span>Mini Instagram</span>
                    </a>
                </div>

                <nav class="flex flex-col space-y-4 pt-8">
                    <!-- Menu Links -->
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 text-gray-700 hover:text-black">
                        <i class="fas fa-home"></i><span>Home</span>
                    </a>
                    <a href="{{ route('chat.list') }}"
                        class="flex items-center space-x-2 text-gray-700 hover:text-black">
                        <i class="fas fa-envelope"></i><span>Messages</span>
                    </a>
                    <a href="{{ route('profile.index') }}"
                        class="flex items-center space-x-2 text-gray-700 hover:text-black">
                        <i class="fas fa-user"></i><span>Profile</span>
                    </a>
                    <a href="{{ route('my.posts') }}"
                        class="flex items-center space-x-2 text-gray-700 hover:text-black">
                        <i class="fas fa-user-edit"></i><span>My Posts</span>
                    </a>
                    <a href="{{ route('posts.create') }}"
                        class="flex items-center space-x-2 text-gray-700 hover:text-black">
                        <i class="fas fa-plus"></i><span>Create post</span>
                    </a>
                    <a href="{{ route('posts.index') }}"
                        class="flex items-center space-x-2 text-gray-700 hover:text-black">
                        <i class="fas fa-th-list"></i><span>All posts</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="pt-4">
                        @csrf
                        <button type="submit"
                            class="text-white bg-red-500 hover:bg-red-700 px-4 py-2 rounded-lg w-full">
                            Logout
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex flex-col items-center justify-center w-full md:w-3/4 p-8">
            <div class="w-full max-w-4xl space-y-6">
                {{ $slot }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');

            menuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        });
    </script>
</body>

</html>
