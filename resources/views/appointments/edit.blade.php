@extends('layouts.app')
@section('content')
<h1>Afspraak bewerken</h1>
<form method="POST" action="{{ route('appointments.update',$appointment) }}">
  @csrf @method('PUT')
  <div class="mb-3"><label>Client</label><input name="client_name" class="form-control" value="{{ $appointment->client_name }}" required></div>
  <div class="mb-3"><label>Medewerker</label><input name="employee_name" class="form-control" value="{{ $appointment->employee_name }}" required></div>
  <div class="mb-3"><label>Datum en tijd</label>
    <input name="appointment_date" type="datetime-local" class="form-control" value="{{ $appointment->appointment_date->format('Y-m-d\TH:i') }}" required>
  </div>
  <div class="mb-3"><label>Status</label>
    <select name="status" class="form-select">
      @foreach(['scheduled'=>'Gepland','confirmed'=>'Bevestigd','cancelled'=>'Geannuleerd'] as $val=>$label)
        <option value="{{ $val }}" @selected($appointment->status === $val)>{{ $label }}</option>
      @endforeach
    </select>
  </div>
  <div class="mb-3"><label>Notities</label><textarea name="notes" class="form-control">{{ $appointment->notes }}</textarea></div>
  <button class="btn btn-primary">Opslaan</button>
</form>
@endsection