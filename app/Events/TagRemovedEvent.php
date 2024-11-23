<?php

namespace App\Events;

use App\Traits\TaggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

class TagRemovedEvent
{
    use SerializesModels;

    /** @var TaggableTrait|Model **/
    public $model;

    /*** @var string */
    public $tagSlug;

    /**
     * Create a new event instance.
     *
     * @param TaggableTrait|Model $model
     * @param string $tagSlug
     */
    public function __construct($model, string $tagSlug)
    {
        $this->model = $model;
        $this->tagSlug = $tagSlug;
    }
}
