<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['user_one_id', 'user_two_id'];

    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    /**
     * Get the other participant in the conversation.
     */
    public function getOtherUser($userId)
    {
        return $this->user_one_id == $userId ? $this->userTwo : $this->userOne;
    }

    /**
     * Count unread messages for a specific user in this conversation.
     */
    public function unreadCountFor($userId)
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Scope: all conversations for a given user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_one_id', $userId)
            ->orWhere('user_two_id', $userId);
    }

    /**
     * Find or create a conversation between two users.
     * Always stores the smaller ID as user_one_id for consistency.
     */
    public static function findOrCreateBetween($userAId, $userBId)
    {
        $ids = [min($userAId, $userBId), max($userAId, $userBId)];

        return self::firstOrCreate(
            ['user_one_id' => $ids[0], 'user_two_id' => $ids[1]]
        );
    }
}
