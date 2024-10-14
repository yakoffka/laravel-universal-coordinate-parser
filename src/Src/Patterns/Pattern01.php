<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Src\Patterns;

use Illuminate\Support\Arr;
use Yakoffka\UniversalCoordinateParser\Src\AbstractPattern;
use Yakoffka\UniversalCoordinateParser\Src\Dto\PointDTO;

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
     * @param string $src
     * @param float|int $ltDegrees
     * @param float|int $ltMinutes
     * @param float|int $ltSeconds
     * @param string $ltLetter
     * @param null $ltSign
     * @param float|int $lnDegrees
     * @param float|int $lnMinutes
     * @param float|int $lnSeconds
     * @param string $lnLetter
     * @param null $lnSign
     * @param string $name
     */
    public function __construct(
        public string    $src,
        public float|int $ltDegrees,
        public float|int $ltMinutes,
        public float|int $ltSeconds,
        public string    $ltLetter,
        public null      $ltSign,
        public float|int $lnDegrees,
        public float|int $lnMinutes,
        public float|int $lnSeconds,
        public string    $lnLetter,
        public null      $lnSign,
        public string    $name = 'pattern01',
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
            src: $params['t01'],
            ltDegrees: (float)$params['ltD01'],
            ltMinutes: (float)Arr::get($params, 'ltM01', 0),
            ltSeconds: (float)Arr::get($params, 'ltSec01', 0),
            ltLetter: $params['ltL01'],
            ltSign: null,
            lnDegrees: (float)$params['lnD01'],
            lnMinutes: (float)Arr::get($params, 'lnM01', 0),
            lnSeconds: (float)Arr::get($params, 'lnSec01', 0),
            lnLetter: $params['lnL01'],
            lnSign: null,
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
