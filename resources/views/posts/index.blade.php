<x-layout>
    @foreach ($posts as $post)
        <div>
            <img src="{{ asset('storage/' . $post->img_path) }}" alt="Post image">
            <p>{{ $post->body }}</p>
            {{-- <p>By {{ $post->user->name }}</p> --}}
        </div>
    @endforeach
</x-layout>
