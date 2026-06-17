<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    use HasFactory;

    protected $table = 'hostel_inquiries';

    protected $fillable = [
        'student_id',
        'hostel_id',
        'name',
        'email',
        'mobile',
        'message',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'student_id' => 'integer',
        ];
    }

    // ----------------------------------------------------------------
    // Relationships
    // ----------------------------------------------------------------

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function hostel(): BelongsTo
    {
        return $this->belongsTo(Hostel::class);
    }

    // ----------------------------------------------------------------
    // Scopes
    // ----------------------------------------------------------------

    public function scopeNew($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeForOwner($query, int $ownerId)
    {
        return $query->whereHas('hostel', fn ($q) => $q->where('owner_id', $ownerId));
    }


}
