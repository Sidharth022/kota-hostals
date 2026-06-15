<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements HasMedia, FilamentUser
{
    use HasFactory, HasRoles, InteractsWithMedia, LogsActivity, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'role_id',
        'profile_image',
        'status',
        'google_id',
        'facebook_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ----------------------------------------------------------------
    // Activity Log
    // ----------------------------------------------------------------

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'role_id', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    // ----------------------------------------------------------------
    // Media Library
    // ----------------------------------------------------------------

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    // ----------------------------------------------------------------
    // Relationships
    // ----------------------------------------------------------------

    public function hostels(): HasMany
    {
        return $this->hasMany(Hostel::class, 'owner_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function ownerProfile(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(OwnerProfile::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class, 'student_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(HostelApplication::class, 'student_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function favoriteHostels(): BelongsToMany
    {
        return $this->belongsToMany(Hostel::class, 'favorites');
    }

    // ----------------------------------------------------------------
    // Role Helpers
    // ----------------------------------------------------------------

    public function isSuperAdmin(): bool
    {
        return $this->role && $this->role->slug === 'super-admin';
    }

    public function isOwner(): bool
    {
        return $this->role && $this->role->slug === 'hostel-owner';
    }

    public function isStudent(): bool
    {
        return $this->role && $this->role->slug === 'student';
    }

    // ----------------------------------------------------------------
    // Filament — allow all users with any role access to admin
    // ----------------------------------------------------------------

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return $this->isSuperAdmin();
    }
}
