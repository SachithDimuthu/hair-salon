<div class="max-w-7xl mx-auto p-6">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Staff Schedule</h2>
        <p class="text-lg text-gray-600">Manage staff work schedules and view appointments</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Controls -->
    <div class="mb-6 flex flex-col md:flex-row gap-4 items-start md:items-center justify-between">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Staff Selection -->
            <div>
                <label for="staff_select" class="block text-sm font-medium text-gray-700 mb-1">Staff Member</label>
                <select id="staff_select" wire:model.live="selectedStaff" 
                        class="px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <option value="">Select Staff Member</option>
                    @foreach($staff_members as $staff)
                        <option value="{{ $staff->id }}">{{ $staff->first_name }} {{ $staff->last_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date Selection -->
            <div>
                <label for="date_select" class="block text-sm font-medium text-gray-700 mb-1">Week Starting</label>
                <input type="date" id="date_select" wire:model.live="selectedDate" 
                       class="px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
        </div>

        <!-- Week Navigation -->
        <div class="flex items-center gap-2">
            <button wire:click="previousWeek" 
                    class="px-3 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-md">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            
            <span class="text-sm font-medium text-gray-900 px-4">
                {{ $currentWeek->format('M j') }} - {{ $currentWeek->copy()->endOfWeek()->format('M j, Y') }}
            </span>
            
            <button wire:click="nextWeek" 
                    class="px-3 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-md">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>

    @if($selectedStaff)
        <!-- Schedule Grid -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Header with days -->
            <div class="grid grid-cols-8 bg-gray-50 border-b">
                <div class="p-4 text-sm font-medium text-gray-900">Time</div>
                @foreach($weekDates as $date)
                    <div class="p-4 text-center border-l">
                        <div class="text-sm font-medium text-gray-900">{{ $date->format('D') }}</div>
                        <div class="text-sm text-gray-600">{{ $date->format('M j') }}</div>
                        @php
                            $dayName = $date->format('l');
                            $schedule = $workSchedules[$dayName] ?? null;
                        @endphp
                        @if($schedule && $schedule['available'])
                            <div class="text-xs text-green-600 mt-1">
                                {{ $schedule['start'] }} - {{ $schedule['end'] }}
                            </div>
                            <button wire:click="editSchedule('{{ $dayName }}')" 
                                    class="text-xs text-indigo-600 hover:text-indigo-800 mt-1">
                                Edit
                            </button>
                        @else
                            <div class="text-xs text-red-600 mt-1">Unavailable</div>
                            <button wire:click="editSchedule('{{ $dayName }}')" 
                                    class="text-xs text-indigo-600 hover:text-indigo-800 mt-1">
                                Set Hours
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Time slots and appointments -->
            <div class="max-h-96 overflow-y-auto">
                @php
                    $timeSlots = collect();
                    foreach($weekDates as $date) {
                        $slots = $this->getTimeSlots($date);
                        $timeSlots = $timeSlots->merge($slots);
                    }
                    $timeSlots = $timeSlots->unique()->sort()->values();
                @endphp

                @foreach($timeSlots as $time)
                    <div class="grid grid-cols-8 border-b border-gray-100 min-h-[60px]">
                        <!-- Time column -->
                        <div class="p-3 text-sm text-gray-600 bg-gray-50 border-r">
                            {{ Carbon\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}
                        </div>

                        <!-- Day columns -->
                        @foreach($weekDates as $date)
                            <div class="p-2 border-l relative">
                                @php
                                    $dayName = $date->format('l');
                                    $schedule = $workSchedules[$dayName] ?? null;
                                    $appointment = null;
                                    
                                    if ($schedule && $schedule['available']) {
                                        $appointment = $this->getAppointmentForTimeSlot($date, $time);
                                    }
                                @endphp

                                @if($schedule && $schedule['available'])
                                    @if($appointment)
                                        <div class="bg-blue-100 border border-blue-300 rounded p-2 text-xs">
                                            <div class="font-semibold text-blue-900">
                                                {{ $appointment->customer->name ?? 'Unknown' }}
                                            </div>
                                            <div class="text-blue-700">
                                                {{ $appointment->start_time }} - {{ $appointment->end_time }}
                                            </div>
                                            @if($appointment->appointmentServices->count() > 0)
                                                <div class="text-blue-600 mt-1">
                                                    {{ $appointment->appointmentServices->first()->service->name }}
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <!-- Available time slot -->
                                        <div class="h-full bg-green-50 rounded border border-green-200 flex items-center justify-center opacity-50 hover:opacity-75 transition-opacity">
                                            <span class="text-xs text-green-600">Available</span>
                                        </div>
                                    @endif
                                @else
                                    <!-- Unavailable time slot -->
                                    <div class="h-full bg-gray-100 rounded border border-gray-200"></div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach

                @if($timeSlots->isEmpty())
                    <div class="grid grid-cols-8">
                        <div class="col-span-8 p-8 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>No schedule set for this staff member.</p>
                            <p class="text-sm mt-1">Click "Set Hours" to configure working hours.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Schedule Summary -->
        <div class="mt-6 bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Week Summary</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">
                        {{ $appointments->flatten()->count() }}
                    </div>
                    <div class="text-sm text-gray-600">Total Appointments</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">
                        @php
                            $totalHours = 0;
                            foreach($workSchedules as $day => $schedule) {
                                if ($schedule['available']) {
                                    $start = Carbon\Carbon::createFromFormat('H:i', $schedule['start']);
                                    $end = Carbon\Carbon::createFromFormat('H:i', $schedule['end']);
                                    $totalHours += $end->diffInHours($start);
                                }
                            }
                        @endphp
                        {{ $totalHours }}h
                    </div>
                    <div class="text-sm text-gray-600">Scheduled Hours</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">
                        ${{ number_format($appointments->flatten()->sum('total_amount') ?? 0, 2) }}
                    </div>
                    <div class="text-sm text-gray-600">Revenue</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-orange-600">
                        {{ $workSchedules->where('available', true)->count() }}
                    </div>
                    <div class="text-sm text-gray-600">Working Days</div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Select a staff member</h3>
            <p class="mt-1 text-sm text-gray-500">Choose a staff member to view their schedule and appointments.</p>
        </div>
    @endif

    <!-- Schedule Edit Modal -->
    @if($showScheduleModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Edit Schedule - {{ $schedule_day_of_week }}
                    </h3>
                    
                    <form wire:submit="saveSchedule" class="space-y-4">
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="schedule_is_available" 
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-900">Available for work</span>
                            </label>
                        </div>

                        @if($schedule_is_available)
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Start Time</label>
                                    <input type="time" wire:model="schedule_start_time" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('schedule_start_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">End Time</label>
                                    <input type="time" wire:model="schedule_end_time" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('schedule_end_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Break Start (Optional)</label>
                                    <input type="time" wire:model="schedule_break_start" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Break End (Optional)</label>
                                    <input type="time" wire:model="schedule_break_end" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        @endif

                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" wire:click="closeScheduleModal" 
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700">
                                Save Schedule
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
