<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

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

Route::get('/{NumberOne}_{NumberTwo}_{Tool?}', function ($slug1, $slug2,$slugx=null) {


   
    
    $result = Cache::remember("{$slug1}_{$slug2}_{$slugx}", 10 ,function () use ($slug1, $slug2, $slugx)
    {
        var_dump('calculated');

         switch ($slugx){

            case "add";
            case null;
                return $slug1 + $slug2;    
                break;

            case "sub";
                return $slug1 - $slug2;
                break;

            case "mul";
                return $slug1 * $slug2;
                break;

            case "div";
                if ($slug2 == 0){
                   abort(500, "cannot divide by zero");
                } else return $slug1/$slug2;
                break;
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
        'slugx'=> $actions[$slugx]
    ]);
})->whereNumber(['NumberOne','NumberTwo'])->whereAlpha('Tool');



