<?php

namespace App\Commands\Labyrinth\SetStart;

use App\Contracts\Command;
use App\Models\Labyrinth;

class SetStartCommand implements Command
{
    public function __construct(
        public int       $y,
        public int       $x,
        public Labyrinth $labyrinth
    )
    {
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getLabyrinth(): Labyrinth
    {
        return $this->labyrinth;
    }
}
