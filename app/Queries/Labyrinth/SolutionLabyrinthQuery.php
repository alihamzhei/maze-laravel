<?php

namespace App\Queries\Labyrinth;

use App\Models\Labyrinth;
use App\Services\LabyrinthSolverService;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class SolutionLabyrinthQuery
{
    public function __construct(public Labyrinth $labyrinth)
    {
    }

    public function execute()
    {
        if ($this->labyrinth->start_coordinates === null){
            throw new BadRequestException('start coordinates should be determined');
        }

        if ($this->labyrinth->end_coordinates === null){
            throw new BadRequestException('end coordinates should be determined');
        }

        $labService = new LabyrinthSolverService(
            $this->labyrinth->playfield,
            $this->labyrinth->start_coordinates,
            $this->labyrinth->end_coordinates,
            $this->labyrinth->dimension
        );

        $labService->start();

        return $labService->getPath();
    }
}
