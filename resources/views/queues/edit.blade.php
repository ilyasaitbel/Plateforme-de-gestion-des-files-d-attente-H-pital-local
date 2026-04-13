@extends('layouts.app')

@section('content')

<h2>Edit Queue</h2>

<form method="POST" action="{{ route('queues.update',$queue->id) }}">
    @csrf
    @method('PUT')

    <select name="service_id">
        @foreach($services as $service)
            <option value="{{ $service->id }}"
                {{ $service->id == $queue->service_id ? 'selected' : '' }}>
                {{ $service->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <input type="text" name="name" value="{{ $queue->name }}">

    <br><br>

    <select name="status">
        <option value="OPEN">OPEN</option>
        <option value="CLOSED">CLOSED</option>
        <option value="PAUSED">PAUSED</option>
    </select>

    <br><br>

    <button type="submit">Update</button>

</form>

@endsection