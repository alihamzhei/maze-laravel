<?php

namespace App\Http\Controllers;

use App\Commands\CommandBus;
use App\Commands\Labyrinth\SetEnd\SetEndCommand;
use App\Commands\Labyrinth\SetStart\SetStartCommand;
use App\Commands\Labyrinth\Store\StoreLabyrinthCommand;
use App\Commands\Labyrinth\UpdatePlayfield\UpdatePlayfieldCommand;
use App\Facades\Response;
use App\Http\Requests\DimensionRequest;
use App\Http\Requests\UpdatePlayfieldRequest as PlayfieldRequest;
use App\Models\Labyrinth;
use App\Queries\Labyrinth\ListLabyrinthQuery;
use App\Queries\Labyrinth\SolutionLabyrinthQuery;
use App\Services\LabyrinthSolverService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class LabyrinthController extends Controller
{
    /**
     * @param CommandBus $commandBus
     */
    public function __construct(
        public CommandBus $commandBus,
    ) {
    }

    /**
     * @return JsonResponse
     */
    public function store(): JsonResponse
    {
        $labyrinth = $this->commandBus->dispatch(new StoreLabyrinthCommand(auth()->user()));

        return Response::message('labyrinth has been created successfully')
            ->data($labyrinth)
            ->send(SymfonyResponse::HTTP_CREATED);
    }

    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $listQuery = new ListLabyrinthQuery(auth()->user());

        return Response::message('labyrinths has been listed successfully')
            ->data($listQuery->execute())
            ->send(SymfonyResponse::HTTP_CREATED);
    }

    /**
     * show
     *
     * @param Labyrinth $labyrinth
     * @return JsonResponse
     */
    public function show(Labyrinth $labyrinth): JsonResponse
    {
        return Response::message('labyrinth has been found successfully')
            ->data($labyrinth)
            ->send();
    }

    /**
     * update play field
     *
     * @param Labyrinth $labyrinth
     * @param int $x
     * @param int $y
     * @param string $type
     * @param PlayfieldRequest $request
     * @return JsonResponse
     */
    public function updatePlayfield(
        Labyrinth $labyrinth,
        int $x,
        int $y,
        string $type,
        PlayfieldRequest $request
    ): JsonResponse {
        $labyrinth = $this->commandBus->dispatch(new UpdatePlayfieldCommand($y, $x, $type, $labyrinth));

        return Response::message('labyrinth playfield has been updated successfully')
            ->data($labyrinth)
            ->send();
    }

    /**
     * set start
     *
     * @param Labyrinth $labyrinth
     * @param int $x
     * @param int $y
     * @param DimensionRequest $request
     * @return JsonResponse
     */
    public function setStart(Labyrinth $labyrinth, int $x, int $y, DimensionRequest $request): JsonResponse
    {
        $labyrinth = $this->commandBus->dispatch(new SetStartCommand($y, $x, $labyrinth));

        return Response::message('labyrinth start has been updated successfully')
            ->data($labyrinth)
            ->send();
    }

    /**
     * set end
     *
     * @param Labyrinth $labyrinth
     * @param int $x
     * @param int $y
     * @return JsonResponse
     */
    public function setEnd(Labyrinth $labyrinth, int $x, int $y): JsonResponse
    {
        $labyrinth = $this->commandBus->dispatch(new SetEndCommand($y, $x, $labyrinth));

        return Response::message('labyrinth end has been updated successfully')
            ->data($labyrinth)
            ->send();
    }

    /**
     * solution
     *
     * @param Labyrinth $labyrinth
     * @return JsonResponse
     */
    public function solution(Labyrinth $labyrinth): JsonResponse
    {
        $solutionQuery = new SolutionLabyrinthQuery($labyrinth);

        return Response::message('labyrinth end has been solved successfully')
            ->data($solutionQuery->execute())
            ->send();
    }
}
