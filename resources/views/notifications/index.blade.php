@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Notifications</h1>

<div class="bg-white shadow rounded p-4">

    @forelse($notifications as $notification)
        <div class="border-b py-3 flex justify-between items-center">

            {{-- LEFT SIDE --}}
            <div>
                <p class="font-semibold text-gray-800">
                    {{ $notification->message }}
                </p>

                @if($notification->ticket)
                    <p class="text-sm text-gray-500">
                        Ticket #{{ $notification->ticket->number }}
                    </p>
                @endif

                <p class="text-xs text-gray-400">
                    {{ $notification->created_at->diffForHumans() }}
                </p>
            </div>

            {{-- RIGHT SIDE --}}
            <div class="flex items-center space-x-3">

                {{-- VIEW --}}
                <a href="{{ route('notifications.show', $notification) }}"
                   class="text-blue-500 hover:underline">
                    View
                </a>

                {{-- DELETE --}}
                <form method="POST"
                      action="{{ route('notifications.destroy', $notification) }}">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            onclick="return confirm('Are you sure?')"
                            class="text-red-500 hover:underline">
                        Delete
                    </button>
                </form>

            </div>

        </div>
    @empty

        <div class="text-center py-10 text-gray-500">
            No notifications found.
        </div>

    @endforelse

</div>

@endsection