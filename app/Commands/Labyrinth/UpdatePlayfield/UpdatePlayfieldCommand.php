<?php

namespace App\Commands\Labyrinth\UpdatePlayfield;

use App\Contracts\Command;
use App\Models\Labyrinth;

class UpdatePlayfieldCommand implements Command
{
    public function __construct(
        public int       $y,
        public int       $x,
        public string    $type,
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

    public function getType(): string
    {
        return $this->type;
    }
}
