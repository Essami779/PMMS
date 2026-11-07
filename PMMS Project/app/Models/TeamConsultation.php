<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamConsultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'requested_by',
        'consultant_name',
        'consultant_title',
        'consultant_avatar',
        'topic',
        'category',
        'description',
        'status',
        'session_date',
        'meeting_link',
        'recommendations',
        'rating',
    ];

    protected $casts = [
        'session_date' => 'datetime',
        'rating' => 'integer',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'technical' => 'استشارة معمارية وتقنية',
            'security' => 'تدقيق أمني واختراق قياسي',
            'business' => 'نموذج عمل واستثمار',
            'ux' => 'تصميم وتجربة مستخدم UI/UX',
            'legal' => 'قانوني وحماية ملكية فكرية',
            default => 'استشارة متخصصة',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'قيد المراجعة والمطابقة',
            'confirmed' => 'مؤكدة ومجدولة',
            'completed' => 'مكتملة وموثقة',
            'cancelled' => 'ملغاة',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'amber',
            'confirmed' => 'indigo',
            'completed' => 'emerald',
            'cancelled' => 'rose',
            default => 'slate',
        };
    }
}

