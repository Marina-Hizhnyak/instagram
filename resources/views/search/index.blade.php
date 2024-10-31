<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Search Results for "{{ $query }}"</h1>

        {{-- Display Users --}}
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Users</h2>
            @if ($users->isEmpty())
                <p class="text-gray-600">No users found.</p>
            @else
                <ul class="space-y-4">
                    @foreach ($users as $user)
                        <li class="bg-white p-4 rounded shadow">
                            <a href="{{ route('profile.show', $user->id) }}" class="text-lg font-semibold text-blue-500">
                                {{ $user->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Display Posts --}}
        <div>
            <h2 class="text-xl font-semibold mb-4">Posts</h2>
            @if ($posts->isEmpty())
                <p class="text-gray-600">No posts found.</p>
            @else
                <ul class="space-y-6">
                    @foreach ($posts as $post)
                        <li class="bg-white p-4 rounded shadow">
                            <p class="text-gray-700">{{ $post->body }}</p>
                            <a href="{{ route('profile.show', $post->user->id) }}" class="text-blue-500 text-sm">
                                By {{ $post->user->name }}
                            </a>
                            <p class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-layout>
