<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'duration_minutes',
        'base_price',
        'is_active',
        'requires_consultation',
        'image',
        'sort_order',
    ];

    protected $casts = [
        'duration_minutes' => 'integer',
        'base_price' => 'decimal:2',
        'is_active' => 'boolean',
        'requires_consultation' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function staff(): BelongsToMany
    {
        return $this->belongsToMany(Staff::class, 'staff_services')
            ->withPivot('price_override')
            ->withTimestamps();
    }

    public function appointmentServices(): HasMany
    {
        return $this->hasMany(AppointmentService::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, int $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function scopeAvailableStaff($query)
    {
        return $query->whereHas('staff', function($q) {
            $q->where('staff.is_active', true);
        });
    }

    // Accessors
    public function getDurationHoursAttribute(): float
    {
        return round($this->duration_minutes / 60, 2);
    }

    public function getFormattedDurationAttribute(): string
    {
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;

        if ($hours > 0 && $minutes > 0) {
            return "{$hours}h {$minutes}m";
        } elseif ($hours > 0) {
            return "{$hours}h";
        } else {
            return "{$minutes}m";
        }
    }

    // Business Logic Methods
    public function getAvailableStaff()
    {
        return $this->staff()->where('staff.is_active', true)->get();
    }

    public function getPriceForStaff(int $staffId): float
    {
        $staff = $this->staff()->where('staff.id', $staffId)->first();
        
        if (!$staff) {
            return $this->base_price;
        }

        return $staff->pivot->price_override ?? $this->base_price;
    }

    public function getAverageRating(): float
    {
        return $this->reviews()
            ->where('is_approved', true)
            ->avg('rating') ?? 0;
    }

    public function getReviewsCount(): int
    {
        return $this->reviews()
            ->where('is_approved', true)
            ->count();
    }
}
