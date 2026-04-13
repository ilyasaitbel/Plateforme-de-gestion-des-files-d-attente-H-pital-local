@extends('layouts.app')

@section('content')

<style>
/* BODY FIX */
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
}

/* DASHBOARD */
.dashboard {
    min-height: calc(100vh - 80px);
    display: flex;
    justify-content: center;
    align-items: center;
}

/* CONTENT */
.dashboard-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 30px;
}

/* HEADER */
.dashboard-header {
    text-align: center;
    color: white;
}

.dashboard-header h1 {
    font-size: 36px;
    margin-bottom: 5px;
}

/* STATS GRID */
.stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

/* CARD */
.card {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(12px);

    padding: 25px;
    border-radius: 15px;

    text-align: center;
    color: white;

    border: 1px solid rgba(255,255,255,0.15);

    transition: 0.3s;
}

.card:hover {
    transform: translateY(-5px);
}

/* ICON */
.icon {
    width: 60px;
    height: 60px;
    margin: auto;

    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;

    margin-bottom: 15px;
}

.icon img {
    width: 30px;
}

/* TEXT */
.number {
    font-size: 28px;
    font-weight: bold;
}

.label {
    font-size: 14px;
    opacity: 0.8;
}

/* RESPONSIVE */
@media(max-width: 900px){
    .stats {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media(max-width: 500px){
    .stats {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="dashboard">
    <div class="dashboard-content">

        <!-- HEADER -->
        <div class="dashboard-header">
            <h1>{{ $hospital->name ?? 'Mon Hôpital' }}</h1>
            <p>Tableau de bord de l’hôpital</p>
        </div>

        <!-- STATS -->
        <div class="stats">

            <!-- SERVICES -->
            <div class="card">
                <div class="icon" style="background:#22c55e;">
                    <img src="https://cdn-icons-png.flaticon.com/512/4320/4320371.png">
                </div>
                <div class="number">{{ $services_count }}</div>
                <div class="label">Services</div>
            </div>

            <!-- AGENTS -->
            <div class="card">
                <div class="icon" style="background:#f59e0b;">
                    <img src="https://cdn-icons-png.flaticon.com/512/3774/3774299.png">
                </div>
                <div class="number">{{ $agents_count }}</div>
                <div class="label">Agents</div>
            </div>

            <!-- CITOYENS -->
            <div class="card">
                <div class="icon" style="background:#8b5cf6;">
                    <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png">
                </div>
                <div class="number">{{ $citoyens_count }}</div>
                <div class="label">Citoyens</div>
            </div>

            <!-- TICKETS -->
            <div class="card">
                <div class="icon" style="background:#06b6d4;">
                    <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png">
                </div>
                <div class="number">{{ $tickets_count }}</div>
                <div class="label">Tickets aujourd'hui</div>
            </div>

        </div>

    </div>
</div>

@endsection