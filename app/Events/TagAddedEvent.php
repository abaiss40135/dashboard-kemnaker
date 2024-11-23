<?php

namespace App\Events;

use App\Traits\TaggableTrait;
use App\Models\Tagging\Tagged;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;

class TagAddedEvent
{
    use SerializesModels;

    /** @var TaggableTrait|Model * */
    public $model;

    /** @var string */
    public $tagSlug;

    /** @var Tagged */
    public $tagged;

    /**
     * Create a new event instance.
     *
     * @param TaggableTrait|Model $model
     * @param string $tagSlug
     * @param Tagged $tagged
     */
    public function __construct($model, string $tagSlug, Tagged $tagged)
    {
        $this->model = $model;
        $this->tagSlug = $tagSlug;
        $this->tagged = $tagged;
    }
}
