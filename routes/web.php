<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\AdminController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\EasypayController;

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

// Public routes
// Explicitly match GET and HEAD for root to avoid "GET method not supported" issues
// that can appear if a stale route cache exists or if the server converts a HEAD
// request improperly. Laravel normally handles HEAD automatically for GET but we
// are being explicit for robustness.
Route::match(['GET','HEAD'], '/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/notices', [PageController::class, 'notices'])->name('notices');

// Application routes
Route::get('/application', [PageController::class, 'application'])->name('application');
Route::get('/application-status', [PageController::class, 'applicationStatus'])->name('application-status');
Route::post('/application-status', [ApplicationController::class, 'checkStatus'])->name('application-status.check');

// Form routes
Route::get('/forms/{form}', [FormController::class, 'show'])->name('forms.show');
Route::post('/forms/{form}', [FormController::class, 'submit'])->name('forms.submit');

// Application payment routes
Route::get('/forms/{application}/payment', [PaymentController::class, 'show'])->name('forms.payment.show');
Route::get('/forms/{application}/payment/decision', [PaymentController::class, 'decision'])->name('forms.payment.decision');
Route::post('/forms/{application}/payment/pay-now', [PaymentController::class, 'payNow'])->name('forms.payment.pay_now');
Route::post('/forms/{application}/payment/pay-later', [PaymentController::class, 'payLater'])->name('forms.payment.pay_later');

// New explicit Pay Later action (refined) via dedicated controller (idempotent marking)
Route::post('/applications/{application}/pay-later', [\App\Http\Controllers\ApplicationPaymentController::class, 'payLater'])->name('applications.pay_later');
Route::get('/forms/{application}/payment/success', [PaymentController::class, 'success'])->name('forms.payment.success');
Route::get('/forms/{application}/payment/receipt-pdf', [PaymentController::class, 'receiptPdf'])->name('forms.payment.receipt-pdf');

// bKash return / execute endpoints (user redirect back with payment_id)
Route::get('/forms/{application}/payment/bkash/return', [PaymentController::class, 'bkashReturn'])->name('forms.payment.bkash.return');
Route::post('/forms/{application}/payment/bkash/execute', [PaymentController::class, 'bkashExecute'])->name('forms.payment.bkash.execute');

// Easypay routes
Route::post('/easypay/initiate', [EasypayController::class, 'initiatePayment'])->name('easypay.initiate');
Route::post('/easypay/callback', [EasypayController::class, 'handleCallback'])->name('easypay.callback');

// Admin Authentication Routes
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Admin Routes
Route::middleware(['web', 'admin.auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Form Manager Routes
    Route::resource('/admin/forms', \App\Http\Controllers\Admin\FormController::class)->names([
        'index' => 'admin.forms.index',
        'create' => 'admin.forms.create',
        'store' => 'admin.forms.store',
        'show' => 'admin.forms.show',
        'edit' => 'admin.forms.edit',
        'update' => 'admin.forms.update',
        'destroy' => 'admin.forms.destroy'
    ]);
    Route::get('/admin/forms/{form}/builder', [\App\Http\Controllers\Admin\FormController::class, 'builder'])->name('admin.forms.builder');
    Route::post('/admin/forms/{form}/fields', [\App\Http\Controllers\Admin\FormController::class, 'updateFields'])->name('admin.forms.update-fields');

    // Subject Management Routes
    // Explicitly define each route with proper names
    Route::get('/admin/subjects', [SubjectController::class, 'index'])->name('admin.subjects.index');
    Route::get('/admin/subjects/create', [SubjectController::class, 'create'])->name('admin.subjects.create');
    Route::post('/admin/subjects', [SubjectController::class, 'store'])->name('admin.subjects.store');
    Route::get('/admin/subjects/{subject}', [SubjectController::class, 'show'])->name('admin.subjects.show');
    Route::get('/admin/subjects/{subject}/edit', [SubjectController::class, 'edit'])->name('admin.subjects.edit');
    Route::put('/admin/subjects/{subject}', [SubjectController::class, 'update'])->name('admin.subjects.update');
    Route::delete('/admin/subjects/{subject}', [SubjectController::class, 'destroy'])->name('admin.subjects.destroy');
    Route::put('/admin/subjects/{subject}/status', [SubjectController::class, 'updateStatus'])->name('admin.subjects.update-status');
    Route::post('/admin/subjects/{subject}/form-fees', [SubjectController::class, 'saveFormFees'])->name('admin.subjects.save-form-fees')->middleware('web');

    // Admin Applications
    Route::get('/admin/applications', [AdminApplicationController::class, 'index'])->name('admin.applications.index');
    Route::get('/admin/applications/{application}', [AdminApplicationController::class, 'show'])->name('admin.applications.show');
    Route::match(['PUT', 'POST'], '/admin/applications/{application}/status', [AdminApplicationController::class, 'updateStatus'])->name('admin.applications.update-status');
    Route::post('/admin/applications/bulk-status', [AdminApplicationController::class, 'bulkUpdateStatus'])->name('admin.applications.bulk-status');
    Route::match(['DELETE', 'POST'], '/admin/applications/{application}', [AdminApplicationController::class, 'destroy'])->name('admin.applications.destroy');

    // Admin Payments
    Route::get('/admin/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('admin.payments.index');
    Route::get('/admin/payments/{payment}', [\App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('admin.payments.show');
    Route::post('/admin/payments/{payment}/refund', [\App\Http\Controllers\Admin\PaymentController::class, 'refund'])->name('admin.payments.refund');
    Route::get('/admin/payments-export', [\App\Http\Controllers\Admin\PaymentController::class, 'exportCsv'])->name('admin.payments.export');

    // Admin Payment Gateways
    Route::get('/admin/payment-gateways', [\App\Http\Controllers\Admin\PaymentGatewayController::class, 'index'])->name('admin.payment-gateways.index');
    Route::get('/admin/payment-gateways/{gateway}/edit', [\App\Http\Controllers\Admin\PaymentGatewayController::class, 'edit'])->name('admin.payment-gateways.edit');
    Route::put('/admin/payment-gateways/{gateway}', [\App\Http\Controllers\Admin\PaymentGatewayController::class, 'update'])->name('admin.payment-gateways.update');

    // Admin Receipt Design
    Route::get('/admin/receipt-design', [\App\Http\Controllers\Admin\ReceiptDesignController::class, 'index'])->name('admin.receipt-design.index');
    Route::put('/admin/receipt-design', [\App\Http\Controllers\Admin\ReceiptDesignController::class, 'update'])->name('admin.receipt-design.update');
    
    // Admin Settings
    Route::get('/admin/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('admin.settings.index');
    Route::put('/admin/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('admin.settings.update');
    
    // Admin User Management
    Route::resource('/admin/users', \App\Http\Controllers\Admin\UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy'
    ]);
    
    // Bulk delete users
    Route::delete('/admin/users/bulk-delete', [\App\Http\Controllers\Admin\UserController::class, 'bulkDestroy'])->name('admin.users.bulk-delete');
});

// Public Pages
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');

// Auth Routes (if needed)
// Route::get('/login', [PageController::class, 'login'])->name('login');