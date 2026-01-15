@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1>Accountoverzicht</h1>
  <a class="btn btn-primary" href="{{ route('accounts.create') }}">Nieuw account</a> <!-- Button to create a new account -->
</div>

<div class="card">
  <div class="card-body">
    @if($users->isEmpty())
      <div class="alert alert-info">Geen accounts gevonden.</div> <!-- Message if no accounts exist -->
    @else
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Naam</th> <!-- Account name -->
              <th>E-mail</th> <!-- Account email -->
              <th>Rol</th> <!-- Account role -->
              <th class="text-end">Acties</th> <!-- Actions column -->
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
              <tr>
                <td>{{ $user->name }}</td> <!-- Display account name -->
                <td>{{ $user->email }}</td> <!-- Display account email -->
                <td>{{ ucfirst($user->role ?? '-') }}</td> <!-- Display account role -->
                <td class="text-end">
                  <a class="btn btn-sm btn-secondary" href="{{ route('accounts.edit', $user) }}">Bewerken</a> <!-- Edit button -->
                  <form method="POST" action="{{ route('accounts.destroy', $user) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Verwijderen</button> <!-- Delete button -->
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{ $users->links() }} <!-- Pagination links -->
    @endif
  </div>
</div>
@endsection