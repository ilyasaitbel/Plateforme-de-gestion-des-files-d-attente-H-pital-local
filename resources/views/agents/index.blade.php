@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div>
            <h1>Les agents de {{ auth()->user()->administrator->hospital->name ?? 'l’hôpital' }}</h1>
            <p>Consultez et gérez les agents affectés à cet hôpital.</p>
        </div>

        <a href="{{ route('agents.create') }}" class="btn btn-primary">Ajouter un agent</a>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Hôpital</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($agents as $agent)
                        <tr>
                            <td>{{ $agent->user->name ?? '—' }}</td>
                            <td>{{ $agent->user->email ?? '—' }}</td>
                            <td>{{ $agent->queue->service->hospital->name ?? '—' }}</td>
                            <td>
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    <a href="{{ route('agents.edit', $agent) }}" class="btn btn-warning">Modifier</a>

                                    <form method="POST" action="{{ route('agents.destroy', $agent) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Delete?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">Aucun agent trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
