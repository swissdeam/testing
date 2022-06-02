<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{int1}+{int2}', function ($slug1, $slug2) {

    
    $summing_result = cache()->remember(".summing_result", 10, function() use ($slug1, $slug2){
        var_dump('calculated');
        return $slug1 + $slug2;
    });

    return view('/summing_result', [
        'summing_result' => $summing_result,
        'slug1' =>$slug1,
        'slug2' => $slug2
    ]);
});


Route::get('/{int3}_{int4}_{opt}', function ($slug3, $slug4, $slugx) {

    
    $result = cache()->remember(".summing_result", 10, function() use ($slug3, $slug4,$slugx){
        var_dump('calculated');
        switch ($slugx){
            case "add";
                return $slug3 + $slug4;
                $slugx = "adding";
                break;

            case "sub";
                return $slug3 - $slug4;
                $slugx = "subtracting";
                break;
            case "mul";
                return $slug3 * $slug4;
                $slugx = "multiplication";
                break;
            case "div";
                if ($slug4 == 0){
                abort("cannot divide by zero");
                } else return $slug3/$slug4;
                $slugx = "division";
                break;
        };
        
    });

    return view('/additional_assigment', [
        'result' => $result,
        'slug3' =>$slug3,
        'slug4' => $slug4,
        'slugx'=> $slugx
    ]);
});
