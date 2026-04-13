@extends('layouts.app')
@section('title', 'Citoyens')
@section('content')
<div class="page-header">
    <h1>Citoyens</h1>
</div>
<table>
    <thead>
        <tr><th>Nom</th><th>Email</th></tr>
    </thead>
    <tbody>
        @forelse($citoyens as $citoyen)
        <tr>
            <td>{{ $citoyen->user->name }}</td>
            <td>{{ $citoyen->user->email }}</td>
        </tr>
        @empty
        <tr><td colspan="2" style="text-align:center;color:#999">Aucun citoyen.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection