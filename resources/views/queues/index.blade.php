@extends('layouts.app')

@section('content')

<h2>Files d'attente</h2>

@if(auth()->user()->isAdmin())
    <a href="{{ route('queues.create') }}">Ajouter Queue</a>
@endif

<table border="1" cellpadding="10">
    <tr>
        <th>Nom</th>
        <th>Service</th>
        <th>Status</th>
        <th>Numéro actuel</th>
        <th>Actions</th>
    </tr>

    @foreach($queues as $queue)
        <tr>
            <td>{{ $queue->name }}</td>
            <td>{{ $queue->service->name ?? '' }}</td>
            <td>{{ $queue->status }}</td>
            <td>{{ $queue->current_number }}</td>
            <td>

                <form action="{{ route('queues.callNext',$queue->id) }}" method="POST">
                    @csrf
                    <button type="submit">Call Next</button>
                </form>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('queues.edit',$queue->id) }}">Edit</a>

                    <form action="{{ route('queues.destroy',$queue->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                @endif

            </td>
        </tr>
    @endforeach

</table>

@endsection