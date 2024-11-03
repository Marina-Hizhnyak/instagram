<x-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800">{{ $user->name }}'s Profile</h1>
                <p class="text-gray-600 mt-2">{{ $user->bio }}</p>
            </div>

            {{-- Follow/Unfollow Button --}}
            @if (Auth::id() !== $user->id)
                <div class="mt-4 flex justify-center">
                    @if (Auth::user()->following->contains($user->id))
                        <form action="{{ route('unfollow', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                Unfollow
                            </button>
                        </form>
                    @else
                        <form action="{{ route('follow', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                Follow
                            </button>
                        </form>
                    @endif
                </div>
            @endif

            <div class="mt-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ $user->name }}'s Posts</h2>
                <ul class="space-y-6">
                    @foreach ($posts as $post)
                        <li id="post-{{ $post->id }}" class="bg-gray-100 rounded-lg shadow-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $post->img_path) }}" alt="Post image"
                                class="w-full h-64 object-cover">
                            <div class="p-4">
                                <p class="text-gray-700">{{ $post->body }}</p>

                                {{-- Like/Unlike Button --}}
                                <div class="mt-4">
                                    <span id="like-count-{{ $post->id }}"
                                        class="text-gray-600">{{ $post->likes->count() }} likes</span>
                                    <div id="like-btn-{{ $post->id }}">
                                        @if ($post->likes->contains('user_id', Auth::id()))
                                            <button onclick="toggleLike({{ $post->id }}, 'unlike')"
                                                class="text-red-500 font-bold">Unlike</button>
                                        @else
                                            <button onclick="toggleLike({{ $post->id }}, 'like')"
                                                class="text-blue-500 font-bold">Like</button>
                                        @endif
                                    </div>
                                </div>

                                {{-- Display Comments --}}
                                <div class="mt-6">
                                    <h3 class="text-lg font-semibold text-gray-800">Comments</h3>
                                    <ul class="space-y-4">
                                        @foreach ($post->comments as $comment)
                                            <li class="bg-white p-4 rounded shadow">
                                                <p class="text-gray-700"><strong>{{ $comment->user->name }}</strong>:
                                                    {{ $comment->content }}</p>
                                                <span
                                                    class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                {{-- Add Comment Form --}}
                                <form action="{{ route('posts.comment.store', $post->id) }}" method="POST"
                                    class="mt-4">
                                    @csrf
                                    <textarea name="content" rows="2" class="w-full p-2 border rounded" placeholder="Add a comment..."></textarea>
                                    <button type="submit"
                                        class="mt-2 bg-blue-500 text-white font-bold py-1 px-4 rounded">Comment</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>


            </div>
        </div>
    </div>
</x-layout>



<script>
    function toggleLike(postId, action) {
        fetch(`/posts/${postId}/${action}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Update the like count
                document.getElementById(`like-count-${postId}`).textContent = `${data.likes} likes`;

                // Update the button
                const likeBtn = document.getElementById(`like-btn-${postId}`);
                if (action === 'like') {
                    likeBtn.innerHTML =
                        `<button onclick="toggleLike(${postId}, 'unlike')" class="text-red-500 font-bold">Unlike</button>`;
                } else {
                    likeBtn.innerHTML =
                        `<button onclick="toggleLike(${postId}, 'like')" class="text-blue-500 font-bold">Like</button>`;
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function submitComment(postId) {
        const commentContent = document.querySelector(`#comment-input-${postId}`).value;

        fetch(`/posts/${postId}/comment`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    content: commentContent
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add the new comment to the list
                    const commentList = document.querySelector(`#comments-list-${postId}`);
                    const newComment = document.createElement('li');
                    newComment.classList.add('bg-white', 'p-4', 'rounded', 'shadow');
                    newComment.innerHTML = `
                    <p class="text-gray-700"><strong>${data.comment.user.name}</strong>: ${data.comment.content}</p>
                    <span class="text-sm text-gray-500">${data.comment.created_at}</span>
                `;
                    commentList.appendChild(newComment);

                    // Clear the input
                    document.querySelector(`#comment-input-${postId}`).value = '';
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>
