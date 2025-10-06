<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use MongoDB\Laravel\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    // Use MongoDB connection
    protected $connection = 'mongodb';
    protected $collection = 'services';
    
    // MongoDB uses _id as primary key
    protected $primaryKey = '_id';

    protected $fillable = [
        'name',
        'slug',
        'category',
        'description', 
        'price',
        'duration',
        'active',
        'visibility',
        'image',
        'features',
        'tags',
    ];

    protected $casts = [
        'price' => 'float',
        'duration' => 'integer',
        'active' => 'boolean',
        'features' => 'array',
        'tags' => 'array',
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
        return $query->where('active', true);
    }

    public function scopePublic($query)
    {
        return $query->where('active', true)->where('visibility', 'public');
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
