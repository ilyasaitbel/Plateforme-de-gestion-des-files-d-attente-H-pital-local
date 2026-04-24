@extends('layouts.app')

@section('title', 'Gestion des citoyens')

@section('content')
    <div class="page-header" style="display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
        <div>
            <h1>Les citoyens</h1>
            <p>Consultez et gérez les citoyens enregistrés dans la plateforme.</p>
        </div>

        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <span class="badge badge-blue">{{ $citoyens->count() }} citoyen(s)</span>

            @if(!auth()->user()->isAdmin())
                <a href="{{ route('citoyens.create') }}" class="btn btn-primary">Ajouter un citoyen</a>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Tickets</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($citoyens as $citoyen)
                        <tr>
                            <td>{{ $citoyen->user->name ?? '—' }}</td>
                            <td>{{ $citoyen->user->email ?? '—' }}</td>
                            <td>{{ $citoyen->tickets->count() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center;">Aucun citoyen trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
