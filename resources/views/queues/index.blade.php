@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div>
            <h1>Files d'attente</h1>
            <p>Suivez l'état des files et gérez les appels en cours.</p>
        </div>

        @if(auth()->user()->isAdmin())
            <a href="{{ route('queues.create') }}" class="btn btn-primary">Ajouter une file</a>
        @endif
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Service</th>
                        <th>Statut</th>
                        <th>Numéro actuel</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($queues as $queue)
                        <tr>
                            <td>{{ $queue->name }}</td>
                            <td>{{ $queue->service->name ?? '—' }}</td>
                            <td>
                                <span class="badge">{{ $queue->status }}</span>
                            </td>
                            <td>{{ $queue->current_number }}</td>
                            <td>
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    @if(auth()->user()->isAgent())
                                        <form action="{{ route('queues.callNext', $queue->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-primary" title="Appeler le suivant" aria-label="Appeler le suivant">
                                                <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" alt="Appeler le suivant" style="width: 18px; height: 18px; object-fit: contain; filter: brightness(0) invert(1);">
                                            </button>
                                        </form>
                                    @endif

                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('queues.edit', $queue->id) }}" class="btn btn-warning">Modifier</a>

                                        <form action="{{ route('queues.destroy', $queue->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">Aucune file d'attente disponible.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
