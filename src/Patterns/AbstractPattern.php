<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Patterns;

use Yakoffka\UniversalCoordinateParser\Dto\PointDTO;
use Yakoffka\UniversalCoordinateParser\Exceptions\WrongLatitudeException;
use Yakoffka\UniversalCoordinateParser\Exceptions\WrongLetterException;
use Yakoffka\UniversalCoordinateParser\Exceptions\WrongLongitudeException;

abstract class AbstractPattern
{
    private const MINUTES_IN_DEGREES = 60;
    private const SECONDS_IN_DEGREES = 3600;

    /**
     * @param array $params
     * @return static
     */
    abstract public static function from(array $params): static;

    /**
     * @return PointDTO
     * @throws WrongLatitudeException
     * @throws WrongLetterException
     * @throws WrongLongitudeException
     */
    public function toPointDto(): PointDTO
    {
        return PointDTO::fromLatLon($this->getLat(), $this->getLon(), $this->src, $this->name);
    }

    /**
     * @return float
     * @throws WrongLatitudeException
     * @throws WrongLetterException
     */
    protected function getLat(): float
    {
        $lat = $this->getMultiplier($this->ltSign ?? $this->ltLetter) * (
                $this->ltDegrees
                + $this->ltMinutes / self::MINUTES_IN_DEGREES
                + $this->ltSeconds / self::SECONDS_IN_DEGREES
            );

        if ($lat < -90 or $lat > 90) {
            throw new WrongLatitudeException("$lat");
        }

        return $lat;
    }

    /**
     * @return float
     * @throws WrongLetterException
     * @throws WrongLongitudeException
     */
    protected function getLon(): float
    {
        $lon = $this->getMultiplier($this->lnSign ?? $this->lnLetter) * (
                $this->lnDegrees
                + $this->lnMinutes / 60
                + $this->lnSeconds / 3600
            );

        if ($lon < -180 or $lon > 180) {
            throw new WrongLongitudeException("$lon");
        }

        return $lon;
    }

    /**
     * @param $letter
     * @return int
     * @throws WrongLetterException
     */
    protected function getMultiplier($letter): int
    {
        return match ($letter) {
            'E', 'N', '' => 1,
            'W', 'S', '-' => -1,
            default => throw new WrongLetterException("Неверное обозначение координаты '$letter'"),
        };
    }
}
