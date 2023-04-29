<?php

namespace LaraZeus\Wind\Models;

use Database\Factories\DepartmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed $slug
 * @property mixed $is_active
 */
class Department extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name', 'is_active', 'user_id', 'layout', 'ordering', 'desc', 'options', 'logo', 'start_date', 'end_date', 'slug',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'options' => 'array',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function newFactory()
    {
        return DepartmentFactory::new();
    }

    public function letters()
    {
        return $this->hasMany(config('zeus-wind.models.letter'));
    }
}
