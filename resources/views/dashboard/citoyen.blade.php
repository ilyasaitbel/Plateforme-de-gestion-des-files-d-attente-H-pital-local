@extends('layouts.app')

@section('title', 'Mon Espace - HôpitalFile')
@section('page-title', 'Mon Tableau de bord')

@section('content')
    <style>
        .section-icon-img {
            width: 22px;
            height: 22px;
            object-fit: contain;
            vertical-align: middle;
        }

        .button-icon-img {
            width: 18px;
            height: 18px;
            object-fit: contain;
        }

        .emoji-icon-img {
            width: 20px;
            height: 20px;
            object-fit: contain;
        }
    </style>

    <div class="card" style="margin-bottom: 1.5rem; padding: 1rem 1.25rem;">
        <div style="font-size: 1rem; color: #6c757d;">Citoyen connecté</div>
        <div style="font-size: 1.5rem; font-weight: 700; color: #1f2d3d;">{{ auth()->user()->name }}</div>
    </div>

    @if(isset($active_ticket))
        <!-- Active Ticket Card -->
        <div class="ticket-display" style="background: linear-gradient(135deg, #198754 0%, #157347 100%);">
            <div class="ticket-label">Mon Ticket Actif</div>
            <div class="ticket-number">{{ $active_ticket->number }}</div>
            <div style="font-size: 1.25rem; margin-top: 1rem;">
                {{ $active_ticket->queue->service->name }} - {{ $active_ticket->queue->service->hospital->name }}
            </div>
        </div>

        <!-- Ticket Status Info -->
        <div class="queue-info">
            <div class="info-item" style="border-left: 4px solid #0d6efd;">
                <div class="info-label">Tickets restants avant votre tour</div>
                <div class="info-value" style="font-size: 2rem; color: #0d6efd;">
                    {{ $queue_position ?? '---' }}
                </div>
                <div style="margin-top: 10px; color: #5b6b84; font-weight: 700;">
                    La file est arrivée au numéro :
                    <strong>#{{ $active_ticket->queue->current_number ?: '0' }}</strong>
                </div>
            </div>
            <div class="info-item" style="border-left: 4px solid #198754;">
                <div class="info-label">Statut</div>
                <div class="info-value">
                    @if($active_ticket->status === 'EN_ATTENTE')
                        <span class="badge badge-blue" style="font-size: 1rem;">EN ATTENTE</span>
                    @elseif($active_ticket->status === 'APPELE')
                        <span class="badge badge-orange" style="font-size: 1rem;">APPELÉ</span>
                    @endif
                </div>
            </div>
            <div class="info-item" style="border-left: 4px solid #6c757d;">
                <div class="info-label">Heure d'arrivée</div>
                <div class="info-value">{{ $active_ticket->created_at->format('H:i') }}</div>
            </div>
            <div class="info-item" style="border-left: 4px solid #dc3545;">
                <div class="info-label">Temps d'attente estimé</div>
                <div class="info-value">{{ $estimated_wait ?? '15 min' }}</div>
            </div>
        </div>

        @if($active_ticket->status === 'EN_ATTENTE')
            <div class="text-center mb-4">
                <form action="/tickets/{{ $active_ticket->id }}/cancel" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler ce ticket ?');">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-lg">
                        <img src="https://cdn-icons-png.flaticon.com/512/1828/1828843.png" alt="Annuler" class="button-icon-img">
                        <span>Annuler mon ticket</span>
                    </button>
                </form>
            </div>
        @endif
    @else
        <div class="card" style="text-align: center; padding: 3rem;">
            <div class="dashboard-icon-badge" style="margin: 0 auto 1rem;">
                <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" alt="Ticket">
            </div>
            <h3 style="margin-bottom: 1rem;">Aucun ticket actif</h3>
            <p style="color: #6c757d; margin-bottom: 1.5rem;">Prenez un ticket pour rejoindre une file d'attente</p>
            <a href="/tickets/create" class="btn btn-primary btn-lg">
                <span class="dashboard-icon-badge dashboard-icon-badge--sm">
                    <img src="https://cdn-icons-png.flaticon.com/512/992/992651.png" alt="Ajouter">
                </span>
                <span>Prendre un ticket</span>
            </a>
        </div>
    @endif

    <!-- History -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <img src="https://cdn-icons-png.flaticon.com/512/1828/1828817.png" alt="Historique" class="section-icon-img">
                Historique des tickets
            </h3>
        </div>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ticket_history ?? [] as $ticket)
                        <tr>
                            <td>{{ $ticket->number }}</td>
                            <td>{{ $ticket->queue->service->name }}</td>
                            <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($ticket->status === 'TERMINE')
                                    <span class="badge badge-green">Terminé</span>
                                @elseif($ticket->status === 'ANNULE')
                                    <span class="badge badge-red">Annulé</span>
                                @else
                                    <span class="badge badge-blue">{{ $ticket->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Aucun historique</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
