<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'user_id',
        'employee_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'hire_date',
        'position',
        'specializations',
        'hourly_rate',
        'commission_rate',
        'is_active',
        'bio',
        'profile_image',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'specializations' => 'array',
        'hourly_rate' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'staff_services')
            ->withPivot('price_override')
            ->withTimestamps();
    }

    public function workSchedules(): HasMany
    {
        return $this->hasMany(WorkSchedule::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function ordersProcessed(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByPosition($query, string $position)
    {
        return $query->where('position', $position);
    }

    public function scopeAvailableForService($query, int $serviceId)
    {
        return $query->whereHas('services', function($q) use ($serviceId) {
            $q->where('services.id', $serviceId);
        });
    }

    // Business Logic Methods
    public function isAvailableAt(\DateTime $dateTime): bool
    {
        $dayOfWeek = strtolower($dateTime->format('l'));
        $time = $dateTime->format('H:i:s');

        $schedule = $this->workSchedules()
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->where('effective_date', '<=', $dateTime->format('Y-m-d'))
            ->where(function($q) use ($dateTime) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', $dateTime->format('Y-m-d'));
            })
            ->first();

        if (!$schedule) {
            return false;
        }

        return $time >= $schedule->start_time && $time <= $schedule->end_time;
    }

    public function canProvideService(int $serviceId): bool
    {
        return $this->services()->where('services.id', $serviceId)->exists();
    }

    public function getServicePrice(int $serviceId): ?float
    {
        $staffService = $this->services()
            ->where('services.id', $serviceId)
            ->first();

        if (!$staffService) {
            return null;
        }

        return $staffService->pivot->price_override ?? $staffService->base_price;
    }
}
