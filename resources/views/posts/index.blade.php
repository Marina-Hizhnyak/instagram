<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Recent Posts</h1>

        @foreach ($posts as $post)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6" id="post-{{ $post->id }}">
                {{-- Post Header --}}
                <div class="flex items-center px-4 py-2">
                    <img src="{{ asset('storage/' . ($post->user->profile_photo ?? 'default.webp')) }}"
                        alt="User profile photo" class="w-10 h-10 rounded-full mr-3">
                    <div>
                        {{-- User name --}}
                        <h2 class="text-lg font-semibold">
                            <a href="{{ route('profile.show', $post->user->id) }}" class="text-blue-500 hover:underline">
                                {{ $post->user->name }}
                            </a>
                        </h2>
                        <p class="text-gray-600 text-sm mb-4">{{ $post->created_at->diffForHumans() }}</p>

                    </div>

                    {{-- Follow/Unfollow Button --}}
                    <div class="ml-auto">
                        @if (Auth::id() !== $post->user->id)
                            <button data-user-id="{{ $post->user->id }}"
                                class="follow-btn bg-blue-500 text-white font-bold py-1 px-4 rounded">
                                {{ Auth::user()->following->contains($post->user->id) ? 'Unfollow' : 'Follow' }}
                            </button>
                        @endif
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
                        <button
                            class="like-btn {{ $post->likes->contains('user_id', Auth::id()) ? 'text-red-500' : 'text-blue-500' }} font-bold"
                            data-post-id="{{ $post->id }}">
                            {{ $post->likes->contains('user_id', Auth::id()) ? 'Unlike' : 'Like' }}
                        </button>
                        <span id="likes-count-{{ $post->id }}" class="text-gray-600">{{ $post->likes->count() }}
                            likes</span>
                    </div>

                    {{-- Comment Section --}}
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-800">Comments</h3>
                        <ul class="space-y-4 mb-4" id="comments-list-{{ $post->id }}">
                            @foreach ($post->comments as $comment)
                                <li class="bg-gray-100 p-4 rounded shadow">
                                    <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>
                                    <span
                                        class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                </li>
                            @endforeach
                        </ul>

                        {{-- Add Comment Form --}}
                        <form data-post-id="{{ $post->id }}" class="comment-form mt-2">
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

    {{-- JavaScript for AJAX --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Follow/Unfollow
            document.querySelectorAll('.follow-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    const action = this.textContent.trim() === 'Follow' ? 'follow' : 'unfollow';

                    fetch(`/${action}/${userId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                user_id: userId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.textContent = action === 'follow' ? 'Unfollow' : 'Follow';
                                this.classList.toggle('bg-blue-500');
                                this.classList.toggle('bg-red-500');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });

            // Like/Unlike
            document.querySelectorAll('.like-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.getAttribute('data-post-id');
                    const action = this.textContent.trim() === 'Like' ? 'like' : 'unlike';

                    fetch(`/posts/${postId}/${action}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.textContent = action === 'like' ? 'Unlike' : 'Like';
                                this.classList.toggle('text-blue-500');
                                this.classList.toggle('text-red-500');
                                document.getElementById(`likes-count-${postId}`).textContent =
                                    `${data.likes_count} likes`;
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });

            // Add Comment
            document.querySelectorAll('.comment-form').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const postId = this.getAttribute('data-post-id');
                    const content = this.querySelector('textarea[name="content"]').value;

                    fetch(`/posts/${postId}/comment`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                content
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const newComment = document.createElement('li');
                                newComment.classList.add('bg-gray-100', 'p-4', 'rounded',
                                    'shadow');
                                newComment.innerHTML =
                                    `<p><strong>${data.comment.user_name}</strong>: ${data.comment.content}</p>
                                                    <span class="text-sm text-gray-500">${data.comment.created_at}</span>`;
                                document.getElementById(`comments-list-${postId}`).appendChild(
                                    newComment);
                                this.querySelector('textarea[name="content"]').value = '';
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
</x-layout>
