<?php

use App\Http\Controllers\Admin\AgencyPartnerController;
use App\Http\Controllers\Admin\BuyerLeadController;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\Admin\DigitalAkadController;
use App\Http\Controllers\Admin\PropertyFileController;
use App\Http\Controllers\Admin\PropertyProjectController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Super Admin Management Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', AdminUserController::class);
    Route::resource('agency-partners', AgencyPartnerController::class);
    Route::resource('property-projects', PropertyProjectController::class);
    Route::resource('property-files', PropertyFileController::class);
    Route::resource('buyer-leads', BuyerLeadController::class);
    Route::resource('digital-akads', DigitalAkadController::class);
    Route::resource('commissions', CommissionController::class);
});

require __DIR__.'/auth.php';

