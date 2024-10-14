<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Src\Patterns;

use Yakoffka\UniversalCoordinateParser\Src\AbstractPattern;

/**
 * Шаблон 09 'N55.00136/E057.19818' [yandex]
 *
 * Значения в градусах с возможной дробной частью, разделителем в виде слэша. Буквенное обозначение перед значением
 */
class Pattern09 extends AbstractPattern
{
    /**
     * https://regex101.com/r/EPBroQ/4
     */
    public const REGEX = '^(?<t09>(?<ltL09>N|S)(?<ltD09>\d{1,2}(?:(?:\.\d{1,6})|))/(?<lnL09>W|E)'
    . '(?<lnD09>\d{1,3}(?:(?:\.\d{1,6})|)))$';

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
        public null  $ltMinutes,
        public null  $ltSeconds,
        public string $ltLetter,
        public null $ltSign,
        public float  $lnDegrees,
        public null  $lnMinutes,
        public null  $lnSeconds,
        public string $lnLetter,
        public null $lnSign,
        public string $name = 'pattern09',
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
            src: $params['t09'],
            ltDegrees: (float)$params['ltD09'],
            ltMinutes: null,
            ltSeconds: null,
            ltLetter: $params['ltL09'],
            ltSign: null,
            lnDegrees: (float)$params['lnD09'],
            lnMinutes: null,
            lnSeconds: null,
            lnLetter: $params['lnL09'],
            lnSign: null,
        );
    }
}
