@extends('layouts.app')

@section('title', 'Citoyens')

@section('content')
    <div class="card" style="margin-bottom: 24px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 45%, #93c5fd 100%); border: 1px solid rgba(37, 99, 235, 0.18); box-shadow: 0 24px 55px rgba(37, 99, 235, 0.16);">
        <div>
            <div class="card-title" style="font-size: 30px; margin-bottom: 8px;">Liste des citoyens</div>
            <p style="color: #365277; font-weight: 600;">Consultez les citoyens et le nombre de tickets associés.</p>
        </div>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Nombre de tickets</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($citoyens as $citoyen)
                        <tr>
                            <td>{{ $citoyen->user->name ?? 'Non renseigné' }}</td>
                            <td>{{ $citoyen->user->email ?? 'Non renseigné' }}</td>
                            <td>{{ $citoyen->tickets->count() ?? 0 }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; color: #6b7280;">
                                Aucun citoyen à afficher pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
