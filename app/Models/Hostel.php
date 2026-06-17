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
        'electricity_charges',
        'laundry_charges',
        'mess_charges',
        'maintenance_charges',
        'other_charges',
        'distance_coaching',
        'distance_medical',
        'distance_hospital',
        'distance_library',
        'distance_stationery',
        'distance_food',
        'hostel_score',
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
            'electricity_charges' => 'decimal:2',
            'laundry_charges' => 'decimal:2',
            'mess_charges' => 'decimal:2',
            'maintenance_charges' => 'decimal:2',
            'other_charges' => 'decimal:2',
            'distance_coaching' => 'decimal:2',
            'distance_medical' => 'decimal:2',
            'distance_hospital' => 'decimal:2',
            'distance_library' => 'decimal:2',
            'distance_stationery' => 'decimal:2',
            'distance_food' => 'decimal:2',
            'hostel_score' => 'integer',
        ];
    }

    protected static function booted()
    {
        static::saving(function ($hostel) {
            $hostel->hostel_score = $hostel->calculateHostelScore();

            if ($hostel->isDirty(['latitude', 'longitude'])) {
                if ($hostel->latitude && $hostel->longitude) {
                    $hostel->updateDistancesFromCoordinates((float) $hostel->latitude, (float) $hostel->longitude);
                }
            }
        });
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
            ->logOnly(['title', 'status', 'verified', 'featured', 'monthly_rent', 'hostel_score'])
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

    public function viewsLog(): HasMany
    {
        return $this->hasMany(HostelView::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(HostelReport::class);
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

    // --- Hidden Cost Detector (Feature 1) ---
    public function getRealMonthlyCostAttribute(): float
    {
        return (float) ($this->monthly_rent +
            $this->electricity_charges +
            $this->laundry_charges +
            $this->mess_charges +
            $this->maintenance_charges +
            $this->other_charges);
    }

    public function getAreaRentComparisonAttribute(): array
    {
        $avgRent = self::where('status', 'active')
            ->where('area_id', $this->area_id)
            ->avg('monthly_rent') ?? 0.0;

        $realCost = $this->real_monthly_cost;
        $diff = $avgRent - $realCost;

        return [
            'average' => (float) round($avgRent),
            'difference' => (float) round(abs($diff)),
            'is_saving' => $diff > 0,
        ];
    }

    // --- Kota Survival Score (Feature 2) ---
    public function getSurvivalSubScores(): array
    {
        $calc = function ($dist) {
            if ($dist === null || $dist === '') {
                return 0;
            }
            // 0.2km or less -> 100. 2.5km or more -> 0. Linear decay in between.
            return max(0, min(100, (int) round(100 - ($dist * 40))));
        };

        $coaching = $calc($this->distance_coaching);
        
        $medStore = $calc($this->distance_medical);
        $hospital = $calc($this->distance_hospital);
        $medical = (int) round(($medStore + $hospital) / 2);

        $food = $calc($this->distance_food);

        $library = $calc($this->distance_library);
        $stationery = $calc($this->distance_stationery);
        $study = (int) round(($library + $stationery) / 2);

        return [
            'coaching' => $coaching,
            'medical' => $medical,
            'food' => $food,
            'study' => $study,
        ];
    }

    public function getSurvivalScoreAttribute(): int
    {
        $sub = $this->getSurvivalSubScores();

        $weightCoaching = (float) Setting::get('weight_coaching', 35);
        $weightMedical = (float) Setting::get('weight_medical', 20);
        $weightFood = (float) Setting::get('weight_food', 25);
        $weightStudy = (float) Setting::get('weight_study', 20);

        $totalWeight = $weightCoaching + $weightMedical + $weightFood + $weightStudy;
        if ($totalWeight <= 0) {
            $totalWeight = 100.0;
        }

        $weightedSum = ($sub['coaching'] * $weightCoaching) +
                       ($sub['medical'] * $weightMedical) +
                       ($sub['food'] * $weightFood) +
                       ($sub['study'] * $weightStudy);

        return max(0, min(100, (int) round(($weightedSum / $totalWeight))));
    }

    // --- Future-Ready distance dynamic locator (Feature 2) ---
    public function updateDistancesFromCoordinates(float $lat, float $lng): void
    {
        // Future Google Places API integration placeholder
        // For MVP, we calculate mock distances based on the lat/lng coordinates to simulate API responses.
        // Keep all fields nullable.
        $this->distance_coaching = $this->distance_coaching ?? round(0.1 + (abs(sin($lat * $lng)) * 2.0), 2);
        $this->distance_medical = $this->distance_medical ?? round(0.2 + (abs(cos($lat + $lng)) * 1.5), 2);
        $this->distance_hospital = $this->distance_hospital ?? round(0.5 + (abs(sin($lat - $lng)) * 3.0), 2);
        $this->distance_library = $this->distance_library ?? round(0.3 + (abs(cos($lat * $lng)) * 2.2), 2);
        $this->distance_stationery = $this->distance_stationery ?? round(0.1 + (abs(sin($lat + $lng)) * 1.2), 2);
        $this->distance_food = $this->distance_food ?? round(0.1 + (abs(cos($lat - $lng)) * 0.8), 2);
    }

    // --- Dynamic Ranking Score calculations (Feature 4 & 6) ---
    public function calculateHostelScore(): int
    {
        // 1. Reviews Score (35%)
        $avgRating = $this->getAvgRatingAttribute();
        $reviewsScore = $avgRating > 0 ? ($avgRating / 5) * 100 : 70; // 70 as starting baseline for new hostels

        // 2. Favorites Score (20%)
        $favCount = $this->favorites()->count();
        $favoritesScore = min(100, $favCount * 10);

        // 3. Inquiries Score (20%)
        $inqCount = $this->inquiries()->count();
        $inquiriesScore = min(100, $inqCount * 5);

        // 4. Verification Score (10%)
        $verificationScore = $this->verified ? 100 : 0;

        // 5. Response Rate Score (15%)
        $totalApps = $this->applications()->count();
        $respApps = $this->applications()->where('status', '!=', 'pending')->count();
        $totalInqs = $this->inquiries()->count();
        $respInqs = $this->inquiries()->where('status', '!=', 'pending')->count();
        $totalContacts = $totalApps + $totalInqs;
        $responseRate = $totalContacts > 0 ? (($respApps + $respInqs) / $totalContacts) * 100 : 0.0;

        // Base Score calculation
        $baseScore = ($reviewsScore * 0.35) +
                     ($favoritesScore * 0.20) +
                     ($inquiriesScore * 0.20) +
                     ($verificationScore * 0.10) +
                     ($responseRate * 0.15);

        // 6. View Engagement Bonus
        $uniqueViews = $this->viewsLog()->count();
        $viewsBonus = min(10, (int) floor($uniqueViews / 100)); // up to +10
        if ($this->verified && ($uniqueViews > 500 || $favCount > 5)) {
            $viewsBonus += 5; // extra +5 for verified with strong engagement
        }
        $viewsBonus = min(15, $viewsBonus); // cap at +15

        // 7. Complaint Penalty (approved reports)
        $approvedComplaints = $this->reports()->where('status', 'approved')->count();
        $complaintPenalty = min(50, $approvedComplaints * 10); // -10 per complaint, cap at -50

        // Final score (0-100)
        return max(0, min(100, (int) round($baseScore + $viewsBonus - $complaintPenalty)));
    }

    public function updateHostelScore(): void
    {
        $this->hostel_score = $this->calculateHostelScore();
        $this->saveQuietly();
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
