<?php

namespace App\Listeners;

use App\Events\CreateUser;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ActionCreateUser
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\CreateUser  $event
     * @return void
     */
    public function handle(CreateUser $event)
    {
        $data = $event->data;

        $result = new User();
        $result->name = $data['name'];
        $result->save();
        $result->addMediaFromUrl($data['url'])
           ->toMediaCollection('images');

        $result->photo = $result->getFirstMediaUrl('images');
        $result->save();
    }
}
