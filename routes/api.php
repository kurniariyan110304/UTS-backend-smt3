<?php

use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route untuk menampilkan semua data pegawai
Route::get('/employees', [EmployeesController::class, 'index']);

//Route untuk menambahkan data pegawai
Route::post('/employees', [EmployeesController::class, 'store']);

//Route untuk menampilkan detail pegawai
Route::get('/employees/{id}', [EmployeesController::class, 'show']);

//Route untuk mengedit data pegawai
Route::put('/employees/{id}', [EmployeesController::class, 'update']);

//Route untuk menghapus data pegawai
Route::delete('/employees/{id}', [EmployeesController::class, 'destroy']);

 // Route untuk melihat data employees
 Route::get('/employees/search/{name}', [EmployeesController::class, 'search']);

 // Route untuk melihat data employees
 Route::get('/employees/status/active', [EmployeesController::class, 'active']);

 // Route untuk melihat data employees
 Route::get('/employees/status/inactive', [EmployeesController::class, 'inactive']);

 // Route untuk melihat data employees
 Route::get('/employees/status/terminated', [EmployeesController::class, 'terminated']);


//Route untuk Register dan Login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
