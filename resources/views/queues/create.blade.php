@extends('layouts.app')

@section('content')

<h2>Créer Queue</h2>

<form method="POST" action="{{ route('queues.store') }}">
    @csrf

    <select name="service_id">
        @foreach($services as $service)
            <option value="{{ $service->id }}">{{ $service->name }}</option>
        @endforeach
    </select>

    <br><br>

    <input type="text" name="name" placeholder="Queue name">

    <br><br>

    <button type="submit">Créer</button>

</form>

@endsection