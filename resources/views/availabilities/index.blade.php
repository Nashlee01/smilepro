@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8 gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Medewerker Beschikbaarheid</h1>
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('availabilities.create') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-center">
                Nieuwe Beschikbaarheid
            </a>
            <div class="flex items-center">
                <input type="date" 
                       id="datePicker" 
                       value="{{ $selectedDate }}" 
                       class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
            </div>
        </div>
    </div>

    <div id="availabilityContainer">
        @include('availabilities.partials.availability_list', ['availabilities' => $availabilities])
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const datePicker = document.getElementById('datePicker');
    const availabilityContainer = document.getElementById('availabilityContainer');
    
    datePicker.addEventListener('change', function() {
        const selectedDate = this.value;
        
        // Show loading state
        availabilityContainer.innerHTML = `
            <div class="flex justify-center items-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
            </div>
        `;
        
        // Fetch availability for the selected date
        fetch(`/availabilities/date/${selectedDate}`)
            .then(response => response.json())
            .then(data => {
                if (data.availabilities && data.availabilities.length > 0) {
                    // Reload the page with the selected date to show the full view
                    window.location.href = `?date=${selectedDate}`;
                } else {
                    availabilityContainer.innerHTML = `
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="p-6 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-lg font-medium text-gray-900">Geen beschikbaarheid</h3>
                                <p class="mt-1 text-sm text-gray-500">Er is geen beschikbaarheid gevonden voor ${new Date(selectedDate).toLocaleDateString('nl-NL', {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'})}.</p>
                            </div>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                availabilityContainer.innerHTML = `
                    <div class="bg-red-50 border-l-4 border-red-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">Er is een fout opgetreden bij het ophalen van de beschikbaarheid. Probeer het opnieuw.</p>
                            </div>
                        </div>
                    </div>
                `;
            });
    });
});
</script>
@endpush
@endsection
