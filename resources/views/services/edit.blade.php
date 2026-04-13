@extends('layouts.app')

@section('content')

<h2>Edit Service</h2>

<form method="POST" action="{{ route('services.update',$service->id) }}">
    @csrf
    @method('PUT')

    <select name="hospital_id">
        @foreach($hospitals as $hospital)
            <option value="{{ $hospital->id }}" 
                {{ $hospital->id == $service->hospital_id ? 'selected' : '' }}>
                {{ $hospital->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <input type="text" name="name" value="{{ $service->name }}">

    <br><br>

    <textarea name="description">{{ $service->description }}</textarea>

    <br><br>

    <button type="submit">Update</button>

</form>

@endsection