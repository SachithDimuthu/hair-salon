<?php

namespace App\Livewire;

use App\Models\Staff;
use App\Models\Appointment;
use App\Models\WorkSchedule;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Validate;

class StaffSchedule extends Component
{
    public $selectedStaff = null;
    public $selectedDate;
    public $currentWeek;
    public $weekDates = [];
    public $staff_members = [];
    public $appointments = [];
    public $workSchedules = [];
    public $viewMode = 'week'; // week, day

    // Schedule editing properties
    public $showScheduleModal = false;
    public $editingSchedule = null;

    #[Validate('required')]
    public $schedule_day_of_week;

    #[Validate('required')]
    public $schedule_start_time;

    #[Validate('required')]
    public $schedule_end_time;

    #[Validate('nullable')]
    public $schedule_break_start;

    #[Validate('nullable')]
    public $schedule_break_end;

    public $schedule_is_available = true;

    public function mount()
    {
        $this->selectedDate = Carbon::today()->format('Y-m-d');
        $this->currentWeek = Carbon::today()->startOfWeek();
        $this->generateWeekDates();
        $this->staff_members = Staff::where('is_active', true)->orderBy('first_name')->get();
        
        if ($this->staff_members->count() > 0) {
            $this->selectedStaff = $this->staff_members->first()->id;
        }
        
        $this->loadScheduleData();
    }

    public function generateWeekDates()
    {
        $this->weekDates = [];
        $date = $this->currentWeek->copy();
        
        for ($i = 0; $i < 7; $i++) {
            $this->weekDates[] = $date->copy();
            $date->addDay();
        }
    }

    public function previousWeek()
    {
        $this->currentWeek->subWeek();
        $this->generateWeekDates();
        $this->loadScheduleData();
    }

    public function nextWeek()
    {
        $this->currentWeek->addWeek();
        $this->generateWeekDates();
        $this->loadScheduleData();
    }

    public function updatedSelectedStaff()
    {
        $this->loadScheduleData();
    }

    public function updatedSelectedDate()
    {
        $this->currentWeek = Carbon::parse($this->selectedDate)->startOfWeek();
        $this->generateWeekDates();
        $this->loadScheduleData();
    }

    public function loadScheduleData()
    {
        if (!$this->selectedStaff) {
            $this->appointments = collect();
            $this->workSchedules = collect();
            return;
        }

        // Load appointments for the week
        $weekStart = $this->currentWeek->copy()->startOfDay();
        $weekEnd = $this->currentWeek->copy()->endOfWeek()->endOfDay();

        $this->appointments = Appointment::with(['customer', 'appointmentServices.service'])
            ->where('staff_id', $this->selectedStaff)
            ->whereBetween('appointment_date', [$weekStart->format('Y-m-d'), $weekEnd->format('Y-m-d')])
            ->where('status', '!=', 'cancelled')
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->get()
            ->groupBy('appointment_date');

        // Load work schedules (assuming basic daily schedules for now)
        $this->workSchedules = collect([
            'Monday' => ['start' => '09:00', 'end' => '17:00', 'available' => true],
            'Tuesday' => ['start' => '09:00', 'end' => '17:00', 'available' => true],
            'Wednesday' => ['start' => '09:00', 'end' => '17:00', 'available' => true],
            'Thursday' => ['start' => '09:00', 'end' => '17:00', 'available' => true],
            'Friday' => ['start' => '09:00', 'end' => '17:00', 'available' => true],
            'Saturday' => ['start' => '10:00', 'end' => '16:00', 'available' => true],
            'Sunday' => ['start' => '10:00', 'end' => '14:00', 'available' => false],
        ]);
    }

    public function editSchedule($dayOfWeek)
    {
        $this->editingSchedule = $dayOfWeek;
        $schedule = $this->workSchedules[$dayOfWeek] ?? null;
        
        if ($schedule) {
            $this->schedule_day_of_week = $dayOfWeek;
            $this->schedule_start_time = $schedule['start'];
            $this->schedule_end_time = $schedule['end'];
            $this->schedule_is_available = $schedule['available'];
            $this->schedule_break_start = $schedule['break_start'] ?? '';
            $this->schedule_break_end = $schedule['break_end'] ?? '';
        } else {
            $this->resetScheduleForm();
            $this->schedule_day_of_week = $dayOfWeek;
        }
        
        $this->showScheduleModal = true;
    }

    public function saveSchedule()
    {
        $this->validate();

        // In a real application, you would save this to the WorkSchedule model
        $this->workSchedules[$this->schedule_day_of_week] = [
            'start' => $this->schedule_start_time,
            'end' => $this->schedule_end_time,
            'available' => $this->schedule_is_available,
            'break_start' => $this->schedule_break_start,
            'break_end' => $this->schedule_break_end,
        ];

        $this->closeScheduleModal();
        session()->flash('message', 'Schedule updated successfully!');
    }

    public function closeScheduleModal()
    {
        $this->showScheduleModal = false;
        $this->resetScheduleForm();
    }

    public function resetScheduleForm()
    {
        $this->reset([
            'editingSchedule',
            'schedule_day_of_week',
            'schedule_start_time',
            'schedule_end_time',
            'schedule_break_start',
            'schedule_break_end',
            'schedule_is_available'
        ]);
    }

    public function getTimeSlots($date)
    {
        $dayName = $date->format('l');
        $schedule = $this->workSchedules[$dayName] ?? null;
        
        if (!$schedule || !$schedule['available']) {
            return collect();
        }

        $slots = collect();
        $start = Carbon::createFromFormat('H:i', $schedule['start']);
        $end = Carbon::createFromFormat('H:i', $schedule['end']);
        
        while ($start->lt($end)) {
            $slots->push($start->format('H:i'));
            $start->addMinutes(30);
        }
        
        return $slots;
    }

    public function getAppointmentForTimeSlot($date, $time)
    {
        $dateKey = $date->format('Y-m-d');
        $appointments = $this->appointments[$dateKey] ?? collect();
        
        return $appointments->first(function ($appointment) use ($time) {
            $startTime = Carbon::createFromFormat('H:i', $appointment->start_time);
            $endTime = Carbon::createFromFormat('H:i', $appointment->end_time);
            $checkTime = Carbon::createFromFormat('H:i', $time);
            
            return $checkTime->between($startTime, $endTime->subMinute());
        });
    }

    public function render()
    {
        return view('livewire.staff-schedule');
    }
}
