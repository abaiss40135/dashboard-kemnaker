<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function administrator()
    {
        return User::where('email', 'admin@bospolri.go.id')->first();
    }
}
