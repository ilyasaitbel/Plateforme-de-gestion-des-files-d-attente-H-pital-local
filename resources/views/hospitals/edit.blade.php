@extends('layouts.app')
@section('title', 'Modifier hôpital')
@section('content')
<div class="page-header">
    <h1>✏️ Modifier : {{ $hospital->name }}</h1>
    <a href="{{ route('hospitals.index') }}" class="btn btn-outline">← Retour</a>
</div>
<div class="card" style="max-width:600px">
    <form method="POST" action="{{ route('hospitals.update', $hospital) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Nom de l'hôpital</label>
            <input type="text" name="name" value="{{ old('name', $hospital->name) }}" required>
        </div>
        <div class="form-group">
            <label>Adresse</label>
            <input type="text" name="address" value="{{ old('address', $hospital->address) }}" required>
        </div>
        <div class="form-group">
            <label>Téléphone</label>
            <input type="text" name="phone" value="{{ old('phone', $hospital->phone) }}">
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-warning">💾 Modifier</button>
            <a href="{{ route('hospitals.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection