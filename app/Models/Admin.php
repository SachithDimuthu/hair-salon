<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'AdminName',
        'Email',
        'Password',
        'Role',
        'ContactNumber',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    protected $casts = [
        'Password' => 'hashed',
    ];

    protected $primaryKey = 'AdminID';

    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'admin_customer', 'AdminID', 'CustomerID')
                    ->withTimestamps();
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'admin_service', 'AdminID', 'ServiceID')
                    ->withTimestamps();
    }

    public function deals(): BelongsToMany
    {
        return $this->belongsToMany(Deal::class, 'admin_deal', 'AdminID', 'DealID')
                    ->withTimestamps();
    }

    public function getAuthPassword()
    {
        return $this->Password;
    }
}
