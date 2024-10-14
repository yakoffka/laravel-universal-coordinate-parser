<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Src\Patterns;

use Yakoffka\UniversalCoordinateParser\Src\AbstractPattern;

/**
 * Шаблон 08 '3600.86/-07530.07'
 *
 * Жестко позиционированные значения в градусах и минутах с дробной частью, разделителем в виде слэша, без буквенного
 * обозначения
 */
class Pattern08 extends AbstractPattern
{
    /**
     * https://regex101.com/r/o4H23D/4
     */
    public const REGEX = '^(?<t08>(?<ltSign08>-|)(?<ltD08>\d{2})(?<ltM08>\d{2}\.\d{2})/(?<lnSign08>-|)(?<lnD08>\d{3})'
    . '(?<lnM08>\d{2}\.\d{2}))$';

    /**
     * @param string $src
     * @param float $ltDegrees
     * @param float $ltMinutes
     * @param null $ltSeconds
     * @param null $ltLetter
     * @param string $ltSign
     * @param float $lnDegrees
     * @param float $lnMinutes
     * @param null $lnSeconds
     * @param null $lnLetter
     * @param string $lnSign
     * @param string $name
     */
    public function __construct(
        public string $src,
        public float  $ltDegrees,
        public float  $ltMinutes,
        public null  $ltSeconds,
        public null $ltLetter,
        public string $ltSign,
        public float  $lnDegrees,
        public float  $lnMinutes,
        public null  $lnSeconds,
        public null $lnLetter,
        public string $lnSign,
        public string $name = 'pattern08',
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
            src: $params['t08'],
            ltDegrees: (float)$params['ltD08'],
            ltMinutes: (float)$params['ltM08'],
            ltSeconds: null,
            ltLetter: null,
            ltSign: $params['ltSign08'],
            lnDegrees: (float)$params['lnD08'],
            lnMinutes: (float)$params['lnM08'],
            lnSeconds: null,
            lnLetter: null,
            lnSign: $params['lnSign08'],
        );
    }
}
