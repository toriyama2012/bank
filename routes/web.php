<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\ReportController;

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

// Original code from Sanctum and JetStream installation
Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Original code from Sanctum and JetStream installation
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /*Route::get('branches', [BranchController::class, 'index'])->name('branches.index');

    Route::post('branches', [BranchController::class, 'store'])->name('branches.store');

    Route::get('branches/create', [BranchController::class, 'create'])->name('branches.create');

    Route::get('branches/{id}',  [BranchController::class, 'show'])->name('branches.show');

    Route::put('branches/{id}',  [BranchController::class, 'update'])->name('branches.update');

    Route::delete('branches/{id}', [BranchController::class, 'destroy'])->name('branches.destroy');

    Route::get('branches/{id}/edit',  [BranchController::class, 'edit'])->name('branches.edit');*/

    Route::resource('branches', BranchController::class);


    Route::get('branches/{id}/customer', [CustomerController::class, 'customersIndex'])->name('branches.customers.index');

    Route::post('branches/{id}/customer', [CustomerController::class, 'customersStore'])->name('branches.customers.store');

    Route::get('branches/{id}/customer/create', [CustomerController::class, 'customersCreate'])->name('branches.customers.create');

    Route::get('branches/{id}/customer/{customer_id}', [CustomerController::class, 'customersShow'])->name('branches.customers.show');

    Route::put('branches/{id}/customer/{customer_id}', [CustomerController::class, 'customersUpdate'])->name('branches.customers.update');

    Route::delete('branches/{id}/customer/{customer_id}', [CustomerController::class, 'customersDestroy'])->name('branches.customers.destroy');

    Route::get('branches/{id}/customer/{customer_id}/edit', [CustomerController::class, 'customersEdit'])->name('branches.customers.edit');


    Route::get('transfers', [TransferController::class, 'transfersIndex'])->name('transfers.index');

    Route::post('transfers/store', [TransferController::class, 'transfersStore'])->name('transfers.store');

    Route::post('transfers/validation', [TransferController::class, 'transfersAjaxValidate'])->name('transfers.validation');


    Route::get('reports', [ReportController::class, 'ReportsIndex'])->name('reports.index');

    Route::get('reports/branch-highest-balances', [ReportController::class, 'ReportsBranchHighestBalances'])->name('reports.branch-highest-balances');
    Route::get('reports/branch-more-two-customers-and-balance-over-50k', [ReportController::class, 'ReportsBranchMoreTwoCustomersAndBalanceOver50kReport'])->name('reports.branch-more-two-customers-and-balance-over-50k');
    Route::get('reports/branch-more-two-customers-and-balance-over-50k-v2', [ReportController::class, 'ReportsBranchMoreTwoCustomersAndBalanceOver50kReportV2'])->name('reports.branch-more-two-customers-and-balance-over-50k-v2');
});
