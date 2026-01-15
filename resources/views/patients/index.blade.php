<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patiënten Overzicht</title>
    <!-- Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Patiënten</h1>
        <!-- Link to create new patient -->
        <a href="{{ route('patients.create') }}" class="btn btn-primary mb-3">Nieuwe patiënt</a>
        <!-- Display success message if patient was added -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <!-- Table displaying all patients -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Voornaam</th>
                    <th>Achternaam</th>
                    <th>Email</th>
                    <th>Telefoon</th>
                    <th>Geboortedatum</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through patients and display each in a row -->
                @foreach($patients as $patient)
                <tr>
                    <td>{{ $patient->id }}</td>
                    <td>{{ $patient->first_name }}</td>
                    <td>{{ $patient->last_name }}</td>
                    <td>{{ $patient->email }}</td>
                    <td>{{ $patient->phone }}</td>
                    <td>{{ $patient->date_of_birth ? $patient->date_of_birth->format('d-m-Y') : '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>