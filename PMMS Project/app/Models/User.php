<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'avatar'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('users');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    /**
     * Get user avatar URL attribute or fallback to default image.
     * إضافة ?v=timestamp لتفادي كاش المتصفح حتى تظهر الصورة المحدّثة فورًا في الهيدر.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/' . $this->avatar) . '?v=' . ($this->updated_at?->timestamp ?? time());
        }
        return asset('images/default-avatar.svg');
    }

    /**
     * الفرق التي يقودها المستخدم
     */
    public function ledTeams(): HasMany
    {
        return $this->hasMany(Team::class, 'leader_id');
    }

    /**
     * الفرق التي ينتمي إليها المستخدم كعضو
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_members')
            ->withPivot(['id', 'role_in_team', 'joined_at', 'status'])
            ->withTimestamps();
    }

    /**
     * الملف المهني والسيرة الذاتية
     */
    public function profile(): HasOne
    {
        return $this->hasOne(MemberProfile::class);
    }

    /**
     * المهام المسندة للمستخدم
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(TeamTask::class, 'assigned_to');
    }

    /**
     * الحصول على الفريق الفعال للمستخدم (سواء كقائد أو كعضو)
     */
    public function currentTeam(): ?Team
    {
        $led = $this->ledTeams()->latest()->first();
        if ($led) {
            return $led;
        }

        return $this->teams()->latest()->first();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
