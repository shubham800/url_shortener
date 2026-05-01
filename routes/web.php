<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::middleware('role:SuperAdmin')->group(function(){
        Route::resource('companies', CompanyController::class)->only(['index','create','store']);
    });

    // invitations
    Route::middleware('role:SuperAdmin,Admin')->group(function(){
        Route::get('invite', [InvitationController::class, 'create'])->name('invitations.create');
        Route::post('invite', [InvitationController::class, 'store'])->name('invitations.store');
    });


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';

// Invitations accept - guest
Route::get('/invite/{token}', [InvitationController::class, 'accept'])->name('invitations.accept');
Route::post('/invite/{token}', [InvitationController::class, 'register'])->name('invitations.register');