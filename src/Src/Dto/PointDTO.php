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
     */
    public function __construct(
        public float $lat,
        public float $lon,
    )
    {
    }

    /**
     * Создание объекта с округлением координат до 6 знаков после запятой
     *
     * @param float $latDeg - Широта точки в градусах
     * @param float $lonDeg - Долгота точки в градусах
     * @return PointDTO
     */
    #[Pure] public static function fromLatLon(float $latDeg, float $lonDeg): PointDTO
    {
        return new self(
            lat: round($latDeg, 6),
            lon: round($lonDeg, 6),
        );
    }

    /**
     * @throws WrongLongitudeException
     */
    public static function checkLongitude(float $lonDeg): void
    {
        if ($lonDeg < -180 or $lonDeg > 180) {
            throw new WrongLongitudeException("$lonDeg");
        }
    }

    /**
     * @throws WrongLatitudeException
     */
    public static function checkLatitude(float $latDeg): void
    {
        if ($latDeg < -90 or $latDeg > 90) {
            throw new WrongLatitudeException("$latDeg");
        }
    }
}
