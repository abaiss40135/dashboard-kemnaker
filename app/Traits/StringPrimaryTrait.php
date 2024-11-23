<?php


namespace App\Traits;


trait StringPrimaryTrait
{
    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
