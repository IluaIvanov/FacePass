<?php

namespace App\Console\Commands;

use App\Events\CreateUser;
use App\Services\VkApi\VkApi;
use Illuminate\Console\Command;

class ImportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:import {user : The ID of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start importing users from an external service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userId = $this->argument('user'); //'ilua.ivanov'

        $maxSizeArray = 5000;
        $offset = 0;

        $userInfo = (new VkApi)->sendQuery([
            'user_ids' => $userId,
        ], 'users.get');

        if (count($userInfo['response']) != 0) {
            $userId = $userInfo['response'][0]['id'];
            $countFriends = $this->getFriends($userId, $maxSizeArray, $offset)['response']['count'];

            if($countFriends != 0) {
                while ($offset <= $countFriends) {
                    $peoples = $this->getFriends($userId, $maxSizeArray, $offset);
                    $this->sendEvent($peoples['response']['items']);
                    $offset += $maxSizeArray;
                }
            } else return $this->error('Not found friends to user');
        } else return $this->error('Not found user');

        $this->info('Import users complete!');
    }

    protected function getFriends($userId, $count, $offset)
    {
        return (new VkApi)->sendQuery([
            'user_id' => $userId,
            'count' => $count,
            'offset' => $offset,
            'lang' => 'ru',
            'fields' => [
                'photo_200_orig'
            ]
        ], 'friends.get');
    }

    protected function sendEvent($items)
    {
        foreach ($items as $people) {
            event(new CreateUser([
                'name' => $people['first_name'].' '.$people['last_name'],
                'url' => $people['photo_200_orig']
            ]));
        }
    }
}
