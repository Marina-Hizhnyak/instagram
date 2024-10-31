<x-layout>

    <div class="container mx-auto py-8 px-4">
        <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-blue-500 p-4 text-center">
                <h2 class="text-2xl font-bold text-white">User Profile</h2>
            </div>

            <div class="flex flex-col items-center p-6">
                <!-- Profile Photo -->
                <div class="w-24 h-24 rounded-full overflow-hidden mb-4">
                    <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('images/default-profile.png') }}"
                        alt="Profile Photo" class="w-full h-full object-cover">
                </div>

                <!-- Name -->
                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $user->name }}</h3>

                <!-- Email -->
                <p class="text-gray-600 mb-4">{{ $user->email }}</p>

                <!-- Bio -->
                @if ($user->bio)
                    <p class="text-gray-700 text-center mb-4">{{ $user->bio }}</p>
                @else
                    <p class="text-gray-500 italic mb-4">Bio not provided</p>
                @endif

                <!-- Profile Management Buttons -->
                <div class="flex space-x-4">
                    <a href="{{ route('profile.edit') }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">Edit
                        Profile</a>
                    <form action="{{ route('profile.destroy') }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete your profile?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">Delete
                            Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-layout>
