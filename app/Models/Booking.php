<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Booking extends Model
{
    protected $fillable = [
        'customer_id',
        'customer_first_name',
        'customer_last_name',
        'customer_email',
        'customer_phone',
        'service_id',
        'service_name',
        'service_price',
        'booking_date',
        'booking_time',
        'duration_minutes',
        'total_price',
        'special_requests',
        'status',
        'admin_notes',
        'staff_id'
    ];

    protected $casts = [
        'booking_date' => 'date',
        'booking_time' => 'datetime:H:i',
        'service_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'duration_minutes' => 'integer'
    ];

    // Relationships
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    // Service relationship (MongoDB Service)
    public function service()
    {
        return Service::where('_id', $this->service_id)->first();
    }

    // Accessors
    public function getCustomerFullNameAttribute(): string
    {
        return $this->customer_first_name . ' ' . $this->customer_last_name;
    }

    public function getBookingDateTimeAttribute(): Carbon
    {
        return Carbon::parse($this->booking_date . ' ' . $this->booking_time);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'in-progress' => 'purple',
            'completed' => 'green',
            'cancelled' => 'red',
            default => 'gray'
        };
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('booking_date', '>=', now()->toDateString())
                    ->whereIn('status', ['pending', 'confirmed']);
    }

    public function scopeToday($query)
    {
        return $query->where('booking_date', now()->toDateString());
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereRaw("strftime('%m', booking_date) = ?", [now()->format('m')])
                    ->whereRaw("strftime('%Y', booking_date) = ?", [now()->format('Y')]);
    }

    // Status methods
    public function confirm()
    {
        $this->update(['status' => 'confirmed']);
    }

    public function complete()
    {
        $this->update(['status' => 'completed']);
    }

    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
    }

    public function startService()
    {
        $this->update(['status' => 'in-progress']);
    }

    // Static methods for analytics
    public static function getStatusDistribution()
    {
        return self::selectRaw('status, COUNT(*) as count')
                  ->groupBy('status')
                  ->pluck('count', 'status')
                  ->toArray();
    }

    public static function getMonthlyTrends($months = 6)
    {
        return self::selectRaw("strftime('%Y', booking_date) as year, strftime('%m', booking_date) as month, COUNT(*) as count")
                  ->where('booking_date', '>=', now()->subMonths($months))
                  ->groupBy('year', 'month')
                  ->orderBy('year')
                  ->orderBy('month')
                  ->get();
    }

    public static function getPopularServices($limit = 5)
    {
        return self::selectRaw('service_name, service_id, COUNT(*) as booking_count')
                  ->groupBy('service_name', 'service_id')
                  ->orderBy('booking_count', 'desc')
                  ->limit($limit)
                  ->get();
    }

    public static function getTodayRevenue()
    {
        return self::where('booking_date', now()->toDateString())
                  ->whereIn('status', ['confirmed', 'completed'])
                  ->sum('total_price');
    }

    public static function getMonthlyRevenue()
    {
        return self::thisMonth()
                  ->whereIn('status', ['confirmed', 'completed'])
                  ->sum('total_price');
    }
}
