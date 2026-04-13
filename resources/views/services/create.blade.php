@extends('layouts.app')

@section('content')

<h2>Ajouter Service</h2>

<form method="POST" action="{{ route('services.store') }}">
    @csrf

    <select name="hospital_id">
        @foreach($hospitals as $hospital)
            <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
        @endforeach
    </select>

    <br><br>

    <input type="text" name="name" placeholder="Service name">

    <br><br>

    <textarea name="description" placeholder="Description"></textarea>

    <br><br>

    <button type="submit">Ajouter</button>

</form>

@endsection