<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Src\Patterns;

use Yakoffka\UniversalCoordinateParser\Src\AbstractPattern;

/**
 * Шаблон 06 '360061N/0753004W'
 *
 * Жестко позиционированные значения в градусах, минутах и секундах без дробной части, разделителем в виде слэша, без
 * буквенного обозначения
 */
class Pattern06 extends AbstractPattern
{
    /**
     * https://regex101.com/r/4Z8Ttn/6
     */
    public const REGEX = '^(?<t06>(?<ltSign06>-|)(?<ltD06>\d{2})(?<ltM06>\d{2})(?<ltSec06>\d{2})/(?<lnSign06>-|)'
    . '(?<lnD06>\d{3})(?<lnM06>\d{2})(?<lnSec06>\d{2}))$';

    /**
     * @param string $src
     * @param float $ltDegrees
     * @param float $ltMinutes
     * @param float $ltSeconds
     * @param null $ltLetter
     * @param string $ltSign
     * @param float $lnDegrees
     * @param float $lnMinutes
     * @param float $lnSeconds
     * @param null $lnLetter
     * @param string $lnSign
     * @param string $name
     */
    public function __construct(
        public string $src,
        public float  $ltDegrees,
        public float  $ltMinutes,
        public float  $ltSeconds,
        public null $ltLetter,
        public string $ltSign,
        public float  $lnDegrees,
        public float  $lnMinutes,
        public float  $lnSeconds,
        public null $lnLetter,
        public string $lnSign,
        public string $name = 'pattern06',
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
            src: $params['t06'],
            ltDegrees: (float)$params['ltD06'],
            ltMinutes: (float)$params['ltM06'],
            ltSeconds: (float)$params['ltSec06'],
            ltLetter: null,
            ltSign: $params['ltSign06'],
            lnDegrees: (float)$params['lnD06'],
            lnMinutes: (float)$params['lnM06'],
            lnSeconds: (float)$params['lnSec06'],
            lnLetter: null,
            lnSign: $params['lnSign06'],
        );
    }
}
