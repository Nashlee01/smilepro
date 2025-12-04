@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h1>Medewerkersoverzicht</h1>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
