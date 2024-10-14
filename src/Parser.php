<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser;

use Illuminate\Support\Arr;
use RuntimeException;
use Yakoffka\UniversalCoordinateParser\Enums\PatternType;
use Yakoffka\UniversalCoordinateParser\Src\AbstractPattern;
use Yakoffka\UniversalCoordinateParser\Src\Dto\PointDTO;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\PatternNotFoundException;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\WrongLatitudeException;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\WrongLetterException;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\WrongLongitudeException;

/**
 * Универсальный парсер координат.
 * Преобразует строку координат в одном из распространенных форматов в PointDTO
 *
 * @todo обновить общий шаблон и сообщить Виталию!
 */
class Parser
{
    /**
     * Преобразование строки координат в одном из распространенных форматов в PointDTO
     *
     * @param string $subject строка координат без указания формата
     * @return PointDTO
     * @throws WrongLatitudeException
     * @throws WrongLetterException
     * @throws WrongLongitudeException
     * @throws PatternNotFoundException
     */
    public function getPointDto(string $subject): PointDto
    {
        $matches = $this->getMatches($subject, $matches);
        $params = $this->cleanMatches($matches);
        $pattern = $this->getPattern($params, $subject);

        return $pattern->toPointDto();
    }

    /**
     * @param string $subject
     * @param $matches
     * @return mixed
     * @throws PatternNotFoundException
     */
    public function getMatches(string $subject, &$matches): mixed
    {
        $res = preg_match(PatternType::getUniversalRegex(), $subject, $matches, PREG_UNMATCHED_AS_NULL);

        return match ($res) {
            false => throw new RuntimeException("An error occurred while parsing '$subject': preg_match()"),
            0 => throw new PatternNotFoundException("Pattern for '$subject' not found"),
            default => $matches,
        };
    }

    /**
     * @param array $params
     * @param string $subject
     * @return AbstractPattern
     */
    private function getPattern(array $params, string $subject): AbstractPattern
    {
        $patternName = $this->getPatternName($params, $subject);

        return PatternType::getPattern($patternName, $params);
    }

    /**
     *
     * @param array $params
     * @param string $subject
     * @return string
     */
    private function getPatternName(array $params, string $subject): string
    {
        $matchingPatterns = array_intersect(PatternType::getPatternNames(), array_keys($params));

        if (count($matchingPatterns) > 1) {
            throw new RuntimeException("More than one pattern matched for '$subject': "
                . implode(', ', $matchingPatterns));

        } elseif (count($matchingPatterns) === 0) {
            dump($subject, $params);
            throw new RuntimeException("No pattern found matching '$subject'");
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