@extends('layouts.app')
@section('title', 'Hôpitaux')
@section('content')
<style>
    .hospital-index-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
    }

    .hospital-index-title {
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .emoji-icon-img,
    .section-icon-img,
    .button-icon-img {
        width: 18px;
        height: 18px;
        object-fit: contain;
        vertical-align: middle;
        flex-shrink: 0;
    }

    .hospital-index-title .section-icon-img,
    .empty-icon .section-icon-img {
        width: 24px;
        height: 24px;
    }

    .hospital-index-header .btn,
    td .btn,
    td form button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        padding: 18px 0;
    }

    .empty-icon {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(14, 165, 233, 0.12);
    }
</style>

<div class="page-header hospital-index-header">
    <h1 class="hospital-index-title">
        <img src="https://cdn-icons-png.flaticon.com/512/2967/2967350.png" alt="" class="section-icon-img">
        <span>Hôpitaux</span>
    </h1>
    <a href="{{ route('hospitals.create') }}" class="btn btn-primary">
        <img src="https://cdn-icons-png.flaticon.com/512/992/992651.png" alt="" class="button-icon-img">
        <span>Ajouter</span>
    </a>
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
                        <div class="empty-icon">
                            <img src="https://cdn-icons-png.flaticon.com/512/2967/2967350.png" alt="" class="section-icon-img">
                        </div>
                        <p>Aucun hôpital enregistré</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection