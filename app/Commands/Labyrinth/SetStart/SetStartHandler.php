<?php

namespace App\Commands\Labyrinth\SetStart;

use App\Commands\Labyrinth\Store\StoreLabyrinthCommand;
use App\Enums\Labyrinth\Playfield;
use App\Models\Labyrinth;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class SetStartHandler
{
    /**
     * handler
     *
     * @param SetStartCommand $command
     * @return Labyrinth
     */
    public function handler(SetStartCommand $command): Labyrinth
    {
        $playfield = $command->labyrinth->playfield;

        $startTarget = $playfield[$command->getY()][$command->getX()];

        $startCoordinates = [
            'x' => $command->getX(),
            'y' => $command->getY()
        ];

        if ($startTarget === Playfield::FILLED->value) {
            throw new BadRequestException('the cell has filled before, you cannot target filled cell');
        }

        if ($startCoordinates === $command->labyrinth->end_coordinates) {
            throw new BadRequestException('this cell has been filled as a end cell , Try another');
        }

        $command->labyrinth->start_coordinates = $startCoordinates;
        $command->labyrinth->save();

        return $command->labyrinth;
    }
}
