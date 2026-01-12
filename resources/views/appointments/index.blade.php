@extends('layouts.app')
@section('content')
<h1>Afspraakoverzicht</h1>
<a class="btn btn-primary" href="{{ route('appointments.create') }}">Nieuwe afspraak</a>
<table class="table mt-3">
  <thead><tr><th>Client</th><th>Medewerker</th><th>Datum</th><th>Status</th><th></th></tr></thead>
  <tbody>
    @foreach($appointments as $a)
      <tr>
        <td>{{ $a->client_name }}</td>
        <td>{{ $a->employee_name }}</td>
        <td>{{ $a->appointment_date->format('d-m-Y H:i') }}</td>
        <td>{{ ucfirst($a->status) }}</td>
        <td class="text-end">
          <a class="btn btn-sm btn-secondary" href="{{ route('appointments.edit',$a) }}">Bewerken</a>
          <form method="POST" action="{{ route('appointments.destroy',$a) }}" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Verwijderen</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection