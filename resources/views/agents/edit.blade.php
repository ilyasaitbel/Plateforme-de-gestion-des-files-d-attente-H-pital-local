@extends('layouts.app')

@section('title', 'Modifier un agent')

@section('content')
<div class="card" style="max-width: 860px; margin: 0 auto; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 45%, #93c5fd 100%); border: 1px solid rgba(37, 99, 235, 0.18); box-shadow: 0 24px 55px rgba(37, 99, 235, 0.16);">
    <div class="card-header" style="margin-bottom: 24px;">
        <div>
            <div class="card-title" style="font-size: 30px; margin-bottom: 8px;">Modifier un agent</div>
            <p style="color: #365277; font-weight: 600;">
                Réaffectez l’agent à une file disponible dans votre hôpital.
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('agents.update', $agent) }}">
        @csrf
        @method('PUT')

        <div style="display: grid; gap: 22px;">
            <div>
                <label for="queue_id">File</label>
                <select id="queue_id" name="queue_id" required>
                    @forelse ($queues as $queue)
                        <option value="{{ $queue->id }}" {{ old('queue_id', $agent->queue_id) == $queue->id ? 'selected' : '' }}>
                            {{ $queue->name }} — {{ $queue->service->name }} ({{ $queue->service->hospital->name }})
                        </option>
                    @empty
                        <option value="" disabled selected>Aucune file disponible</option>
                    @endforelse
                </select>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 8px;">
                <a href="{{ route('agents.index') }}" class="btn btn-outline">Annuler</a>
                <button type="submit" class="btn btn-success">Mettre à jour</button>
            </div>
        </div>
    </form>
</div>
@endsection
