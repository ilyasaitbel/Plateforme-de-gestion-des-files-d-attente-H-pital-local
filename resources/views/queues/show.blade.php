@extends('layouts.app')

@section('content')

<h2>{{ $queue->name }}</h2>

<p>Status: {{ $queue->status }}</p>
<p>Current number: {{ $queue->current_number }}</p>

<a href="{{ route('queues.index') }}">Back</a>

@endsection