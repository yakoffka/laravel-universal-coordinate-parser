<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\WrongLatitudeException;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\WrongLongitudeException;
use Yakoffka\UniversalCoordinateParser\Tests\TestCase;

/**
 * Тестирование разбора координат для паттерна 3
 *
 * ./vendor/bin/phpunit --filter Pattern03Test
 */
class Pattern03Test extends TestCase
{
    /**
     * Успешное получение PointDto на основе переданной строки координат в ожидаемом формате
     *
     * @return void
     *
     * docker compose exec php php artisan test --filter pattern03Success
     */
    #[DataProvider('successProvider')] #[Test]
    public function pattern03Success(string $src, float $lat, float $lon, string $pattern): void
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
     * @return void
     *
     * docker compose exec php php artisan test --filter pattern03WrongLatitude
     */
    #[DataProvider('wrongLatitudeProvider')] #[Test]
    public function pattern03WrongLatitude(string $src, float $lat, float $lon, string $pattern): void
    {
        $this->expectException(WrongLatitudeException::class);

        $pointDto = $this->parser->getPointDto($src);
    }

    /**
     * Неуспешное получение PointDto на основе переданной строки координат в ожидаемом формате с неверными значениями
     * долготы
     *
     * @return void
     *
     * docker compose exec php php artisan test --filter pattern03WrongLongitude
     */
    #[DataProvider('wrongLongitudeProvider')] #[Test]
    public function pattern03WrongLongitude(string $src, float $lat, float $lon, string $pattern): void
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
            // only degrees
            ['36/-75', 36, -75, 'pattern03'],
            ['-36/75', -36, 75, 'pattern03'],
            ['36.1/-75.1', 36.1, -75.1, 'pattern03'],
            ['-36.1/75.1', -36.1, 75.1, 'pattern03'],
            ['36.00001/-75.00001', 36.00001, -75.00001, 'pattern03'],
            ['-36.00001/75.00001', -36.00001, 75.00001, 'pattern03'],
        ];
    }

    /**
     * @return array[]
     */
    public static function wrongLatitudeProvider(): array
    {
        return [
            ['91/-75', 91, -75, 'pattern03'],
            ['-91/75', -91, 75, 'pattern03'],
            ['90.1/-75.1', 90.1, -75.1, 'pattern03'],
            ['-90.1/75.1', -90.1, 75.1, 'pattern03'],
            ['90.00001/-75.00001', 90.00001, -75.00001, 'pattern03'],
            ['-90.00001/75.00001', -90.00001, 75.00001, 'pattern03'],
        ];
    }

    /**
     * @return array[]
     */
    public static function wrongLongitudeProvider(): array
    {
        return [
            ['36/-181', 36, -181, 'pattern03'],
            ['-36/181', -36, 181, 'pattern03'],
            ['36.1/-180.1', 36.1, -180.1, 'pattern03'],
            ['-36.1/180.1', -36.1, 180.1, 'pattern03'],
            ['36.00001/-180.00001', 36.00001, -180.00001, 'pattern03'],
            ['-36.00001/180.00001', -36.00001, 180.00001, 'pattern03'],
        ];
    }
}
