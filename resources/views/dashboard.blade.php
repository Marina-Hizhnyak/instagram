<x-layout>
    {{-- <header name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Post Feed Content -->
    @foreach ($posts as $post)
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 rounded-full bg-gray-200"></div>
                <div>
                    <span class="font-semibold">{{ $post->user->name }}</span>
                    <span class="text-gray-500 text-sm">• {{ $post->created_at->diffForHumans() }}</span>
                </div>
            </div>
            <div class="mt-4">
                <img src="{{ $post->image_url }}" alt="Post image" class="w-full rounded-lg">
            </div>
            <div class="flex justify-between mt-4">
                <div class="flex space-x-4">
                    <i class="far fa-heart text-gray-700"></i>
                    <i class="far fa-comment text-gray-700"></i>
                </div>
                <span class="text-gray-500">{{ $post->likes_count }} лайков</span>
            </div>
        </div>
    @endforeach
</x-layout>
