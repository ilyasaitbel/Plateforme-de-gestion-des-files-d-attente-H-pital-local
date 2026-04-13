@extends('layouts.app')

@section('title', 'Créer votre hôpital')

@section('content')
<style>
    .page-topbar {
        display: none;
    }

    .hospital-create-shell {
        display: grid;
        grid-template-columns: minmax(280px, 420px) minmax(320px, 1fr);
        gap: 24px;
        align-items: stretch;
    }

    .hospital-hero-card {
        position: relative;
        overflow: hidden;
        padding: 30px;
        min-height: 100%;
        background:
            radial-gradient(circle at top right, rgba(255,255,255,0.28), transparent 28%),
            linear-gradient(160deg, #38bdf8 0%, #2563eb 100%);
        color: #fff;
        border-radius: 30px;
        box-shadow: 0 28px 60px rgba(37, 99, 235, 0.22);
    }

    .hospital-hero-card::after {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        right: -70px;
        bottom: -70px;
        border-radius: 999px;
        background: rgba(255,255,255,0.12);
    }

    .hospital-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 999px;
        background: rgba(255,255,255,0.14);
        border: 1px solid rgba(255,255,255,0.2);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        margin-bottom: 18px;
    }

    .emoji-icon-img,
    .section-icon-img,
    .button-icon-img {
        width: 18px;
        height: 18px;
        object-fit: contain;
        vertical-align: middle;
        flex-shrink: 0;
    }

    .hospital-hero-badge .section-icon-img,
    .hospital-mini-badge .section-icon-img,
    .btn .button-icon-img {
        width: 16px;
        height: 16px;
    }

    .hospital-point-icon .section-icon-img {
        width: 18px;
        height: 18px;
    }

    .hospital-hero-title {
        font-size: 34px;
        line-height: 1.1;
        font-weight: 900;
        letter-spacing: -0.04em;
        margin-bottom: 14px;
        position: relative;
        z-index: 1;
    }

    .hospital-hero-text {
        color: rgba(255,255,255,0.9);
        line-height: 1.8;
        font-size: 15px;
        margin-bottom: 22px;
        position: relative;
        z-index: 1;
    }

    .hospital-points {
        list-style: none;
        padding: 0;
        display: grid;
        gap: 12px;
        position: relative;
        z-index: 1;
    }

    .hospital-points li {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 14px 16px;
        border-radius: 18px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.14);
        backdrop-filter: blur(6px);
    }

    .hospital-point-icon {
        width: 34px;
        height: 34px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.16);
        flex-shrink: 0;
        font-size: 16px;
    }

    .hospital-form-card {
        padding: 28px;
        border-radius: 30px;
        background: linear-gradient(180deg, rgba(255,255,255,0.9), rgba(246,251,255,0.95));
        border: 1px solid rgba(125, 211, 252, 0.35);
        box-shadow: var(--shadow-soft);
    }

    .hospital-form-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 24px;
    }

    .hospital-form-kicker {
        display: inline-block;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #0ea5e9;
        margin-bottom: 10px;
    }

    .hospital-form-title {
        font-size: 30px;
        font-weight: 900;
        letter-spacing: -0.04em;
        margin-bottom: 10px;
        color: var(--text-main);
    }

    .hospital-form-subtitle {
        color: var(--text-soft);
        line-height: 1.7;
        max-width: 620px;
        font-size: 14px;
    }

    .hospital-mini-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        padding: 12px 16px;
        border-radius: 999px;
        background: #e0f2fe;
        color: #0369a1;
        font-size: 13px;
        font-weight: 800;
    }

    .hospital-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .hospital-grid .full-width {
        grid-column: 1 / -1;
    }

    .field-card {
        padding: 18px;
        border-radius: 22px;
        background: rgba(255,255,255,0.75);
        border: 1px solid rgba(186, 230, 253, 0.9);
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.6);
    }

    .field-hint {
        margin-top: 8px;
        color: var(--text-faint);
        font-size: 12px;
        line-height: 1.6;
    }

    .hospital-actions {
        margin-top: 24px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: space-between;
        align-items: center;
    }

    .hospital-actions-left {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .hospital-actions-left .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .hospital-note {
        color: var(--text-soft);
        font-size: 13px;
        line-height: 1.7;
    }

    @media (max-width: 980px) {
        .hospital-create-shell {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .hospital-grid {
            grid-template-columns: 1fr;
        }

        .hospital-form-top,
        .hospital-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .hospital-actions-left {
            width: 100%;
            flex-direction: column;
        }

        .hospital-actions-left .btn {
            width: 100%;
            justify-content: center;
        }

        .hospital-mini-badge {
            justify-content: center;
        }
    }
</style>

<div class="hospital-create-shell">
    <div class="hospital-hero-card">
        <div class="hospital-hero-badge">
            <img src="https://cdn-icons-png.flaticon.com/512/2967/2967350.png" alt="" class="section-icon-img">
            <span>Configuration initiale</span>
        </div>

        <h1 class="hospital-hero-title">Créez votre premier hôpital</h1>

        <p class="hospital-hero-text">
            Pour continuer à utiliser l’espace administrateur, commencez par enregistrer votre hôpital.
            Une fois créé, vous pourrez ajouter vos services, organiser les files d’attente et gérer les agents.
        </p>

        <ul class="hospital-points">
            <li>
                <span class="hospital-point-icon">
                    <img src="https://cdn-icons-png.flaticon.com/512/684/684908.png" alt="" class="section-icon-img">
                </span>
                <div>
                    <strong>Identité claire</strong><br>
                    Ajoutez le nom officiel et l’adresse pour structurer votre espace hospitalier.
                </div>
            </li>
            <li>
                <span class="hospital-point-icon">
                    <img src="https://cdn-icons-png.flaticon.com/512/724/724664.png" alt="" class="section-icon-img">
                </span>
                <div>
                    <strong>Contact rapide</strong><br>
                    Enregistrez un numéro utile pour la coordination et l’administration.
                </div>
            </li>
            <li>
                <span class="hospital-point-icon">
                    <img src="https://cdn-icons-png.flaticon.com/512/3524/3524636.png" alt="" class="section-icon-img">
                </span>
                <div>
                    <strong>Activation de la plateforme</strong><br>
                    Après cette étape, le dashboard admin devient entièrement opérationnel.
                </div>
            </li>
        </ul>
    </div>

    <div class="hospital-form-card">
        <div class="hospital-form-top">
            <div>
                <span class="hospital-form-kicker">Espace administrateur</span>
                <h2 class="hospital-form-title">Ajouter un hôpital</h2>
                <p class="hospital-form-subtitle">
                    Remplissez les informations essentielles ci-dessous. Cette configuration est nécessaire
                    pour débloquer la gestion des services, agents, files et tickets.
                </p>
            </div>

            <div class="hospital-mini-badge">
                <img src="https://cdn-icons-png.flaticon.com/512/1828/1828884.png" alt="" class="section-icon-img">
                <span>Étape obligatoire</span>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('hospitals.store') }}">
            @csrf

            <div class="hospital-grid">
                <div class="field-card full-width">
                    <label for="name">Nom de l'hôpital</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Ex: Hôpital Ibn Sina" required>
                    <div class="field-hint">Utilisez le nom officiel ou le nom le plus connu de l’établissement.</div>
                </div>

                <div class="field-card full-width">
                    <label for="address">Adresse</label>
                    <input id="address" type="text" name="address" value="{{ old('address') }}" placeholder="Adresse complète" required>
                    <div class="field-hint">Exemple : avenue, quartier, ville ou toute indication utile pour localiser l’hôpital.</div>
                </div>

                <div class="field-card full-width">
                    <label for="phone">Téléphone</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="+212 6xx xxx xxx" required>
                    <div class="field-hint">Ajoutez un numéro joignable pour le contact administratif.</div>
                </div>
            </div>

            <div class="hospital-actions">
                <div class="hospital-actions-left">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <img src="https://cdn-icons-png.flaticon.com/512/2550/2550250.png" alt="" class="button-icon-img">
                        <span>Enregistrer l'hôpital</span>
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline btn-lg">Annuler</a>
                </div>

                <div class="hospital-note">
                    Après l’enregistrement, vous serez redirigé vers votre dashboard.
                </div>
            </div>
        </form>
    </div>
</div>
@endsection