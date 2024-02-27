<?php

namespace App\Services;

class LabyrinthSolverService
{
    public function __construct(
        public array $playfield,
        public array $startCoordinates,
        public array $endCoordinates,
        public array $dimension
    )
    {
    }

    /**
     * get number pattern
     *
     * @return array
     */
    public function getNumberPattern(): array
    {
        $yDimension = $this->dimension['y'];
        $xDimension = $this->dimension['x'];

        $pattern = [];
        for ($y = 0; $y < $yDimension; $y++) {
            $xPattern = [];
            for ($x = 0; $x < $xDimension; $x++) {
                $xPattern[] = "$y" . "|" . "$x";
            }

            $pattern[] = $xPattern;
        }

        return $pattern;
    }

    public function findPossibleWays(int $y, int $x): array
    {
        if ($this->exists($y, $x) === false) {
            return [];
        }

        $ways = [];

//        $rightPath = ;

//        dd($rightPath);
    }

    public function exists(int $y, int $x): bool
    {
        return isset($this->playfield[$y][$x]);
    }
}
