@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Agent Details</h1>

<div class="bg-white p-4 shadow rounded">

    <p><strong>Name:</strong> {{ $agent->user->name }}</p>
    <p><strong>Email:</strong> {{ $agent->user->email }}</p>
    <p><strong>Hospital:</strong> {{ $agent->hospital->name }}</p>

</div>

@endsection