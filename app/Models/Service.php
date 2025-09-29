<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use MongoDB\Laravel\Eloquent\Model;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    // Store service records inside MongoDB
    protected $connection = 'mongodb';

    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'base_price',
        'image',
        'durations',
        'tags',
        'active',
        'staff_ids',
        'addon_ids',
        'visibility',
        'rating',
        'booking_constraints',
    ];

    protected $casts = [
        'base_price' => 'float',
        'active' => 'boolean',
        'rating' => 'float',
        'durations' => 'array',
        'tags' => 'array',
        'staff_ids' => 'array',
        'addon_ids' => 'array',
        'booking_constraints' => 'array',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

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
        return $query->where('visibility', 'public');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeWithTags($query, array $tags)
    {
        return $query->whereIn('tags', $tags);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
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

    public function getBasePriceAttribute($value)
    {
        if ($value instanceof \MongoDB\BSON\Decimal128) {
            return (float) $value->__toString();
        }
        return (float) $value;
    }
}
