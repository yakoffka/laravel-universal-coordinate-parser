<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Src\Patterns;

use Yakoffka\UniversalCoordinateParser\Src\AbstractPattern;

/**
 * Шаблон 02 '36.01N/75.50W'
 *
 * Значения в градусах с возможной дробной частью, разделителем в виде слэша и буквенным обозначением
 */
class Pattern02 extends AbstractPattern
{
    /**
     * https://regex101.com/r/Zguahj/5
     */
    public const REGEX = '^(?<t02>(?<ltD02>\d{1,2}(?:\.\d{1,6}|))(?<ltL02>N|S)/(?<lnD02>\d{1,3}(?:\.\d{1,6}|))'
    . '(?<lnL02>W|E))$';

    /**
     * @param string $src
     * @param float $ltDegrees
     * @param null $ltMinutes
     * @param null $ltSeconds
     * @param string $ltLetter
     * @param null $ltSign
     * @param float $lnDegrees
     * @param null $lnMinutes
     * @param null $lnSeconds
     * @param string $lnLetter
     * @param null $lnSign
     * @param string $name
     */
    public function __construct(
        public string $src,
        public float  $ltDegrees,
        public null   $ltMinutes,
        public null   $ltSeconds,
        public string $ltLetter,
        public null   $ltSign,
        public float  $lnDegrees,
        public null   $lnMinutes,
        public null   $lnSeconds,
        public string $lnLetter,
        public null   $lnSign,
        public string $name = 'pattern02',
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
            src: $params['t02'],
            ltDegrees: (float)$params['ltD02'],
            ltMinutes: null,
            ltSeconds: null,
            ltLetter: $params['ltL02'],
            ltSign: null,
            lnDegrees: (float)$params['lnD02'],
            lnMinutes: null,
            lnSeconds: null,
            lnLetter: $params['lnL02'],
            lnSign: null,
        );
    }
}
