@extends('layouts.app')

@section('content')

<h2>Créer Ticket</h2>

<form method="POST" action="{{ route('tickets.store') }}">
    @csrf

    <select name="queue_id">
        @foreach($queues as $queue)
            <option value="{{ $queue->id }}">{{ $queue->name }}</option>
        @endforeach
    </select>

    <br><br>

    <select name="citoyen_id">
        @foreach($citoyens as $citoyen)
            <option value="{{ $citoyen->id }}">{{ $citoyen->user->name }}</option>
        @endforeach
    </select>

    <br><br>

    <button type="submit">Créer</button>

</form>

@endsection