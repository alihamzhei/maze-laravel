<?php

namespace App\Queries\Labyrinth;

use App\Models\User;

class ListLabyrinthQuery
{
    public function __construct(public User $user)
    {
    }

    public function execute()
    {
        return $this->user->labyrinths()->latest()->paginate();
    }
}
