@extends('layouts.app')

@section('title', 'Tableau de bord Agent - HôpitalFile')
@section('page-title', 'Tableau de bord Agent')

@section('content')
    <style>
        .agent-dashboard {
            display: grid;
            gap: 24px;
            width: 100%;
        }

        .agent-hero {
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) minmax(320px, 0.9fr);
            gap: 24px;
            align-items: stretch;
        }

        .agent-hero-card {
            padding: 32px;
            border-radius: 32px;
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            color: #fff;
            box-shadow: var(--shadow-card);
            min-height: 260px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .agent-hero-card__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            font-weight: 800;
            opacity: 0.88;
            margin-bottom: 14px;
        }

        .agent-hero-card__title {
            font-size: clamp(32px, 5vw, 54px);
            font-weight: 900;
            line-height: 1;
            letter-spacing: -0.06em;
            margin-bottom: 14px;
        }

        .agent-hero-card__subtitle {
            font-size: 16px;
            line-height: 1.8;
            color: rgba(239, 246, 255, 0.92);
            max-width: 680px;
        }

        .agent-hero-card__meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 24px;
        }

        .agent-chip {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.16);
            font-size: 13px;
            font-weight: 800;
        }

        .agent-current-card {
            padding: 28px;
            border-radius: 32px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(239, 249, 255, 0.94));
            border: 1px solid rgba(125, 211, 252, 0.35);
            box-shadow: var(--shadow-soft);
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }

        .agent-current-card__label {
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--text-soft);
            margin-bottom: 12px;
        }

        .agent-current-card__number {
            font-size: clamp(48px, 7vw, 86px);
            line-height: 1;
            font-weight: 900;
            letter-spacing: -0.08em;
            color: var(--text-main);
        }

        .agent-current-card__name {
            margin-top: 16px;
            font-size: 18px;
            font-weight: 700;
            color: var(--text-soft);
        }

        .agent-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
        }

        .agent-stat-card {
            padding: 22px;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(125, 177, 255, 0.18);
            box-shadow: var(--shadow-soft);
        }

        .agent-stat-card__label {
            font-size: 13px;
            color: var(--text-soft);
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 800;
        }

        .agent-stat-card__value {
            font-size: 30px;
            font-weight: 900;
            letter-spacing: -0.05em;
            color: var(--text-main);
        }

        .agent-stat-card__hint {
            margin-top: 8px;
            color: var(--text-faint);
            font-size: 13px;
            line-height: 1.6;
        }

        .agent-actions-panel {
            padding: 26px;
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(125, 177, 255, 0.18);
            box-shadow: var(--shadow-soft);
        }

        .agent-actions-panel__header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            margin-bottom: 20px;
        }

        .agent-actions-panel__title {
            font-size: 24px;
            font-weight: 900;
            letter-spacing: -0.04em;
        }

        .agent-actions-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .agent-action-form {
            width: 100%;
        }

        .agent-action-btn {
            width: 100%;
            min-height: 74px;
            border-radius: 22px;
            font-size: 15px;
        }

        .agent-action-btn[disabled] {
            opacity: 0.55;
            cursor: not-allowed;
            transform: none;
        }

        .agent-status-banner {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .agent-status-banner--open {
            color: #047857;
            background: #d1fae5;
        }

        .agent-status-banner--closed {
            color: #be123c;
            background: #ffe4e6;
        }

        .agent-waiting-card {
            padding: 24px;
            border-radius: 28px;
        }

        .agent-empty-note {
            padding: 22px;
            text-align: center;
            border-radius: 22px;
            background: rgba(239, 249, 255, 0.8);
            color: var(--text-soft);
            font-weight: 700;
        }

        .agent-waiting-ticket {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 56px;
            padding: 10px 14px;
            border-radius: 16px;
            background: #eff6ff;
            color: #1d4ed8;
            font-weight: 900;
        }

        @media (max-width: 1180px) {
            .agent-hero,
            .agent-actions-grid,
            .agent-stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 860px) {
            .agent-hero,
            .agent-actions-grid,
            .agent-stats-grid {
                grid-template-columns: 1fr;
            }

            .agent-actions-panel__header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    @if ($errors->any())
        <div class="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if(isset($current_queue) && $current_queue)
        <div class="agent-dashboard">
            <section class="agent-hero">
                <div class="agent-hero-card">
                    <div>
                        <div class="agent-hero-card__eyebrow">Espace agent · gestion de la file</div>
                        <div class="agent-hero-card__title">{{ $current_queue->name }}</div>
                        <div class="agent-hero-card__subtitle">
                            Service {{ $current_queue->service->name }} ·
                            {{ $current_queue->service->hospital->name ?? 'Hôpital non défini' }}.
                        </div>
                    </div>

                    <div class="agent-hero-card__meta">
                        <span class="agent-chip">Statut : {{ $current_queue->status === 'OPEN' ? 'Ouverte' : 'Fermée' }}</span>
                        <span class="agent-chip">En attente : {{ $waiting_count }}</span>
                        <span class="agent-chip">Aujourd’hui : {{ $total_today }}</span>
                    </div>
                </div>

                <div class="agent-current-card">
                    <div class="agent-current-card__label">Numéro en cours</div>
                    <div class="agent-current-card__number">{{ $current_ticket->number ?? ($current_queue->current_number ?: '---') }}</div>
                    <div class="agent-current-card__name">
                        {{ $current_ticket->citoyen->user->name ?? 'Aucun ticket en cours' }}
                    </div>
                </div>
            </section>

            <section class="agent-stats-grid">
                <article class="agent-stat-card">
                    <div class="agent-stat-card__label">Statut de la file</div>
                    <div class="agent-stat-card__value">{{ $current_queue->status === 'OPEN' ? 'Ouverte' : 'Fermée' }}</div>
                    <div class="agent-stat-card__hint">Les citoyens ne peuvent prendre un ticket que quand la file est ouverte.</div>
                </article>

                <article class="agent-stat-card">
                    <div class="agent-stat-card__label">Numéro actuel</div>
                    <div class="agent-stat-card__value">{{ $current_ticket->number ?? ($current_queue->current_number ?: '0') }}</div>
                    <div class="agent-stat-card__hint">Dernier ticket appelé par l’agent.</div>
                </article>

                <article class="agent-stat-card">
                    <div class="agent-stat-card__label">Tickets en attente</div>
                    <div class="agent-stat-card__value">{{ $waiting_count }}</div>
                    <div class="agent-stat-card__hint">Nombre de citoyens encore dans la file.</div>
                </article>

                <article class="agent-stat-card">
                    <div class="agent-stat-card__label">Total aujourd’hui</div>
                    <div class="agent-stat-card__value">{{ $total_today }}</div>
                    <div class="agent-stat-card__hint">Tickets enregistrés aujourd’hui pour cette file.</div>
                </article>
            </section>

            <section class="agent-actions-panel">
                <div class="agent-actions-panel__header">
                    <div>
                        <div class="agent-actions-panel__title">Actions rapides</div>
                        <p style="margin-top: 8px; color: var(--text-soft); line-height: 1.7;">
                            Ouvrez ou fermez la file, puis appelez le prochain ticket directement depuis le dashboard.
                        </p>
                    </div>

                    <span class="agent-status-banner {{ $current_queue->status === 'OPEN' ? 'agent-status-banner--open' : 'agent-status-banner--closed' }}">
                        {{ $current_queue->status === 'OPEN' ? 'File ouverte' : 'File fermée' }}
                    </span>
                </div>

                <div class="agent-actions-grid">
                    <form action="{{ route('queues.open', $current_queue) }}" method="POST" class="agent-action-form">
                        @csrf
                        <button type="submit" class="btn btn-success agent-action-btn" {{ $current_queue->status === 'OPEN' ? 'disabled' : '' }}>
                            Open Queue
                        </button>
                    </form>

                    <form action="{{ route('queues.close', $current_queue) }}" method="POST" class="agent-action-form">
                        @csrf
                        <button type="submit" class="btn btn-danger agent-action-btn" {{ $current_queue->status !== 'OPEN' ? 'disabled' : '' }}>
                            Close Queue
                        </button>
                    </form>

                    <form action="{{ route('queues.callNext', $current_queue) }}" method="POST" class="agent-action-form">
                        @csrf
                        <button type="submit" class="btn btn-primary agent-action-btn" {{ $current_queue->status !== 'OPEN' || $waiting_count < 1 ? 'disabled' : '' }}>
                            Appeler le suivant
                        </button>
                    </form>
                </div>
            </section>

            <section class="card agent-waiting-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <span class="dashboard-icon-badge dashboard-icon-badge--sm">
                            <img src="https://cdn-icons-png.flaticon.com/512/2921/2921222.png" alt="Tickets en attente">
                        </span>
                        Tickets en attente
                    </h3>
                </div>

                @if(($waiting_tickets ?? collect())->count())
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Numéro</th>
                                    <th>Citoyen</th>
                                    <th>Heure d'arrivée</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($waiting_tickets as $ticket)
                                    <tr>
                                        <td><span class="agent-waiting-ticket">#{{ $ticket->number }}</span></td>
                                        <td>{{ $ticket->citoyen->user->name }}</td>
                                        <td>{{ $ticket->created_at->format('H:i') }}</td>
                                        <td><span class="badge badge-blue">EN ATTENTE</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="agent-empty-note">
                        Aucun ticket en attente pour le moment.
                    </div>
                @endif
            </section>
        </div>
    @else
        <div class="card">
            <div class="empty-state">
                <div class="dashboard-icon-badge" style="margin-bottom: 8px;">
                    <img src="https://cdn-icons-png.flaticon.com/512/2921/2921222.png" alt="Aucune file">
                </div>
                <h3 style="font-size: 24px; font-weight: 900;">Aucune file assignée</h3>
                <p style="max-width: 560px; color: var(--text-soft); line-height: 1.8;">
                    Aucun agent n’est encore lié à une file d’attente. Demandez à l’administrateur de vous assigner une file pour commencer à appeler les tickets.
                </p>
            </div>
        </div>
    @endif
@endsection
