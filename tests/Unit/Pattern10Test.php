<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\WrongLatitudeException;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\WrongLetterException;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\WrongLongitudeException;
use Yakoffka\UniversalCoordinateParser\Tests\TestCase;

/**
 * Тестирование разбора координат для паттерна 10
 *
 * ./vendor/bin/phpunit --filter Pattern10Test
 */
class Pattern10Test extends TestCase
{
    /**
     * Успешное получение PointDto на основе переданной строки координат в ожидаемом формате
     *
     * @param string $src
     * @param float $lat
     * @param float $lon
     * @param string $pattern
     * @return void
     *
     * docker compose exec php php artisan test --filter pattern10Success
     * @throws WrongLatitudeException
     * @throws WrongLongitudeException
     * @throws WrongLetterException
     */
    #[DataProvider('successProvider')] #[Test]
    public function pattern10Success(string $src, float $lat, float $lon, string $pattern): void
    {
        $pointDto = $this->parser->getPointDto($src);

        self::assertEquals($pointDto->lat, $lat);
        self::assertEquals($pointDto->lon, $lon);
        self::assertEquals($pointDto->src, $src);
        self::assertEquals($pointDto->pattern, $pattern);
    }

    /**
     * Неуспешное получение PointDto на основе переданной строки координат в ожидаемом формате с неверными значениями
     * долготы
     *
     * @param string $src
     * @param float $lat
     * @param float $lon
     * @param string $pattern
     * @return void
     *
     * docker compose exec php php artisan test --filter pattern10WrongLatitude
     * @throws WrongLatitudeException
     * @throws WrongLetterException
     * @throws WrongLongitudeException
     */
    #[DataProvider('wrongLatitudeProvider')] #[Test]
    public function pattern10WrongLatitude(string $src, float $lat, float $lon, string $pattern): void
    {
        $this->expectException(WrongLatitudeException::class);

        $pointDto = $this->parser->getPointDto($src);
    }

    /**
     * Неуспешное получение PointDto на основе переданной строки координат в ожидаемом формате с неверными значениями
     * долготы
     *
     * @param string $src
     * @param float $lat
     * @param float $lon
     * @param string $pattern
     * @return void
     *
     * docker compose exec php php artisan test --filter pattern10WrongLongitude
     * @throws WrongLatitudeException
     * @throws WrongLetterException
     * @throws WrongLongitudeException
     */
    #[DataProvider('wrongLongitudeProvider')] #[Test]
    public function pattern10WrongLongitude(string $src, float $lat, float $lon, string $pattern): void
    {
        $this->expectException(WrongLongitudeException::class);

        $pointDto = $this->parser->getPointDto($src);
    }

    /**
     * @return array[]
     * @todo дописать максимальные значения для всех случаев (минут, секунд, с дробными частями)
     */
    public static function successProvider(): array
    {
        return [
            // '3720S18208E'
            ['0000N00000W', 0, 0, 'pattern10'],
            ['0000S00000E', 0, 0, 'pattern10'],
            ['3720N12208W', 37.333333, -122.133333, 'pattern10'],
            ['3720S12208E', -37.333333, 122.133333, 'pattern10'],
            ['9000N18000W', 90, -180, 'pattern10'],
            ['9000S18000E', -90, 180, 'pattern10'],
        ];
    }

    /**
     * @return array[]
     */
    public static function wrongLatitudeProvider(): array
    {
        return [
            ['9001N18000W', 90, -180, 'pattern10'],
            ['9001S18000E', -90, 180, 'pattern10'],
        ];
    }

    /**
     * @return array[]
     */
    public static function wrongLongitudeProvider(): array
    {
        return [
            ['9000N18001W', 90, -180, 'pattern10'],
            ['9000S18001E', -90, 180, 'pattern10'],
        ];
    }
}
