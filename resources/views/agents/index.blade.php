@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Agents</h1>

<a href="{{ route('agents.create') }}"
   class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
    + Add Agent
</a>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-2">Name</th>
            <th class="p-2">Email</th>
            <th class="p-2">Hospital</th>
            <th class="p-2">Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($agents as $agent)
            <tr class="border-t">
                <td class="p-2">{{ $agent->user->name }}</td>
                <td class="p-2">{{ $agent->user->email }}</td>
                <td class="p-2">{{ $agent->hospital->name }}</td>

                <td class="p-2 space-x-2">

                    <a href="{{ route('agents.show', $agent) }}"
                       class="text-blue-500">View</a>

                    <a href="{{ route('agents.edit', $agent) }}"
                       class="text-yellow-500">Edit</a>

                    <form method="POST"
                          action="{{ route('agents.destroy', $agent) }}"
                          class="inline">
                        @csrf
                        @method('DELETE')

                        <button onclick="return confirm('Delete?')"
                                class="text-red-500">
                            Delete
                        </button>
                    </form>

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center p-4 text-gray-500">
                    No agents found
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection