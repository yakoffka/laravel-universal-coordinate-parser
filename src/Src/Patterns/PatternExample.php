<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Src\Patterns;

use Yakoffka\UniversalCoordinateParser\Src\AbstractPattern;

/**
 * Класс, описывающий шаблон для строки определенного формата (либо группы схожих форматов).
 */
class PatternExample extends AbstractPattern
{
    /**
     * Шаблон Example 'DDDDDDDDDDDDDDDDDDDDDDDDD'
     *
     * DESCRIPTION
     *
     * link_to_regex
     */
    public const REGEX = 'regex';

    /**
     * @param string $src
     * @param float|int $ltDegrees
     * @param float|int $ltMinutes
     * @param float|int $ltSeconds
     * @param string $ltLetter
     * @param string $ltSign
     * @param float|int $lnDegrees
     * @param float|int $lnMinutes
     * @param float|int $lnSeconds
     * @param string $lnLetter
     * @param string $lnSign
     * @param string $name
     */
    public function __construct(
        public string    $src,
        public float|int $ltDegrees,
        public float|int $ltMinutes,
        public float|int $ltSeconds,
        public string    $ltLetter,
        public string    $ltSign,
        public float|int $lnDegrees,
        public float|int $lnMinutes,
        public float|int $lnSeconds,
        public string    $lnLetter,
        public string    $lnSign,
        public string    $name = 'patternExample',
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
            ltDegrees: $params['ltDExample'],
            ltMinutes: $params['ltMExample'],
            ltSeconds: $params['ltSecExample'],
            ltLetter: $params['ltLExample'],
            ltSign: $params['ltSign'],
            lnDegrees: $params['lnDExample'],
            lnMinutes: $params['lnMExample'],
            lnSeconds: $params['lnSecExample'],
            lnLetter: $params['lnLExample'],
            lnSign: $params['lnSign'],
        );
    }
}
