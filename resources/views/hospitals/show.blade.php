@extends('layouts.app')
@section('title', 'Hôpital')
@section('content')
<div class="page-header">
    <h1>🏥 {{ $hospital->name }}</h1>
    <a href="{{ route('hospitals.index') }}" class="btn btn-outline">← Retour</a>
</div>
<div class="card" style="max-width:600px">
    <div style="display:flex;flex-direction:column;gap:14px">
        <div>
            <p style="font-size:12px;color:#888;margin-bottom:4px">Nom</p>
            <p style="font-weight:600">{{ $hospital->name }}</p>
        </div>
        <div>
            <p style="font-size:12px;color:#888;margin-bottom:4px">Adresse</p>
            <p>{{ $hospital->address }}</p>
        </div>
        <div>
            <p style="font-size:12px;color:#888;margin-bottom:4px">Téléphone</p>
            <p>{{ $hospital->phone ?? '—' }}</p>
        </div>
        <div>
            <p style="font-size:12px;color:#888;margin-bottom:4px">Services</p>
            <span class="badge badge-info">{{ $hospital->services->count() }} services</span>
        </div>
    </div>
    <div class="form-actions" style="margin-top:20px">
        <a href="{{ route('hospitals.edit', $hospital) }}" class="btn btn-warning">✏️ Modifier</a>
        <form method="POST" action="{{ route('hospitals.destroy', $hospital) }}">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer ?')">🗑️ Supprimer</button>
        </form>
    </div>
</div>
@endsection