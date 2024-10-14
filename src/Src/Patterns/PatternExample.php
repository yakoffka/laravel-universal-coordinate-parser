<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Src\Patterns;

use Yakoffka\UniversalCoordinateParser\Src\AbstractPattern;
use Yakoffka\UniversalCoordinateParser\Src\Dto\PointDTO;

/**
 * Класс, описывающий шаблон для строки определенного формата (либо группы схожих форматов).
 */
class PatternExample extends AbstractPattern
{
    /**
     * Шаблон Example '36°00′51″N/75°30′04″W'
     *
     * Значения в градусах, минутах и секундах с возможной дробной частью, разделителем в виде слеша, буквенным
     * обозначением и обозначением градусов, минут и секунд
     *
     * link_to_regex
     */
    public const REGEX_EXAMPLE = '~regex~';

    /**
     * @param string $src
     * @param float|int $ltDExample
     * @param float|int $ltMExample
     * @param float|int $ltSecExample
     * @param string $ltLExample
     * @param float|int $lnDExample
     * @param float|int $lnMExample
     * @param float|int $lnSecExample
     * @param string $lnLExample
     * @param string $name
     */
    public function __construct(
        public string    $src,
        public float|int $ltDExample,
        public float|int $ltMExample,
        public float|int $ltSecExample,
        public string    $ltLExample,
        public float|int $lnDExample,
        public float|int $lnMExample,
        public float|int $lnSecExample,
        public string    $lnLExample,
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
            src: $params['t01'],
            ltDExample: $params['ltDExample'],
            ltMExample: $params['ltMExample'],
            ltSecExample: $params['ltSecExample'],
            ltLExample: $params['ltLExample'],
            lnDExample: $params['lnDExample'],
            lnMExample: $params['lnMExample'],
            lnSecExample: $params['lnSecExample'],
            lnLExample: $params['lnLExample'],
        );
    }

    /**
     * @param string $src
     * @return PointDTO
     */
    public function parse(string $src): PointDTO
    {
        // TODO: Implement parse() method.
    }
}
