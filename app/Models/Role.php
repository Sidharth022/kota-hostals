<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends SpatieRole
{
    protected $fillable = [
        'name',
        'slug',
        'status',
        'guard_name',
    ];

    public function directUsers(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
