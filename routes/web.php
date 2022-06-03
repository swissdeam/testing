<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::get('/test', function () {
    $testParam = "Облaко яндекс";
    return Str::slug($testParam);
});

Route::get('/{NumberOne}_{NumberTwo}_{Tool?}', function ($slug1, $slug2, $slugs = null) {


    $result = Cache::remember("{$slug1}_{$slug2}_{$slugs}", 10, function () use ($slug1, $slug2, $slugs) {

        switch ($slugs) {
            case "sub";
                return $slug1 - $slug2;
            case "mul";
                return $slug1 * $slug2;
            case "div";
                if ($slug2 === 0) {
                    abort(500, "cannot divide by zero");
                } else {
                    return $slug1 / $slug2;
                }
            default:
                return $slug1 + $slug2;

        }
    });

    $actions = [
        null => 'adding',
        'add' => 'adding',
        'sub' => 'subtracting',
        'div' => 'division',
        'mul' => 'multiplication'
    ];


    return view('/additional_assigment', [
        'result' => $result,
        'slug1' => $slug1,
        'slug2' => $slug2,
        'slugs' => $actions[$slugs]
    ]);
})->
whereNumber(['NumberOne', 'NumberTwo'])->whereAlpha('Tool');



