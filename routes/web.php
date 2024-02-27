<?php

use App\Services\LabyrinthSolverService;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {

    $array = [
        ["F", "E", "E", "F", "E", "E", "E"],
        ["E", "F", "E", "E", "F", "E", "E"],
        ["E", "E", "E", "E", "E", "F", "E"],
        ["E", "F", "E", "F", "E", "E", "E"]
    ];

    $arrayByNumber = [
        // [y . x]
        [0.0, 0.1, 0.2, 0.3, 0.4, 0.5, 0.6],
        [1.0, 1.1, 1.2, 1.3, 1.4, 1.5, 1.6],
        [2.0, 2.1, 2.2, 2.3, 2.4, 2.5, 2.6],
        [3.0, 3.1, 3.2, 3.3, 3.4, 3.5, 3.6],
    ];

    //       top

    // left   S   right

    //      bottom

    // S  +  1  = right
    // S  +  10 = bottom
    // S  -  10 = top
    // S  -  1  = left

    $startCoordinates = [
        'y' => 1,
        'x' => 0,
    ];

    $endCoordinates = [
        'y' => 0,
        'x' => 4,
    ];

    $labService = new LabyrinthSolverService($array, $startCoordinates, $endCoordinates, [
        'y' => config('app.labyrinth_y'),
        'x' => config('app.labyrinth_x')
    ]);

//    $b = explode('.', 20.10);
//
////    dd((int)$b[1]);
//    dd($b);

    $labService->findPossibleWays(2, 1);
    dd($labService->getNumberPattern());
});
