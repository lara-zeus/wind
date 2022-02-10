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

    protected $fillable = [
        'name', 'email', 'department_id', 'title', 'message', 'status', 'reply_message', 'reply_title',
    ];

    protected static function newFactory()
    {
        return LetterFactory::new();
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function getReplyTitleAttribute($value)
    {
        return $value ?? 're: '.$this->title;
    }
}
