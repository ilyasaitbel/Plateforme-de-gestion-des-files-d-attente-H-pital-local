@extends('layouts.app')

@section('title', 'Mon Espace - HôpitalFile')
@section('page-title', 'Mon Tableau de bord')

@section('content')
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
                <div class="info-label">Position dans la file</div>
                <div class="info-value" style="font-size: 2rem; color: #0d6efd;">
                    #{{ $queue_position ?? '---' }}
                </div>
            </div>
            <div class="info-item" style="border-left: 4px solid #198754;">
                <div class="info-label">Statut</div>
                <div class="info-value">
                    @if($active_ticket->status === 'EN_ATTENTE')
                        <span class="badge badge-blue" style="font-size: 1rem;">EN ATTENTE</span>
                    @elseif($active_ticket->status === 'APPELE')
                        <span class="badge badge-orange" style="font-size: 1rem;">APPELÉ</span>
                    @elseif($active_ticket->status === 'EN_COURS')
                        <span class="badge badge-yellow" style="font-size: 1rem;">EN COURS</span>
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
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-lg">
                        <span>❌</span>
                        <span>Annuler mon ticket</span>
                    </button>
                </form>
            </div>
        @endif
    @else
        <div class="card" style="text-align: center; padding: 3rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">🎫</div>
            <h3 style="margin-bottom: 1rem;">Aucun ticket actif</h3>
            <p style="color: #6c757d; margin-bottom: 1.5rem;">Prenez un ticket pour rejoindre une file d'attente</p>
            <a href="/tickets/create" class="btn btn-primary btn-lg">
                <span>➕</span>
                <span>Prendre un ticket</span>
            </a>
        </div>
    @endif

    <!-- My Appointments -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">📅 Mes Rendez-vous</h3>
        </div>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Service</th>
                        <th>Hôpital</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments ?? [] as $appointment)
                        <tr>
                            <td>{{ $appointment->date->format('d/m/Y H:i') }}</td>
                            <td>{{ $appointment->service->name }}</td>
                            <td>{{ $appointment->service->hospital->name }}</td>
                            <td>
                                @if($appointment->status === 'CONFIRME')
                                    <span class="badge badge-green">Confirmé</span>
                                @elseif($appointment->status === 'EN_ATTENTE')
                                    <span class="badge badge-blue">En attente</span>
                                @else
                                    <span class="badge badge-red">Annulé</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Aucun rendez-vous programmé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- History -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">🕐 Historique des tickets</h3>
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