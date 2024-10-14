<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Src\Patterns;

use Yakoffka\UniversalCoordinateParser\Src\AbstractPattern;

/**
 * Шаблон 05 '360051N/0753004W'
 * DD°MM′SS″ (with letters) in ForeFlight (360051N/0753004W equivalent 36°00′51″N/75°30′04″W)
 *
 * Жестко позиционированные значения в градусах, минутах и секундах без дробной части, разделителем в виде слэша,
 * буквенным обозначением
 */
class Pattern05 extends AbstractPattern
{
    /**
     * https://regex101.com/r/UBFTg2/4
     */
    public const REGEX = '^(?<t05>(?<ltD05>\d{2})(?<ltM05>\d{2})(?<ltSec05>\d{2})(?<ltL05>N|S)/(?<lnD05>\d{3})'
        . '(?<lnM05>\d{2})(?<lnSec05>\d{2})(?<lnL05>W|E))$';

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
        public null $ltSign,
        public float  $lnDegrees,
        public float  $lnMinutes,
        public float  $lnSeconds,
        public string $lnLetter,
        public null $lnSign,
        public string $name = 'pattern05',
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
            src: $params['t05'],
            ltDegrees: (float)$params['ltD05'],
            ltMinutes: (float)$params['ltM05'],
            ltSeconds: (float)$params['ltSec05'],
            ltLetter: $params['ltL05'],
            ltSign: null,
            lnDegrees: (float)$params['lnD05'],
            lnMinutes: (float)$params['lnM05'],
            lnSeconds: (float)$params['lnSec05'],
            lnLetter: $params['lnL05'],
            lnSign: null,
        );
    }
}
