@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Create Agent</h1>

<form method="POST" action="{{ route('agents.store') }}"
      class="bg-white p-4 shadow rounded">
    @csrf

    <div class="mb-4">
        <label>User</label>
        <select name="user_id" class="w-full border p-2 rounded">
            @foreach($users as $user)
                <option value="{{ $user->id }}">
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label>Hospital</label>
        <select name="hospital_id" class="w-full border p-2 rounded">
            @foreach($hospitals as $hospital)
                <option value="{{ $hospital->id }}">
                    {{ $hospital->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button class="bg-green-500 text-white px-4 py-2 rounded">
        Save
    </button>

</form>

@endsection