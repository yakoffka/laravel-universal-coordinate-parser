<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser;

use Yakoffka\UniversalCoordinateParser\Src\Dto\PointDTO;
use Illuminate\Support\Arr;
use RuntimeException;
use Yakoffka\UniversalCoordinateParser\Src\AbstractPattern;
use Yakoffka\UniversalCoordinateParser\Src\Patterns\Pattern01;
use Yakoffka\UniversalCoordinateParser\Src\Patterns\Pattern02;

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
    public const UNIVERSAL_REGEX = '~^('
    . '?<t01>(?<ltD01>\d{1,2}(?:(?:\.\d{1,6})|))°(?:(?<ltM01>\d{1,2}(?:(?:\.\d{1,6})|))′|)'
    . '(?:(?<ltSec01>\d{1,2}(?:(?:\.\d{1,6})|))″|)(?<ltL01>N|S)/(?<lnD01>\d{1,3}(?:(?:\.\d{1,6})|))°'
    . '(?:(?<lnM01>\d{1,2}(?:(?:\.\d{1,6})|))′|)(?:(?<lnSec01>\d{1,2}(?:(?:\.\d{1,6})|))″|)(?<lnL01>W|E))$'
    . '|^(?<t02>(?<ltD02>\d{1,2}(?:\.\d{1,6}|))(?<ltL02>N|S)/(?<lnD02>\d{1,3}(?:\.\d{1,6}|))(?<lnL02>W|E))$'
    . '|^(?<t03>(?<ltS03>-|)(?<ltD03>\d{1,2}(?:\.\d{1,6}|))(?:/|,|(?:, ))(?<lnS03>-|)(?<lnD03>\d{1,3}(?:\.\d{1,6}|)))$'
    . '|^(?<t05>(?<ltD05>\d{2})(?<ltM05>\d{2})(?<ltS05>\d{2})(?<ltL05>N|S)/(?<lnD05>\d{3})(?<lnM05>\d{2})'
    . '(?<lnS05>\d{2})(?<lnL05>W|E))$'
    . '|^(?<t06>(?<ltS06>-|)(?<ltD06>\d{2})(?<ltM06>\d{2})(?<ltSec06>\d{2})/(?<lnS06>-|)(?<lnD06>\d{3})'
    . '(?<lnM06>\d{2})(?<lnSec06>\d{2}))$'
    . '|^(?<t07>(?<ltD07>\d{2})(?<ltM07>\d{2}\.\d{2})(?<ltL07>S|N)/(?<lnD07>\d{3})(?<lnM07>\d{2}\.\d{2})(?<lnL07>W|E))$'
    . '|^(?<t08>(?<ltS08>-|)(?<ltD08>\d{2})(?<ltM08>\d{2}\.\d{2})/(?<lnS08>-|)(?<lnD08>\d{3})(?<lnM08>\d{2}\.\d{2}))$'
    . '|^(?<t09>(?<ltL09>N|S)(?<ltD09>\d{1,2}(?:(?:\.\d{1,6})|))/(?<lnL09>W|E)(?<lnD09>\d{1,3}(?:(?:\.\d{1,6})|)))$'
    . '|^(?<t10>(?<ltD10>\d{2})(?<ltM10>\d{2})(?<ltL10>N|S)(?<lnD10>\d{3})(?<lnM10>\d{2})(?<lnL10>W|E))$~';

    /**
     * Шаблон 01: значения в градусах, минутах и секундах с возможной дробной частью, разделителем в виде слеша,
     * буквенным обозначением и обозначением градусов, минут и секунд
     *
     * https://regex101.com/r/P4Pv8c/9
     */
    public const REGEX_01 = '~^(?<t01>'
    . '(?<ltD01>\d{1,2}(?:(?:\.\d{1,6})|))°(?:(?<ltM01>\d{1,2}(?:(?:\.\d{1,6})|))′|)'
    . '(?:(?<ltSec01>\d{1,2}(?:(?:\.\d{1,6})|))″|)(?<ltL01>N|S)/(?<lnD01>\d{1,3}(?:(?:\.\d{1,6})|))°'
    . '(?:(?<lnM01>\d{1,2}(?:(?:\.\d{1,6})|))′|)(?:(?<lnSec01>\d{1,2}(?:(?:\.\d{1,6})|))″|)(?<lnL01>W|E))$~';

    /**
     * Шаблон 02: значения в градусах с возможной дробной частью, разделителем в виде слеша и буквенным обозначением
     *
     * https://regex101.com/r/Zguahj/5
     */
    public const REGEX_02 = '~^(?<t02>(?<ltD02>\d{1,2}(?:\.\d{1,6}|))(?<ltL02>N|S)/(?<lnD02>\d{1,3}(?:\.\d{1,6}|))'
    . '(?<lnL02>W|E))$~';

    /**
     * Шаблон 03: DD.dd (with a minus) in ForeFlight (36.01/-75.50 equivalent 36.01°N/75.5°W)
     * значения в градусах с возможной дробной частью, разделителем в виде слеша, запятой или запятой с пробелом и без
     * буквенного обозначения
     *
     * https://regex101.com/r/D3AGHV/4
     */
    public const REGEX_03 = '~^(?<t03>(?<ltS03>-|)(?<ltD03>\d{1,2}(?:\.\d{1,6}|))(?:/|,|(?:, ))(?<lnS03>-|)'
    . '(?<lnD03>\d{1,3}(?:\.\d{1,6}|)))$~';

    /**
     * Шаблон 05: DD°MM′SS″ (with letters) in ForeFlight (360051N/0753004W equivalent 36°00′51″N/75°30′04″W)
     * жестко позиционированные значения в градусах, минутах и секундах без дробной части, разделителем в виде слеша,
     * буквенным обозначением без проверки значений
     *
     * https://regex101.com/r/UBFTg2/4
     */
    public const REGEX_05 = '~^(?<t05>(?<ltD05>\d{2})(?<ltM05>\d{2})(?<ltSec05>\d{2})(?<ltL05>N|S)/(?<lnD05>\d{3})'
    . '(?<lnM05>\d{2})(?<lnSec05>\d{2})(?<lnL05>W|E))$~';

    /**
     * Шаблон 06: DD°MM′SS″ (with a minus) in ForeFlight (360051/-0753004 equivalent 36°00′51″N/75°30′04″W)
     * жестко позиционированные значения в градусах, минутах и секундах без дробной части, разделителем в виде слеша,
     * без буквенного обозначения
     *
     * https://regex101.com/r/4Z8Ttn/5
     */
    public const REGEX_06 = '~^(?<t06>(?<ltS06>-|)(?<ltD06>\d{2})(?<ltM06>\d{2})(?<ltSec06>\d{2})/(?<lnS06>-|)'
    . '(?<lnD06>\d{3})(?<lnM06>\d{2})(?<lnSec06>\d{2}))$~';

    /**
     * Шаблон 07: DD°MM.mm (with letters) in ForeFlight (3600.86N/07530.07W equivalent 36°00.86′N/75°30.07′W)
     * жестко позиционированные значения в градусах и минутах с дробной частью, разделителем в виде слеша, буквенным
     * обозначением
     *
     * https://regex101.com/r/RtNxVp/4
     */
    public const REGEX_07 = '~^(?<t07>(?<ltD07>\d{2})(?<ltM07>\d{2}\.\d{2})(?<ltL07>S|N)/(?<lnD07>\d{3})'
    . '(?<lnM07>\d{2}\.\d{2})(?<lnL07>W|E))$~';

    /**
     * Шаблон 08: DD°MM.mm (with a minus) in ForeFlight (3600.86/-07530.07 equivalent 36°00.86′N/75°30.07′W)
     * жестко позиционированные значения в градусах и минутах с дробной частью, разделителем в виде слеша, без
     * буквенного обозначения
     *
     * https://regex101.com/r/o4H23D/3
     */
    public const REGEX_08 = '~^(?<t08>(?<ltS08>-|)(?<ltD08>\d{2})(?<ltM08>\d{2}\.\d{2})/(?<lnS08>-|)'
    . '(?<lnD08>\d{3})(?<lnM08>\d{2}\.\d{2}))$~';

    /**
     * Шаблон 09: yandex (N55.00136/E057.19818 equivalent 55.00136°N/057.19818°E)
     * значения в градусах с возможной дробной частью, разделителем в виде слеша, а буквенное обозначение расположено
     * перед значением
     *
     * https://regex101.com/r/EPBroQ/3
     */
    public const REGEX_09 = '~^(?<t09>(?<ltL09>N|S)(?<ltD09>\d{1,2}(?:(?:\.\d{1,6})|))/(?<lnL09>W|E)'
    . '(?<lnD09>\d{1,3}(?:(?:\.\d{1,6})|)))$~';

    /**
     * Шаблон 10: ТС-2013 число представлено в жестком формате GGMMSGGGMMS
     *
     * https://regex101.com/r/AE6g5S/3
     */
    public const REGEX_10 = '~^(?<t10>(?<ltD10>\d{2})(?<ltM10>\d{2})(?<ltL10>N|S)(?<lnD10>\d{3})(?<lnM10>\d{2})'
    . '(?<lnL10>W|E))$~';

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
     */
    public function getPointDto(string $subject): PointDto
    {
        $matches = $this->getMatches($subject, $matches);
        $params = $this->cleanMatches($matches);
        // dd($params);
        $pattern = $this->getPattern($params, $subject);

        return $pattern->toPointDto();
    }
//
//    /**
//     * Разбор строки координат на основе универсального шаблона #1
//     *
//     * @param string $subject строка координат без указания формата
//     * @return PointDTO
//     */
//    public static function parseByO1(string $subject): PointDto
//    {
//        $res = preg_match(self::REGEX_01, $subject, $matches);
//
//        if ($res !== false) {
//            dd($matches);
//        } else {
//            dd($res);
//        }
//
//        return new PointDTO(0, 0);
//    }
//
//    /**
//     * Разбор строки координат на основе универсального шаблона #2
//     *
//     * @param string $subject строка координат без указания формата
//     * @return PointDTO
//     */
//    public static function parseByO2(string $subject): PointDto
//    {
//        $res = preg_match(self::REGEX_02, $subject, $matches);
//
//        if ($res !== false) {
//            dd($matches);
//        } else {
//            dd($res);
//        }
//
//        return new PointDTO(0, 0);
//    }

    /**
     * @param string $subject
     * @param $matches
     * @return mixed
     */
    public function getMatches(string $subject, &$matches): mixed
    {
        $res = preg_match(self::UNIVERSAL_REGEX, $subject, $matches, PREG_UNMATCHED_AS_NULL);
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
            // 't03' => '', // Pattern03::from($params),
            // // 't04' => '', // Pattern04::from($params),
            // 't05' => '', // Pattern05::from($params),
            // 't06' => '', // Pattern06::from($params),
            // 't07' => '', // Pattern07::from($params),
            // 't08' => '', // Pattern08::from($params),
            // 't09' => '', // Pattern09::from($params),
            // 't10' => '', // Pattern10::from($params),
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
        // dd($matchingPatterns);

        if (count($matchingPatterns) !== 1) {
            throw new RuntimeException("Найдено совпадение с более, чем одним шаблоном для '$subject': "
                . implode(', ', $matchingPatterns));

        } elseif (count($matchingPatterns) === 0) {
            throw new RuntimeException("Не найдено совпадений ни с одним одним шаблоном для '$subject'");
        }

        //dd($matchingPatterns);
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