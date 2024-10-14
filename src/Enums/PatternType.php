<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Enums;

use Yakoffka\UniversalCoordinateParser\Src\AbstractPattern;
use Yakoffka\UniversalCoordinateParser\Src\Patterns\Pattern01;
use Yakoffka\UniversalCoordinateParser\Src\Patterns\Pattern02;
use Yakoffka\UniversalCoordinateParser\Src\Patterns\Pattern03;
use Yakoffka\UniversalCoordinateParser\Src\Patterns\Pattern05;
use Yakoffka\UniversalCoordinateParser\Src\Patterns\Pattern06;
use Yakoffka\UniversalCoordinateParser\Src\Patterns\Pattern07;
use Yakoffka\UniversalCoordinateParser\Src\Patterns\Pattern08;
use Yakoffka\UniversalCoordinateParser\Src\Patterns\Pattern09;
use Yakoffka\UniversalCoordinateParser\Src\Patterns\Pattern10;

enum PatternType: string
{
    case t01 = Pattern01::class;
    case t02 = Pattern02::class;
    case t03 = Pattern03::class;
    //case t04 = Pattern04::class;
    case t05 = Pattern05::class;
    case t06 = Pattern06::class;
    case t07 = Pattern07::class;
    case t08 = Pattern08::class;
    case t09 = Pattern09::class;
    case t10 = Pattern10::class;

    /**
     * @return array<string>
     */
    public static function getPatternNames(): array
    {
        return array_map(fn(self $patternType) => $patternType->name, self::cases());
    }

    /**
     * @param string $name
     * @param array $params
     * @return AbstractPattern
     */
    public static function getPattern(string $name, array $params): AbstractPattern
    {
        return match ($name) {
            't01' => Pattern01::from($params),
            't02' => Pattern02::from($params),
            't03' => Pattern03::from($params),
            // 't04' => '', // Pattern04::from($params),
            't05' => Pattern05::from($params),
            't06' => Pattern06::from($params),
            't07' => Pattern07::from($params),
            't08' => Pattern08::from($params),
            't09' => Pattern09::from($params),
            't10' => Pattern10::from($params),
        };
    }

    /**
     * Универсальный шаблон
     *
     * https://regex101.com/r/pqVQ3w/9 (при изменении результата обновить регулярное выражение)
     *
     * @return string
     */
    public static function getUniversalRegex(): string
    {
        return '~'
            . Pattern01::REGEX
            . '|' . Pattern02::REGEX
            . '|' . Pattern03::REGEX
            // . '|' . Pattern04::REGEX
            . '|' . Pattern05::REGEX
            . '|' . Pattern06::REGEX
            . '|' . Pattern07::REGEX
            . '|' . Pattern08::REGEX
            . '|' . Pattern09::REGEX
            . '|' . Pattern10::REGEX
            . '~';
    }
}
