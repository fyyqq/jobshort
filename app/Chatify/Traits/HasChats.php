<?php

namespace App\Chatify\Traits;

use App\Chatify\Models\Message;
use App\Chatify\Models\Conversation;

trait HasChats
{
    /**
     * Get the user's conversations.
     */
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class);
    }

    /**
     * Get the user's messages.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // ...
}
