<?php

namespace App\Jobs;

use App\Models\Hostel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecalculateHostelScore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $hostel;

    public function __construct(Hostel $hostel)
    {
        $this->hostel = $hostel;
    }

    public function handle()
    {
        $this->hostel->updateHostelScore();
    }
}
