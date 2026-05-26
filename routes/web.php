<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShortUrlController;
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

// Short url resolve
Route::get('s/{code}',[ShortUrlController::class, 'resolve'])->name('urls.resolve');

Route::middleware('auth')->group(function () {

    // Super Admin
    Route::middleware('role:SuperAdmin')->group(function(){
        Route::resource('companies', CompanyController::class)->only(['index','create','store']);
        Route::get('all-urls',[ShortUrlController::class, 'allUrls'])->name('urls.all');
    });

    // Admin + Member - Create Urls
    Route::middleware('role:Admin,Member')->group(function(){
        Route::get('urls/create', [ShortUrlController::class, 'create'])->name('urls.create');
        Route::post('urls',[ShortUrlController::class, 'store'])->name('urls.store');
    });

    // Admin only - Company URL list
    Route::middleware('role:Admin')->group(function(){
        Route::get('urls', [ShortUrlController::class, 'index'])->name('urls.index');
    });

    // Member only - Own URL list
    Route::middleware('role:Member')->group(function(){
        Route::get('my-urls', [ShortUrlController::class, 'myUrls'])->name('urls.mine');
    });

    // invitations
    Route::middleware('role:SuperAdmin,Admin')->group(function(){
        Route::get('invite', [InvitationController::class, 'create'])->name('invitations.create');
        Route::post('invite', [InvitationController::class, 'store'])->name('invitations.store');
    });

    Route::get('/export-urls', [ShortUrlController::class, 'export'])->name('urls.export');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';

// Invitations accept - guest
Route::get('/invite/{token}', [InvitationController::class, 'accept'])->name('invitations.accept');
Route::post('/invite/{token}', [InvitationController::class, 'register'])->name('invitations.register');