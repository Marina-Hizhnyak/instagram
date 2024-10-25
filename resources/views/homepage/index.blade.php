<x-guest-layout>
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Лента постов -->
            @foreach ($posts as $post)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <!-- Имя пользователя и аватарка -->
                    <div class="flex items-center px-4 py-3">
                        <img src="{{ $post->user->avatar }}" class="w-10 h-10 rounded-full" alt="{{ $post->user->name }}">
                        <div class="ml-3">
                            <div class="text-sm font-semibold text-gray-800">{{ $post->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</div>
                        </div>
                    </div>

                    <!-- Фото поста -->
                    <div>
                        <img src="{{ $post->img_path }}" alt="Post image" class="w-full h-64 object-cover mx-auto">
                    </div>

                    <!-- Описание поста (если есть) -->
                    @if ($post->body)
                        <div class="px-4 py-2">
                            <p class="text-sm text-gray-800">{{ $post->body }}</p>
                        </div>
                    @endif

                    <!-- Взаимодействие с постом: лайки, комментарии, сохранение -->
                    <div class="px-4 py-2 flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <!-- Лайк -->
                            <button class="text-gray-600 hover:text-red-500 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                            </button>
                            <!-- Количество лайков -->
                            <span class="text-sm text-gray-600">{{ $post->likes_count }} likes</span>

                            <!-- Комментарии -->
                            <button class="text-gray-600 hover:text-blue-500 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8h2a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V10a2 2 0 012-2h2" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12v7" />
                                </svg>
                            </button>
                            <!-- Количество комментариев -->
                            <span class="text-sm text-gray-600">{{ $post->comments_count }} comments</span>
                        </div>

                        <!-- Кнопка сохранения поста -->
                        <button class="text-gray-600 hover:text-green-500 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5v14l7-5 7 5V5a2 2 0 00-2-2H7a2 2 0 00-2 2z" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-guest-layout>
