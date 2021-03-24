<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportsController;
use App\Http\Controllers\ReportsController;

Route::middleware(['auth'])->group(function () {
    Route::view('/', 'dashboard')->name('home');
    Route::post('import', ImportsController::class)->name('import.store');
    Route::delete('reports/transfer/{transfer}', [ReportsController::class, 'destroyTransfer'])->name('reports.transfer_destroy');
    Route::resource('reports', ReportsController::class)->only(['show', 'destroy']);
});


require __DIR__.'/auth.php';
