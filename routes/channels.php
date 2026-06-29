<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Conversation;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
*/

Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    $conversation = Conversation::find($conversationId);

    if (!$conversation) {
        return false;
    }

    return $conversation->user_one_id === $user->id || $conversation->user_two_id === $user->id;
});

Broadcast::channel('app', function ($user) {
    return ['id' => $user->id, 'name' => $user->name];
});
