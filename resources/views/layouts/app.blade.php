<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'MediQueue')</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
:root {
    --bg-main: #eef8ff;
    --bg-soft: #f6fbff;
    --panel: rgba(255, 255, 255, 0.82);
    --panel-strong: #ffffff;
    --panel-border: rgba(125, 177, 255, 0.18);
    --primary: #38bdf8;
    --primary-strong: #0ea5e9;
    --primary-dark: #2563eb;
    --accent: #7dd3fc;
    --accent-soft: #dff4ff;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #f43f5e;
    --text-main: #0f172a;
    --text-soft: #5b6b84;
    --text-faint: #8aa0ba;
    --white: #ffffff;
    --shadow-soft: 0 18px 45px rgba(56, 189, 248, 0.12);
    --shadow-card: 0 26px 60px rgba(37, 99, 235, 0.14);
    --shadow-nav: 0 20px 50px rgba(14, 165, 233, 0.18);
    --radius-xl: 30px;
    --radius-lg: 24px;
    --radius-md: 18px;
    --container-width: min(1680px, calc(100vw - 40px));
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
}

body {
    font-family: 'Inter', sans-serif;
    min-height: 100vh;
    color: var(--text-main);
    background:
        radial-gradient(circle at top left, rgba(125, 211, 252, 0.45), transparent 28%),
        radial-gradient(circle at top right, rgba(59, 130, 246, 0.18), transparent 24%),
        radial-gradient(circle at bottom center, rgba(186, 230, 253, 0.55), transparent 36%),
        linear-gradient(180deg, #f8fdff 0%, #edf8ff 45%, #eaf5ff 100%);
}

a {
    color: inherit;
}

img {
    max-width: 100%;
}

.emoji-icon-img,
.inline-icon-img,
.brand-icon-img {
    display: inline-block;
    object-fit: contain;
    vertical-align: middle;
    flex-shrink: 0;
}

.emoji-icon-img,
.inline-icon-img {
    width: 18px;
    height: 18px;
}

.brand-icon-img {
    width: 30px;
    height: 30px;
    filter: brightness(0) invert(1);
}

.app-shell {
    min-height: 100vh;
    padding: 20px;
}

.top-navigation-wrap {
    position: sticky;
    top: 0;
    z-index: 100;
    padding-bottom: 18px;
    backdrop-filter: blur(8px);
}

.top-navigation {
    max-width: var(--container-width);
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 16px 18px;
    border-radius: 28px;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.72), rgba(240, 249, 255, 0.88));
    border: 1px solid rgba(125, 211, 252, 0.42);
    box-shadow: var(--shadow-nav);
    backdrop-filter: blur(20px);
}

.brand-block {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-shrink: 0;
}

.brand-icon {
    width: 58px;
    height: 58px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #dff4ff, #60a5fa);
    color: #fff;
    font-size: 28px;
    box-shadow: 0 14px 30px rgba(56, 189, 248, 0.24);
}

.brand-text {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.brand-text strong {
    font-size: 27px;
    font-weight: 900;
    letter-spacing: -0.04em;
    line-height: 1;
    color: #0f172a;
}

.brand-text span {
    font-size: 12px;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: #5f7ea1;
    font-weight: 700;
}

.top-navigation-center {
    flex: 1;
    display: flex;
    justify-content: center;
}

.nav-menu {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    justify-content: center;
}

.nav-link {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: 18px;
    text-decoration: none;
    color: #47617f;
    border: 1px solid transparent;
    font-size: 14px;
    font-weight: 700;
    transition: transform 0.22s ease, background 0.22s ease, color 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
}

.nav-link:hover,
.nav-link.active {
    color: #0f172a;
    background: linear-gradient(135deg, rgba(186, 230, 253, 0.9), rgba(255, 255, 255, 0.95));
    border-color: rgba(56, 189, 248, 0.3);
    box-shadow: 0 12px 28px rgba(56, 189, 248, 0.16);
    transform: translateY(-2px);
}

.nav-icon {
    width: 34px;
    height: 34px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #e0f2fe, #ffffff);
    border: 1px solid rgba(56, 189, 248, 0.18);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.85);
    flex-shrink: 0;
}

.nav-icon img {
    width: 17px;
    height: 17px;
    object-fit: contain;
    filter: brightness(0) saturate(100%) invert(49%) sepia(96%) saturate(1199%) hue-rotate(173deg) brightness(98%) contrast(94%);
}

.nav-label {
    white-space: nowrap;
}

.top-navigation-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-shrink: 0;
}

.user-pill {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 10px 16px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.85);
    border: 1px solid rgba(125, 211, 252, 0.4);
    color: var(--text-soft);
    font-size: 14px;
    font-weight: 700;
    box-shadow: 0 14px 30px rgba(56, 189, 248, 0.12);
}

.user-dot {
    width: 10px;
    height: 10px;
    border-radius: 999px;
    background: var(--success);
    box-shadow: 0 0 0 6px rgba(16, 185, 129, 0.12);
}

.main-container {
    max-width: var(--container-width);
    margin: 0 auto;
}

.hospital-banner {
    max-width: var(--container-width);
    margin: 0 auto 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    padding: 28px 32px;
    border-radius: 28px;
    background: linear-gradient(135deg, #1d4ed8, #38bdf8);
    border: 1px solid rgba(191, 219, 254, 0.32);
    box-shadow: 0 22px 50px rgba(37, 99, 235, 0.28);
}

.hospital-banner__title {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.hospital-banner__title span {
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.16em;
    color: rgba(219, 234, 254, 0.9);
    font-weight: 800;
}

.hospital-banner__title strong {
    font-size: clamp(34px, 4vw, 46px);
    font-weight: 900;
    letter-spacing: -0.05em;
    line-height: 1.05;
    color: #ffffff;
}

.hospital-banner__meta {
    max-width: 420px;
    text-align: right;
    color: rgba(239, 246, 255, 0.92);
    font-size: 16px;
    line-height: 1.6;
    font-weight: 700;
}

.content {
    padding: 0;
}

.card,
.table-wrapper,
.auth-box,
.stats-card,
.panel,
.form-panel {
    background: var(--panel);
    border: 1px solid var(--panel-border);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-soft);
    backdrop-filter: blur(16px);
}

.card {
    padding: 24px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
    padding: 24px 26px;
    background: linear-gradient(135deg, rgba(125, 211, 252, 0.28), rgba(255, 255, 255, 0.92));
    border: 1px solid rgba(56, 189, 248, 0.16);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-soft);
}

.page-header h1 {
    font-size: 28px;
    font-weight: 800;
    letter-spacing: -0.03em;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px 18px;
    border-radius: 14px;
    border: 1px solid transparent;
    cursor: pointer;
    text-decoration: none;
    font-weight: 800;
    font-size: 14px;
    transition: transform 0.2s ease, box-shadow 0.22s ease, opacity 0.22s ease, background 0.22s ease;
}

.btn:hover {
    transform: translateY(-2px);
}

.btn-primary {
    color: #ffffff;
    background: linear-gradient(135deg, var(--primary-strong), var(--primary));
    box-shadow: 0 16px 30px rgba(14, 165, 233, 0.2);
}

.btn-outline {
    color: var(--text-main);
    background: rgba(255,255,255,0.72);
    border-color: rgba(148, 163, 184, 0.22);
}

.btn-warning {
    color: #fff;
    background: linear-gradient(135deg, #f59e0b, #fbbf24);
}

.btn-success {
    color: #fff;
    background: linear-gradient(135deg, #10b981, #22c55e);
    box-shadow: 0 14px 28px rgba(16, 185, 129, 0.18);
}

.btn-danger,
.btn-logout {
    color: #fff;
    background: linear-gradient(135deg, #fb7185, #f43f5e);
    box-shadow: 0 14px 28px rgba(244, 63, 94, 0.18);
}

.btn-lg {
    padding: 14px 24px;
    font-size: 15px;
}

.btn-sm {
    padding: 9px 14px;
    font-size: 13px;
    border-radius: 12px;
}

.table-wrapper,
.table-container {
    padding: 14px;
    overflow-x: auto;
    border-radius: 22px;
    background: rgba(255,255,255,0.68);
}

table,
.table {
    width: 100%;
    border-collapse: collapse;
    overflow: hidden;
    border-radius: 18px;
}

thead tr {
    background: linear-gradient(135deg, #eff9ff, #dff4ff);
}

th,
td {
    padding: 16px 14px;
    text-align: left;
    border-bottom: 1px solid rgba(148, 163, 184, 0.14);
    vertical-align: middle;
}

th {
    color: var(--text-main);
    font-size: 13px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

td {
    color: var(--text-soft);
    font-size: 14px;
}

tbody tr {
    transition: background 0.2s ease, transform 0.2s ease;
}

tbody tr:hover {
    background: rgba(56, 189, 248, 0.05);
}

tbody strong {
    color: var(--text-main);
}

.card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 18px;
}

.card-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 20px;
    font-weight: 800;
    color: var(--text-main);
}

input,
select,
textarea {
    width: 100%;
    padding: 13px 14px;
    margin-top: 6px;
    border-radius: 14px;
    border: 1px solid rgba(148, 163, 184, 0.28);
    background: rgba(255,255,255,0.96);
    color: var(--text-main);
    outline: none;
    transition: border-color 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
}

input::placeholder,
textarea::placeholder {
    color: var(--text-faint);
}

input:focus,
select:focus,
textarea:focus {
    border-color: rgba(14, 165, 233, 0.45);
    box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.12);
}

label {
    display: inline-block;
    margin-bottom: 6px;
    color: var(--text-main);
    font-size: 14px;
    font-weight: 700;
}

form {
    margin: 0;
}

.alert,
.success,
.error-message {
    padding: 14px 16px;
    border-radius: 16px;
    margin-bottom: 18px;
    border: 1px solid transparent;
}

.alert,
.error-message {
    color: #991b1b;
    background: #fff1f2;
    border-color: #fecdd3;
}

.success {
    color: #065f46;
    background: #ecfdf5;
    border-color: #a7f3d0;
}

.empty-state {
    min-height: 220px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 12px;
    text-align: center;
    color: var(--text-soft);
}

.empty-icon {
    width: 74px;
    height: 74px;
    border-radius: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #eff9ff, #ffffff);
    font-size: 34px;
    box-shadow: var(--shadow-soft);
}

.dashboard-icon-badge {
    width: 76px;
    height: 76px;
    border-radius: 24px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    position: relative;
    background: linear-gradient(135deg, #ffffff, #e0f2fe);
    border: 1px solid rgba(56, 189, 248, 0.18);
    box-shadow: 0 16px 34px rgba(56, 189, 248, 0.14);
}

.dashboard-icon-badge::before {
    content: "";
    position: absolute;
    inset: 8px;
    border-radius: 18px;
    background: linear-gradient(135deg, rgba(56, 189, 248, 0.18), rgba(255, 255, 255, 0.8));
}

.dashboard-icon-badge img,
.dashboard-icon-badge .icon-emoji {
    position: relative;
    z-index: 1;
}

.dashboard-icon-badge img {
    width: 34px;
    height: 34px;
    object-fit: contain;
    filter: brightness(0) saturate(100%) invert(58%) sepia(70%) saturate(1202%) hue-rotate(169deg) brightness(97%) contrast(97%);
}

.dashboard-icon-badge .icon-emoji {
    font-size: 30px;
    line-height: 1;
}

.dashboard-icon-badge--sm {
    width: 54px;
    height: 54px;
    border-radius: 18px;
}

.dashboard-icon-badge--sm::before {
    inset: 6px;
    border-radius: 13px;
}

.dashboard-icon-badge--sm img {
    width: 24px;
    height: 24px;
}

.dashboard-icon-badge--sm .icon-emoji {
    font-size: 22px;
}

.badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0.04em;
}

.badge-blue {
    color: #0369a1;
    background: #e0f2fe;
}

.badge-green {
    color: #047857;
    background: #d1fae5;
}

.badge-orange,
.badge-yellow {
    color: #b45309;
    background: #fef3c7;
}

.badge-red {
    color: #be123c;
    background: #ffe4e6;
}

.ticket-display {
    padding: 32px;
    margin-bottom: 24px;
    border-radius: var(--radius-xl);
    background: linear-gradient(135deg, #38bdf8, #2563eb);
    color: #ffffff;
    text-align: center;
    box-shadow: var(--shadow-card);
}

.ticket-label {
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    opacity: 0.85;
}

.ticket-number {
    margin-top: 12px;
    font-size: 56px;
    font-weight: 800;
    letter-spacing: -0.04em;
}

.queue-info {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 18px;
    margin-bottom: 24px;
}

.info-item {
    padding: 22px;
    border-radius: 20px;
    background: var(--panel);
    border: 1px solid var(--panel-border);
    box-shadow: var(--shadow-soft);
}

.info-label {
    font-size: 13px;
    color: var(--text-soft);
    margin-bottom: 10px;
}

.info-value {
    font-size: 26px;
    font-weight: 800;
    color: var(--text-main);
    letter-spacing: -0.03em;
}

.text-center {
    text-align: center;
}

.mb-4 {
    margin-bottom: 24px;
}

ul,
ol {
    padding-left: 22px;
}

::-webkit-scrollbar {
    width: 10px;
    height: 10px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, rgba(56, 189, 248, 0.55), rgba(37, 99, 235, 0.4));
    border-radius: 999px;
}

::-webkit-scrollbar-track {
    background: rgba(148, 163, 184, 0.12);
}

@media (max-width: 1200px) {
    .top-navigation {
        flex-wrap: wrap;
        justify-content: center;
    }

    .top-navigation-center {
        order: 3;
        width: 100%;
    }

}

@media (max-width: 1100px) {
    .queue-info {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 768px) {
    .app-shell {
        padding: 14px;
    }

    .top-navigation {
        padding: 16px;
        border-radius: 24px;
    }

    .brand-text strong {
        font-size: 22px;
    }

    .nav-menu {
        gap: 8px;
    }

    .nav-link {
        padding: 10px 14px;
    }


    .queue-info {
        grid-template-columns: 1fr;
    }

    .hospital-banner {
        flex-direction: column;
        align-items: flex-start;
        padding: 22px 20px;
    }

    .hospital-banner__title strong {
        font-size: 28px;
    }

    .hospital-banner__meta {
        max-width: none;
        text-align: left;
        font-size: 15px;
    }
}

@media (max-width: 640px) {
    .top-navigation-actions {
        width: 100%;
        flex-direction: column;
    }

    .user-pill,
    .top-navigation-actions form,
    .top-navigation-actions .btn {
        width: 100%;
    }

    .nav-menu {
        justify-content: flex-start;
    }

    .card,
    .table-wrapper,
    .page-header,
    .ticket-display,
    .info-item {
        border-radius: 20px;
    }

    .ticket-number {
        font-size: 42px;
    }

    th,
    td {
        padding: 12px 10px;
    }
}
</style>
</head>

<body>

<div class="app-shell">
    <div class="top-navigation-wrap">
        <header class="top-navigation">
            <div class="brand-block">
                <div class="brand-icon">🏥</div>
                <div class="brand-text">
                    <strong>HôpitalFile</strong>
                    <span>Gestion hospitalière</span>
                </div>
            </div>

            <div class="top-navigation-center">
                <nav class="nav-menu">
                    <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <img src="https://cdn-icons-png.flaticon.com/512/1828/1828791.png" alt="Dashboard">
                        </span>
                        <span class="nav-label">Dashboard</span>
                    </a>

                    @if(auth()->check() && auth()->user()->isAdmin())
                        <a href="/services" class="nav-link {{ request()->is('services*') ? 'active' : '' }}">
                            <span class="nav-icon">
                                <img src="https://cdn-icons-png.flaticon.com/512/4320/4320371.png" alt="Services">
                            </span>
                            <span class="nav-label">Services</span>
                        </a>

                        <a href="/queues" class="nav-link {{ request()->is('queues*') ? 'active' : '' }}">
                            <span class="nav-icon">
                                <img src="https://cdn-icons-png.flaticon.com/512/2921/2921222.png" alt="Files">
                            </span>
                            <span class="nav-label">Files</span>
                        </a>

                        <a href="/agents" class="nav-link {{ request()->is('agents*') ? 'active' : '' }}">
                            <span class="nav-icon">
                                <img src="https://cdn-icons-png.flaticon.com/512/3774/3774299.png" alt="Agents">
                            </span>
                            <span class="nav-label">Agents</span>
                        </a>

                        <a href="/citoyens" class="nav-link {{ request()->is('citoyens*') ? 'active' : '' }}">
                            <span class="nav-icon">
                                <img src="https://cdn-icons-png.flaticon.com/512/4140/4140047.png" alt="Citoyens">
                            </span>
                            <span class="nav-label">Citoyens</span>
                        </a>
                    @endif

                    <a href="/tickets" class="nav-link {{ request()->is('tickets*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" alt="Tickets">
                        </span>
                        <span class="nav-label">Tickets</span>
                    </a>
                </nav>
            </div>

            <div class="top-navigation-actions">
                <div class="user-pill">
                    <span class="user-dot"></span>
                    <span>
                        @auth
                            {{ ucfirst(auth()->user()->role ?? 'utilisateur') }}
                        @else
                            Utilisateur connecté
                        @endauth
                    </span>
                </div>

                <form method="POST" action="/logout">
                    @csrf
                    <button class="btn btn-logout" type="submit">Déconnexion</button>
                </form>
            </div>
        </header>
    </div>

    @if(request()->is('dashboard') && auth()->check() && auth()->user()->isAdmin() && optional(auth()->user()->administrator)->hospital)
        <section class="hospital-banner">
            <div class="hospital-banner__title">
                <span>Hôpital administré</span>
                <strong>{{ auth()->user()->administrator->hospital->name }}</strong>
            </div>
            <div class="hospital-banner__meta">
                Espace d’administration de l’établissement
            </div>
        </section>
    @endif

    <main class="main-container">
        <div class="content">
            @yield('content')
        </div>
    </main>
</div>

</body>
</html>
