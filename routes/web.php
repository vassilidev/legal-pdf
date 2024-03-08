<?php

use App\Http\Controllers\Backoffice\ContractController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Pdf\ContractSessionController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

Route::get('/start/{contract}', [SurveyController::class, 'start'])->name('survey.start');
Route::post('/start/{contract}', [SurveyController::class, 'process'])->name('survey.process');

Route::get('/payment/{order}', [OrderController::class, 'paymentView'])->name('order.payment-view');
Route::post('/payment/{order}', [OrderController::class, 'processPayment'])->name('order.process-payment');
Route::get('/payment/{order}/succeeded', [OrderController::class, 'succeeded'])->name('order.succeeded');
Route::get('/invoice/{order}', [OrderController::class, 'invoice'])->name('order.invoice');

Route::middleware('auth:web')
    ->prefix('backoffice/')
    ->name('backoffice.')
    ->group(function () {
        Route::get('builder/{contract}', [ContractController::class, 'edit'])->name('contract.edit');
    });

Route::get('pdf/contract/{contract}', [ContractSessionController::class, 'renderContract'])->name('pdf.contract');
Route::get('pdf/contract-order/{order}', [ContractSessionController::class, 'renderOrder'])->name('pdf.contract.order');

Route::redirect('/login', '/app/login')->name('login');
Route::redirect('/', '/app/login');