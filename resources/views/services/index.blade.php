@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div>
            <h1>Services</h1>
            <p>Gérez les services disponibles par hôpital.</p>
        </div>

        <a href="{{ route('services.create') }}" class="btn btn-primary">Ajouter un service</a>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Hôpital</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td>{{ $service->name }}</td>
                            <td>{{ $service->hospital->name ?? '—' }}</td>
                            <td>
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    <a href="{{ route('services.edit', $service->id) }}" class="btn btn-warning">Modifier</a>

                                    <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center;">Aucun service disponible pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
