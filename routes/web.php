<?php

use App\Services\LabyrinthSolverService;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {

    $array = [
        ["F", "E", "E", "F", "D", "E", "E"],
        ["S", "F", "E", "E", "F", "E", "E"],
        ["E", "E", "E", "E", "E", "F", "E"],
        ["E", "F", "E", "F", "E", "E", "E"]
    ];

    $arrayByNumber = [
        // [y . x]
        [00, 01, 02, 03, 04, 05, 06],
        [10, 11, 12, 13, 14, 15, 16],
        [20, 21, 22, 23, 24, 25, 26],
        [30, 31, 32, 33, 34, 35, 36],
    ];

    //       top

    // left   S   right

    //      bottom

    // S  +  1  = right
    // S  +  10 = bottom
    // S  -  10 = top
    // S  -  1  = left

    $startCoordinates = [
        'y' => 0,
        'x' => 4,
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

//    $labService->findPossibleWays(2, 1);
    dd($labService->initScoreTable());
});
