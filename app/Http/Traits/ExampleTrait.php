<?php
namespace App\Http\Traits;
use Log;
trait ExampleTrait {

    public function sampleTraitFunction()
    {
        Log::info('Running sample trait');
    }
}
