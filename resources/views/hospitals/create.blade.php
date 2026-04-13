@extends('layouts.app')
@section('title', 'Ajouter un hôpital')
@section('content')
<div class="page-header">
    <h1>🏥 Ajouter un hôpital</h1>
    <a href="{{ route('hospitals.index') }}" class="btn btn-outline">← Retour</a>
</div>
<div class="card" style="max-width:600px">
    <form method="POST" action="{{ route('hospitals.store') }}">
        @csrf
        <div class="form-group">
            <label>Nom de l'hôpital</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Ex: Hôpital Ibn Sina" required>
        </div>
        <div class="form-group">
            <label>Adresse</label>
            <input type="text" name="address" value="{{ old('address') }}" placeholder="Adresse complète" required>
        </div>
        <div class="form-group">
            <label>Téléphone</label>
            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+212 6xx xxx xxx">
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
            <a href="{{ route('hospitals.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection