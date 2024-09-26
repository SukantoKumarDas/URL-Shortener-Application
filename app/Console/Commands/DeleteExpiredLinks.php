<?php

namespace App\Console\Commands;

use App\Models\Url;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteExpiredLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'links:delete-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Soft delete all expired after expiration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the current date and time
        $currentDateTime = Carbon::now();

        // Find all expired links where the expiration datetime is more more than or equal to current date
        $expiredLinks = Url::where('expired_at', '<=', $currentDateTime)
                                ->whereNull('deleted_at') // only target non-deleted links
                                ->get();
        
        // Soft delete each expired link
        foreach ($expiredLinks as $link) {
            $link->delete();
        }

        $this->info('Expired links have been soft deleted.');
    }
}
