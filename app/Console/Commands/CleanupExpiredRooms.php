<?php

namespace App\Console\Commands;

use App\Models\Room;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CleanupExpiredRooms extends Command
{
    protected $signature = 'rooms:cleanup';
    protected $description = 'Clean up expired room listings';

    public function handle()
    {
        $expiredRooms = Room::where('is_available', true)
            ->where('created_at', '<', Carbon::now()->subMonths(3))
            ->get();

        foreach ($expiredRooms as $room) {
            $room->update(['is_available' => false]);
            $this->info("Marked room {$room->id} as unavailable");
        }

        $this->info('Cleanup completed successfully');
    }
} 