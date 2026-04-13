@extends('layouts.app')

@section('content')

<h2>Services</h2>

<a href="{{ route('services.create') }}">Ajouter Service</a>

<table border="1" cellpadding="10">
    <tr>
        <th>Name</th>
        <th>Hospital</th>
        <th>Actions</th>
    </tr>

    @foreach($services as $service)
        <tr>
            <td>{{ $service->name }}</td>
            <td>{{ $service->hospital->name }}</td>
            <td>
                <a href="{{ route('services.show',$service->id) }}">View</a>
                <a href="{{ route('services.edit',$service->id) }}">Edit</a>

                <form action="{{ route('services.destroy',$service->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach

</table>

@endsection