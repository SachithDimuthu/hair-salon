<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deal extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'deals';

    protected $fillable = [
        'DealName',
        'Description',
        'DiscountPercentage',
        'StartDate',
        'EndDate',
        'IsActive',
        'ServiceID',
        'Terms', // Additional terms and conditions
        'MaxUses', // Maximum number of times this deal can be used
        'CurrentUses', // Current usage count
    ];

    protected $casts = [
        'DiscountPercentage' => 'decimal:2',
        'IsActive' => 'boolean',
        'StartDate' => 'date',
        'EndDate' => 'date',
        'MaxUses' => 'integer',
        'CurrentUses' => 'integer',
    ];

    // MongoDB doesn't need primary key specification
    // The _id field is automatically used

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'ServiceID', 'id');
    }

    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(Admin::class, 'admin_deal', 'DealID', 'AdminID')
                    ->withTimestamps();
    }

    // MongoDB-specific scopes
    public function scopeActive($query)
    {
        return $query->where('IsActive', true)
                    ->where('StartDate', '<=', now())
                    ->where('EndDate', '>=', now());
    }

    public function scopeByService($query, $serviceId)
    {
        return $query->where('ServiceID', $serviceId);
    }

    // Helper method to check if deal is still available
    public function isAvailable()
    {
        if (!$this->IsActive) return false;
        if (now()->lt($this->StartDate) || now()->gt($this->EndDate)) return false;
        if ($this->MaxUses && $this->CurrentUses >= $this->MaxUses) return false;
        
        return true;
    }
}
