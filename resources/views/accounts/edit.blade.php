@extends('layouts.app')
@section('content')
<h1>Account bewerken</h1>
<form method="POST" action="{{ route('accounts.update', $account) }}" class="card">
  @csrf
  @method('PUT')
  <div class="card-body">
    <div class="mb-3">
      <label class="form-label">Naam</label>
      <input name="name" class="form-control" value="{{ $account->name }}" required>
    </div>
    <div class="mb-3">
      <label class="form-label">E-mail</label>
      <input name="email" type="email" class="form-control" value="{{ $account->email }}" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Rol</label>
      <select name="role" class="form-select">
        @foreach(['assistant'=>'Assistent','dentist'=>'Tandarts','practicemanager'=>'Praktijkmanager'] as $val=>$label)
          <option value="{{ $val }}" @selected(($account->role ?? '') === $val)>{{ $label }}</option>
        @endforeach
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Wachtwoord (optioneel)</label>
      <input name="password" type="password" class="form-control">
    </div>
    <button class="btn btn-primary">Opslaan</button>
  </div>
</form>
@endsection