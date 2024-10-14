<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Tests\Unit;

use Yakoffka\UniversalCoordinateParser\Tests\TestCase;

/**
 * ./vendor/bin/phpunit --filter SimpleTest
 */
class SimpleTest extends TestCase
{
    /**
     * Успешное получение PointDto на основе переданной строки координат в ожидаемом формате
     *
     * @test
     * @return void
     *
     * docker compose exec php php artisan test --filter universalCoordinatesParserSimple
     */
    public function universalCoordinatesParserSimple(): void
    {
//        $true = 1 === 1;
//        self::assertTrue($true);


        $point = '36.123456N/175.123456W';
        //$point = '3720S18208E';

//        $service = resolve(UniversalCoordinatesService::class);
//
//        // $pointDto = $service->parseByO2($point);
//        //$pointDto = $service->getPointDto($point);
//        $pointDto = $service->getPointDto($point);
//        dd($pointDto);

        // $pointDto = $service->parseByO2($point);
        //$pointDto = $service->getPointDto($point);
        $pointDto = $this->parser->getPointDto($point);
        dd($pointDto);
    }
}
