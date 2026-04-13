@extends('layouts.app')
@section('title', 'Utilisateurs')
@section('content')
<div class="page-header">
    <h1>Utilisateurs</h1>
</div>
<table>
    <thead>
        <tr><th>Nom</th><th>Email</th><th>Rôle</th></tr>
    </thead>
    <tbody>
        @forelse($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td><span class="badge badge-info">{{ $user->role ?? '-' }}</span></td>
        </tr>
        @empty
        <tr><td colspan="3" style="text-align:center;color:#999">Aucun utilisateur.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection