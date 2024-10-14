<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser;

use Illuminate\Support\Arr;
use RuntimeException;
use Yakoffka\UniversalCoordinateParser\Src\AbstractPattern;
use Yakoffka\UniversalCoordinateParser\Src\Dto\PointDTO;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\WrongLatitudeException;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\WrongLetterException;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\WrongLongitudeException;
use Yakoffka\UniversalCoordinateParser\Src\Patterns\Pattern01;
use Yakoffka\UniversalCoordinateParser\Src\Patterns\Pattern02;
use Yakoffka\UniversalCoordinateParser\Src\Patterns\Pattern03;
use Yakoffka\UniversalCoordinateParser\Src\Patterns\Pattern05;
use Yakoffka\UniversalCoordinateParser\Src\Patterns\Pattern06;
use Yakoffka\UniversalCoordinateParser\Src\Patterns\Pattern07;
use Yakoffka\UniversalCoordinateParser\Src\Patterns\Pattern08;
use Yakoffka\UniversalCoordinateParser\Src\Patterns\Pattern09;
use Yakoffka\UniversalCoordinateParser\Src\Patterns\Pattern10;

/**
 * Универсальный парсер координат.
 * Преобразует строку координат в одном из распространенных форматов в PointDTO
 */
class Parser
{
    /**
     * Универсальный шаблон
     *
     * https://regex101.com/r/pqVQ3w/9
     */
    public const REGEX = '~'
    . Pattern01::REGEX
    . '|' . Pattern02::REGEX
    . '|' . Pattern03::REGEX
    . '|' . Pattern05::REGEX
    . '|' . Pattern06::REGEX
    . '|' . Pattern07::REGEX
    . '|' . Pattern08::REGEX
    . '|' . Pattern09::REGEX
    . '|' . Pattern10::REGEX
    . '~';

    /**
     * @var array|string[]
     * @todo избыточно!
     */
    private array $patterns = [
        't01' => Pattern01::class,
        't02' => Pattern02::class,
        't03' => '', // Pattern03::class,
        // 't04' => '', // Pattern04::class,
        't05' => '', // Pattern05::class,
        't06' => '', // Pattern06::class,
        't07' => '', // Pattern07::class,
        't08' => '', // Pattern08::class,
        't09' => '', // Pattern09::class,
        't10' => '', // Pattern10::class,
    ];

    /**
     * Преобразование строки координат в одном из распространенных форматов в PointDTO
     *
     * @param string $subject строка координат без указания формата
     * @return PointDTO
     * @throws WrongLatitudeException
     * @throws WrongLetterException
     * @throws WrongLongitudeException
     */
    public function getPointDto(string $subject): PointDto
    {
        $matches = $this->getMatches($subject, $matches);
        $params = $this->cleanMatches($matches);
        // dd($params);
        $pattern = $this->getPattern($params, $subject);
        // dd($pattern);

        return $pattern->toPointDto();
    }

    /**
     * @param string $subject
     * @param $matches
     * @return mixed
     */
    public function getMatches(string $subject, &$matches): mixed
    {
        $res = preg_match(self::REGEX, $subject, $matches, PREG_UNMATCHED_AS_NULL);
        if ($res === false) {
            throw new RuntimeException('Invalid subject');
        }
        return $matches;
    }

    /**
     * @param array $params
     * @param string $subject
     * @return AbstractPattern
     */
    private function getPattern(array $params, string $subject): AbstractPattern
    {
        return match ($this->getPatternName($params, $subject)) {
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
     * @param array $params
     * @param string $subject
     * @return string
     */
    private function getPatternName(array $params, string $subject): string
    {
        $matchingPatterns = array_intersect(array_keys($this->patterns), array_keys($params));

        if (count($matchingPatterns) > 1) {
            throw new RuntimeException("Найдено совпадение с более, чем одним шаблоном для '$subject': "
                . implode(', ', $matchingPatterns));

        } elseif (count($matchingPatterns) === 0) {
            throw new RuntimeException("Не найдено совпадений ни с одним одним шаблоном для '$subject'");
        }

        return array_shift($matchingPatterns);
    }

    /**
     * @param array $matches
     * @return array
     */
    private function cleanMatches(array $matches): array
    {
        return $this->clearFromNull($this->clearFromNaturalKeys($matches));
    }

    /**
     * Очистка массива от натуральных (0, 1, 2, ...) и дополнительно указанных ключей
     *
     * @param array $matches
     * @param array|null $dirtyKeys
     * @return array
     */
    private function clearFromNaturalKeys(array $matches, ?array $dirtyKeys = null): array
    {
        return Arr::except($matches, [...range(0, count($matches)), ...($dirtyKeys ?? [])]);
    }

    /**
     * Очистка массива array<?string> от null значений
     *
     * @param array $matches
     * @return array
     */
    private function clearFromNull(array $matches): array
    {
        return array_filter($matches, fn(?string $v) => $v !== null);
    }
}