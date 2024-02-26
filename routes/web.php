<?php

use App\Http\Controllers\Backoffice\FormController;
use App\Http\Controllers\Pdf\ContractSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/{contract}/start', function (\App\Models\Contract $contract) {
    return view('backoffice.startContractForm', compact('contract'));
})->name('startContractForm');

Route::middleware('auth:web')
    ->prefix('backoffice/')
    ->name('backoffice.')
    ->group(function () {
        Route::get('form/{form}/edit', [FormController::class, 'edit'])->name('form.edit');
    });

Route::get('pdf/contract/{contract}', [ContractSessionController::class, 'render'])->name('pdf.contract');

Route::redirect('/login', '/admin/login')->name('login');