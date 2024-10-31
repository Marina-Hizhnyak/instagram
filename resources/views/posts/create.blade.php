<x-layout>
    <div class="container mx-auto px-4 py-8 max-w-xl">
        <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Create a New Post</h2>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded-lg shadow-md">
            @csrf

            <!-- Upload Image Field -->
            <div class="mb-4">
                <label for="img" class="block text-sm font-medium text-gray-700 mb-1">Upload Image</label>
                <input type="file" name="img" id="img" required
                    class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg p-2 focus:ring-orange-500 focus:border-orange-500">
            </div>

            <!-- Caption Field -->
            <div class="mb-4">
                <label for="caption" class="block text-sm font-medium text-gray-700 mb-1">Caption</label>
                <textarea name="caption" id="caption" placeholder="Write a caption..." rows="4"
                    class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg p-2 focus:ring-orange-500 focus:border-orange-500"></textarea>
            </div>

            <!-- Publish Button -->
            <div class="flex justify-center">
                <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50 transition ease-in-out duration-150">
                    Publish
                </button>
            </div>
        </form>
    </div>
</x-layout>
