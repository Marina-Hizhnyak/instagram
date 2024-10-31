<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Your Feed</h1>

        {{-- Latest Posts Section --}}
        <h2 class="text-xl font-semibold mb-4">Latest Posts</h2>
        @if ($latestPosts->isEmpty())
            <p class="text-gray-600">No recent posts available. Follow some users to see their posts here!</p>
        @else
            <ul class="space-y-6">
                @foreach ($latestPosts as $post)
                    <li class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="p-4">
                            {{-- User name --}}
                            <h2 class="text-lg font-semibold">{{ $post->user->name }}</h2>
                            <p class="text-gray-600 text-sm mb-4">{{ $post->created_at->diffForHumans() }}</p>

                            {{-- Post image --}}
                            <img src="{{ asset('storage/' . $post->img_path) }}" alt="Post image"
                                class="w-full h-64 object-cover mb-4">

                            {{-- Post caption --}}
                            <p class="text-gray-700 mb-4">{{ $post->body }}</p>

                            {{-- Likes and comments --}}
                            <div class="flex items-center space-x-4">
                                {{-- Like/unlike button --}}
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

                            {{-- Comments --}}
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

                                {{-- Add comment form --}}
                                <form action="{{ route('posts.comment.store', $post->id) }}" method="POST">
                                    @csrf
                                    <textarea name="content" rows="2" class="w-full p-2 border rounded mb-2" placeholder="Add a comment..."></textarea>
                                    <button type="submit"
                                        class="bg-blue-500 text-white font-bold py-1 px-4 rounded">Comment</button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            {{-- Pagination for latest posts --}}
            <div class="mt-6">
                {{ $latestPosts->links() }}
            </div>
        @endif

        {{-- Popular Posts Section --}}
        <h2 class="text-xl font-semibold mt-12 mb-4">Popular Posts</h2>
        @if ($popularPosts->isEmpty())
            <p class="text-gray-600">No popular posts available yet.</p>
        @else
            <ul class="space-y-6">
                @foreach ($popularPosts as $post)
                    <li class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="p-4">
                            {{-- User name --}}
                            <h2 class="text-lg font-semibold">{{ $post->user->name }}</h2>
                            <p class="text-gray-600 text-sm mb-4">{{ $post->created_at->diffForHumans() }}</p>

                            {{-- Post image --}}
                            <img src="{{ asset('storage/' . $post->img_path) }}" alt="Post image"
                                class="w-full h-64 object-cover mb-4">

                            {{-- Post caption --}}
                            <p class="text-gray-700 mb-4">{{ $post->body }}</p>

                            {{-- Likes and comments --}}
                            <div class="flex items-center space-x-4">
                                {{-- Like/unlike button --}}
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

                            {{-- Comments --}}
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold text-gray-800">Comments</h3>
                                <ul class="space-y-4 mb-4">
                                    @foreach ($post->comments as $comment)
                                        <li class="bg-gray-100 p-4 rounded shadow">
                                            <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}
                                            </p>
                                            <span
                                                class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        </li>
                                    @endforeach
                                </ul>

                                {{-- Add comment form --}}
                                <form action="{{ route('posts.comment.store', $post->id) }}" method="POST">
                                    @csrf
                                    <textarea name="content" rows="2" class="w-full p-2 border rounded mb-2" placeholder="Add a comment..."></textarea>
                                    <button type="submit"
                                        class="bg-blue-500 text-white font-bold py-1 px-4 rounded">Comment</button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-layout>
