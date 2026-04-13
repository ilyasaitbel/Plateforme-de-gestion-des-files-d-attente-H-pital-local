@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Create Notification</h1>

<form method="POST" action="{{ route('notifications.store') }}"
      class="bg-white p-4 shadow rounded">
    @csrf

    <div class="mb-4">
        <label class="block mb-1">Message</label>

        <input type="text" name="message"
               class="w-full border p-2 rounded @error('message') border-red-500 @enderror">

        @error('message')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <button class="bg-green-500 text-white px-4 py-2 rounded">
        Save
    </button>
</form>
@endsection