{{-- <x-layout>
    @foreach ($posts as $post)
        <div>
            <img src="{{ asset('storage/' . $post->img_path) }}" alt="Post image">
            <p>{{ $post->body }}</p>
            {{-- <p>By {{ $post->user->name }}</p> --}}
{{-- </div>
    @endforeach
</x-layout> --}}

<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Recent Posts</h1>

        @foreach ($posts as $post)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                {{-- Post Header --}}
                <div class="flex items-center px-4 py-2">
                    <img src="{{ asset('storage/' . ($post->user->profile_photo ?? 'default-profile.png')) }}"
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
                        {{-- Like Button --}}
                        @if ($post->likes->contains('user_id', Auth::id()))
                            <form action="{{ route('posts.unlike', $post->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-500 font-bold">Unlike</button>
                            </form>
                        @else
                            <form action="{{ route('posts.like', $post->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-blue-500 font-bold">Like</button>
                            </form>
                        @endif
                        <span class="text-gray-600">{{ $post->likes->count() }} likes</span>
                    </div>

                    {{-- Comment Section --}}
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-800">Comments</h3>
                        <ul class="space-y-4 mb-4">
                            @foreach ($post->comments as $comment)
                                <li class="bg-gray-100 p-4 rounded shadow">
                                    <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>
                                    <span
                                        class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                </li>
                            @endforeach
                        </ul>

                        {{-- Add Comment Form --}}
                        <form action="{{ route('posts.comment.store', $post->id) }}" method="POST" class="mt-2">
                            @csrf
                            <textarea name="content" rows="2" class="w-full p-2 border rounded" placeholder="Add a comment..."></textarea>
                            <button type="submit"
                                class="mt-2 bg-blue-500 text-white font-bold py-1 px-4 rounded">Comment</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-layout>
