
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('bienvenida');
    }
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/bienvenida', [LoginController::class, 'bienvenida'])->name('bienvenida');
    // Add other protected routes here
});
 

