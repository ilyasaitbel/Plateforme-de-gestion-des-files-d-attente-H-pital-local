@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Notification Details</h1>

<div class="bg-white p-4 shadow rounded">

    <p class="mb-2">
        <strong>Message:</strong> {{ $notification->message }}
    </p>

    @if($notification->ticket)
        <p class="mb-2">
            <strong>Ticket:</strong> #{{ $notification->ticket->number }}
        </p>
    @endif

    <p class="text-gray-500 text-sm">
        {{ $notification->created_at }}
    </p>

</div>
@endsection