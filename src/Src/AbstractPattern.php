<?php
declare(strict_types=1);

namespace Yakoffka\UniversalCoordinateParser\Src;

use Yakoffka\UniversalCoordinateParser\Src\Dto\PointDTO;

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
     */
    public function toPointDto(): PointDTO
    {
        return PointDTO::fromLatLon($this->getLat(), $this->getLon());
    }

    /**
     * @return float
     */
    protected function getLat(): float
    {
        // @todo реализовать!
        return 0.0;
    }

    /**
     * @return float
     */
    protected function getLon(): float
    {
        // @todo реализовать!
        return 0.0;
    }
}
