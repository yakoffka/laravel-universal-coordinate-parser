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
 * Тестирование разбора координат для паттерна 09
 *
 * ./vendor/bin/phpunit --filter Pattern09Test
 */
class Pattern09Test extends TestCase
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
    public function pattern09Success(string $src, float $lat, float $lon, string $pattern): void
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
    public function pattern09WrongLatitude(string $src, float $lat, float $lon, string $pattern): void
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
    public function pattern09WrongLongitude(string $src, float $lat, float $lon, string $pattern): void
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
            ['N00/W000', 0, 0, 'pattern09'],
            ['S00/E000', 0, 0, 'pattern09'],
            ['N00.0/W000.0', 0, 0, 'pattern09'],
            ['S00.0/E000.0', 0, 0, 'pattern09'],
            ['N00.00000/W000.00000', 0, 0, 'pattern09'],
            ['S00.00000/E000.00000', 0, 0, 'pattern09'],
            ['N55.00136/W057.19818', 55.00136, -057.19818, 'pattern09'],
            ['S55.00136/E057.19818', -55.00136, 057.19818, 'pattern09'],
            ['N90.000000/W180.000000', 90, -180, 'pattern09'],
            ['S90.000000/E180.000000', -90, 180, 'pattern09'],
        ];
    }

    /**
     * @return array[]
     */
    public static function wrongLatitudeProvider(): array
    {
        return [
            ['N90.000001/W180.000000', 90, -180, 'pattern09'],
            ['S90.000001/E180.000000', -90, 180, 'pattern09'],
        ];
    }

    /**
     * @return array[]
     */
    public static function wrongLongitudeProvider(): array
    {
        return [
            ['N90.000000/W180.000001', 90, -180, 'pattern09'],
            ['S90.000000/E180.000001', -90, 180, 'pattern09'],
        ];
    }
}
