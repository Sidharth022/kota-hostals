<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Hostel extends Model implements HasMedia
{
    use HasFactory, HasSlug, InteractsWithMedia, LogsActivity, Searchable;
    protected $fillable = [
        'owner_id',
        'area_id',
        'slug',
        'title',
        'description',
        'address',
        'latitude',
        'longitude',
        'monthly_rent',
        'security_deposit',
        'room_types',
        'gender_type',
        'google_map_url',
        'total_rooms',
        'available_rooms',
        'featured',
        'verified',
        'status',
        'meta_title',
        'meta_description',
        'views',
        'gallery_images',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'monthly_rent' => 'decimal:2',
            'security_deposit' => 'decimal:2',
            'room_types' => 'array',
            'featured' => 'boolean',
            'verified' => 'boolean',
            'views' => 'integer',
            'total_rooms' => 'integer',
            'available_rooms' => 'integer',
        ];
    }

    // ----------------------------------------------------------------
    // Slug
    // ----------------------------------------------------------------

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(80);
    }

    // ----------------------------------------------------------------
    // Activity Log
    // ----------------------------------------------------------------

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'status', 'verified', 'featured', 'monthly_rent'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    // ----------------------------------------------------------------
    // Media Library
    // ----------------------------------------------------------------

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    // ----------------------------------------------------------------
    // Laravel Scout
    // ----------------------------------------------------------------

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'address' => $this->address,
            'area' => $this->area?->title,
            'gender_type' => $this->gender_type,
            'monthly_rent' => $this->monthly_rent,
        ];
    }

    public function shouldBeSearchable(): bool
    {
        return $this->status === 'active';
    }

    // ----------------------------------------------------------------
    // Relationships
    // ----------------------------------------------------------------

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function images(): HasMany
    {   
        return $this->hasMany(HostelImage::class)->orderBy('sort_order');
    }

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'hostel_facilities');
    }

    public function coachingCenters(): BelongsToMany
    {
        return $this->belongsToMany(CoachingCenter::class, 'hostel_coaching_centers')
            ->withPivot('distance_km')
            ->orderByPivot('distance_km');
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(HostelApplication::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    // ----------------------------------------------------------------
    // Scopes
    // ----------------------------------------------------------------

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('verified', true);
    }

    public function scopeGenderType($query, string $type)
    {
        return $query->where('gender_type', $type);
    }

    public function scopeForArea($query, int|string $areaId)
    {
        return $query->where('area_id', $areaId);
    }

    public function scopePriceRange($query, ?float $min, ?float $max)
    {
        return $query
            ->when($min, fn ($q) => $q->where('monthly_rent', '>=', $min))
            ->when($max, fn ($q) => $q->where('monthly_rent', '<=', $max));
    }

    /**
     * Haversine formula — filter hostels within a given radius (km).
     */
    public function scopeWithinRadius($query, float $lat, float $lng, float $radiusKm = 2.0)
    {
        return $query->selectRaw(
            '*, ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance',
            [$lat, $lng, $lat]
        )->having('distance', '<=', $radiusKm)->orderBy('distance');
    }

    // ----------------------------------------------------------------
    // Accessors
    // ----------------------------------------------------------------

    public function getAvgRatingAttribute(): float
    {
        return round($this->approvedReviews()->avg('rating') ?? 0, 1);
    }

    public function getPrimaryImageAttribute(): ?string
    {
        $first = $this->images()->first();
        return $first ? $first->getUrl() : null;
    }

    public function getGalleryImagesAttribute(): array
    {
        return $this->images()->pluck('image_path')->toArray();
    }

    public function setGalleryImagesAttribute($value): void
    {   
        $value = is_array($value) ? array_filter($value) : [];

        $existingImages = $this->images()->get();
        $existingPaths = $existingImages->pluck('image_path')->toArray();

        // Delete images that are not in the new list
        foreach ($existingImages as $img) {
            if (!in_array($img->image_path, $value)) {
                // \Illuminate\Support\Facades\Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
        }
        // Add new images or update sort order
        foreach ($value as $index => $path) {
            if (!in_array($path, $existingPaths)) {
                $this->images()->create([
                    'image_path' => $path,
                    'sort_order' => $index,
                ]);
            } else {
                $this->images()->where('image_path', $path)->update(['sort_order' => $index]);
            }
        }
    }

    // ----------------------------------------------------------------
    // Helpers
    // ----------------------------------------------------------------

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
