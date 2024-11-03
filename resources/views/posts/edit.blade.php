<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Edit Post</h1>

        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
            @if ($errors->any())
                <div class="mb-4">
                    <ul class="list-disc list-inside text-red-500">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Image Field -->
                <div class="mb-4">
                    <label for="img" class="block text-sm font-medium text-gray-700">Update Image</label>
                    <input type="file" name="img" id="img"
                        class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg p-2">
                    @if ($post->img_path)
                        <img src="{{ asset('storage/' . $post->img_path) }}" alt="Post image"
                            class="mt-4 w-full h-64 object-cover rounded">
                    @endif
                </div>

                <!-- Caption Field -->
                <div class="mb-4">
                    <label for="body" class="block text-sm font-medium text-gray-700">Caption</label>
                    <textarea name="body" id="body" rows="3"
                        class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg p-2" placeholder="Write a caption...">{{ old('body', $post->body) }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Update Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
