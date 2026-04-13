@extends('layouts.app')

@section('title', 'Ajouter un service')

@section('content')
<div class="card" style="max-width: 860px; margin: 0 auto; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 45%, #93c5fd 100%); border: 1px solid rgba(37, 99, 235, 0.18); box-shadow: 0 24px 55px rgba(37, 99, 235, 0.16);">
    <div class="card-header" style="margin-bottom: 24px;">
        <div>
            <div class="card-title" style="font-size: 30px; margin-bottom: 8px;">Ajouter un service</div>
            <p style="color: #365277; font-weight: 600;">
                Le service sera automatiquement lié à votre hôpital.
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('services.store') }}">
        @csrf

        <div style="display: grid; gap: 22px;">
            <div>
                <label for="name">Nom du service</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Ex: Radiologie"
                    required
                >
            </div>

            <div>
                <label for="description">Description</label>
                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    placeholder="Décrivez brièvement le service"
                >{{ old('description') }}</textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 8px;">
                <a href="{{ route('services.index') }}" class="btn btn-outline">Annuler</a>
                <button type="submit" class="btn btn-success">Ajouter le service</button>
            </div>
        </div>
    </form>
</div>
@endsection
