@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
.admin-dashboard {
    display: grid;
    gap: 28px;
}


.admin-actions-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 22px;
}

.admin-action-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    text-decoration: none;
    padding: 22px;
    border-radius: 24px;
    background: linear-gradient(180deg, #ffffff, #f8fbff);
    border: 1px solid rgba(37, 99, 235, 0.1);
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
    transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
}

.admin-action-card:hover {
    transform: translateY(-6px);
    border-color: rgba(37, 99, 235, 0.22);
    box-shadow: 0 24px 48px rgba(37, 99, 235, 0.14);
}

.admin-action-card h3 {
    font-size: 18px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 6px;
}

.admin-action-card p {
    color: #64748b;
    font-size: 14px;
    line-height: 1.6;
}

.admin-stats-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 22px;
}

.admin-stat-card {
    position: relative;
    overflow: hidden;
    padding: 24px;
    border-radius: 26px;
    background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
    border: 1px solid rgba(37, 99, 235, 0.1);
    box-shadow: 0 18px 36px rgba(15, 23, 42, 0.08);
    transition: transform 0.22s ease, box-shadow 0.22s ease;
}

.admin-stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 26px 46px rgba(37, 99, 235, 0.14);
}

.admin-stat-card::after {
    content: "";
    position: absolute;
    width: 120px;
    height: 120px;
    right: -36px;
    bottom: -46px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(96, 165, 250, 0.16), transparent 70%);
}

.admin-stat-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    margin-bottom: 18px;
}

.admin-stat-title {
    font-size: 13px;
    font-weight: 800;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.12em;
}

.admin-stat-value {
    font-size: 44px;
    font-weight: 900;
    line-height: 1;
    letter-spacing: -0.05em;
    color: #0f172a;
    margin-bottom: 10px;
}

.admin-stat-text {
    color: #64748b;
    font-size: 14px;
    line-height: 1.6;
}

.dashboard-icon-badge {
    box-shadow: 0 10px 22px rgba(59, 130, 246, 0.18);
}

@media (max-width: 1200px) {
    .admin-stats-grid,
    .admin-actions-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .admin-actions-grid,
    .admin-stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="admin-dashboard">
    <section class="admin-actions-grid">
        <a href="{{ route('agents.create') }}" class="admin-action-card">
            <div>
                <h3>Ajouter un agent</h3>
                <p>Créer rapidement un nouveau compte agent pour l’hôpital.</p>
            </div>
            <span class="dashboard-icon-badge">
                <img src="https://cdn-icons-png.flaticon.com/512/992/992651.png" alt="Ajouter agent">
            </span>
        </a>

        <a href="{{ route('services.create') }}" class="admin-action-card">
            <div>
                <h3>Ajouter un service</h3>
                <p>Créer un nouveau service et organiser les files d’attente.</p>
            </div>
            <span class="dashboard-icon-badge">
                <img src="https://cdn-icons-png.flaticon.com/512/1828/1828919.png" alt="Ajouter service">
            </span>
        </a>

        <a href="{{ route('queues.create') }}" class="admin-action-card">
            <div>
                <h3>Créer une file</h3>
                <p>Ajouter une file d’attente pour mieux gérer les patients.</p>
            </div>
            <span class="dashboard-icon-badge">
                <img src="https://cdn-icons-png.flaticon.com/512/2921/2921222.png" alt="Créer file">
            </span>
        </a>
    </section>

    <section class="admin-stats-grid">
        <article class="admin-stat-card">
            <div class="admin-stat-top">
                <span class="admin-stat-title">Services</span>
                <span class="dashboard-icon-badge dashboard-icon-badge--sm">
                    <img src="https://cdn-icons-png.flaticon.com/512/4320/4320371.png" alt="Services">
                </span>
            </div>
            <div class="admin-stat-value">{{ $services_count }}</div>
            <div class="admin-stat-text">Services actifs dans l’établissement</div>
        </article>

        <article class="admin-stat-card">
            <div class="admin-stat-top">
                <span class="admin-stat-title">Agents</span>
                <span class="dashboard-icon-badge dashboard-icon-badge--sm">
                    <img src="https://cdn-icons-png.flaticon.com/512/3774/3774299.png" alt="Agents">
                </span>
            </div>
            <div class="admin-stat-value">{{ $agents_count }}</div>
            <div class="admin-stat-text">Agents disponibles pour gérer les files</div>
        </article>

        <article class="admin-stat-card">
            <div class="admin-stat-top">
                <span class="admin-stat-title">Citoyens</span>
                <span class="dashboard-icon-badge dashboard-icon-badge--sm">
                    <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png" alt="Citoyens">
                </span>
            </div>
            <div class="admin-stat-value">{{ $citoyens_count }}</div>
            <div class="admin-stat-text">Citoyens enregistrés dans la plateforme</div>
        </article>

        <article class="admin-stat-card">
            <div class="admin-stat-top">
                <span class="admin-stat-title">Tickets</span>
                <span class="dashboard-icon-badge dashboard-icon-badge--sm">
                    <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" alt="Tickets">
                </span>
            </div>
            <div class="admin-stat-value">{{ $tickets_count }}</div>
            <div class="admin-stat-text">Tickets créés aujourd’hui</div>
        </article>
    </section>
</div>

@endsection
