<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Src\Patterns;

use Yakoffka\UniversalCoordinateParser\Src\Dto\PointDTO;
use Yakoffka\UniversalCoordinateParser\Src\AbstractPattern;

/**
 * Класс, описывающий шаблон для строки определенного формата (либо группы схожих форматов).
 */
class Pattern01 extends AbstractPattern
{
    /**
     * Шаблон 01 '36°00′51″N/75°30′04″W'
     *
     * Значения в градусах, минутах и секундах с возможной дробной частью, разделителем в виде слеша, буквенным
     * обозначением и обозначением градусов, минут и секунд
     *
     * https://regex101.com/r/P4Pv8c/9
     */
    public const REGEX_01 = '~^(?<t01>'
    . '(?<ltD01>\d{1,2}(?:(?:\.\d{1,6})|))°(?:(?<ltM01>\d{1,2}(?:(?:\.\d{1,6})|))′|)'
    . '(?:(?<ltSec01>\d{1,2}(?:(?:\.\d{1,6})|))″|)(?<ltL01>N|S)/(?<lnD01>\d{1,3}(?:(?:\.\d{1,6})|))°'
    . '(?:(?<lnM01>\d{1,2}(?:(?:\.\d{1,6})|))′|)(?:(?<lnSec01>\d{1,2}(?:(?:\.\d{1,6})|))″|)(?<lnL01>W|E))$~';

    /**
     * @param string $t01
     * @param float|int $ltD01
     * @param float|int $ltM01
     * @param float|int $ltSec01
     * @param string $ltL01
     * @param float|int $lnD01
     * @param float|int $lnM01
     * @param float|int $lnSec01
     * @param string $lnL01
     */
    public function __construct(
        public string    $t01,
        public float|int $ltD01,
        public float|int $ltM01,
        public float|int $ltSec01,
        public string    $ltL01,
        public float|int $lnD01,
        public float|int $lnM01,
        public float|int $lnSec01,
        public string    $lnL01,
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
            t01: $params['t01'],
            ltD01: $params['ltD01'],
            ltM01: $params['ltM01'],
            ltSec01: $params['ltSec01'],
            ltL01: $params['ltL01'],
            lnD01: $params['lnD01'],
            lnM01: $params['lnM01'],
            lnSec01: $params['lnSec01'],
            lnL01: $params['lnL01'],
        );
    }

    /**
     * @param string $src
     * @return PointDTO
     */
    public function parse(string $src): PointDTO
    {
        // TODO: Implement parse() method.
        return PointDTO::fromLatLon(0,0);
    }

    /**
     * @return float
     */
    protected function getLat(): float
    {
        // @todo реализовать!
        return 0.0;
    }

    /**
     * @return float
     */
    protected function getLon(): float
    {
        // @todo реализовать!
        return 0.0;
    }
}
