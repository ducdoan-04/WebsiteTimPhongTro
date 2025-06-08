<?php

namespace App\Jobs;

use App\Models\Room;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendRoomNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $room;

    public function __construct(Room $room)
    {
        $this->room = $room;
    }

    public function handle()
    {
        $users = User::where('role', 'user')->get();

        foreach ($users as $user) {
            Mail::send('emails.new-room', ['room' => $this->room, 'user' => $user], function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('Phòng trọ mới phù hợp với bạn');
            });
        }
    }
} 