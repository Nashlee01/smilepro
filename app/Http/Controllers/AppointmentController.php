<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::orderBy('appointment_date','desc')->paginate(15);
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('appointments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_name' => ['required','string','max:255'],
            'employee_name' => ['required','string','max:255'],
            'appointment_date' => ['required','date'],
            'status' => ['nullable','string','in:scheduled,confirmed,cancelled'],
            'notes' => ['nullable','string'],
        ]);

        Appointment::create($data);
        return redirect()->route('appointments.index')->with('status','Afspraak aangemaakt');
    }

    public function edit(Appointment $appointment)
    {
        return view('appointments.edit', compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'client_name' => ['required','string','max:255'],
            'employee_name' => ['required','string','max:255'],
            'appointment_date' => ['required','date'],
            'status' => ['nullable','string','in:scheduled,confirmed,cancelled'],
            'notes' => ['nullable','string'],
        ]);

        $appointment->update($data);
        return redirect()->route('appointments.index')->with('status','Afspraak bijgewerkt');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('status','Afspraak verwijderd');
    }
}