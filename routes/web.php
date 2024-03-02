<?php

use App\Http\Controllers\Backoffice\ContractController;
use App\Http\Controllers\Pdf\ContractSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/{contract}/start', function (\App\Models\Contract $contract) {
    return view('backoffice.startContractForm', compact('contract'));
})->name('startContractForm');

Route::middleware('auth:web')
    ->prefix('backoffice/')
    ->name('backoffice.')
    ->group(function () {
        Route::get('builder/{contract}', [ContractController::class, 'edit'])->name('contract.edit');
    });

Route::get('pdf/contract/{contract}', [ContractSessionController::class, 'render'])->name('pdf.contract');

Route::redirect('/login', '/app/login')->name('login');
Route::redirect('/', '/app/login');

Route::view('test', 'test');