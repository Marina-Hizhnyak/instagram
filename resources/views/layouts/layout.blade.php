<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Mini Instagram' }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- Подключение стилей -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <!-- Логотип -->
            <div>
                <a href="/"
                    class="group font-bold text-3xl flex items-center space-x-4 hover:text-emerald-600 transition ">
                    <x-application-logo
                        class="w-10 h-10 fill-current text-gray-500 group-hover:text-emerald-500 transition" />
                    <span>Mini Instagram</span>
                </a>
            </div>
            {{-- <a href="{{ route('home') }}" class="text-2xl font-bold">
                Mini Instagram
            </a> --}}

            <!-- Навигация -->
            <nav>
                <ul class="flex space-x-4">
                    <!-- Ссылка на главную ленту -->
                    <li><a href="{{ route('posts.index') }}" class="text-gray-700 hover:text-gray-900">Home</a></li>

                    <!-- Ссылка на создание поста -->
                    <li><a href="{{ route('posts.create') }}" class="text-gray-700 hover:text-gray-900">New Post</a>
                    </li>

                    <!-- Ссылка на профиль -->
                    <li><a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-gray-900">Profile</a></li>

                    <!-- Выход -->
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-gray-900">Logout</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        {{ $slot }} <!-- Контент, который будет передаваться в этот макет -->
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow mt-12">
        <div class="container mx-auto px-4 py-4 text-center">
            <p class="text-gray-600">&copy; 2024 Mini Instagram. All rights reserved.</p>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script> <!-- Подключение скриптов -->
</body>

</html>
