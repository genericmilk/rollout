<?php

declare(strict_types=1);
namespace Genericmilk\Rollout\Facades;
use Illuminate\Support\Facades\Facade;

class Rollout extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Rollout';
    }
}
