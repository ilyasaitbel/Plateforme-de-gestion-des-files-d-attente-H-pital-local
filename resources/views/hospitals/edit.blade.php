@extends('layouts.app')
@section('title', 'Modifier hôpital')
@section('content')
<style>
    .hospital-edit-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
    }

    .hospital-edit-title {
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

    .hospital-edit-title .section-icon-img {
        width: 22px;
        height: 22px;
    }

    .hospital-edit-actions .btn,
    .form-actions .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
</style>

<div class="page-header hospital-edit-header">
    <h1 class="hospital-edit-title">
        <img src="https://cdn-icons-png.flaticon.com/512/1159/1159633.png" alt="" class="section-icon-img">
        <span>Modifier : {{ $hospital->name }}</span>
    </h1>
    <a href="{{ route('hospitals.index') }}" class="btn btn-outline">Retour</a>
</div>
<div class="card" style="max-width:600px">
    <form method="POST" action="{{ route('hospitals.update', $hospital) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Nom de l'hôpital</label>
            <input type="text" name="name" value="{{ old('name', $hospital->name) }}" required>
        </div>
        <div class="form-group">
            <label>Adresse</label>
            <input type="text" name="address" value="{{ old('address', $hospital->address) }}" required>
        </div>
        <div class="form-group">
            <label>Téléphone</label>
            <input type="text" name="phone" value="{{ old('phone', $hospital->phone) }}">
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-warning">
                <img src="https://cdn-icons-png.flaticon.com/512/2550/2550250.png" alt="" class="button-icon-img">
                <span>Modifier</span>
            </button>
            <a href="{{ route('hospitals.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection