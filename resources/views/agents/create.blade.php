@extends('layouts.app')

@section('title', 'Ajouter un agent')

@section('content')
<div class="card" style="max-width: 860px; margin: 0 auto; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 45%, #93c5fd 100%); border: 1px solid rgba(37, 99, 235, 0.18); box-shadow: 0 24px 55px rgba(37, 99, 235, 0.16);">
    <div class="card-header" style="margin-bottom: 24px;">
        <div>
            <div class="card-title" style="font-size: 30px; margin-bottom: 8px;">Ajouter un agent</div>
            <p style="color: #365277; font-weight: 600;">
                Créez directement un nouveau compte agent.
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('agents.store') }}">
        @csrf

        <div style="display: grid; gap: 22px;">
            <div>
                <label for="name">Nom complet</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Ex: Ahmed El Mansouri"
                    required
                >
            </div>

            <div>
                <label for="email">Adresse email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="agent@hopital.ma"
                    required
                >
            </div>

            <div>
                <label for="password">Mot de passe</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Minimum 8 caractères"
                    required
                >
            </div>

            <div>
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    placeholder="Retapez le mot de passe"
                    required
                >
            </div>

            <div>
                <label for="queue_id">File d'attente</label>
                <select id="queue_id" name="queue_id" required>
                    <option value="">Choisir une file d'attente</option>
                    @foreach($queues as $queue)
                        <option value="{{ $queue->id }}" {{ old('queue_id') == $queue->id ? 'selected' : '' }}>
                            {{ $queue->name }} — {{ $queue->service->name }} ({{ $queue->service->hospital->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 8px;">
                <a href="{{ route('agents.index') }}" class="btn btn-outline">Annuler</a>
                <button type="submit" class="btn btn-success">Créer l’agent</button>
            </div>
        </div>
    </form>
</div>
@endsection