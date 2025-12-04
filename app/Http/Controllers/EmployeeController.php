<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        try {
            // Redirect to login if not authenticated
            if (!Auth::check()) {
                return redirect()->route('login');
            }

            // Only allow practicemanagers to view the employee list
            if (Auth::user()->role !== 'practicemanager') {
                abort(403, 'Unauthorized action.');
            }

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
