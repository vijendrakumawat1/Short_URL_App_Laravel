<?php
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
        // Invitations
    Route::get('/invite', [InvitationController::class, 'index'])->name('invite.index');
    Route::get('/invite/create', [InvitationController::class, 'create'])->name('invite.create');
    Route::post('/invite', [InvitationController::class, 'store'])->name('invite.store');

    // Short URLs
    Route::get('/short-urls', [ShortUrlController::class, 'index'])->name('shorturls.index');
    Route::get('/short-urls/create', [ShortUrlController::class, 'create'])->name('shorturls.create');
    Route::post('/short-urls', [ShortUrlController::class, 'store'])->name('shorturls.store');

    // Redirect (must be logged in)
    Route::get('/r/{short_code}', [ShortUrlController::class, 'redirect'])->name('shorturls.redirect');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
