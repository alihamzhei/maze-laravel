<?php

namespace App\Commands\Labyrinth\SetEnd;

use App\Enums\Labyrinth\Playfield;
use App\Models\Labyrinth;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class SetEndHandler
{
    public function handler(SetEndCommand $command): Labyrinth
    {
        $playfield = $command->labyrinth->playfield;

        $startTarget = $playfield[$command->getY()][$command->getX()];

        if ($startTarget === Playfield::FILLED->value) {
            throw new BadRequestException('the cell has been filled before, you cannot target filled cell');
        }

        $command->labyrinth->end_coordinates = [
            'x' => $command->getX(),
            'y' => $command->getY()
        ];

        $command->labyrinth->save();

        return $command->labyrinth;
    }
}
