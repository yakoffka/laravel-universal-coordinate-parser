<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Yakoffka\UniversalCoordinateParser\Exceptions\PatternNotFoundException;
use Yakoffka\UniversalCoordinateParser\Exceptions\WrongLatitudeException;
use Yakoffka\UniversalCoordinateParser\Exceptions\WrongLetterException;
use Yakoffka\UniversalCoordinateParser\Exceptions\WrongLongitudeException;
use Yakoffka\UniversalCoordinateParser\Tests\TestCase;

/**
 * Тестирование разбора координат для паттерна 05
 *
 * ./vendor/bin/phpunit --filter Pattern05Test
 */
class Pattern05Test extends TestCase
{
    /**
     * Успешное получение PointDto на основе переданной строки координат в ожидаемом формате
     *
     * @param string $src
     * @param float $lat
     * @param float $lon
     * @param string $pattern
     * @return void
     * @throws WrongLatitudeException
     * @throws WrongLongitudeException
     * @throws WrongLetterException
     * @throws PatternNotFoundException
     */
    #[DataProvider('successProvider')] #[Test]
    public function pattern05Success(string $src, float $lat, float $lon, string $pattern): void
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
     * @throws WrongLatitudeException
     * @throws WrongLetterException
     * @throws WrongLongitudeException
     * @throws PatternNotFoundException
     */
    #[DataProvider('wrongLatitudeProvider')] #[Test]
    public function pattern05WrongLatitude(string $src, float $lat, float $lon, string $pattern): void
    {
        $this->expectException(WrongLatitudeException::class);

        $this->parser->getPointDto($src);
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
     * @throws WrongLatitudeException
     * @throws WrongLetterException
     * @throws WrongLongitudeException
     * @throws PatternNotFoundException
     */
    #[DataProvider('wrongLongitudeProvider')] #[Test]
    public function pattern05WrongLongitude(string $src, float $lat, float $lon, string $pattern): void
    {
        $this->expectException(WrongLongitudeException::class);

        $this->parser->getPointDto($src);
    }

    /**
     * @return array[]
     * @todo дописать максимальные значения для всех случаев (минут, секунд, с дробными частями)
     */
    public static function successProvider(): array
    {
        return [
            ['000000N/0000000W', 0, 0, 'pattern05'],
            ['000000S/0000000E', 0, 0, 'pattern05'],
            ['360051N/0753004W', 36.014167, -75.501111, 'pattern05'],
            ['360051S/0753004E', -36.014167, 75.501111, 'pattern05'],
            ['900000N/1800000W', 90, -180, 'pattern05'],
            ['900000S/1800000E', -90, 180, 'pattern05'],
        ];
    }

    /**
     * @return array[]
     */
    public static function wrongLatitudeProvider(): array
    {
        return [
            ['910000N/1800000W', 90, -180, 'pattern05'],
            ['910000S/1800000E', -90, 180, 'pattern05'],
            ['900100N/1800000W', 90, -180, 'pattern05'],
            ['900100S/1800000E', -90, 180, 'pattern05'],
            ['900001N/1800000W', 90, -180, 'pattern05'],
            ['900001S/1800000E', -90, 180, 'pattern05'],
        ];
    }

    /**
     * @return array[]
     */
    public static function wrongLongitudeProvider(): array
    {
        return [
            ['900000N/1810000W', 90, -180, 'pattern05'],
            ['900000S/1810000E', -90, 180, 'pattern05'],
            ['900000N/1800100W', 90, -180, 'pattern05'],
            ['900000S/1800100E', -90, 180, 'pattern05'],
            ['900000N/1800001W', 90, -180, 'pattern05'],
            ['900000S/1800001E', -90, 180, 'pattern05'],
        ];
    }
}
