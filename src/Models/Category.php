<?php

namespace LaraZeus\Wind\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name', 'is_active', 'user_id', 'name', 'layout', 'ordering', 'is_active', 'desc', 'options', 'logo', 'start_date', 'end_date', 'slug',
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
        return CategoryFactory::new();
    }

    public function letters()
    {
        return $this->hasMany(Letter::class);
    }
}
