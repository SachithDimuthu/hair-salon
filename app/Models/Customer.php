<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'city',
        'postal_code',
        'emergency_contact_name',
        'emergency_contact_phone',
        'notes',
        'is_active',
        'last_visit_at',
        'total_visits',
        'total_spent',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'last_visit_at' => 'datetime',
        'is_active' => 'boolean',
        'total_spent' => 'decimal:2',
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

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
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

    public function scopeWithUpcomingAppointments($query)
    {
        return $query->whereHas('appointments', function($q) {
            $q->where('appointment_date', '>=', now()->toDateString())
              ->where('status', '!=', 'cancelled');
        });
    }

    // Business Logic Methods
    public function updateVisitStats(): void
    {
        $this->total_visits = $this->appointments()->where('status', 'completed')->count();
        $this->total_spent = $this->orders()->where('status', 'completed')->sum('total_amount');
        $this->last_visit_at = $this->appointments()
            ->where('status', 'completed')
            ->latest('appointment_date')
            ->value('appointment_date');
        $this->save();
    }

    public function hasUpcomingAppointments(): bool
    {
        return $this->appointments()
            ->where('appointment_date', '>=', now()->toDateString())
            ->where('status', '!=', 'cancelled')
            ->exists();
    }
}
