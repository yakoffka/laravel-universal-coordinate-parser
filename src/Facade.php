<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

class Facade extends IlluminateFacade
{
    protected static function getFacadeAccessor(): string
    {
        return Parser::class;
    }
}