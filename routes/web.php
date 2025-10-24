<?php

//use App\Livewire\Work;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes([
    'login' => true,
    'register' => false,
    'verify' => false,
    'reset' => false
  ]);
  
// Route::get('/work', Work::class);

Route::middleware('auth')->group(function () {
    // ...
    Route::get('/', [App\Http\Controllers\WorkController::class, 'index'])->name('work.index');
    Route::get('work/show-deleted', [App\Http\Controllers\WorkController::class, 'showDeleted'])->name('work.show_deleted');
    Route::get('work/{work}/print/{type?}', [App\Http\Controllers\WorkController::class, 'print'])->name('work.print');
    Route::resource('work', App\Http\Controllers\WorkController::class, ['except' => ['store', 'update', 'destroy']]);
    // routes/web.php
    
    // Loans
    Route::get('loan/search/', [App\Http\Controllers\LoanController::class, 'search'])->name('loan.search');
    Route::resource('loan', App\Http\Controllers\LoanController::class);
    Route::resource('item', App\Http\Controllers\ItemController::class);
    Route::resource('note', App\Http\Controllers\NoteController::class);
    Route::resource('partner', App\Http\Controllers\PartnerController::class);

});

