<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Src\Patterns;

use Yakoffka\UniversalCoordinateParser\Src\AbstractPattern;

/**
 * Шаблон 10 '3720S18208E' [ТС-2013]
 *
 * Значение представлено в жестком формате GGMMLGGGMML
 */
class Pattern10 extends AbstractPattern
{
    /**
     * https://regex101.com/r/AE6g5S/3
     */
    public const REGEX = '^(?<t10>(?<ltD10>\d{2})(?<ltM10>\d{2})(?<ltL10>N|S)(?<lnD10>\d{3})(?<lnM10>\d{2})'
    . '(?<lnL10>W|E))$';

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
        public string $name = 'pattern10',
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
            src: $params['t10'],
            ltDegrees: (float)$params['ltD10'],
            ltMinutes: (float)$params['ltM10'],
            ltSeconds: null,
            ltLetter: $params['ltL10'],
            ltSign: null,
            lnDegrees: (float)$params['lnD10'],
            lnMinutes: (float)$params['lnM10'],
            lnSeconds: null,
            lnLetter: $params['lnL10'],
            lnSign: null,
        );
    }
}
