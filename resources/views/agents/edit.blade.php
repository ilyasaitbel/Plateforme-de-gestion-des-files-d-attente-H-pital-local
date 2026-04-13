@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Edit Agent</h1>

<form method="POST" action="{{ route('agents.update', $agent) }}"
      class="bg-white p-4 shadow rounded">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label for="queue_id">Queue</label>
        <select id="queue_id" name="queue_id" class="w-full border p-2 rounded">
            @foreach($queues as $queue)
                <option value="{{ $queue->id }}"
                    {{ old('queue_id', $agent->queue_id) == $queue->id ? 'selected' : '' }}>
                    {{ $queue->name }} — {{ $queue->service->name }} ({{ $queue->service->hospital->name }})
                </option>
            @endforeach
        </select>
    </div>

    <button class="bg-blue-500 text-white px-4 py-2 rounded">
        Update
    </button>

</form>

@endsection