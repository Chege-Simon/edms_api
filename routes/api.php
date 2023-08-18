<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocFieldController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// folder endpoints
Route::get('folders',[FolderController::class, 'index'])->name('folders');
Route::get('folders/{id}',[FolderController::class, 'show'])->name('folders.show');
Route::post('folders',[FolderController::class, 'store'])->name('folders.store');
Route::post('folders/{id}',[FolderController::class, 'update'])->name('folders.update');
Route::get('folders/{id}/delete',[FolderController::class, 'destroy'])->name('folders.destroy');


// fields endpoints
Route::get('fields',[FieldController::class, 'index'])->name('fields');
Route::get('fields/{id}',[FieldController::class, 'show'])->name('fields.show');
Route::post('fields',[FieldController::class, 'store'])->name('fields.store');
Route::post('fields/{id}',[FieldController::class, 'update'])->name('fields.update');
Route::get('fields/{id}/delete',[FieldController::class, 'destroy'])->name('fields.destroy');


// documents endpoints
Route::get('documents',[DocumentController::class, 'index'])->name('documents');
Route::get('documents/{id}',[DocumentController::class, 'show'])->name('documents.show');
Route::post('documents',[DocumentController::class, 'store'])->name('documents.store');
Route::post('documents/{id}',[DocumentController::class, 'update'])->name('documents.update');
Route::get('documents/{id}/delete',[DocumentController::class, 'destroy'])->name('documents.destroy');

 
// docfields endpoints
Route::get('docfields',[DocFieldController::class, 'index'])->name('docfields');
Route::get('docfields/{id}',[DocFieldController::class, 'show'])->name('docfields.show');
Route::post('docfields',[DocFieldController::class, 'store'])->name('docfields.store');
Route::post('docfields/{id}',[DocFieldController::class, 'update'])->name('docfields.update');
Route::get('docfields/{id}/delete',[DocFieldController::class, 'destroy'])->name('docfields.destroy');