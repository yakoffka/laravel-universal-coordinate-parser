<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\PatternNotFoundException;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\WrongLatitudeException;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\WrongLetterException;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\WrongLongitudeException;
use Yakoffka\UniversalCoordinateParser\Tests\TestCase;

/**
 * Тестирование разбора координат для паттерна 08
 *
 * ./vendor/bin/phpunit --filter Pattern08Test
 */
class Pattern08Test extends TestCase
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
    public function pattern08Success(string $src, float $lat, float $lon, string $pattern): void
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
    public function pattern08WrongLatitude(string $src, float $lat, float $lon, string $pattern): void
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
    public function pattern08WrongLongitude(string $src, float $lat, float $lon, string $pattern): void
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
            ['0000.00/-00000.00', 0, 0, 'pattern08'],
            ['-0000.00/00000.00', 0, 0, 'pattern08'],
            ['3600.86/-07530.07', 36.014333, -75.501167, 'pattern08'],
            ['-3600.86/07530.07', -36.014333, 75.501167, 'pattern08'],
            ['9000.00/-18000.00', 90, -180, 'pattern08'],
            ['-9000.00/18000.00', -90, 180, 'pattern08'],
        ];
    }

    /**
     * @return array[]
     */
    public static function wrongLatitudeProvider(): array
    {
        return [
            ['910000/-1800000', 90, -180, 'pattern08'],
            ['-910000/1800000', -90, 180, 'pattern08'],
            ['900100/-1800000', 90, -180, 'pattern08'],
            ['-900100/1800000', -90, 180, 'pattern08'],
            ['900001/-1800000', 90, -180, 'pattern08'],
            ['-900001/1800000', -90, 180, 'pattern08'],
        ];
    }

    /**
     * @return array[]
     */
    public static function wrongLongitudeProvider(): array
    {
        return [
            ['900000/-1810000', 90, -180, 'pattern08'],
            ['-900000/1810000', -90, 180, 'pattern08'],
            ['900000/-1800100', 90, -180, 'pattern08'],
            ['-900000/1800100', -90, 180, 'pattern08'],
            ['900000/-1800001', 90, -180, 'pattern08'],
            ['-900000/1800001', -90, 180, 'pattern08'],
        ];
    }
}
