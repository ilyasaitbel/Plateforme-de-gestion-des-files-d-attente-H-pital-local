@extends('layouts.app')

@section('title', 'Tickets')

@section('content')
<div class="page-header">
    <div>
        <h1>Tickets</h1>
        <p style="color: var(--text-soft); margin-top: 6px;">Consultez et gérez les tickets disponibles selon votre rôle.</p>
    </div>

    <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
        <form method="GET" action="{{ route('tickets.index') }}" style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; background: rgba(255, 255, 255, 0.85); border: 1px solid rgba(37, 99, 235, 0.18); border-radius: 18px; box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);">
                <span style="font-size: 13px; font-weight: 700; color: #365277; letter-spacing: 0.02em;">Filtrer par statut</span>
                <select name="status" onchange="this.form.submit()" style="min-width: 210px; margin-top: 0; border-radius: 14px; border: 1px solid rgba(37, 99, 235, 0.22); background: linear-gradient(135deg, #ffffff 0%, #eff6ff 100%); box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9), 0 6px 18px rgba(37, 99, 235, 0.08); font-weight: 600;">
                    <option value="">Tous les statuts</option>
                    @foreach($statuses as $statusValue => $statusLabel)
                        <option value="{{ $statusValue }}" {{ $status === $statusValue ? 'selected' : '' }}>
                            {{ $statusLabel }}
                        </option>
                    @endforeach
                </select>
            </div>

        </form>

        @if(!auth()->user()->isAdmin())
            <a href="{{ route('tickets.create') }}" class="btn btn-primary">
                <span class="dashboard-icon-badge dashboard-icon-badge--sm">
                    <img src="https://cdn-icons-png.flaticon.com/512/992/992651.png" alt="Créer">
                </span>
                <span>Créer Ticket</span>
            </a>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <span class="dashboard-icon-badge dashboard-icon-badge--sm">
                <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" alt="Tickets">
            </span>
            Liste des tickets
        </h3>
        <span class="badge badge-blue">{{ $tickets->count() }} ticket(s)</span>
    </div>

    @if($tickets->isEmpty())
        <div class="empty-state">
            <div class="dashboard-icon-badge">
                <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" alt="Aucun ticket">
            </div>
            <h3 style="color: var(--text-main);">Aucun ticket trouvé</h3>
            <p>Si tu as déjà créé un ticket, il apparaîtra ici automatiquement.</p>
        </div>
    @else
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Numéro</th>
                        <th>Statut</th>
                        <th>File</th>
                        <th>Service / Hôpital</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr>
                            <td><strong>#{{ $ticket->number }}</strong></td>
                            <td>
                                @if($ticket->status === 'EN_ATTENTE')
                                    <span class="badge badge-blue">En attente</span>
                                @elseif($ticket->status === 'APPELE')
                                    <span class="badge badge-orange">Appelé</span>
                                @elseif($ticket->status === 'EN_COURS')
                                    <span class="badge badge-yellow">En cours</span>
                                @elseif($ticket->status === 'TERMINE')
                                    <span class="badge badge-green">Terminé</span>
                                @elseif($ticket->status === 'ANNULE')
                                    <span class="badge badge-red">Annulé</span>
                                @else
                                    <span class="badge badge-blue">{{ $ticket->status }}</span>
                                @endif
                            </td>
                            <td>{{ $ticket->queue->name ?? '—' }}</td>
                            <td>
                                {{ $ticket->queue->service->name ?? '—' }}
                                @if(optional($ticket->queue->service->hospital)->name)
                                    <div style="font-size: 12px; color: var(--text-faint); margin-top: 4px;">
                                        {{ $ticket->queue->service->hospital->name }}
                                    </div>
                                @endif
                            </td>
                            <td style="white-space: nowrap;">
                                @if(auth()->user()->isAgent() && $ticket->status !== 'ANNULE' && $ticket->status !== 'TERMINE')
                                    <form action="{{ route('tickets.cancel', $ticket->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">Annuler</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
