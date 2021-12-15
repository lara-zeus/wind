<?php

namespace LaraZeus\Wind;

use Illuminate\Support\Facades\Wind;

/**
 * @see \LaraZeus\Bolt\Skeleton\SkeletonClass
 */
class WindFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bolt';
    }
}
