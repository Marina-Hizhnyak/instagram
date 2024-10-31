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
    <div class="flex min-h-screen">
        <!-- Sidebar -->
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
                    <!-- Search Form -->
                    <form action="{{ route('search') }}" method="GET"
                        class="flex items-center bg-gray-200 rounded-lg">
                        <input type="text" name="query" placeholder="Search..."
                            class="bg-transparent border-none p-2 w-full rounded-l-lg focus:outline-none">
                        <button type="submit"
                            class="bg-blue-500 text-white font-bold py-2 px-4 rounded-r-lg">Search</button>
                    </form>

                    <!-- Menu Links -->
                    <a href="{{ route('home') }}"
                        class="flex items-center space-x-2 text-gray-700 hover:text-black {{ request()->routeIs('home') ? 'text-black font-semibold' : '' }}">
                        <i class="fas fa-home"></i><span>Home</span>
                    </a>
                    <a href="#" class="flex items-center space-x-2 text-gray-700 hover:text-black">
                        <i class="fas fa-bell"></i><span>Notifications</span>
                    </a>
                    <a href="#" class="flex items-center space-x-2 text-gray-700 hover:text-black">
                        <i class="fas fa-envelope"></i><span>Messages</span>
                    </a>
                    <a href="{{ route('profile.index') }}"
                        class="flex items-center space-x-2 text-gray-700 hover:text-black {{ request()->routeIs('profile.index') ? 'text-black font-semibold' : '' }}">
                        <i class="fas fa-user"></i><span>Profile</span>
                    </a>
                    <a href="{{ route('posts.create') }}"
                        class="flex items-center space-x-2 text-gray-700 hover:text-black">
                        <i class="fas fa-plus"></i><span>Create</span>
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

        <!-- Main Content Area -->
        <main class="w-full md:w-2/4 p-6">
            <!-- Stories Section -->
            <div class="flex space-x-4 overflow-x-auto mb-6 bg-gray-100 p-4 rounded-lg">
                {{-- {{ $stories }} --}}
                <p>Stories placeholder</p>
            </div>

            <!-- Main Feed -->
            <div class="space-y-6">
                {{ $slot }}
            </div>
        </main>

        <!-- Right Sidebar or Additional Content -->
        <div class="hidden md:block w-1/4 p-6">
            <h2 class="text-lg font-semibold mb-4">Additional Content</h2>
            <p>Suggestions or trending topics could go here.</p>
        </div>
    </div>
</body>

</html>
