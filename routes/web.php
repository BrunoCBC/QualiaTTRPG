<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RpgController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\DiceController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserFavoriteController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\SheetTypeController;
use App\Http\Controllers\FavoriteController;

Route::get('/', [HomeController::class, 'index'])->name('home');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/user/{username?}', [ProfileController::class, 'show'])->name('user.profile');
    Route::get('/user/{username}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/user/{username}', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/rpg/create', [RpgController::class, 'create'])->name('rpg.create');
    Route::post('/rpg/store', [RpgController::class, 'store'])->name('rpg.store');
    Route::get('/rpg/{rpg_hash}', [RpgController::class, 'show'])->name('rpg.show');
    Route::get('/rpg/{rpg_hash}/edit', [RpgController::class, 'edit'])->name('rpg.edit');
    Route::put('/rpg/{rpg_hash}', [RpgController::class, 'update'])->name('rpg.update');
    Route::delete('/rpg/{rpg_hash}', [RpgController::class, 'destroy'])->name('rpg.destroy');

    Route::get('/rpg/{rpg_hash}/roll', [DiceController::class, 'index'])->name('dices.index');
    Route::post('/rpg/{rpg_hash}/roll', [DiceController::class, 'roll'])->name('dices.roll');

    Route::get('/rpg/{rpg_hash}/attributes', [AttributeController::class, 'index'])->name('rpg.attributes.index');
    Route::post('/rpg/{rpg_hash}/attributes', [AttributeController::class, 'store'])->name('rpg.attributes.store');
    Route::delete('/rpg/{rpg_hash}/attributes/{attribute}', [AttributeController::class, 'destroy'])->name('rpg.attributes.destroy');
    Route::post('/rpg/sheet/adjust-attribute-points', [SheetController::class, 'adjustAttributePoints'])->name('attribute.adjustPoints');

    Route::get('/rpg/{rpg_hash}/levels', [LevelController::class, 'index'])->name('rpg.levels.index');
    Route::post('/rpg/{rpg_hash}/levels', [LevelController::class, 'store'])->name('rpg.levels.store');
    Route::delete('/rpg/{rpg_hash}/levels/{level}', [LevelController::class, 'destroy'])->name('rpg.levels.destroy');

    Route::get('/rpg/{rpg_hash}/folders/{folder_hash?}', [FolderController::class, 'index'])->name('folders.index');
    Route::post('/rpg/{rpg_hash}/folders/{folder_hash?}', [FolderController::class, 'store'])->name('folders.store');
    Route::get('/rpg/{rpg_hash}/folders/{folder_hash}/edit', [FolderController::class, 'edit'])->name('folders.edit');
    Route::put('/rpg/{rpg_hash}/folders/{folder_hash}', [FolderController::class, 'update'])->name('folders.update');
    Route::delete('/rpg/{rpg_hash}/folders/{folder_hash}', [FolderController::class, 'destroy'])->name('folders.destroy');

    Route::get('/rpg/{rpg_hash}/folders/{folder_hash}/files', [FileController::class, 'index'])->name('files.index');
    Route::post('/rpg/{rpg_hash}/folders/{folder_hash}/files', [FileController::class, 'store'])->name('files.store');
    Route::get('/rpg/{rpg_hash}/folders/{folder_hash}/files/{file_hash}', [FileController::class, 'show'])->name('files.show');
    Route::get('/rpg/{rpg_hash}/folders/{folder_hash}/files/{file_hash}/edit', [FileController::class, 'edit'])->name('files.edit');
    Route::put('/rpg/{rpg_hash}/folders/{folder_hash}/files/{file_hash}', [FileController::class, 'update'])->name('files.update');
    Route::delete('/rpg/{rpg_hash}/folders/{folder_hash}/files/{file_hash}', [FileController::class, 'destroy'])->name('files.destroy');
    Route::get('/rpg/{rpg_hash}/folders/{folder_hash}/files/{file_hash}/download', [FileController::class, 'download'])->name('files.download');

    Route::get('/rpg/{rpg_hash}/folders/{folder_hash}/sheets', [SheetController::class, 'index'])->name('sheets.index');
    Route::get('/rpg/{rpg_hash}/folders/{folder_hash}/sheets/create', [SheetController::class, 'create'])->name('sheets.create');
    Route::get('/rpg/{rpg_hash}/folders/{folder_hash}/sheets/{sheet_hash}', [SheetController::class, 'show'])->name('sheets.show');
    Route::get('/rpg/{rpg_hash}/folders/{folder_hash}/sheets/{sheet_hash}/edit', [SheetController::class, 'edit'])->name('sheets.edit');
    Route::post('/rpg/{rpg_hash}/folders/{folder_hash}/sheets', [SheetController::class, 'store'])->name('sheets.store');
    Route::put('/rpg/{rpg_hash}/folders/{folder_hash}/sheets/{sheet_hash}', [SheetController::class, 'update'])->name('sheets.update');
    Route::delete('/rpg/{rpg_hash}/folders/{folder_hash}/sheets/{sheet_hash}', [SheetController::class, 'destroy'])->name('sheets.destroy');

    Route::get('/rpg/{rpg_hash}/sheettypes', [SheetTypeController::class, 'index'])->name('sheettypes.index');
    Route::get('/rpg/{rpg_hash}/sheettypes/create', [SheetTypeController::class, 'create'])->name('sheettypes.create');
    Route::post('/rpg/{rpg_hash}/sheettypes', [SheetTypeController::class, 'store'])->name('sheettypes.store');
    Route::get('/rpg/{rpg_hash}/sheettypes/{sheettype_hash}/edit', [SheetTypeController::class, 'edit'])->name('sheettypes.edit');
    Route::put('/rpg/{rpg_hash}/sheettypes/{sheettype_hash}', [SheetTypeController::class, 'update'])->name('sheettypes.update');
    Route::delete('/rpg/{rpg_hash}/sheettypes/{sheettype_hash}', [SheetTypeController::class, 'destroy'])->name('sheettypes.destroy');

    Route::get('/rpg/{rpg_hash}/folders/{folder_hash}/create', [FolderController::class, 'create'])->name('folders.create');
    Route::get('/rpg/{rpg_hash}/folders/{folder_hash}/files/create', [FileController::class, 'create'])->name('files.create');
    Route::get('/rpg/{rpg_hash}/folders/{folder_hash}/sheets/create', [SheetController::class, 'create'])->name('sheets.create');
});
