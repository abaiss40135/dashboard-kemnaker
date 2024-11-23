<?php

namespace App\Models\Tagging;

use App\Helpers\TaggingUtility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Tagged extends Model
{
    protected $table = 'tagged';
    public $timestamps = false;
    protected $fillable = ['tag_name', 'tag_slug'];
    protected $hidden = ['taggable_type', 'taggable_id'];
    /**
     * Morph to the tag
     *
     * @return MorphTo
     */
    public function taggable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get instance of tag linked to the tagged value
     *
     * @return BelongsTo
     */
    public function tag(): BelongsTo
    {
        $model = TaggingUtility::tagModelString();
        return $this->belongsTo($model, 'tag_slug', 'slug');
    }
}
