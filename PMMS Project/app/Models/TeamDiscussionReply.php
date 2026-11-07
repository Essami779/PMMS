<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamDiscussionReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'discussion_id',
        'user_id',
        'content',
    ];

    public function discussion()
    {
        return $this->belongsTo(TeamDiscussion::class, 'discussion_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

