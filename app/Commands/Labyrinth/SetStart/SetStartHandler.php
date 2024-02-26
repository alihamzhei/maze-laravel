<?php

namespace App\Commands\Labyrinth\SetStart;

use App\Commands\Labyrinth\Store\StoreLabyrinthCommand;
use App\Enums\Labyrinth\Playfield;
use App\Models\Labyrinth;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class SetStartHandler
{
    public function handler(SetStartCommand $command): Labyrinth
    {
        $playfield = $command->labyrinth->playfield;

        $startTarget = $playfield[$command->getY()][$command->getX()];

        if ($startTarget === Playfield::FILLED->value) {
            throw new BadRequestException('the cell has filled before, you cannot target filled cell');
        }

        $command->labyrinth->start_coordinates = [
            'x' => $command->getX(),
            'y' => $command->getY()
        ];

        $command->labyrinth->save();

        return $command->labyrinth;
    }
}
