<?php

namespace LaraZeus\Wind\Models;

use Database\Factories\LetterFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaraZeus\Wind\WindPlugin;

/**
 * @property string $name
 * @property string $email
 * @property int $department_id
 * @property string $title
 * @property string $message
 * @property string $status
 * @property string $reply_message
 * @property string $reply_title
 */
class Letter extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory(): LetterFactory
    {
        return LetterFactory::new();
    }

    /** @return BelongsTo<Letter, Department> */
    public function department(): BelongsTo
    {
        return $this->belongsTo(WindPlugin::get()->getDepartmentModel());
    }

    public function getReplyTitleAttribute(): string
    {
        return $this->reply_title ?? __('re') . ': ' . $this->title;
    }
}
