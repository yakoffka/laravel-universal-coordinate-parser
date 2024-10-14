<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Src;

use Yakoffka\UniversalCoordinateParser\Src\Dto\PointDTO;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\WrongLatitudeException;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\WrongLetterException;
use Yakoffka\UniversalCoordinateParser\Src\Exceptions\WrongLongitudeException;

abstract class AbstractPattern
{
    /**
     * @param array $params
     * @return static
     */
    abstract public static function from(array $params): static;

    /**
     * @param string $src
     * @return PointDTO
     */
    abstract public function parse(string $src): PointDTO;

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
        $lat = ($this->ltSign ?? $this->getMultiplier($this->ltLetter)) * (
                $this->ltDegrees
                + $this->ltMinutes / 60
                + $this->ltSeconds / 3600
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
        $lon = ($this->lnSign ?? $this->getMultiplier($this->lnLetter)) * (
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
            'E', 'N' => 1,
            'W', 'S' => -1,
            default => throw new WrongLetterException("Неверное обозначение координаты '$letter'"),
        };
    }
}
