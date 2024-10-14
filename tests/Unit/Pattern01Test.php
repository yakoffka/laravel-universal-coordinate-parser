<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\WrongLatitudeException;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\WrongLongitudeException;
use Yakoffka\UniversalCoordinateParser\Tests\TestCase;

/**
 * Тестирование разбора координат для первого паттерна
 *
 * ./vendor/bin/phpunit --filter Pattern01Test
 */
class Pattern01Test extends TestCase
{
    /**
     * Успешное получение PointDto на основе переданной строки координат в ожидаемом формате
     *
     * @return void
     *
     * docker compose exec php php artisan test --filter pattern01Success
     */
    #[DataProvider('successProvider')] #[Test]
    public function pattern01Success(string $src, float $lat, float $lon, string $pattern): void
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
     * docker compose exec php php artisan test --filter pattern01WrongLatitude
     */
    #[DataProvider('wrongLatitudeProvider')] #[Test]
    public function pattern01WrongLatitude(string $src, float $lat, float $lon, string $pattern): void
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
     * docker compose exec php php artisan test --filter pattern01WrongLongitude
     */
    #[DataProvider('wrongLongitudeProvider')] #[Test]
    public function pattern01WrongLongitude(string $src, float $lat, float $lon, string $pattern): void
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
            ['36°N/75°W', 36, -75, 'pattern01'],
            ['36°S/75°E', -36, 75, 'pattern01'],
            ['90°N/180°W', 90, -180, 'pattern01'],
            ['90°S/180°E', -90, 180, 'pattern01'],
            // degrees and minutes
            ['36°01′N/75°01′W', 36.016667, -75.016667, 'pattern01'],
            ['36°01′S/75°01′E', -36.016667, 75.016667, 'pattern01'],
            ['36°30′N/75°30′W', 36.5, -75.5, 'pattern01'],
            ['36°30′S/75°30′E', -36.5, 75.5, 'pattern01'],
            ['36°59′N/75°59′W', 36.983333, -75.983333, 'pattern01'],
            ['36°59′S/75°59′E', -36.983333, 75.983333, 'pattern01'],
            ['36°60′N/75°60′W', 37, -76, 'pattern01'], // @todo продумать
            ['36°60′S/75°60′E', -37, 76, 'pattern01'], // @todo продумать
            ['36°61′N/75°61′W', 37.016667, -76.016667, 'pattern01'], // @todo продумать
            ['36°61′S/75°61′E', -37.016667, 76.016667, 'pattern01'], // @todo продумать
            // degrees, minutes and seconds
            ['36°30′01″N/75°30′01″W', 36.500278, -75.500278, 'pattern01'],
            ['36°30′01″S/75°30′01″E', -36.500278, 75.500278, 'pattern01'],
            ['36°30′30″N/75°30′30″W', 36.508333, -75.508333, 'pattern01'],
            ['36°30′30″S/75°30′30″E', -36.508333, 75.508333, 'pattern01'],
            ['36°30′59″N/75°30′59″W', 36.516389, -75.516389, 'pattern01'],
            ['36°30′59″S/75°30′59″E', -36.516389, 75.516389, 'pattern01'],
            ['36°30′60″N/75°30′60″W', 36.516667, -75.516667, 'pattern01'], // @todo продумать
            ['36°30′60″S/75°30′60″E', -36.516667, 75.516667, 'pattern01'], // @todo продумать
            ['36°30′61″N/75°30′61″W', 36.516944, -75.516944, 'pattern01'], // @todo продумать
            ['36°30′61″S/75°30′61″E', -36.516944, 75.516944, 'pattern01'], // @todo продумать
            // only degrees with fractional
            ['36.01°N/75.01°W', 36.01, -75.01, 'pattern01'],
            ['36.01°S/75.01°E', -36.01, 75.01, 'pattern01'],
            ['36.50°N/75.50°W', 36.50, -75.50, 'pattern01'],
            ['36.50°S/75.50°E', -36.50, 75.50, 'pattern01'],
            ['36.99°N/75.99°W', 36.99, -75.99, 'pattern01'],
            ['36.99°S/75.99°E', -36.99, 75.99, 'pattern01'],
            // degrees and minutes with fractional
            ['36°01.01′N/75°01.01′W', 36.016833, -75.016833, 'pattern01'],
            ['36°01.01′S/75°01.01′E', -36.016833, 75.016833, 'pattern01'],
            ['36°01.50′N/75°01.50′W', 36.025, -75.025, 'pattern01'],
            ['36°01.50′S/75°01.50′E', -36.025, 75.025, 'pattern01'],
            ['36°01.99′N/75°01.99′W', 36.033167, -75.033167, 'pattern01'],
            ['36°01.99′S/75°01.99′E', -36.033167, 75.033167, 'pattern01'],
            // degrees, minutes and seconds
            ['36°01′01.01″N/75°01′01.01″W', 36.016947, -75.016947, 'pattern01'],
            ['36°01′01.01″S/75°01′01.01″E', -36.016947, 75.016947, 'pattern01'],
            ['36°01′01.50″N/75°01′01.50″W', 36.017083, -75.017083, 'pattern01'],
            ['36°01′01.50″S/75°01′01.50″E', -36.017083, 75.017083, 'pattern01'],
            ['36°01′01.99″N/75°01′01.99″W', 36.017219, -75.017219, 'pattern01'],
            ['36°01′01.99″S/75°01′01.99″E', -36.017219, 75.017219, 'pattern01'],
        ];
    }

    /**
     * @return array[]
     */
    public static function wrongLatitudeProvider(): array
    {
        return [
            // only degrees
            ['91°N/75°W', 91, -75, 'pattern01'],
            ['91°S/75°E', -91, 75, 'pattern01'],
            // degrees and minutes
            ['90°01′N/75°30′W', 0, 0, 'pattern01'],
            ['90°01′S/75°30′E', 0, 0, 'pattern01'],
            // degrees, minutes and seconds
            ['90°00′01″N/75°30′01″W', 36.500278, -75.500278, 'pattern01'],
            ['90°00′01″S/75°30′01″E', -36.500278, 75.500278, 'pattern01'],
            // only degrees with fractional
            ['90.01°N/75.01°W', 36.01, -75.01, 'pattern01'],
            ['90.01°S/75.01°E', -36.01, 75.01, 'pattern01'],
            // degrees and minutes with fractional
            ['90°00.01′N/75°01.01′W', 36.016833, -75.016833, 'pattern01'],
            ['90°00.01′S/75°01.01′E', -36.016833, 75.016833, 'pattern01'],
            // degrees, minutes and seconds
            ['90°00′00.01″N/75°01′01.01″W', 36.016947, -75.016947, 'pattern01'],
            ['90°00′00.01″S/75°01′01.01″E', -36.016947, 75.016947, 'pattern01'],
        ];
    }

    /**
     * @return array[]
     */
    public static function wrongLongitudeProvider(): array
    {
        return [
            // only degrees
            ['36°N/181°W', 36, -181, 'pattern01'],
            ['36°S/181°E', -36, 181, 'pattern01'],
            // degrees and minutes
            ['36°01′N/180°01′W', 36.016667, -75.016667, 'pattern01'],
            ['36°01′S/180°01′E', -36.016667, 75.016667, 'pattern01'],
            // degrees, minutes and seconds
            ['36°00′01″N/180°00′01″W', 36.500278, -180.500278, 'pattern01'],
            ['36°00′01″S/180°00′01″E', -36.500278, 180.500278, 'pattern01'],
            // only degrees with fractional
            ['36.01°N/180.01°W', 36.01, -180.01, 'pattern01'],
            ['36.01°S/180.01°E', -36.01, 180.01, 'pattern01'],
            // degrees and minutes with fractional
            ['36°00.01′N/180°00.01′W', 36.016833, -180.016833, 'pattern01'],
            ['36°00.01′S/180°00.01′E', -36.016833, 180.016833, 'pattern01'],
            // degrees, minutes and seconds
            ['36°00′00.01″N/180°00′00.01″W', 36.016947, -180.016947, 'pattern01'],
            ['36°00′00.01″S/180°00′00.01″E', -36.016947, 75.016947, 'pattern01'],
        ];
    }
}
