<?php

namespace LaraZeus\Wind\Models;

use Database\Factories\DepartmentFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use LaraZeus\Wind\WindPlugin;

/**
 * @property string $slug
 * @property bool $is_active
 * @property string $logo
 * @property string $name
 * @property string $user_id
 * @property int $ordering
 * @property string $desc
 * @property array $options
 * @property Carbon $start_date
 * @property Carbon $end_date
 */
class Department extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'options' => 'array',
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function newFactory(): DepartmentFactory
    {
        return DepartmentFactory::new();
    }

    /** @phpstan-return hasMany<Letter> */
    public function letters(): HasMany
    {
        return $this->hasMany(WindPlugin::get()->getDepartmentModel());
    }

    public function image(): ?string
    {
        if (str($this->logo)->startsWith('http')) {
            return $this->logo;
        }
        if ($this->logo !== null) {
            return Storage::disk(WindPlugin::get()->getUploadDisk())
                ->url($this->logo);
        }

        return null;
    }

    public function scopeDepartments(Builder $query): void
    {
        $query->where('is_active', true)->orderBy('ordering');
    }
}
