@extends('layouts.app')
@section('content')
<h1>Nieuw account</h1>
<form method="POST" action="{{ route('accounts.store') }}" class="card">
  @csrf
  <div class="card-body">
    <div class="mb-3">
      <label class="form-label">Naam</label>
      <input name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">E-mail</label>
      <input name="email" type="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Rol</label>
      <select name="role" class="form-select">
        <option value="assistant">Assistent</option>
        <option value="dentist">Tandarts</option>
        <option value="practicemanager">Praktijkmanager</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Wachtwoord</label>
      <input name="password" type="password" class="form-control" required>
    </div>
    <button class="btn btn-primary">Opslaan</button>
  </div>
</form>
@endsection