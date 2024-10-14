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
 * Тестирование разбора координат для паттерна 02
 *
 * ./vendor/bin/phpunit --filter Pattern02Test
 */
class Pattern02Test extends TestCase
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
     * docker compose exec php php artisan test --filter pattern02Success
     * @throws WrongLatitudeException
     * @throws WrongLetterException
     * @throws WrongLongitudeException
     */
    #[DataProvider('successProvider')] #[Test]
    public function pattern02Success(string $src, float $lat, float $lon, string $pattern): void
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
     * docker compose exec php php artisan test --filter pattern02WrongLatitude
     * @throws WrongLatitudeException
     * @throws WrongLongitudeException
     * @throws WrongLetterException
     */
    #[DataProvider('wrongLatitudeProvider')] #[Test]
    public function pattern02WrongLatitude(string $src, float $lat, float $lon, string $pattern): void
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
     * docker compose exec php php artisan test --filter pattern02WrongLongitude
     * @throws WrongLatitudeException
     * @throws WrongLetterException
     * @throws WrongLongitudeException
     */
    #[DataProvider('wrongLongitudeProvider')] #[Test]
    public function pattern02WrongLongitude(string $src, float $lat, float $lon, string $pattern): void
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
            ['00N/000W', 0, 0, 'pattern02'],
            ['00S/000E', 0, 0, 'pattern02'],
            ['36N/75W', 36, -75, 'pattern02'],
            ['36S/75E', -36, 75, 'pattern02'],
            ['36.1N/75.1W', 36.1, -75.1, 'pattern02'],
            ['36.1S/75.1E', -36.1, 75.1, 'pattern02'],
            ['36.00001N/75.00001W', 36.00001, -75.00001, 'pattern02'],
            ['36.00001S/75.00001E', -36.00001, 75.00001, 'pattern02'],
        ];
    }

    /**
     * @return array[]
     */
    public static function wrongLatitudeProvider(): array
    {
        return [
            ['91N/75W', 91, -75, 'pattern02'],
            ['91S/75E', -91, 75, 'pattern02'],
            ['90.1N/75.1W', 90.1, -75.1, 'pattern02'],
            ['90.1S/75.1E', -90.1, 75.1, 'pattern02'],
            ['90.00001N/75.00001W', 90.00001, -75.00001, 'pattern02'],
            ['90.00001S/75.00001E', -90.00001, 75.00001, 'pattern02'],
        ];
    }

    /**
     * @return array[]
     */
    public static function wrongLongitudeProvider(): array
    {
        return [
            ['36N/181W', 36, -181, 'pattern02'],
            ['36S/181E', -36, 181, 'pattern02'],
            ['36.1N/180.1W', 36.1, -180.1, 'pattern02'],
            ['36.1S/180.1E', -36.1, 180.1, 'pattern02'],
            ['36.00001N/180.00001W', 36.00001, -180.00001, 'pattern02'],
            ['36.00001S/180.00001E', -36.00001, 180.00001, 'pattern02'],
        ];
    }
}
