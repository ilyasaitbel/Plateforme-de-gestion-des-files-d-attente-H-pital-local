@extends('layouts.app')
@section('title', 'Administrateurs')
@section('content')
<div class="page-header">
    <h1>Administrateurs</h1>
</div>
<table>
    <thead>
        <tr><th>Nom</th><th>Email</th></tr>
    </thead>
    <tbody>
        @forelse($administrators as $admin)
        <tr>
            <td>{{ $admin->user->name }}</td>
            <td>{{ $admin->user->email }}</td>
        </tr>
        @empty
        <tr><td colspan="2" style="text-align:center;color:#999">Aucun administrateur.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection