<?php

namespace App\Http\Controllers;

use App\Models\EmployeeAvailability;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvailabilityController extends Controller
{
    public function create()
    {
        return view('availabilities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $startDateTime = Carbon::parse($validated['date'] . ' ' . $validated['start_time']);
        $endDateTime = Carbon::parse($validated['date'] . ' ' . $validated['end_time']);

        $existing = EmployeeAvailability::where('user_id', auth()->id())
            ->where('date', $validated['date'])
            ->where(function($query) use ($startDateTime, $endDateTime) {
                $query->whereBetween('start_time', [$startDateTime->format('H:i:s'), $endDateTime->format('H:i:s')])
                      ->orWhereBetween('end_time', [$startDateTime->format('H:i:s'), $endDateTime->format('H:i:s')])
                      ->orWhere(function($q) use ($startDateTime, $endDateTime) {
                          $q->where('start_time', '<=', $startDateTime->format('H:i:s'))
                            ->where('end_time', '>=', $endDateTime->format('H:i:s'));
                      });
            })
            ->exists();

        if ($existing) {
            return back()->with('error', 'Er is al een beschikbaarheid in dit tijdsblok.');
        }

        EmployeeAvailability::create([
            'user_id' => auth()->id(),
            'date' => $validated['date'],
            'start_time' => $startDateTime->format('H:i:s'),
            'end_time' => $endDateTime->format('H:i:s'),
        ]);

        return redirect()->route('availabilities.index')
            ->with('success', 'Beschikbaarheid succesvol toegevoegd!');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedDate = $request->input('date') ?? now()->toDateString();
        
        if ($user->role === 'practicemanager') {
            $availabilities = EmployeeAvailability::with('user')
                ->where('date', '>=', now()->toDateString())
                ->orderBy('date')
                ->orderBy('start_time')
                ->get()
                ->groupBy('user_id');
        } else {
            $availabilities = $user->availabilities()
                ->where('date', '>=', now()->toDateString())
                ->orderBy('date')
                ->orderBy('start_time')
                ->get()
                ->groupBy('user_id');
        }

        return view('availabilities.index', [
            'availabilities' => $availabilities,
            'selectedDate' => $selectedDate
        ]);
    }

    public function getByDate($date)
    {
        $availabilities = EmployeeAvailability::with('user')
            ->whereDate('date', $date)
            ->orderBy('start_time')
            ->get()
            ->groupBy('user_id');

        return response()->json($availabilities);
    }
}
