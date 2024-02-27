<?php

namespace App\Services;

use App\Enums\Labyrinth\Playfield;
use Illuminate\Support\Facades\Cache;
use JetBrains\PhpStorm\NoReturn;

class LabyrinthSolverService
{
    public function __construct(
        public array $playfield,
        public array $startCoordinates,
        public array $endCoordinates,
        public array $dimension
    )
    {
        $this->initScoreTable();
    }

    /**
     * get number pattern
     *
     * @return void
     */
    #[NoReturn] public function initScoreTable(): void
    {
        $yDimension = $this->dimension['y'];
        $xDimension = $this->dimension['x'];

        $pattern = [];
        for ($y = 0; $y < $yDimension; $y++) {
            $xPattern = [];

            for ($x = 0; $x < $xDimension; $x++) {
                $score = 0;

                if ($this->playfield[$y][$x] === Playfield::FILLED->value) {
                    $score = -10;
                }

                if ($this->startCoordinates['y'] === $y and $this->startCoordinates['x'] === $x) {
                    $score = 1;
                }

                $xPattern["$y" . "|" . "$x"] = $score;
            }

            $pattern[] = $xPattern;
        }

        Cache::forever('scores', $pattern);
    }


    public function findPossibleWays(int $y, int $x): array
    {
        if ($this->exists($y, $x) === false) {
            return [];
        }

    }

    public function exists(int $y, int $x): bool
    {
        return isset($this->playfield[$y][$x]);
    }
}
