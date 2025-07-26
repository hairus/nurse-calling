<?php

use App\Http\Controllers\NurseController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('nurse');
});

Route::get('/report', function () {
    return view('report');
});

// ruangan 1
Route::get('/infus/{ruang}/{bed}', [NurseController::class, 'infus']);
Route::get('/perawat/{ruang}/{bed}', [NurseController::class, 'perawat']);
Route::get('/emergency/{raung}/0', [NurseController::class, 'emergency']);
Route::get('/cancel/{ruang}/0', [NurseController::class, 'cancel']);


Route::get('/counting', [NurseController::class, 'counting']);
// Route::post('/send', [NurseController::class, 'send']);
