<?php

namespace LaraZeus\Wind\Models;

use Database\Factories\LetterFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Letter extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasUpdates;
    use HasActive;

    protected $fillable = [
        'name', 'email', 'category_id', 'title', 'message', 'status','reply_message','reply_title'
    ];

    protected static function newFactory()
    {
        return LetterFactory::new();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}