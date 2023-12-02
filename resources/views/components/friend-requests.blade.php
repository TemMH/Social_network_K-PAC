<!-- resources/views/components/friend-requests.blade.php -->

<div>
    <h3 class="text-lg font-semibold mb-4">Friend Requests</h3>

    @forelse ($friendRequests as $request)
        <div class="flex items-center justify-between mb-2">
            <p>{{ $request->sender->name }} sent you a friend request</p>
            <div class="flex space-x-2">
                <form method="POST" action="{{ route('accept-friend-request', $request->sender) }}">
                    @csrf
                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">Accept</button>
                </form>
                <form method="POST" action="{{ route('reject-friend-request', $request->sender) }}">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Reject</button>
                </form>
            </div>
        </div>
    @empty
        <p>No friend requests</p>
    @endforelse
</div>
