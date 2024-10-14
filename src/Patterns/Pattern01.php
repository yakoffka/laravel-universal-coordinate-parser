<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Patterns;

use Illuminate\Support\Arr;

/**
 * Шаблон 01 '36°00′51″N/75°30′04″W'
 *
 * Значения в градусах, минутах и секундах с возможной дробной частью, разделителем в виде слэша, буквенным
 * обозначением и обозначением градусов, минут и секунд
 */
class Pattern01 extends AbstractPattern
{
    /**
     * https://regex101.com/r/P4Pv8c/9
     */
    public const REGEX = '^(?<t01>'
    . '(?<ltD01>\d{1,2}(?:(?:\.\d{1,6})|))°(?:(?<ltM01>\d{1,2}(?:(?:\.\d{1,6})|))′|)'
    . '(?:(?<ltSec01>\d{1,2}(?:(?:\.\d{1,6})|))″|)(?<ltL01>N|S)/(?<lnD01>\d{1,3}(?:(?:\.\d{1,6})|))°'
    . '(?:(?<lnM01>\d{1,2}(?:(?:\.\d{1,6})|))′|)(?:(?<lnSec01>\d{1,2}(?:(?:\.\d{1,6})|))″|)(?<lnL01>W|E))$';

    /**
     * @param string $src
     * @param float $ltDegrees
     * @param float $ltMinutes
     * @param float $ltSeconds
     * @param string $ltLetter
     * @param null $ltSign
     * @param float $lnDegrees
     * @param float $lnMinutes
     * @param float $lnSeconds
     * @param string $lnLetter
     * @param null $lnSign
     * @param string $name
     */
    public function __construct(
        public string $src,
        public float  $ltDegrees,
        public float  $ltMinutes,
        public float  $ltSeconds,
        public string $ltLetter,
        public null   $ltSign,
        public float  $lnDegrees,
        public float  $lnMinutes,
        public float  $lnSeconds,
        public string $lnLetter,
        public null   $lnSign,
        public string $name = 'pattern01',
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
}
