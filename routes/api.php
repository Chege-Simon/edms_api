<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\WorkstepController;
use App\Http\Controllers\PossibleActionController;
use App\Http\Controllers\WorkstepResultController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocFieldController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupMembershipController;
use App\Http\Controllers\GroupPermissionController;
use App\Models\WorkStep;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => 'auth'

], function () {
// Route::group(['middleware' =>['ldap.auth']],function () {
// Route::get('/login', 'AuthController@index','login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::get('/user-profile', [AuthController::class, 'userProfile'])->name('user-profile');  
 
});
    Route::group(['middleware' => ['jwt.auth']], function () {
    // folder endpoints
    Route::get('folders', [FolderController::class, 'index'])->name('folders');
    Route::get('folders/{id}', [FolderController::class, 'show'])->name('folders.show');
    Route::post('folders', [FolderController::class, 'store'])->name('folders.store');
    Route::post('folders/{id}', [FolderController::class, 'update'])->name('folders.update');
    Route::get('folders/{id}/delete', [FolderController::class, 'destroy'])->name('folders.destroy');


    // fields endpoints
    Route::get('fields', [FieldController::class, 'index'])->name('fields');
    Route::get('fields/{id}', [FieldController::class, 'show'])->name('fields.show');
    Route::post('fields', [FieldController::class, 'store'])->name('fields.store');
    Route::post('fields/{id}', [FieldController::class, 'update'])->name('fields.update');
    Route::get('fields/{id}/delete', [FieldController::class, 'destroy'])->name('fields.destroy');


    // documents endpoints
    Route::get('documents', [DocumentController::class, 'index'])->name('documents');
    Route::get('documents/{id}', [DocumentController::class, 'show'])->name('documents.show');
    Route::post('documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::post('documents/{id}', [DocumentController::class, 'update'])->name('documents.update');
    Route::get('documents/{id}/delete', [DocumentController::class, 'destroy'])->name('documents.destroy');


    // docfields endpoints
    Route::get('docfields', [DocFieldController::class, 'index'])->name('docfields');
    Route::get('docfields/{id}', [DocFieldController::class, 'show'])->name('docfields.show');
    Route::post('docfields', [DocFieldController::class, 'store'])->name('docfields.store');
    Route::post('docfields/{id}', [DocFieldController::class, 'update'])->name('docfields.update');
    Route::get('docfields/{id}/delete', [DocFieldController::class, 'destroy'])->name('docfields.destroy');



    // users endpoints
    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::post('users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('users/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy');


    // groups endpoints
    Route::get('groups', [GroupController::class, 'index'])->name('groups');
    Route::get('groups/{id}', [GroupController::class, 'show'])->name('groups.show');
    Route::post('groups', [GroupController::class, 'store'])->name('groups.store');
    Route::post('groups/{id}', [GroupController::class, 'update'])->name('groups.update');
    Route::get('groups/{id}/delete', [GroupController::class, 'destroy'])->name('groups.destroy');


    // groupmemberships endpoints
    Route::get('groupmemberships', [GroupMembershipController::class, 'index'])->name('groupmemberships');
    Route::get('groupmemberships/{id}', [GroupMembershipController::class, 'show'])->name('groupmemberships.show');
    Route::post('groupmemberships', [GroupMembershipController::class, 'store'])->name('groupmemberships.store');
    Route::post('groupmemberships/{id}', [GroupMembershipController::class, 'update'])->name('groupmemberships.update');
    Route::get('groupmemberships/{id}/delete', [GroupMembershipController::class, 'destroy'])->name('groupmemberships.destroy');


    // grouppermissions endpoints
    Route::get('grouppermissions', [GroupPermissionController::class, 'index'])->name('grouppermissions');
    Route::get('grouppermissions/{id}', [GroupPermissionController::class, 'show'])->name('grouppermissions.show');
    Route::post('grouppermissions', [GroupPermissionController::class, 'store'])->name('grouppermissions.store');
    Route::post('grouppermissions/{id}', [GroupPermissionController::class, 'update'])->name('grouppermissions.update');
    Route::get('grouppermissions/{id}/delete', [GroupPermissionController::class, 'destroy'])->name('grouppermissions.destroy');


     // workstep endpoints
     Route::get('workstep', [WorkStepController::class, 'index'])->name('workstep');
     Route::get('workstep/{id}', [WorkStepController::class, 'show'])->name('workstep.show');
     Route::post('workstep', [WorkStepController::class, 'store'])->name('workstep.store');
     Route::post('workstep/{id}', [WorkStepController::class, 'update'])->name('workstep.update');
     Route::get('workstep/{id}/delete', [WorkStepController::class, 'destroy'])->name('workstep.destroy');

     
      // possible action endpoints
      Route::get('possibleaction', [PossibleActionController::class, 'index'])->name('possibleaction');
      Route::get('possibleaction/{id}', [PossibleActionController::class, 'show'])->name('possibleaction.show');
      Route::post('possibleaction', [PossibleActionController::class, 'store'])->name('possibleaction.store');
      Route::post('possibleaction/{id}', [PossibleActionController::class, 'update'])->name('possibleaction.update');
      Route::get('possibleaction/{id}/delete', [PossibleActionController::class, 'destroy'])->name('possibleaction.destroy');
 

      // workstep result endpoints
     Route::get('workstepresult', [WorkstepResultController::class, 'index'])->name('workstepresult');
     Route::get('workstepresult/{id}', [WorkstepResultController::class, 'show'])->name('workstepresult.show');
     Route::post('workstepresult', [WorkstepResultController::class, 'store'])->name('workstepresult.store');
     Route::post('workstepresult/{id}', [WorkstepResultController::class, 'update'])->name('workstepresult.update');
     Route::get('workstepresult/{id}/delete', [WorkstepResultController::class, 'destroy'])->name('workstepresult.destroy');
});  