@extends('layouts.app')

@section('title', 'Ajouter une file d’attente')

@section('content')
<div class="card" style="max-width: 860px; margin: 0 auto; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 45%, #93c5fd 100%); border: 1px solid rgba(37, 99, 235, 0.18); box-shadow: 0 24px 55px rgba(37, 99, 235, 0.16);">
    <div class="card-header" style="margin-bottom: 24px;">
        <div>
            <div class="card-title" style="font-size: 30px; margin-bottom: 8px;">Ajouter une file d’attente</div>
            <p style="color: #365277; font-weight: 600;">
                La file sera liée à un service disponible de votre hôpital.
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('queues.store') }}">
        @csrf

        <div style="display: grid; gap: 22px;">
            <div>
                <label for="service_id">Service</label>
                <select id="service_id" name="service_id" required>
                    <option value="">Choisir un service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="name">Nom de la file</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Ex: File consultation générale"
                    required
                >
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 8px;">
                <a href="{{ route('queues.index') }}" class="btn btn-outline">Annuler</a>
                <button type="submit" class="btn btn-success">Ajouter la file</button>
            </div>
        </div>
    </form>
</div>
@endsection
