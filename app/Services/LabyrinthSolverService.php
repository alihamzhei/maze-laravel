<?php

namespace App\Services;

use App\Enums\Labyrinth\Playfield;
use Illuminate\Support\Facades\Cache;
use JetBrains\PhpStorm\NoReturn;

class LabyrinthSolverService
{
    public array $scores;
    public array $currentStare;

    public array $path;

    /**
     * @param array $playfield
     * @param array $startCoordinates
     * @param array $endCoordinates
     * @param array $dimension
     */
    #[NoReturn] public function __construct(
        public array $playfield,
        public array $startCoordinates,
        public array $endCoordinates,
        public array $dimension
    ) {
        $this->initScoreTable();

        $this->currentStare = [
            'y' => $this->startCoordinates['y'],
            'x' => $this->startCoordinates['x'],
        ];
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

        $scores = [];
        for ($y = 0; $y < $yDimension; $y++) {
            for ($x = 0; $x < $xDimension; $x++) {
                $scores[$y."_".$x] = [
                    'Right' => 0.0,
                    'Left' => 0.0,
                    'Top' => 0.0,
                    'Bottom' => 0.0,
                ];
            }
        }

        $this->scores = $scores;
    }

    #[NoReturn] public function next(): void
    {
        if ($this->isEndState($this->currentStare)) {
            return;
        }

        $possibleSteps = $this->findPossibleSteps(...$this->currentStare);

        $nextStep = $this->selectNextStep($possibleSteps);

        $this->updateScoreTable($this->currentStare, $nextStep['step'], $nextStep['location'], 0.05);

        $this->path[] = $nextStep['step'];

        $this->currentStare = $nextStep['location'];
    }

    /**
     * exists
     *
     * @return void
     */
    #[NoReturn] public function start(): void
    {
        for ($i = 0; $i <= 100000; $i++) {
            $this->next();
        };
    }

    public function updateScoreTable(array $currentState, string $selectedAction, array $nextState, float $reward): void
    {
        $currentState = "{$currentState['y']}_{$currentState['x']}";
        $nextState = "{$nextState['y']}_{$nextState['x']}";

        $currentQValue = $this->scores[$currentState][$selectedAction];

        $maxNextQValue = max($this->scores[$nextState]);

        $alpha = 0.1;
        $gamma = 0.9;
        $newQValue = (1 - $alpha) * $currentQValue + $alpha * ($reward + $gamma * $maxNextQValue);

        $this->scores[$currentState][$selectedAction] = $newQValue;
    }

    /**
     * @param array $possibleSteps
     * @return array
     */
    public function selectNextStep(array $possibleSteps): array
    {
        if (rand(0, 100) < 0.4 * 100) {
            return $possibleSteps[array_rand($possibleSteps)];
        }


        $maxIndex = null;
        $maxScore = PHP_INT_MIN;

        foreach ($possibleSteps as $index => $item) {
            if ($item["score"] > $maxScore) {
                $maxScore = $item["score"];
                $maxIndex = $index;
            }
        }

        return $possibleSteps[$maxIndex];
    }

    /**
     * find possible steps
     *
     * @param int $y
     * @param int $x
     * @return array
     */
    public function findPossibleSteps(int $y, int $x): array
    {
        if ($this->exists($y, $x) === false) {
            return [];
        }

        $possibleSteps = [];
        if ($this->exists($y, $x + 1)) {
            $possibleSteps[] = [
                'step' => 'Right',
                'score' => $this->scores[$y."_".$x + 1]['Right'],
                'location' => [
                    'y' => $y,
                    'x' => $x + 1,
                ],
            ];
        }

        if ($this->exists($y, $x - 1)) {
            $possibleSteps[] = [
                'step' => 'Left',
                'score' => $this->scores[$y."_".$x - 1]['Left'],
                'location' => [
                    'y' => $y,
                    'x' => $x - 1,
                ],
            ];
        }

        if ($this->exists($y - 1, $x)) {
            $possibleSteps[] = [
                'step' => 'Top',
                'score' => $this->scores[$y - 1 ."_".$x]['Top'],
                'location' => [
                    'y' => $y - 1,
                    'x' => $x,
                ],
            ];
        }

        if ($this->exists($y + 1, $x)) {
            $possibleSteps[] = [
                'step' => 'Bottom',
                'score' => $this->scores[$y + 1 ."_".$x]['Bottom'],
                'location' => [
                    'y' => $y + 1,
                    'x' => $x,
                ],
            ];
        }

        return $possibleSteps;
    }

    /**
     * @param array $step
     * @return bool
     */
    public function isEndState(array $step): bool
    {
        return $this->endCoordinates['y'] === $step['y'] && $this->endCoordinates['x'] === $step['x'];
    }

    /**
     * exists
     *
     * @param int $y
     * @param int $x
     * @return bool
     */
    public function exists(int $y, int $x): bool
    {
        return isset($this->playfield[$y][$x]) && $this->playfield[$y][$x] !== Playfield::FILLED->value;
    }


    /**
     * @return array
     */
    public function getPath(): array
    {
        return $this->path;
    }
}
