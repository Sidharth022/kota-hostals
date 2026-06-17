<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HostelReport extends Model
{
    use HasFactory;

    protected $table = 'hostel_reports';

    protected $fillable = [
        'hostel_id',
        'user_id',
        'reason',
        'description',
        'status',
    ];

    public static $reasons = [
        'wrong_pricing' => 'Wrong Pricing',
        'fake_photos' => 'Fake Photos',
        'misleading_information' => 'Misleading Information',
        'poor_food' => 'Poor Food',
        'poor_cleanliness' => 'Poor Cleanliness',
        'hostel_closed' => 'Hostel Closed',
        'owner_not_responding' => 'Owner Not Responding',
        'other' => 'Other',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hostel(): BelongsTo
    {
        return $this->belongsTo(Hostel::class);
    }


}
