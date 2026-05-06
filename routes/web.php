<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\JurySimulationController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Routes publiques
Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/api/comments', [CommentController::class, 'index']);
Route::post('/api/comments', [CommentController::class, 'store']);
// Routes d'authentification (guest)
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

// Déconnexion
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Routes de vérification d'email
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware(['signed'])
    ->name('verification.verify');

// Routes protégées (authentification requise)
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');
    
    Route::get('/offres', [OfferController::class, 'index'])->name('offers.index');
    Route::post('/offres/order', [OfferController::class, 'createOrder'])->name('offers.create-order');
});

// Routes protégées (email vérifié)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // ========== ROUTES INERTIA (PAGES) ==========
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/offers', [OfferController::class, 'index'])->name('offers');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Présentations
    Route::post('/api/generate-presentation', [PresentationController::class, 'store']);
        Route::get('/api/presentation-status/{id}', [PresentationController::class, 'status']);
    Route::post('/api/presentations/update/{id}', [PresentationController::class, 'update']);
    Route::get('/api/presentations/{id}', [PresentationController::class, 'getJson']);
    Route::get('/api/export-presentation/{id}', [PresentationController::class, 'export']);
    Route::get('/presentation/status/{id}', [PresentationController::class, 'status']);
    Route::get('/debug/presentation/{id}', [PresentationController::class, 'debugPresentation']);
    Route::get('/presentation/create', [PresentationController::class, 'create'])->name('presentation.create');
Route::get('/presentation-status/{id}', [PresentationController::class, 'status'])->middleware('auth');
    Route::get('/presentation/{id}', [PresentationController::class, 'show']);
    Route::post('/presentations/{presentation}/add-slide', [PresentationController::class, 'addSlide'])->name('presentations.add-slide');
    Route::put('/presentations/{presentation}/update-slide/{slideNumber}', [PresentationController::class, 'updateSlide'])->name('presentations.update-slide');
    Route::delete('/presentations/{presentation}/delete-slide/{slideNumber}', [PresentationController::class, 'deleteSlide'])->name('presentations.delete-slide');
    Route::get('/presentations', [PresentationController::class, 'index'])->name('presentations.index');

    // ========== ROUTES JURY SIMULATION ==========
    
    // Page Inertia pour la simulation (AFFICHAGE)
    Route::get('/jury/simulate', [JurySimulationController::class, 'simulatePage'])->name('jury.simulate');
    
    // Routes API (retournent du JSON) - À mettre POUR TOUTES les routes API
     Route::post('/jury/analyze-answer', [JurySimulationController::class, 'analyzeAnswer']);
     Route::get('/api/jury/analysis-result/{simulationId}/{questionIndex}', 
        [JurySimulationController::class, 'getAnalysisResult']);
    Route::get('/api/jury/simulations', [JurySimulationController::class, 'index']);
    Route::post('/api/jury/simulations', [JurySimulationController::class, 'store']);
    Route::post('/jury/generate-questions', [JurySimulationController::class, 'generateQuestions']);
        Route::post('/jury/questions-status', [JurySimulationController::class, 'getQuestionsStatus']); 
    Route::post('/jury/analyze-answer', [JurySimulationController::class, 'analyzeAnswer']);
    Route::get('/api/jury/simulations/stats', [JurySimulationController::class, 'stats']);
    Route::get('/api/jury/simulations/{id}', [JurySimulationController::class, 'show']);
    
    // Pages Inertia pour l'historique et stats (AFFICHAGE)
    Route::get('/jury/history', function () {
        return Inertia::render('Jury/History');
    })->name('jury.history');
    
    Route::get('/jury/stats', function () {
        return Inertia::render('Jury/Stats');
    })->name('jury.stats');
    
    Route::get('/jury/simulation/{id}', function ($id) {
        return Inertia::render('Jury/SimulationDetails', ['id' => $id]);
    })->name('jury.simulation.details');
    
    // Autres pages
    Route::get('/reformulation/create', function () {
        return Inertia::render('Reformulation/Create');
    })->name('reformulation.create');
    
    Route::get('/activity', function () {
        return Inertia::render('Activity/Index');
    })->name('activity.index');
    
    Route::get('/support/contact', function () {
        return Inertia::render('Support/Contact');
    })->name('support.contact');
});

// Routes ADMIN
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/commandes', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/commandes/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/commandes/{order}/activate', [AdminOrderController::class, 'activate'])->name('orders.activate');
    Route::post('/commandes/{order}/cancel', [AdminOrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/utilisateurs', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/utilisateurs/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::post('/utilisateurs/{user}/add-credits', [AdminUserController::class, 'addCredits'])->name('users.add-credits');
    Route::post('/utilisateurs/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggle-admin');
    Route::get('/offres', [OfferController::class, 'adminIndex'])->name('offers.index');
    Route::get('/offres/create', [OfferController::class, 'adminCreate'])->name('offers.create');
    Route::post('/offres', [OfferController::class, 'adminStore'])->name('offers.store');
    Route::get('/offres/{offer}/edit', [OfferController::class, 'adminEdit'])->name('offers.edit');
    Route::put('/offres/{offer}', [OfferController::class, 'adminUpdate'])->name('offers.update');
    Route::delete('/offres/{offer}', [OfferController::class, 'adminDestroy'])->name('offers.destroy');
    Route::post('/offres/{offer}/toggle-status', [OfferController::class, 'adminToggleStatus'])->name('offers.toggle-status');
    Route::get('/statistiques', [AdminDashboardController::class, 'statistics'])->name('statistics');
    Route::get('/rapports', [AdminDashboardController::class, 'reports'])->name('reports');
});

// Route de test
Route::get('/test-admin', function () {
    return Inertia::render('TestAdmin');
})->middleware(['auth', 'admin'])->name('test.admin');