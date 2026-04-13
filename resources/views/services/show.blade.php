@extends('layouts.app')

@section('content')

<h2>{{ $service->name }}</h2>

<p>Hospital: {{ $service->hospital->name }}</p>

<p>{{ $service->description }}</p>

<a href="{{ route('services.index') }}">Back</a>

@endsection