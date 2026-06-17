<?php

namespace App\Console\Commands;

use App\Models\Hostel;
use Illuminate\Console\Command;

class RecalculateHostelScores extends Command
{
    protected $signature = 'hostels:recalculate-scores';
    protected $description = 'Recalculate ranking scores for all active hostels';

    public function handle()
    {
        $this->info('Starting score recalculation...');
        
        Hostel::where('status', 'active')->chunk(100, function ($hostels) {
            foreach ($hostels as $hostel) {
                $hostel->updateHostelScore();
            }
        });

        $this->info('Score recalculation complete!');
    }
}
