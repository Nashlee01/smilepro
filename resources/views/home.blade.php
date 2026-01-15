@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">SmilePro Dashboard</div>

                <div class="card-body">
                    <!-- Status message if present -->
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Welcome message and navigation links -->
                    <h2>Welkom bij SmilePro</h2>
                    <p>Als assistent kunt u hier patiënten beheren.</p>
                    <!-- Link to patients management -->
                    <a href="{{ route('patients.index') }}" class="btn btn-primary">Patiënten</a>
                    <!-- Link to employees management -->
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Medewerkers</a>
                    <!-- Link to availability management -->
                    <a href="{{ route('availabilities.index') }}" class="btn btn-info">Beschikbaarheid</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
