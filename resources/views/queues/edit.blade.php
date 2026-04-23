@extends('layouts.app')

@section('title', 'Modifier une file')

@section('content')
<div class="card" style="max-width: 860px; margin: 0 auto; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 45%, #93c5fd 100%); border: 1px solid rgba(37, 99, 235, 0.18); box-shadow: 0 24px 55px rgba(37, 99, 235, 0.16);">
    <div class="card-header" style="margin-bottom: 24px;">
        <div>
            <div class="card-title" style="font-size: 30px; margin-bottom: 8px;">Modifier une file</div>
            <p style="color: #365277; font-weight: 600;">
                Mettez à jour le nom et le statut de la file.
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('queues.update', $queue->id) }}">
        @csrf
        @method('PUT')

        <input type="hidden" name="service_id" value="{{ $queue->service_id }}">

        <div style="display: grid; gap: 22px;">
            <div>
                <label for="service_name">Service associé</label>
                <input
                    id="service_name"
                    type="text"
                    value="{{ old('service_name', optional($queue->service)->name ?? 'Service associé') }}"
                    readonly
                >
            </div>

            <div>
                <label for="name">Nom de la file</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name', $queue->name) }}"
                    placeholder="Ex: Queue 2 - H1"
                    required
                >
            </div>

            <div>
                <label for="status">Statut</label>
                <select id="status" name="status" required>
                    <option value="OPEN" {{ old('status', $queue->status) === 'OPEN' ? 'selected' : '' }}>OPEN</option>
                    <option value="CLOSED" {{ old('status', $queue->status) === 'CLOSED' ? 'selected' : '' }}>CLOSED</option>
                    <option value="PAUSED" {{ old('status', $queue->status) === 'PAUSED' ? 'selected' : '' }}>PAUSED</option>
                </select>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 8px;">
                <a href="{{ route('queues.index') }}" class="btn btn-outline">Annuler</a>
                <button type="submit" class="btn btn-success">Mettre à jour</button>
            </div>
        </div>
    </form>
</div>
@endsection
