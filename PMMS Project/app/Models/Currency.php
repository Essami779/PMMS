<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Currency extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('lookups');
    }

    protected $table = 'currencies';

    protected $fillable = [
        'code',
        'name',
        'symbol',
        'flag',
        'color_code',
        'hex_color',
        'exchange_rate',
        'is_default',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'exchange_rate' => 'decimal:4',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope for active currencies
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Get default system currency
     */
    public static function getDefault()
    {
        return static::where('is_default', true)->first() 
            ?? static::where('code', 'YER')->first() 
            ?? static::first();
    }

    /**
     * Get default system currency code
     */
    public static function getDefaultCode(): string
    {
        return static::getDefault()?->code ?? 'YER';
    }

    /**
     * Get visual badge classes based on color_code
     */
    public function getBadgeClassAttribute(): string
    {
        return match ($this->color_code) {
            'emerald', 'green' => 'bg-emerald-50 text-emerald-700 border-emerald-300 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-700',
            'amber', 'yellow' => 'bg-amber-50 text-amber-700 border-amber-300 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-700',
            'blue', 'sky' => 'bg-blue-50 text-blue-700 border-blue-300 dark:bg-blue-950/60 dark:text-blue-300 dark:border-blue-700',
            'indigo' => 'bg-indigo-50 text-indigo-700 border-indigo-300 dark:bg-indigo-950/60 dark:text-indigo-300 dark:border-indigo-700',
            'purple' => 'bg-purple-50 text-purple-700 border-purple-300 dark:bg-purple-950/60 dark:text-purple-300 dark:border-purple-700',
            'rose', 'red' => 'bg-rose-50 text-rose-700 border-rose-300 dark:bg-rose-950/60 dark:text-rose-300 dark:border-rose-700',
            'teal' => 'bg-teal-50 text-teal-700 border-teal-300 dark:bg-teal-950/60 dark:text-teal-300 dark:border-teal-700',
            default => 'bg-slate-100 text-slate-700 border-slate-300 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-600',
        };
    }

    /**
     * Get computed hex color
     */
    public function getComputedHexAttribute(): string
    {
        $presetMap = [
            'emerald' => '#059669',
            'green'   => '#059669',
            'amber'   => '#d97706',
            'yellow'  => '#d97706',
            'blue'    => '#2563eb',
            'sky'     => '#0284c7',
            'indigo'  => '#4f46e5',
            'purple'  => '#9333ea',
            'rose'    => '#e11d48',
            'red'     => '#e11d48',
            'teal'    => '#0d9488',
            'cyan'    => '#0891b2',
            'orange'  => '#ea580c',
            'violet'  => '#7c3aed',
            'slate'   => '#475569',
        ];

        // 1. If color_code is specified in presets, use its corresponding color
        if (!empty($this->color_code) && isset($presetMap[$this->color_code])) {
            // If hex_color is customized to a distinct manual color, honor it
            if (!empty($this->hex_color) && !in_array(strtolower($this->hex_color), array_map('strtolower', array_values($presetMap)))) {
                return $this->hex_color;
            }
            return $presetMap[$this->color_code];
        }

        // 2. Otherwise use hex_color if present
        if (!empty($this->hex_color)) {
            return $this->hex_color;
        }

        return '#059669';
    }

    /**
     * Get full display label e.g. "🇾🇪 ريال يمني (YER)"
     */
    public function getFullLabelAttribute(): string
    {
        return trim(($this->flag ? $this->flag . ' ' : '') . $this->name . ' (' . $this->code . ')');
    }
}
