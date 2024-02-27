<?php

namespace App\Commands\Labyrinth\SetEnd;

use App\Enums\Labyrinth\Playfield;
use App\Models\Labyrinth;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class SetEndHandler
{
    /**
     * handler
     *
     * @param SetEndCommand $command
     * @return Labyrinth
     */
    public function handler(SetEndCommand $command): Labyrinth
    {
        $playfield = $command->labyrinth->playfield;

        $startTarget = $playfield[$command->getY()][$command->getX()];

        $endCoordinates = [
            'x' => $command->getX(),
            'y' => $command->getY()
        ];

        if ($startTarget === Playfield::FILLED->value) {
            throw new BadRequestException('the cell has been filled before, you cannot target filled cell');
        }

        if ($endCoordinates === $command->labyrinth->start_coordinates) {
            throw new BadRequestException('this cell has been filled as a start cell , Try another');
        }

        $command->labyrinth->end_coordinates = $endCoordinates;
        $command->labyrinth->save();

        return $command->labyrinth;
    }
}
