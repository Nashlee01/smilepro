@extends('layouts.app')
@section('content')
<h1>Nieuwe medewerker</h1>
<form method="POST" action="{{ route('employees.store') }}">
  @csrf
  <div class="mb-3">
    <label class="form-label">Naam</label>
    <input name="name" class="form-control" value="{{ old('name') }}" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input name="email" type="email" class="form-control" value="{{ old('email') }}" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Rol</label>
    <select name="role" class="form-select" required>
      <option value="dentist" @selected(old('role')==='dentist')>Dentist</option>
      <option value="assistant" @selected(old('role')==='assistant')>Assistant</option>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      <option value="active" @selected(old('status','active')==='active')>Actief</option>
      <option value="inactive" @selected(old('status')==='inactive')>Inactief</option>
    </select>
  </div>
  <div class="d-flex gap-2">
    <button class="btn btn-primary">Opslaan</button>
    <a href="{{ route('employees.index') }}" class="btn btn-light">Annuleren</a>
  </div>
</form>
@endsection
