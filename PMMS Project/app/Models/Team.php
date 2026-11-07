<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'leader_id',
        'name',
        'project_title',
        'description',
        'category',
        'university',
        'department',
        'invite_code',
        'status',
        'progress_percentage',
        'github_repo',
        'avatar',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($team) {
            if (empty($team->invite_code)) {
                $team->invite_code = strtoupper(Str::random(8));
            }
        });
    }

    /**
     * قائد الفريق
     */
    public function leader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    /**
     * أعضاء الفريق (مستخدمين)
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_members')
            ->withPivot(['id', 'role_in_team', 'joined_at', 'status'])
            ->withTimestamps();
    }

    /**
     * سجلات العضوية
     */
    public function teamMembers(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }

    /**
     * الدعوات المعلقة والسابقة
     */
    public function invitations(): HasMany
    {
        return $this->hasMany(TeamInvitation::class);
    }

    /**
     * مهام ومراحل الفريق
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(TeamTask::class);
    }

    /**
     * وقفات وملاحظات الفريق اليومية
     */
    public function standups(): HasMany
    {
        return $this->hasMany(TeamStandup::class)->latest();
    }

    /**
     * خزانة وثائق ومخرجات المشروع
     */
    public function documents(): HasMany
    {
        return $this->hasMany(TeamDocument::class)->latest();
    }

    /**
     * استشارات وجلسات توجيه الفريق
     */
    public function consultations(): HasMany
    {
        return $this->hasMany(TeamConsultation::class)->latest();
    }

    /**
     * نقاشات وغرفة عمليات الفريق
     */
    public function discussions(): HasMany
    {
        return $this->hasMany(TeamDiscussion::class)->latest();
    }

    /**
     * فحص هل المستخدم الحالي هو قائد الفريق
     */
    public function isLeader(User $user): bool
    {
        return (int) $this->leader_id === (int) $user->id;
    }
}

