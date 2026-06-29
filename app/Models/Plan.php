<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'stripe_plan_id',
        'stripe_price_id'
    ];

    // Plan ki saari permissions get karne ke liye relationship
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'plan_has_permissions');
    }
}
