<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}

//to run phpunit inside laravel on windows with xampp nee to use - ./vendor/bin/phpunit
//the regular php unit runs a globaly installed version
