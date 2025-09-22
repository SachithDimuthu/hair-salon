<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'staff_id',
        'appointment_date',
        'start_time',
        'end_time',
        'status',
        'total_amount',
        'deposit_amount',
        'payment_status',
        'notes',
        'cancellation_reason',
        'cancelled_at',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'total_amount' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'cancelled_at' => 'datetime',
    ];

    // Relationships
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function appointmentServices(): HasMany
    {
        return $this->hasMany(AppointmentService::class);
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now()->toDateString())
                    ->whereNotIn('status', ['cancelled', 'completed']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeToday($query)
    {
        return $query->where('appointment_date', now()->toDateString());
    }

    // Business Logic Methods
    public function isOverlapping(string $date, string $startTime, string $endTime, ?int $staffId = null): bool
    {
        $query = static::whereDate('appointment_date', $date)
            ->where('staff_id', $staffId ?? $this->staff_id)
            ->whereNotIn('status', ['cancelled'])
            ->where(function ($q) use ($startTime, $endTime) {
                // Two time ranges overlap if:
                // 1. New start time is during existing appointment
                // 2. New end time is during existing appointment  
                // 3. New appointment completely contains existing appointment
                // 4. Existing appointment completely contains new appointment
                $q->where(function ($subQ) use ($startTime, $endTime) {
                    // New start time is before existing end AND new end time is after existing start
                    $subQ->where('start_time', '<', $endTime)
                         ->where('end_time', '>', $startTime);
                });
            });

        if ($this->exists) {
            $query->where('id', '!=', $this->id);
        }

        return $query->exists();
    }

    public function calculateDuration(): int
    {
        $start = \Carbon\Carbon::parse($this->start_time);
        $end = \Carbon\Carbon::parse($this->end_time);
        return $start->diffInMinutes($end);
    }
}
