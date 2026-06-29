<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    public function hasPlanPermission($permissionName)
    {
        // 1. User ki active subscription ka stripe price ID uthaein
        $activePriceId = $this->subscription('default')->stripe_price ?? null;

        if (!$activePriceId) {
            return false; // Free user ya no active subscription
        }

        // 2. Database query jo check karegi ke kya is plan ko yeh permission mili hui hai
        return Plan::where('stripe_price_id', $activePriceId)
            ->whereHas('permissions', function ($query) use ($permissionName) {
                $query->where('name', $permissionName);
            })->exists();
    }

    public function canCreateMoreProducts()
    {
        // Agar user ke paas full unlimited product features hain (Enterprise)
        if ($this->hasPlanPermission('unlimited-products')) {
            return true;
        }

        // Agar user ke paas products create karne ki basic permission hai (Pro Plan)
        if ($this->hasPlanPermission('create-products')) {
            $productCount = \App\Models\Product::where('user_id', $this->id)->count();
            return $productCount < 5; // Agar count 5 se kam hai toh true return karega
        }

        return false; // Basic plan user ke liye hamesha false
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
