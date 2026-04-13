@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Edit Agent</h1>

<form method="POST" action="{{ route('agents.update', $agent) }}"
      class="bg-white p-4 shadow rounded">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label>Hospital</label>
        <select name="hospital_id" class="w-full border p-2 rounded">
            @foreach($hospitals as $hospital)
                <option value="{{ $hospital->id }}"
                    {{ $agent->hospital_id == $hospital->id ? 'selected' : '' }}>
                    {{ $hospital->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button class="bg-blue-500 text-white px-4 py-2 rounded">
        Update
    </button>

</form>

@endsection