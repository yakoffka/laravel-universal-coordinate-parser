<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Patterns;

/**
 * Шаблон Example 'exampleSrcString'
 *
 * Класс, описывающий шаблон для строки определенного формата (либо группы схожих форматов).
 */
class PatternExample extends AbstractPattern
{
    /**
     * link_to_regex
     */
    public const REGEX = 'regex';

    /**
     * @param string $src
     * @param float $ltDegrees
     * @param float $ltMinutes
     * @param float $ltSeconds
     * @param string $ltLetter
     * @param string $ltSign
     * @param float $lnDegrees
     * @param float $lnMinutes
     * @param float $lnSeconds
     * @param string $lnLetter
     * @param string $lnSign
     * @param string $name
     */
    public function __construct(
        public string $src,
        public float  $ltDegrees,
        public float  $ltMinutes,
        public float  $ltSeconds,
        public string $ltLetter,
        public string $ltSign,
        public float  $lnDegrees,
        public float  $lnMinutes,
        public float  $lnSeconds,
        public string $lnLetter,
        public string $lnSign,
        public string $name = 'patternExample',
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
            src: $params['tExample'],
            ltDegrees: (float)$params['ltDExample'],
            ltMinutes: (float)$params['ltMExample'],
            ltSeconds: (float)$params['ltSecExample'],
            ltLetter: $params['ltLExample'],
            ltSign: $params['ltSignExample'],
            lnDegrees: (float)$params['lnDExample'],
            lnMinutes: (float)$params['lnMExample'],
            lnSeconds: (float)$params['lnSecExample'],
            lnLetter: $params['lnLExample'],
            lnSign: $params['lnSignExample'],
        );
    }
}
