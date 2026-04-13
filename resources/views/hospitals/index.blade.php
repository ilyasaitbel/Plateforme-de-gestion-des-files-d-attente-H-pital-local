@extends('layouts.app')
@section('title', 'Hôpitaux')
@section('content')
<div class="page-header">
    <h1>🏥 Hôpitaux</h1>
    <a href="{{ route('hospitals.create') }}" class="btn btn-primary">+ Ajouter</a>
</div>
<div class="table-wrapper">
    <table>
        <thead>
            <tr><th>Nom</th><th>Adresse</th><th>Téléphone</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($hospitals as $hospital)
            <tr>
                <td><strong>{{ $hospital->name }}</strong></td>
                <td style="color:#666">{{ $hospital->address }}</td>
                <td style="color:#666">{{ $hospital->phone ?? '—' }}</td>
                <td style="display:flex;gap:8px">
                    <a href="{{ route('hospitals.show', $hospital) }}" class="btn btn-outline btn-sm">Voir</a>
                    <a href="{{ route('hospitals.edit', $hospital) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <form method="POST" action="{{ route('hospitals.destroy', $hospital) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">
                    <div class="empty-state">
                        <div class="empty-icon">🏥</div>
                        <p>Aucun hôpital enregistré</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection