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
 * Тестирование выброса исключения PatternNotFoundException
 *
 * ./vendor/bin/phpunit --filter Pattern10Test
 */
class PatternNotFoundTest extends TestCase
{
    /**
     * Успешное получение PointDto на основе переданной строки координат в ожидаемом формате
     *
     * @param string $src
     * @return void
     * @throws WrongLatitudeException
     * @throws WrongLongitudeException
     * @throws WrongLetterException
     * @throws PatternNotFoundException
     */
    #[DataProvider('notFoundProvider')] #[Test]
    public function patternNotFound(string $src): void
    {
        $this->expectException(PatternNotFoundException::class);

        $this->parser->getPointDto($src);
    }

    /**
     * @return array[]
     */
    public static function notFoundProvider(): array
    {
        return [
            // 01
            ['036°00′51.000001″N/75°30′04.000001″W'],
            ['36°00′51.000001″/75°30′04.000001″W'],
            ['36°00′51.000001″N/75°30′04.000001″'],

            // 02
            ['036N/175W'],
            ['36.1234567N/175.123456W'],
            ['36.123456N/175.1234567W'],
            ['036.123456N/175.123456W'],

            // 03
            ['+36.01/-71.22'],
            ['1.12/+123.12'],
            ['-123.12/-123.12'],
            ['-1.1234567/-123.123456'],
            ['-1.123456/-123.1234567'],
            ['53,822313, -8,633963'],
            ['-53,822313, 8,633963'],
            ['-53,822313, -8,633963'],
            ['53,822313,-8,633963'],
            ['-53,822313,8,633963'],
            ['-53,822313,-8,633963'],
            ['123,123'],
            ['12,1234'],
            ['180,180'],
            ['53,822313, -8,633963'],
            ['-53,822313, 8,633963'],
            ['-53,822313, -8,633963'],
            ['53,822313,-8,633963'],
            ['-53,822313,8,633963'],
            ['-53,822313,-8,633963'],

            // 05
            ['1234567N/1234567E'],
            ['123456N/12345678E'],
            ['123456/1234567E'],
            ['123456N/1234567'],
            ['123456E/1234567E'],
            ['123456N/1234567N'],
            ['-123456/1234567E'],
            ['123456N/-1234567'],

            // 06
            ['1231212/1231212'],
            ['-121212/12341212'],
            ['+121212/-1231212'],
            ['121212/+1231212'],

            // 07
            ['12345.12N/12345.12W'],
            ['1234.12N/123456.12W'],
            ['1234.123N/12345.12W'],
            ['1234.12N/12345.123W'],
            ['1234.12/12345.12W'],
            ['1234.12N/12345.12'],
            ['N1234.12/12345.12W'],
            ['1234.12N/W12345.12'],
            ['1234.12N/.12W'],
            ['.12N/12345.12W'],

            // 08
            ['3600.86N/-07530.07'],
            ['3600.86/-07530.07W'],
            ['+3600.86/-07530.07'],
            ['23600.86/-07530.07'],

            // 09
            ['N123.123456/E123.123456'],
            ['N12.123456/E1234.123456'],
            ['N12.1234567/E123.123456'],
            ['N12.123456/E123.1234567'],
            ['N55,00136/E057,19818'],
            ['N55,1/E057,1'],
            ['N000/E000'],
            ['N90,00136/E180,19818'],

            // 10
            ['123412345W'],
            ['1234N12345'],
            ['12345N12345W'],
            ['1234S123456E'],
            ['1234N1234W'],
            ['123S12345E'],
        ];
    }
}
