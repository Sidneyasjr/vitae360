<?php

use App\Http\Controllers\Settings\PermissionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/settings/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/settings/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/settings/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/settings/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('/settings/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/settings/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
});
