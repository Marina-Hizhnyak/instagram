<x-layout>
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-bold mb-4">Chat with {{ $user->name }}</h2>

        <div id="messages" class="border rounded-lg p-4 h-96 overflow-y-auto mb-4">
            @foreach ($messages as $message)
                <div class="mb-2 {{ $message->sender_id == Auth::id() ? 'text-right' : 'text-left' }}">
                    <span
                        class="px-4 py-2 rounded-lg inline-block
                        {{ $message->sender_id == Auth::id() ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }}">
                        {{ $message->content }}
                    </span>
                </div>
            @endforeach
        </div>

        <form id="messageForm" action="{{ route('chat.send') }}" method="POST">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $user->id }}">
            <div class="flex">
                <input type="text" name="content" placeholder="Type a message..."
                    class="w-full border p-2 rounded-l-lg focus:outline-none">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-lg">Send</button>
            </div>
        </form>
    </div>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        const messagesEl = document.getElementById('messages');

        Echo.private(`chat.{{ $user->id }}`)
            .listen('MessageSent', (e) => {
                const message = e.message;
                const messageEl = document.createElement('div');
                messageEl.classList.add('mb-2', message.sender_id === {{ Auth::id() }} ? 'text-right' : 'text-left');
                messageEl.innerHTML =
                    `<span class="px-4 py-2 rounded-lg inline-block ${message.sender_id === {{ Auth::id() }} ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800'}">${message.content}</span>`;
                messagesEl.appendChild(messageEl);
                messagesEl.scrollTop = messagesEl.scrollHeight;
            });

        document.getElementById('messageForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const content = e.target.content.value;

            axios.post("{{ route('chat.send') }}", {
                receiver_id: {{ $user->id }},
                content: content
            }).then(response => {
                e.target.content.value = '';
            }).catch(error => {
                console.error(error);
            });
        });
    </script>
</x-layout>
