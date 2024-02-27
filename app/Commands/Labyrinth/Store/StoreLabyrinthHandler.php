<?php

namespace App\Commands\Labyrinth\Store;

use App\Enums\Labyrinth\Playfield;
use App\Models\Labyrinth;

class StoreLabyrinthHandler
{
    public function handler(StoreLabyrinthCommand $command)
    {
        return Labyrinth::create([
            'user_id' => $command->getUser()->id,
            'playfield' => $this->fillDefaultPlayfield(),
            'dimension' => [
                'y' => config('app.labyrinth_y'),
                'x' => config('app.labyrinth_x')
            ]
        ]);
    }

    public function fillDefaultPlayfield(): array
    {
        return array_fill(
            0,
            config('app.labyrinth_y'),
            array_fill(0, config('app.labyrinth_x'), Playfield::EMPTY->value)
        );
    }
}
