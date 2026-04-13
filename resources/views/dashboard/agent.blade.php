@extends('layouts.app')

@section('title', 'Tableau de bord Agent - HôpitalFile')
@section('page-title', 'Tableau de bord Agent')

@section('content')
    @if(isset($current_queue))
        <!-- Current Ticket Display -->
        <div class="ticket-display">
            <div class="ticket-label">Ticket en cours</div>
            <div class="ticket-number">{{ $current_ticket->number ?? '---' }}</div>
            <div style="font-size: 1.5rem; margin-top: 1rem;">
                {{ $current_ticket->citoyen->user->name ?? 'Aucun ticket en cours' }}
            </div>
        </div>

        <!-- Queue Info -->
        <div class="queue-info">
            <div class="info-item">
                <div class="info-label">File d'attente</div>
                <div class="info-value">{{ $current_queue->name }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Service</div>
                <div class="info-value">{{ $current_queue->service->name }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Tickets en attente</div>
                <div class="info-value">{{ $waiting_count ?? 0 }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Total aujourd'hui</div>
                <div class="info-value">{{ $total_today ?? 0 }}</div>
            </div>
        </div>

        <!-- Call Next Button -->
        <div class="text-center mb-4">
            <form action="/queues/{{ $current_queue->id }}/call-next" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-success btn-lg" style="font-size: 1.25rem; padding: 1.25rem 3rem;">
                    <span>🔊</span>
                    <span>Appeler le suivant</span>
                </button>
            </form>
        </div>

        <!-- Waiting Tickets -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">📋 Tickets en attente</h3>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>N° Ticket</th>
                            <th>Citoyen</th>
                            <th>Heure d'arrivée</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($waiting_tickets ?? [] as $ticket)
                            <tr>
                                <td><strong>{{ $ticket->number }}</strong></td>
                                <td>{{ $ticket->citoyen->user->name }}</td>
                                <td>{{ $ticket->created_at->format('H:i') }}</td>
                                <td><span class="badge badge-blue">EN_ATTENTE</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Aucun ticket en attente</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Active Queues List -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">📋 Mes Files d'attente actives</h3>
            </div>
            @if(isset($queues) && count($queues) > 0)
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Service</th>
                                <th>Hôpital</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($queues as $queue)
                                <tr>
                                    <td><strong>{{ $queue->name }}</strong></td>
                                    <td>{{ $queue->service->name }}</td>
                                    <td>{{ $queue->service->hospital->name }}</td>
                                    <td>
                                        @if($queue->status === 'OPEN')
                                            <span class="badge badge-green">OUVERTE</span>
                                        @elseif($queue->status === 'PAUSED')
                                            <span class="badge badge-orange">PAUSE</span>
                                        @else
                                            <span class="badge badge-red">FERMÉE</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="/queues/{{ $queue->id }}" class="btn btn-primary btn-sm">
                                            <span>▶️</span>
                                            <span>Gérer</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📋</div>
                    <p>Aucune file d'attente assignée</p>
                </div>
            @endif
        </div>
    @endif
@endsection