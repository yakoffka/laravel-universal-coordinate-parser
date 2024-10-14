<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Src\Patterns;

use Yakoffka\UniversalCoordinateParser\Src\Dto\PointDTO;
use Yakoffka\UniversalCoordinateParser\Src\AbstractPattern;

/**
 * Класс, описывающий шаблон для строки определенного формата (либо группы схожих форматов).
 */
class Pattern02 extends AbstractPattern
{
    /**
     * 36.01N/75.50W
     * Шаблон 02: значения в градусах с возможной дробной частью, разделителем в виде слеша и буквенным обозначением
     *
     * https://regex101.com/r/Zguahj/5
     */
    public const REGEX_02 = '~^(?<t02>(?<ltD02>\d{1,2}(?:\.\d{1,6}|))(?<ltL02>N|S)/(?<lnD02>\d{1,3}(?:\.\d{1,6}|))'
    . '(?<lnL02>W|E))$~';

    /**
     * @param string $t02
     * @param float|int $ltD02
     * @param string $ltL02
     * @param float|int $lnD02
     * @param string $lnL02
     */
    public function __construct(
        public string    $t02,
        public float|int $ltD02,
        public string    $ltL02,
        public float|int $lnD02,
        public string    $lnL02,
    )
    {
    }

    /**
     * @param array $params
     * @return static
     */
    public static function from(array $params): static
    {
        return new static(
            t02: $params['t02'],
            ltD02: (float)$params['ltD02'],
            ltL02: $params['ltL02'],
            lnD02: (float)$params['lnD02'],
            lnL02: $params['lnL02'],
        );
    }

    /**
     * @param string $src
     * @return PointDTO
     */
    public function parse(string $src): PointDTO
    {
        // TODO: Implement parse() method.
    }
}
