<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Src\Patterns;

use Yakoffka\UniversalCoordinateParser\Src\AbstractPattern;

/**
 * Шаблон 07 '3600.86N/07530.07W'
 *
 * Жестко позиционированные значения в градусах и минутах с дробной частью, разделителем в виде слэша, буквенным
 * обозначением
 */
class Pattern07 extends AbstractPattern
{
    /**
     * https://regex101.com/r/RtNxVp/4
     */
    public const REGEX = '^(?<t07>(?<ltD07>\d{2})(?<ltM07>\d{2}\.\d{2})(?<ltL07>S|N)/(?<lnD07>\d{3})'
    . '(?<lnM07>\d{2}\.\d{2})(?<lnL07>W|E))$';

    /**
     * @param string $src
     * @param float $ltDegrees
     * @param float $ltMinutes
     * @param null $ltSeconds
     * @param string $ltLetter
     * @param null $ltSign
     * @param float $lnDegrees
     * @param float $lnMinutes
     * @param null $lnSeconds
     * @param string $lnLetter
     * @param null $lnSign
     * @param string $name
     */
    public function __construct(
        public string $src,
        public float  $ltDegrees,
        public float  $ltMinutes,
        public null  $ltSeconds,
        public string $ltLetter,
        public null $ltSign,
        public float  $lnDegrees,
        public float  $lnMinutes,
        public null  $lnSeconds,
        public string $lnLetter,
        public null $lnSign,
        public string $name = 'pattern07',
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
            src: $params['t07'],
            ltDegrees: (float)$params['ltD07'],
            ltMinutes: (float)$params['ltM07'],
            ltSeconds: null,
            ltLetter: $params['ltL07'],
            ltSign: null,
            lnDegrees: (float)$params['lnD07'],
            lnMinutes: (float)$params['lnM07'],
            lnSeconds: null,
            lnLetter: $params['lnL07'],
            lnSign: null,
        );
    }
}
