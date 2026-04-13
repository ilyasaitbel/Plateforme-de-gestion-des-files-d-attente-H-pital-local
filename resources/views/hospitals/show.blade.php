@extends('layouts.app')
@section('title', 'Hôpital')
@section('content')
<style>
    .hospital-show-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
    }

    .hospital-show-title {
        display: inline-flex;
        align-items: center;
        gap: 10px;
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

    .hospital-show-title .section-icon-img {
        width: 24px;
        height: 24px;
    }

    .form-actions .btn,
    .form-actions button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
</style>

<div class="page-header hospital-show-header">
    <h1 class="hospital-show-title">
        <img src="https://cdn-icons-png.flaticon.com/512/2967/2967350.png" alt="" class="section-icon-img">
        <span>{{ $hospital->name }}</span>
    </h1>
    <a href="{{ route('hospitals.index') }}" class="btn btn-outline">Retour</a>
</div>
<div class="card" style="max-width:600px">
    <div style="display:flex;flex-direction:column;gap:14px">
        <div>
            <p style="font-size:12px;color:#888;margin-bottom:4px">Nom</p>
            <p style="font-weight:600">{{ $hospital->name }}</p>
        </div>
        <div>
            <p style="font-size:12px;color:#888;margin-bottom:4px">Adresse</p>
            <p>{{ $hospital->address }}</p>
        </div>
        <div>
            <p style="font-size:12px;color:#888;margin-bottom:4px">Téléphone</p>
            <p>{{ $hospital->phone ?? '—' }}</p>
        </div>
        <div>
            <p style="font-size:12px;color:#888;margin-bottom:4px">Services</p>
            <span class="badge badge-info">{{ $hospital->services->count() }} services</span>
        </div>
    </div>
    <div class="form-actions" style="margin-top:20px">
        <a href="{{ route('hospitals.edit', $hospital) }}" class="btn btn-warning">
            <img src="https://cdn-icons-png.flaticon.com/512/1159/1159633.png" alt="" class="button-icon-img">
            <span>Modifier</span>
        </a>
        <form method="POST" action="{{ route('hospitals.destroy', $hospital) }}">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer ?')">
                <img src="https://cdn-icons-png.flaticon.com/512/1214/1214428.png" alt="" class="button-icon-img">
                <span>Supprimer</span>
            </button>
        </form>
    </div>
</div>
@endsection