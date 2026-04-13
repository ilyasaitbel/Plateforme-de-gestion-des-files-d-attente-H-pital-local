@extends('layouts.app')

@section('content')

<h2>Tickets</h2>

<a href="{{ route('tickets.create') }}">Créer Ticket</a>

<table border="1" cellpadding="10">
    <tr>
        <th>Number</th>
        <th>Status</th>
        <th>Queue</th>
        <th>Actions</th>
    </tr>

    @foreach($tickets as $ticket)
        <tr>
            <td>{{ $ticket->number }}</td>
            <td>{{ $ticket->status }}</td>
            <td>{{ $ticket->queue->name ?? '' }}</td>
            <td>
                <a href="{{ route('tickets.show',$ticket->id) }}">View</a>

                <form action="{{ route('tickets.destroy',$ticket->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>

                <form action="{{ route('tickets.cancel',$ticket->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Cancel</button>
                </form>
            </td>
        </tr>
    @endforeach

</table>

@endsection