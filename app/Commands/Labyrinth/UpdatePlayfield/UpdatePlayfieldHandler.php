<?php

namespace App\Commands\Labyrinth\UpdatePlayfield;

use App\Commands\Labyrinth\Store\StoreLabyrinthCommand;
use App\Enums\Labyrinth\Playfield;
use App\Models\Labyrinth;

class UpdatePlayfieldHandler
{
    public function handler(UpdatePlayfieldCommand $command): Labyrinth
    {
        $playfield = $command->labyrinth->playfield;

        $playfield[$command->getY()][$command->getX()] = $command->getType();

        $command->labyrinth->playfield = $playfield;
        $command->labyrinth->save();

        return $command->labyrinth;
    }
}
