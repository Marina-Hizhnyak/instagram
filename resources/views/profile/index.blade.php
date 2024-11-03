<x-layout>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="w-full max-w-4xl bg-white rounded-xl shadow-lg p-8">
            <!-- Profile Title -->
            <div class="text-center mb-8">
                <h2 class="text-4xl font-extrabold text-gray-800">User Profile</h2>
                <p class="text-gray-500">Your personal information and social activity</p>
            </div>

            <!-- Main Profile Content -->
            <div class="flex flex-col items-center">
                <!-- Profile Photo -->
                <div class="w-32 h-32 rounded-full overflow-hidden shadow-md mb-6">
                    <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('images/default-profile.png') }}"
                        alt="Profile Photo" class="w-full h-full object-cover">
                </div>

                <!-- Username -->
                <h3 class="text-3xl font-semibold text-gray-800 mb-2">{{ $user->name }}</h3>
                <p class="text-gray-500 text-sm mb-4">{{ $user->email }}</p>

                <!-- Bio -->
                @if ($user->bio)
                    <p class="text-gray-700 text-center mb-4 px-6">{{ $user->bio }}</p>
                @else
                    <p class="text-gray-400 italic mb-4">Bio not provided</p>
                @endif

                <!-- Followers/Following -->
                <div class="flex space-x-10 text-center mb-6">
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $user->followers()->count() }}</p>
                        <p class="text-gray-500">Followers</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $user->following()->count() }}</p>
                        <p class="text-gray-500">Following</p>
                    </div>
                </div>

                <!-- Profile Management Buttons -->
                <div class="flex space-x-6 mt-6">
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center bg-blue-600 text-white px-5 py-3 rounded-full hover:bg-blue-700 transition">
                        <i class="fas fa-edit mr-2"></i> Edit Profile
                    </a>
                    <form action="{{ route('profile.destroy') }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete your profile?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="flex items-center bg-red-500 text-white px-5 py-3 rounded-full hover:bg-red-600 transition">
                            <i class="fas fa-trash-alt mr-2"></i> Delete Profile
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
