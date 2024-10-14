<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Src\Patterns;

use Yakoffka\UniversalCoordinateParser\Src\Dto\PointDTO;
use Yakoffka\UniversalCoordinateParser\Src\AbstractPattern;

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
     * @var string $src 'example_src_string'
     */
    public string $src;
    public float|int $ltDExample;
    public float|int $ltMExample;
    public float|int $ltSecExample;
    public string $ltLExample;
    public float|int $lnDExample;
    public float|int $lnMExample;
    public float|int $lnSecExample;
    public string $lnLExample;

    /**
     * @param array $params
     * @return static
     */
    public static function from(array $params): static
    {
        return new static(
            t02: $params['t02'],
            ltD02: (float)$params['ltD02'],
            ltL02: $params['ltL02'],
            lnD02: (float)$params['lnD02'],
            lnL02: $params['lnL02'],
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
