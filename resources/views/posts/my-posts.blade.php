<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">My Posts</h1>

        @foreach ($posts as $post)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                {{-- Post Header --}}
                <div class="flex items-center px-4 py-2">
                    <img src="{{ asset('storage/' . ($post->user->profile_photo ?? 'default.webp')) }}"
                        alt="User profile photo" class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <h2 class="text-lg font-semibold">{{ $post->user->name }}</h2>
                        <p class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                {{-- Post Image --}}
                <img src="{{ asset('storage/' . $post->img_path) }}" alt="Post image" class="w-full h-80 object-cover">

                {{-- Post Body --}}
                <div class="p-4">
                    <p class="text-gray-700">{{ $post->body }}</p>

                    {{-- Likes and Comments Section --}}
                    <div class="flex items-center mt-4 space-x-4">
                        <span class="text-gray-600">{{ $post->likes->count() }} likes</span>
                        <span class="text-gray-600">{{ $post->comments->count() }} comments</span>
                    </div>

                    {{-- Edit/Delete Buttons --}}
                    <div class="mt-4">
                        <a href="{{ route('posts.edit', $post->id) }}" class="text-blue-500 font-bold mr-4">Edit</a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline"
                            onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 font-bold">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-layout>
