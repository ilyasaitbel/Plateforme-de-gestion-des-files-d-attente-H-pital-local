@extends('layouts.app')

@section('content')

<h2>Ticket #{{ $ticket->number }}</h2>

<p>Status: {{ $ticket->status }}</p>
<p>Queue: {{ $ticket->queue->name }}</p>

<a href="{{ route('tickets.index') }}">Back</a>

@endsection