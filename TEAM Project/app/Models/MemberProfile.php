<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class MemberProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_title',
        'phone',
        'bio',
        'skills',
        'university_id_number',
        'major',
        'gpa',
        'github_url',
        'linkedin_url',
        'portfolio_url',
        'cv_path',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * مصفوفة المهارات كـ array
     */
    public function getSkillsListAttribute(): array
    {
        if (empty($this->skills)) {
            return [];
        }

        if (is_array($this->skills)) {
            return $this->skills;
        }

        // Check if JSON
        $decoded = json_decode($this->skills, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        // Split by comma
        return array_map('trim', explode(',', $this->skills));
    }

    /**
     * رابط تحميل أو معاينة الـ CV
     */
    public function getCvUrlAttribute(): ?string
    {
        if ($this->cv_path && Storage::disk('public')->exists($this->cv_path)) {
            return asset('storage/' . $this->cv_path);
        }
        return null;
    }
}

