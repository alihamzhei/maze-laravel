<?php

namespace App\Commands;

use App\Contracts\Command;
use Illuminate\Support\Facades\App;
use ReflectionClass;

class CommandBus
{
    public function dispatch(Command $command): mixed
    {
        $reflection = new ReflectionClass($command);
        $handlerName = str_replace("Command", "Handler", $reflection->getShortName());
        $handlerName = str_replace($reflection->getShortName(), $handlerName, $reflection->getName());
        $handler = App::make($handlerName);

        return $handler->handler($command);
    }
}
