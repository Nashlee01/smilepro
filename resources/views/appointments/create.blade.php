@extends('layouts.app')
@section('content')
<h1>Nieuwe afspraak</h1>
<form method="POST" action="{{ route('appointments.store') }}">
  @csrf
  <div class="mb-3"><label>Client</label><input name="client_name" class="form-control" required></div>
  <div class="mb-3"><label>Medewerker</label><input name="employee_name" class="form-control" required></div>
  <div class="mb-3"><label>Datum en tijd</label><input name="appointment_date" type="datetime-local" class="form-control" required></div>
  <div class="mb-3"><label>Status</label>
    <select name="status" class="form-select">
      <option value="scheduled">Gepland</option>
      <option value="confirmed">Bevestigd</option>
      <option value="cancelled">Geannuleerd</option>
    </select>
  </div>
  <div class="mb-3"><label>Notities</label><textarea name="notes" class="form-control"></textarea></div>
  <button class="btn btn-primary">Opslaan</button>
</form>
@endsection