<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Your Feed</h1>

        {{-- Stories Section --}}
        <h2 class="text-xl font-semibold mb-4">Stories</h2>
        <div class="flex space-x-4 overflow-x-auto mb-6">
            @foreach ($storyUsers as $user)
                <div class="flex flex-col items-center space-y-2">
                    <div class="p-1 bg-gradient-to-tr from-pink-500 via-yellow-500 to-purple-500 rounded-full">
                        <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('images/default.webp') }}"
                            alt="{{ $user->name }}" class="w-16 h-16 rounded-full border-2 border-white">
                    </div>
                    <p class="text-center text-xs text-gray-700 truncate w-16">{{ Str::limit($user->name, 10) }}</p>
                </div>
            @endforeach
        </div>

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
                            <h2 class="text-lg font-semibold">
                                <a href="{{ route('profile.show', $post->user->id) }}"
                                    class="text-blue-500 hover:underline">
                                    {{ $post->user->name }}
                                </a>
                            </h2>
                            <p class="text-gray-600 text-sm mb-4">{{ $post->created_at->diffForHumans() }}</p>


                            {{-- Post image --}}
                            <img src="{{ asset('storage/' . $post->img_path) }}" alt="Post image"
                                class="w-full h-64 object-cover mb-4">

                            {{-- Post caption --}}
                            <p class="text-gray-700 mb-4">{{ $post->body }}</p>

                            {{-- Likes and comments --}}
                            <div class="flex items-center space-x-4">
                                {{-- Like/unlike button --}}
                                <button class="like-btn text-blue-500 font-bold" data-post-id="{{ $post->id }}"
                                    data-liked="{{ $post->likes->contains('user_id', Auth::id()) ? 'true' : 'false' }}">
                                    {{ $post->likes->contains('user_id', Auth::id()) ? 'Unlike' : 'Like' }}
                                </button>
                                <span class="like-count text-gray-600">{{ $post->likes->count() }} likes</span>
                            </div>

                            {{-- Comments --}}
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold text-gray-800">Comments</h3>
                                <ul class="space-y-4 mb-4 comment-list">
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
                                <form class="comment-form" data-post-id="{{ $post->id }}">
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
    </div>

    {{-- JavaScript for AJAX functionality --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Like/Unlike functionality
            document.querySelectorAll('.like-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.getAttribute('data-post-id');
                    const isLiked = this.getAttribute('data-liked') === 'true';
                    const url = isLiked ? `/posts/${postId}/unlike` : `/posts/${postId}/like`;
                    const likeCountSpan = this.nextElementSibling;

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update button text and like count
                                this.textContent = isLiked ? 'Like' : 'Unlike';
                                this.setAttribute('data-liked', isLiked ? 'false' : 'true');
                                likeCountSpan.textContent = `${data.likes_count} likes`;
                                this.classList.toggle('text-red-500', !isLiked);
                                this.classList.toggle('text-blue-500', isLiked);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });

            // Add comment functionality
            document.querySelectorAll('.comment-form').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const postId = this.getAttribute('data-post-id');
                    const content = this.querySelector('textarea[name="content"]').value;
                    const commentList = this.previousElementSibling;

                    fetch(`/posts/${postId}/comment`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                content: content
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Append new comment to comment list
                                const newComment = document.createElement('li');
                                newComment.classList.add('bg-gray-100', 'p-4', 'rounded',
                                    'shadow');
                                newComment.innerHTML =
                                    `<p><strong>${data.comment.user_name}</strong>: ${data.comment.content}</p>
                                                    <span class="text-sm text-gray-500">${data.comment.created_at}</span>`;
                                commentList.appendChild(newComment);
                                // Clear textarea
                                this.querySelector('textarea[name="content"]').value = '';
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
</x-layout>
