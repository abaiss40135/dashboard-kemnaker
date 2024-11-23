<?php

namespace App\Models\Tagging;

use App\Helpers\TaggingUtility;
use Illuminate\Database\Eloquent\Model;

class TagGroups extends Model
{
    protected $table = 'tag_groups';
    public $timestamps = true;
    protected $fillable = ['name'];

    /**
     * Get suggested tags
     */
    public function tags(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        $model = TaggingUtility::tagModelString();

        return $this->hasMany($model, 'tag_group_id');
    }

    /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = TaggingUtility::normalize($value);
    }
}
