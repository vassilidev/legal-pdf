<?php

use App\Http\Controllers\Pdf\ContractSessionController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::redirect('/login', '/admin/login')->name('login');

Route::get('pdf/contract/{contract}', [ContractSessionController::class, 'render'])->name('pdf.contract');