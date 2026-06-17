<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HostelApplication extends Model
{
    use HasFactory;

    protected $table = 'hostel_applications';

    protected $fillable = [
        'hostel_id',
        'student_id',
        'joining_date',
        'notes',
        'status',
    ];

    protected $casts = [
        'joining_date' => 'date',
    ];

    public function hostel(): BelongsTo
    {
        return $this->belongsTo(Hostel::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }


}
