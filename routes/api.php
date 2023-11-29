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
use App\Models\DocumentVersion;
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
    Route::get('folders/{parent_folder_id}', [FolderController::class, 'index'])->name('folders');
    Route::get('folder/show/{id}', [FolderController::class, 'show'])->name('folders.show');
    Route::post('folders/store', [FolderController::class, 'store'])->name('folders.store');
    Route::post('folders/update/{id}', [FolderController::class, 'update'])->name('folders.update');
    Route::get('folders/delete/{id}', [FolderController::class, 'destroy'])->name('folders.destroy');


    // fields endpoints
    Route::get('folder/{folder_id}/fields', [FieldController::class, 'index'])->name('fields');
    Route::get('folder/field/show/{id}', [FieldController::class, 'show'])->name('fields.show');
    Route::post('folder/fields/store', [FieldController::class, 'store'])->name('fields.store');
    Route::post('folder/fields/update/{id}', [FieldController::class, 'update'])->name('fields.update');
    Route::get('folder/fields/delete/{id}', [FieldController::class, 'destroy'])->name('fields.destroy');


    // documents endpoints
    Route::get('folder/{folder_id}/documents', [DocumentController::class, 'index'])->name('documents');
    Route::get('folder/document/show/{id}', [DocumentController::class, 'show'])->name('documents.show');
    Route::post('folder/documents/upload', [DocumentController::class, 'upload'])->name('documents.upload');
    Route::post('folder/documents/re-upload/{id}', [DocumentController::class, 're_upload'])->name('documents.re_upload');
    Route::get('folder/documents/delete/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    Route::get('folder/documentversion/{id}', [DocumentController::class, 'switch_version'])->name('documents.switch_version');


    // docfields endpoints
    Route::get('document/{document_id}/docfields', [DocFieldController::class, 'index'])->name('docfields');
    Route::get('document/docfield/show/{id}', [DocFieldController::class, 'show'])->name('docfields.show');
    Route::post('document/docfields/store', [DocFieldController::class, 'store'])->name('docfields.store');
    Route::post('document/docfields/update/{id}', [DocFieldController::class, 'update'])->name('docfields.update');
    Route::get('document/docfields/delete/{id}', [DocFieldController::class, 'destroy'])->name('docfields.destroy');



    // users endpoints
    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('user/show/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('users/store', [UserController::class, 'store'])->name('users.store');
    Route::post('users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('users/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');


    // groups endpoints
    Route::get('groups', [GroupController::class, 'index'])->name('groups');
    Route::get('group/show/{id}', [GroupController::class, 'show'])->name('groups.show');
    Route::post('groups/store', [GroupController::class, 'store'])->name('groups.store');
    Route::post('groups/update/{id}', [GroupController::class, 'update'])->name('groups.update');
    Route::get('groups/delete/{id}', [GroupController::class, 'destroy'])->name('groups.destroy');


    // groupmemberships endpoints
    Route::get('groupmemberships', [GroupMembershipController::class, 'index'])->name('groupmemberships');
    Route::get('groupmembership/show/{id}', [GroupMembershipController::class, 'show'])->name('groupmemberships.show');
    Route::post('groupmemberships/store', [GroupMembershipController::class, 'store'])->name('groupmemberships.store');
    Route::post('groupmemberships/update/{id}', [GroupMembershipController::class, 'update'])->name('groupmemberships.update');
    Route::get('groupmemberships/delete/{id}', [GroupMembershipController::class, 'destroy'])->name('groupmemberships.destroy');


    // grouppermissions endpoints
    Route::get('grouppermissions', [GroupPermissionController::class, 'index'])->name('grouppermissions');
    Route::get('grouppermission/show/{id}', [GroupPermissionController::class, 'show'])->name('grouppermissions.show');
    Route::post('grouppermissions/store', [GroupPermissionController::class, 'store'])->name('grouppermissions.store');
    Route::post('grouppermissions/update/{id}', [GroupPermissionController::class, 'update'])->name('grouppermissions.update');
    Route::get('grouppermissions/delete/{id}', [GroupPermissionController::class, 'destroy'])->name('grouppermissions.destroy');


    // workstep endpoints
    Route::get('folder/{folder_id}/worksteps', [WorkStepController::class, 'index'])->name('workstep');
    Route::get('folder/workstep/show/{id}', [WorkStepController::class, 'show'])->name('workstep.show');
    Route::post('folder/worksteps/store', [WorkStepController::class, 'store'])->name('workstep.store');
    Route::post('folder/worksteps/update/{id}', [WorkStepController::class, 'update'])->name('workstep.update');
    Route::get('folder/worksteps/delete/{id}', [WorkStepController::class, 'destroy'])->name('workstep.destroy');


    // possible action endpoints
    Route::get('workstep/{workstep_id}/possibleactions', [PossibleActionController::class, 'index'])->name('possibleaction');
    Route::get('workstep/possibleaction/show/{id}', [PossibleActionController::class, 'show'])->name('possibleaction.show');
    Route::post('workstep/possibleactions/store', [PossibleActionController::class, 'store'])->name('possibleaction.store');
    Route::post('workstep/possibleactions/update/{id}', [PossibleActionController::class, 'update'])->name('possibleaction.update');
    Route::get('workstep/possibleactions/delete/{id}', [PossibleActionController::class, 'destroy'])->name('possibleaction.destroy');


    // workstep result endpoints
    Route::get('workstep/{workstep_id}/workstepresults', [WorkstepResultController::class, 'index'])->name('workstepresult');
    Route::get('workstep/workstepresult/show/{id}', [WorkstepResultController::class, 'show'])->name('workstepresult.show');
    Route::post('workstep/workstepresults/store', [WorkstepResultController::class, 'store'])->name('workstepresult.store');
    Route::post('workstep/workstepresults/update/{id}', [WorkstepResultController::class, 'rollback'])->name('workstepresult.rollback');
    Route::get('workstep/workstepresults/delete/{id}', [WorkstepResultController::class, 'destroy'])->name('workstepresult.destroy');
});
