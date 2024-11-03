<x-layout>
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-bold mb-4">Chat List</h2>
        <ul>
            @foreach ($users as $user)
                <li>
                    <a href="{{ route('chat.index', ['user' => $user->id]) }}" class="text-blue-500 hover:underline">
                        Chat with {{ $user->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</x-layout>
