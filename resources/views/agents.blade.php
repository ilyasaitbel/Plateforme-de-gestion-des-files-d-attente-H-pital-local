@extends('layouts.app')
@section('title', 'Agents')
@section('content')
<div class="page-header">
    <h1>Agents</h1>
</div>

@if(isset($creating))
<div class="card">
    <h2>Ajouter un agent</h2>
    <form method="POST" action="/agents">
        @csrf
        <div class="form-group">
            <label>Utilisateur</label>
            <select name="user_id" required>
                <option value="">-- Choisir --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Hôpital</label>
            <select name="hospital_id" required>
                <option value="">-- Choisir --</option>
                @foreach($hospitals as $hospital)
                    <option value="{{ $hospital->id }}" {{ old('hospital_id') == $hospital->id ? 'selected' : '' }}>
                        {{ $hospital->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-success">Enregistrer</button>
            <a href="/agents" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@else
<div class="page-header">
    <a href="/agents/create" class="btn btn-success">+ Ajouter</a>
</div>
<table>
    <thead>
        <tr><th>Nom</th><th>Email</th><th>Hôpital</th></tr>
    </thead>
    <tbody>
        @forelse($agents as $agent)
        <tr>
            <td>{{ $agent->user->name }}</td>
            <td>{{ $agent->user->email }}</td>
            <td>{{ $agent->hospital->name }}</td>
        </tr>
        @empty
        <tr><td colspan="3" style="text-align:center;color:#999">Aucun agent.</td></tr>
        @endforelse
    </tbody>
</table>
@endif
@endsection