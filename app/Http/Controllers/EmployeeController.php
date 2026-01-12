<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    private function authorizePracticeManager(): void
    {
        if (!Auth::check()) {
            abort(403);
        }
        if (Auth::user()->role !== 'practicemanager') {
            abort(403, 'Unauthorized action.');
        }
    }

    public function index()
    {
        // AuthN + AuthZ outside try so 403 isn't swallowed
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->role !== 'practicemanager') {
            abort(403, 'Unauthorized action.');
        }
        try {

            // Get all users except practice managers using JOIN with employee_availabilities
            $employees = User::select('users.*')
                ->leftJoin('employee_availabilities', function($join) {
                    $join->on('users.id', '=', 'employee_availabilities.user_id')
                         ->whereDate('employee_availabilities.date', now()->format('Y-m-d'));
                })
                ->where('role', '!=', 'practicemanager')
                ->with(['availabilities' => function($query) {
                    $query->whereDate('date', now()->format('Y-m-d'));
                }])
                ->groupBy('users.id')
                ->get();
                
            return view('employees.index', [
                'employees' => $employees
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in EmployeeController@index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het ophalen van de medewerkersgegevens.');
        }
    }

    public function create()
    {
        $this->authorizePracticeManager();
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $this->authorizePracticeManager();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role'  => ['required', 'in:dentist,assistant'],
            'status'=> ['nullable', 'in:active,inactive'],
            'active'=> ['nullable', 'boolean'], // backward compatibility with existing views
        ]);

        $status = $validated['status'] ?? (($request->boolean('active')) ? 'active' : 'inactive');

        // Generate a temporary password; hashing handled by cast
        $tempPassword = Str::random(12);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'status' => $status,
            'password' => $tempPassword,
        ]);

        return redirect()->route('employees.index')
            ->with('success', 'Medewerker aangemaakt. Vraag de gebruiker om het wachtwoord te resetten.');
    }

    public function edit(User $employee)
    {
        $this->authorizePracticeManager();
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, User $employee)
    {
        $this->authorizePracticeManager();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $employee->id],
            'role'  => ['required', 'in:dentist,assistant'],
            'status'=> ['nullable', 'in:active,inactive'],
            'active'=> ['nullable', 'boolean'],
        ]);

        $status = $validated['status'] ?? (($request->boolean('active')) ? 'active' : 'inactive');

        $employee->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'status' => $status,
        ]);

        return redirect()->route('employees.index')->with('success', 'Medewerker bijgewerkt.');
    }

    public function destroy(User $employee)
    {
        $this->authorizePracticeManager();

        // Prevent deleting practice managers by route-model binding misuse
        if ($employee->role === 'practicemanager') {
            return redirect()->route('employees.index')->with('error', 'Practicemanagers kunnen niet verwijderd worden.');
        }

        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Medewerker verwijderd.');
    }

    /**
     * Get employee availability using stored procedure
     */
    public function getEmployeeAvailability($employeeId, $date = null)
    {
        try {
            if (is_null($date)) {
                $date = now()->format('Y-m-d');
            }

            // Using the stored procedure
            $results = DB::select(
                'CALL GetEmployeeAvailability(?, ?)', 
                [$employeeId, $date]
            );

            return response()->json([
                'success' => true,
                'data' => $results
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error fetching employee availability: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Er is een fout opgetreden bij het ophalen van de beschikbaarheid.'
            ], 500);
        }
    }
}
