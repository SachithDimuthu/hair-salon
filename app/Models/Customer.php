<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'CustomerName',
        'Email',
        'Password',
        'PhoneNumber',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $primaryKey = 'CustomerID';

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'customer_service', 'CustomerID', 'ServiceID')
                    ->withTimestamps()
                    ->withPivot(['BookedAt', 'Status']);
    }

    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(Admin::class, 'admin_customer', 'CustomerID', 'AdminID')
                    ->withTimestamps();
    }

    public function getAuthPassword()
    {
        return $this->Password;
    }
}
