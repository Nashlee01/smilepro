@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h1>Medewerkersoverzicht</h1>
    </div>
    <div class="col-auto">
        <a href="{{ route('employees.create') }}" class="btn btn-primary">Nieuwe medewerker</a>
    </div>
    </div>

<div class="card">
    <div class="card-body">
        @if($employees->isEmpty())
            <div class="alert alert-info">
                Geen medewerkers beschikbaar.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Naam</th>
                            <th>E-mail</th>
                            <th>Rol</th>
                            <th>Status</th>
                            <th class="text-end">Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                            <tr>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ ucfirst($employee->role) }}</td>
                                <td>
                                    <span class="status-{{ $employee->status }}">
                                        {{ $employee->status === 'active' ? 'Actief' : 'Inactief' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-outline-secondary">Bewerken</a>
                                    <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="d-inline" onsubmit="return confirm('Weet je zeker dat je deze medewerker wilt verwijderen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Verwijderen</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
