<x-layout>
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="img" required>
        <textarea name="caption" placeholder="Description"></textarea>
        <button type="submit">Publish</button>
    </form>
</x-layout>
