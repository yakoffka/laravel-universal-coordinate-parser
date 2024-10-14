<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Src\Dto;

/**
 * DTO для передачи данных о точках
 */
class PointDTO
{
    /**
     * @param float $lat - Широта точки в градусах
     * @param float $lon - Долгота точки в градусах
     * @param string $src - Исходная строка координат
     * @param string $pattern - Наименование паттерна, обнаружившего соответствие
     */
    public function __construct(
        public float $lat,
        public float $lon,
        public string $src,
        public string $pattern,
    )
    {
    }

    /**
     * Создание объекта с округлением координат до 6 знаков после запятой
     *
     * @param float $latDeg - Широта точки в градусах
     * @param float $lonDeg - Долгота точки в градусах
     * @param string $src - Исходная строка координат
     * @param string $pattern - Наименование паттерна, обнаружившего соответствие
     * @return PointDTO
     */
    public static function fromLatLon(float $latDeg, float $lonDeg, string $src, string $pattern): PointDTO
    {
        return new self(
            lat: round($latDeg, 6),
            lon: round($lonDeg, 6),
            src: $src,
            pattern: $pattern,
        );
    }
}
