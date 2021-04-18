<?php

namespace Combindma\Jumia\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Combindma\Jumia\Jumia
 */
class Jumia extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'jumia';
    }
}
