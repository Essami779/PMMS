<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamDiscussion extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'user_id',
        'title',
        'content',
        'category',
        'is_pinned',
        'replies_count',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'replies_count' => 'integer',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies()
    {
        return $this->hasMany(TeamDiscussionReply::class, 'discussion_id')->latest();
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'announcement' => '📢 إعلان وتوجيه رسمي',
            'blocker' => '🚨 عائق تقني حرج (Blocker)',
            'architecture' => '📐 قرار وتصميم معماري',
            'security' => '🛡️ تنبيه أمني وسيبراني',
            'general' => '💬 نقاش وتنسيق عام',
            default => 'نقاش عام',
        };
    }

    public function getCategoryColorAttribute(): string
    {
        return match ($this->category) {
            'announcement' => 'indigo',
            'blocker' => 'rose',
            'architecture' => 'purple',
            'security' => 'emerald',
            'general' => 'slate',
            default => 'slate',
        };
    }
}

