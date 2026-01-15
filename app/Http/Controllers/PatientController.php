<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Controller for handling patient-related operations.
 *
 * This controller manages the CRUD operations for patients,
 * including listing, creating, and storing patient records.
 */
class PatientController extends Controller
{
    /**
     * Display a listing of patients.
     *
     * Shows all patients in a table format.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $patients = Patient::all(); // Retrieve all patients from database
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new patient.
     *
     * Displays the patient creation form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created patient in storage.
     *
     * Validates the input data, creates the patient record,
     * and handles any technical errors that may occur.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',     // First name is required
            'last_name' => 'required|string|max:255',      // Last name is required
            'email' => 'required|email|unique:patients,email', // Email must be unique
            'phone' => 'nullable|string|max:20',           // Phone is optional
            'date_of_birth' => 'nullable|date',            // Date of birth optional
            'address' => 'nullable|string',                // Address is optional
        ]);

        // If validation fails, redirect back with errors and input
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Attempt to create the patient record
        try {
            Patient::create($request->all());
            // Success: redirect to index with success message
            return redirect()->route('patients.index')->with('success', 'Patiënt succesvol toegevoegd');
        } catch (\Exception $e) {
            // Technical error: redirect back with error message and input preserved
            return redirect()->back()
                ->with('error', 'Er is iets misgegaan. Probeer het opnieuw.')
                ->withInput();
        }
    }
}