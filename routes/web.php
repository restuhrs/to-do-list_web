<?php

use App\Http\Controllers\TugasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/todolist', [TugasController::class, 'index'])->name('tugas.index');
Route::get('/data', [TugasController::class, 'data'])->name('tugas.data');
Route::post('/todolist', [TugasController::class, 'store'])->name('tugas.store');
Route::put('/todoliststatus/{id_tugas}', [TugasController::class, 'updateStatus'])->name('tugas.updateStatus');
