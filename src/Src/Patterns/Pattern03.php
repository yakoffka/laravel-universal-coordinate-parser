<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Src\Patterns;

use Yakoffka\UniversalCoordinateParser\Src\AbstractPattern;

/**
 * Шаблон 03 '36.01/-75.50'
 * DD.dd (with a minus) in ForeFlight (36.01/-75.50 equivalent 36.01°N/75.5°W)
 *
 * Значения в градусах с возможной дробной частью, разделителем в виде слэша, запятой или запятой с пробелом и без
 * буквенного обозначения
 */
class Pattern03 extends AbstractPattern
{
    /**
     * https://regex101.com/r/D3AGHV/5
     */
    public const REGEX = '^(?<t03>(?<ltSign03>-|)(?<ltD03>\d{1,2}(?:\.\d{1,6}|))(?:/|,|(?:, ))(?<lnSign03>-|)'
    . '(?<lnD03>\d{1,3}(?:\.\d{1,6}|)))$';

    /**
     * @param string $src
     * @param float $ltDegrees
     * @param null $ltMinutes
     * @param null $ltSeconds
     * @param null $ltLetter
     * @param string $ltSign
     * @param float $lnDegrees
     * @param null $lnMinutes
     * @param null $lnSeconds
     * @param null $lnLetter
     * @param string $lnSign
     * @param string $name
     */
    public function __construct(
        public string $src,
        public float  $ltDegrees,
        public null   $ltMinutes,
        public null   $ltSeconds,
        public null   $ltLetter,
        public string $ltSign,
        public float  $lnDegrees,
        public null   $lnMinutes,
        public null   $lnSeconds,
        public null   $lnLetter,
        public string $lnSign,
        public string $name = 'pattern03',
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
            src: $params['t03'],
            ltDegrees: (float)$params['ltD03'],
            ltMinutes: null,
            ltSeconds: null,
            ltLetter: null,
            ltSign: $params['ltSign03'],
            lnDegrees: (float)$params['lnD03'],
            lnMinutes: null,
            lnSeconds: null,
            lnLetter: null,
            lnSign: $params['lnSign03'],
        );
    }
}
