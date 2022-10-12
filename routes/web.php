<?php

use App\Http\Controllers\EcoFarmController;
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


Route::get("/", "App\Http\Controllers\EcoFarmController@welcome");

Route::resource("tree", EcoFarmController::class);

Route::get("/tree/generates/all", "App\Http\Controllers\EcoFarmController@generateAll")->name( "generates");
Route::get("/tree/generate/{id}", "App\Http\Controllers\EcoFarmController@generate")->name("generate");

Route::get("/tree/export/all", "App\Http\Controllers\EcoFarmController@export")->name("export");
Route::post("/tree/import/all", "App\Http\Controllers\EcoFarmController@import")->name("import");
