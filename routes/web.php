<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('dashboard')->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/', static function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/user', \App\Http\Livewire\User\UserIndex::class)->name('user-index');
    Route::get('country', \App\Http\Livewire\Country\CountryIndex::class)->name('country');
    Route::get('city', \App\Http\Livewire\City\CityIndex::class)->name('city');
    Route::get('department',\App\Http\Livewire\Department\DepartmentIndex::class)->name('department');
    Route::get('employee',\App\Http\Livewire\Employees\EmployeesIndex::class)->name('employee');


});


