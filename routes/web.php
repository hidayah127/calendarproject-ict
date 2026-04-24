<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


// Authentication Routes
Route::get('/',       [AuthController::class,'login'])->name('login');
Route::post('/login', [AuthController::class,'loginProcess'])->name('login.process');
Route::post('/logout',[AuthController::class,'logout'])->name('logout');



// Password Reset Routes
Route::get('/forgot-password',        [AuthController::class, 'forgotPassword'])->name('forgot.password');
Route::post('/forgot-password',       [AuthController::class, 'forgotPasswordProcess'])->name('forgot.password.process');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('reset.password');
Route::post('/reset-password',        [AuthController::class, 'resetPasswordProcess'])->name('reset.password.process');

//portal routes
use App\Http\Controllers\Portal\PublicPortalController;
Route::get('portal',                [PublicPortalController::class, 'index'])->name('portal.index');
Route::post('portal/lookup',        [PublicPortalController::class, 'lookup'])->name('portal.lookup');
Route::get('portal/dashboard',      [PublicPortalController::class, 'dashboard'])->name('portal.dashboard');  
Route::post('portal/claim',         [PublicPortalController::class, 'claim'])->name('portal.claim');
Route::post('portal/proof/{claim}', [PublicPortalController::class, 'uploadProof'])->name('portal.upload-proof');

Route::middleware('auth')->group(function () {
    Route::get('/change-password',  [AuthController::class, 'changePassword'])->name('change.password');
    Route::post('/change-password', [AuthController::class, 'changePasswordProcess'])->name('change.password.process');
});

// Error Pages
Route::middleware('auth')->group(function(){ 
Route::get('/404', function(){
    return view('errors.404');
})->name('404');

});

// Notification Routes
use App\Http\Controllers\NotificationController;

Route::middleware('auth')->group(function () {
    Route::get('/notifications',                       [NotificationController::class, 'index'])       ->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markRead'])   ->name('notifications.read');
    Route::patch('/notifications/mark-all-read',       [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
    Route::delete('/notifications/clear-all',          [NotificationController::class, 'clearAll'])->name('notifications.clearAll');
});

// Admin Routes
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\AccessUserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::prefix('admin')
    ->name('admin.')
    // ->middleware('auth', 'role:admin')
    ->middleware('auth:admin')
    ->group(function () {

    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');  
    Route::resource('staff', StaffController::class);
    Route::post('staff/import-csv', [StaffController::class, 'importCSV'])->name('staff.import.csv');
    Route::resource('departments', DepartmentController::class);
    Route::resource('users', AccessUserController::class)->only(['index','destroy']);

    // Give system access
    Route::post('staff/{id}/give-access', [StaffController::class, 'giveAccess'])->name('staff.giveAccess');

    // Remove system access
    Route::delete('staff/{id}/remove-access', [StaffController::class, 'removeAccess'])->name('staff.removeAccess');

});

// Program Secretariat Routes
use App\Http\Controllers\Head\StaffDepartmentController;
use App\Http\Controllers\Head\ProgramController;
use App\Http\Controllers\Head\CalendarController;
use App\Http\Controllers\Head\DashboardController;
use App\Http\Controllers\Head\CommitteeController;
use App\Http\Controllers\Head\MeritClaimController;

Route::prefix('head')
    ->name('head.')
    ->middleware('auth', 'role:hd,az')
    ->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');  
    Route::resource('staff', StaffDepartmentController::class);

    Route::resource('programs', ProgramController::class);
    Route::patch('programs/{program}/reschedule', [ProgramController::class, 'reschedule'])->name('programs.reschedule');
    Route::patch('programs/{program}/cancel',     [ProgramController::class, 'cancel'])    ->name('programs.cancel');
    Route::get('programs-committee',              [ProgramController::class, 'committee'])->name('programs.committee');

    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');


    Route::get( 'programs/{program}/committee',             [CommitteeController::class, 'index'])  ->name('committee.index');
    Route::post('programs/{program}/committee',             [CommitteeController::class, 'store'])  ->name('committee.store');
    Route::put( 'programs/{program}/committee/{staff}',     [CommitteeController::class, 'update']) ->name('committee.update');
    Route::delete('programs/{program}/committee/{staff}',   [CommitteeController::class, 'destroy'])->name('committee.destroy');
    Route::post('/programs/{program}/committee/import-csv', [CommitteeController::class, 'importCSV'])->name('committee.import.csv');
    Route::post('programs/{program}/committee/notify',      [CommitteeController::class, 'notifyAll'])->name('committee.notify');

    Route::get('merit-claims',                     [MeritClaimController::class, 'index'])->name('merit-claims');
    Route::patch('merit-claims/{claim}/approve',   [MeritClaimController::class, 'approve'])->name('merit-claims.approve');
    Route::patch('merit-claims/{claim}/reject',    [MeritClaimController::class, 'reject'])->name('merit-claims.reject');
    Route::patch('/head/merit-claims/bulk-approve',[MeritClaimController::class, 'bulkApprove'])->name('merit-claims.bulk-approve');
    Route::patch('/head/merit-claims/bulk-reject', [MeritClaimController::class, 'bulkReject'])->name('merit-claims.bulk-reject');
});

// Vice Chancellor Routes
use App\Http\Controllers\VC\ProgramController as VCProgramController;
use App\Http\Controllers\VC\DashboardController as VCDashboardController;
use App\Http\Controllers\VC\WeekendStaffController;
use App\Http\Controllers\VC\MeritReportController;
use App\Http\Controllers\VC\NonWeekendStaffController;

Route::prefix('vc')
    ->name('vc.')
    ->middleware('auth', 'role:vc')
    ->group(function () {
        Route::get('dashboard',         [VCDashboardController::class, 'index'])->name('dashboard');
        Route::get('programs',          [VCProgramController::class, 'index'])->name('programs');
        Route::get('calendar/calendar', [VCProgramController::class, 'calendar'])->name('calendar');
        Route::get('weekend-staff',     [WeekendStaffController::class, 'index'])->name('weekend-staff');
        Route::get('non-weekend-staff', [NonWeekendStaffController::class, 'index'])->name('non-weekend-staff');

        Route::get('reports',        [MeritReportController::class, 'index'])->name('reports');
        Route::get('reports/export', [MeritReportController::class, 'exportCSV'])->name('reports.export');
        // Route::get('reports/generate', [MeritReportController::class, 'generate'])->name('reports.generate');   

    });

// Head of Department Routes
use App\Http\Controllers\HOD\DepartmentOverviewController;
Route::prefix('ld')
    ->name('ld.')
    ->middleware('auth', 'role:ld')
    ->group(function () {
        Route::get('dashboard', [DepartmentOverviewController::class, 'index'])->name('dashboard');
    }); 
