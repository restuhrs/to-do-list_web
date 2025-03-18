<?php

use App\Http\Controllers\TugasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/todolist', [TugasController::class, 'index'])->name('tugas.index');
Route::get('/todolist/data', [TugasController::class, 'data'])->name('tugas.data');
Route::post('/todolist', [TugasController::class, 'store'])->name('tugas.store');
Route::put('/todolist/status/{id_tugas}', [TugasController::class, 'updateStatus'])->name('tugas.updateStatus');
Route::delete('/todolist/{id_tugas}', [TugasController::class, 'destroy'])->name('tugas.delete');
