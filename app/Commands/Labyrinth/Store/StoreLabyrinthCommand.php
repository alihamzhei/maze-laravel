<?php

namespace App\Commands\Labyrinth\Store;

use App\Contracts\Command;
use App\Models\User;

class StoreLabyrinthCommand implements Command
{
    public function __construct(public User $user)
    {

    }

    public function getUser(): User
    {
        return $this->user;
    }
}
