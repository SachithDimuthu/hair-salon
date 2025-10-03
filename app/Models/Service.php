<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    // Temporarily use MySQL instead of MongoDB
    protected $connection = 'mysql';
    
    // Use the correct primary key from migration
    protected $primaryKey = 'ServiceID';

    protected $fillable = [
        'ServiceName',
        'Description', 
        'Price',
        'Visibility',
        'ServicePhoto',
    ];

    protected $casts = [
        'Visibility' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_service', 'ServiceID', 'CustomerID')
                    ->withPivot(['Status', 'BookingDate', 'Notes', 'created_at', 'updated_at'])
                    ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('Visibility', true);
    }

    public function scopePublic($query)
    {
        return $query->where('Visibility', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('ServiceName', 'like', '%' . $category . '%');
    }

    public function scopeWithTags($query, array $tags)
    {
        return $query->whereIn('tags', $tags);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('ServiceName', 'like', '%' . $search . '%');
    }

    // Accessors
    public function getAveragePriceAttribute()
    {
        if (empty($this->durations)) {
            return $this->base_price;
        }
        
        $total = collect($this->durations)->sum('price');
        return $total / count($this->durations);
    }

    // Relationship with bookings
    public function bookings()
    {
        return $this->hasMany(\App\Models\Booking::class, 'service_id', 'ServiceID');
    }

    // Get booking count for this service
    public function getBookingCountAttribute()
    {
        return $this->bookings()->count();
    }

    // Get total revenue from this service
    public function getTotalRevenueAttribute()
    {
        return $this->bookings()
            ->whereIn('status', ['confirmed', 'completed'])
            ->sum('total_price');
    }
}
