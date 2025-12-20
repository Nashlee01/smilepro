<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    // Display a list of employees (users with roles like assistant, dentist, etc.)
    public function index()
    {
        $employees = User::orderBy('name')->paginate(15); // Fetch employees sorted by name with pagination
        return view('employees.index', compact('employees')); // Pass employees to the view
    }

    // Show the form for creating a new employee
    public function create()
    {
        return view('employees.create'); // Render the create employee form
    }

    // Store a newly created employee in the database
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'], // Validate name
            'email' => ['required','email','max:255','unique:users,email'], // Validate email
            'role' => ['required','string','max:100'], // Validate role
            'active' => ['required','boolean'], // Validate active status
            'password' => ['nullable','string','min:8'], // Validate password (optional)
        ]);

        $data['status'] = $request->boolean('active') ? 'active' : 'inactive'; // Map active boolean to status enum
        unset($data['active']); // Remove active from data

        $data['password'] = Hash::make($data['password'] ?? 'newpassword123'); // Hash password or set default

        User::create($data); // Create the user in the database
        return redirect()->route('employees.index')->with('status','Medewerker aangemaakt'); // Redirect with success message
    }

    // Show the form for editing an existing employee
    public function edit(User $employee)
    {
        return view('employees.edit', compact('employee')); // Render the edit employee form
    }

    // Update an existing employee in the database
    public function update(Request $request, User $employee)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'], // Validate name
            'email' => ['required','email','max:255','unique:users,email,'.$employee->id], // Validate email
            'role' => ['required','string','max:100'], // Validate role
            'active' => ['required','boolean'], // Validate active status
            'password' => ['nullable','string','min:8'], // Validate password (optional)
        ]);

        $data['status'] = $request->boolean('active') ? 'active' : 'inactive'; // Map active boolean to status enum
        unset($data['active']); // Remove active from data

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']); // Hash password if provided
        } else {
            unset($data['password']); // Remove password if not provided
        }

        $employee->update($data); // Update the user in the database
        return redirect()->route('employees.index')->with('status','Medewerker bijgewerkt'); // Redirect with success message
    }

    // Delete an employee from the database
    public function destroy(User $employee)
    {
        $employee->delete(); // Delete the user
        return redirect()->route('employees.index')->with('status','Medewerker verwijderd'); // Redirect with success message
    }
}