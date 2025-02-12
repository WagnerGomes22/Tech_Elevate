<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventsController;
use Illuminate\Http\Request;

Route::get('/', [EventsController::class, 'index']);
Route::get('/events/create', [EventsController::class, 'create'])->middleware("auth");
Route::post('/events', [EventsController::class, 'store'])->name('events.store');
Route::get('/event/{id}', [EventsController::class, 'show'])->name('event.show');;
Route::get('/buscar', [EventsController::class, 'index'])->name('buscar');
Route::delete('/delete/{id}',[EventsController::class,'destroy'])->middleware('auth');
Route::get('/events/edit/{id}',[EventsController::class,'edit'])->middleware('auth')->name('events.edit');
Route::put('/events/update/{id}', [EventsController::class, 'update'])->middleware('auth')->name('events.update');

Route::get('/contato', function () {
    return view('contato');
});




Route::post('/events/join/{id}', [EventsController::class, 'joinEvent'])->middleware('auth');

// Nova rota para sair do evento
Route::delete('/events/leave/{id}', [EventsController::class, 'leaveEvent'])->middleware('auth')->name('events.leave');

Route::get('dashboard', [EventsController::class, 'dashboard'])->middleware('auth')->name('events.dashboard');