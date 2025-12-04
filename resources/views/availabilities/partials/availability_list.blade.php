@if($availabilities->count() > 0)
    <div class="space-y-6">
        @foreach($availabilities as $userId => $slots)
            @php
                $user = $slots->first()->user;
                $date = $slots->first()->date;
            @endphp
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($date)->translatedFormat('l d F Y') }}</p>
                </div>
                <div class="bg-gray-50 px-6 py-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Beschikbare tijdsloten:</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($slots as $slot)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">Geen beschikbaarheid</h3>
            <p class="mt-1 text-sm text-gray-500">Er is geen beschikbaarheid gevonden voor de geselecteerde datum.</p>
        </div>
    </div>
@endif
