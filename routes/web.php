<!--
# VERSION 1.0.1
# AmazingTrack SYSTEM UPTM
# HIDAYAH BINTI BURHANNUDIN
# 13.05.2026  -->

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// index page
Route::get('/', function () {
    return view('index');
})->name('index');


// Authentication Routes
Route::get('/login',       [AuthController::class,'login'])->name('login');
Route::post('/login', [AuthController::class,'loginProcess'])->name('login.process');
Route::post('/logout',[AuthController::class,'logout'])->name('logout');



// Password Reset Routes
Route::get('/forgot-password',        [AuthController::class, 'forgotPassword'])->name('forgot.password');
// Route::post('/forgot-password',       [AuthController::class, 'forgotPasswordProcess'])->name('forgot.password.process');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('reset.password');
Route::post('/reset-password',        [AuthController::class, 'resetPasswordProcess'])->name('reset.password.process');
Route::view('/forgot-password', 'auth.forgot-password')->name('forgot.password');

// use App\Http\Controllers\ForgotPasswordController;


// Forgot Password Page
// Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])
//     ->name('forgot-password');
// // Send Forgot Password Request Email
// Route::post('/forgot-password/send', [ForgotPasswordController::class, 'send'])
//     ->name('forgot-password.send');

//portal routes
use App\Http\Controllers\Portal\PublicPortalController;
use App\Http\Controllers\Portal\PublicCalendarController;
Route::get('Portal',                [PublicPortalController::class, 'index'])->name('Portal.index');
Route::post('portal/lookup',        [PublicPortalController::class, 'lookup'])->name('portal.lookup');
Route::get('Portal/dashboard',      [PublicPortalController::class, 'dashboard'])->name('Portal.dashboard');  
Route::post('portal/claim',         [PublicPortalController::class, 'claim'])->name('portal.claim');
Route::post('portal/proof/{claim}', [PublicPortalController::class, 'uploadProof'])->name('portal.upload-proof');

// Public Calendar Route
Route::get('/calendar', [PublicCalendarController::class, 'index'])->name('public.calendar');

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
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;

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
    Route::get('/users/{user}/access',[AccessUserController::class,'editAccess'])->name('users.access');
    Route::put('/users/{user}/access',[AccessUserController::class,'updateAccess'])->name('users.access.update');


    // Program Routes
    Route::resource('programs', AdminProgramController::class);
    Route::patch('programs/{program}/reschedule', [AdminProgramController::class, 'reschedule'])->name('programs.reschedule');
    Route::patch('programs/{program}/cancel',     [AdminProgramController::class, 'cancel'])    ->name('programs.cancel');

    // Give system access
    Route::post('staff/{id}/give-access', [StaffController::class, 'giveAccess'])->name('staff.giveAccess');

    // Remove system access
    Route::delete('staff/{id}/remove-access', [StaffController::class, 'removeAccess'])->name('staff.removeAccess');

    // NEW — reset a forgotten password back to the shared default
    Route::patch('/users/{user}/reset-password-default', [AccessUserController::class, 'resetPasswordToDefault'])->name('users.reset-password-default');

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
use App\Http\Controllers\VC\GalleryController;

Route::prefix('vc')
    ->name('vc.')
    ->middleware('auth', 'role:vc')
    ->group(function () {
        Route::get('dashboard',         [VCDashboardController::class, 'index'])->name('dashboard');
        Route::get('programs',          [VCProgramController::class, 'index'])->name('programs');
        Route::get('programs/create',   [VCProgramController::class, 'create'])->name('programs.create');
        Route::post('programs',         [VCProgramController::class, 'store'])->name('programs.store');
        Route::get('programs/{program}', [VCProgramController::class, 'edit'])->name('programs.edit');
        Route::put('programs/{program}', [VCProgramController::class, 'update'])->name('programs.update');
        Route::delete('programs/{program}', [VCProgramController::class, 'destroy'])->name('programs.destroy');
        Route::patch('programs/{program}/reschedule', [VCProgramController::class, 'reschedule'])->name('programs.reschedule');
        Route::patch('programs/{program}/cancel',     [VCProgramController::class, 'cancel'])    ->name('programs.cancel');

        Route::get('calendar/calendar', [VCProgramController::class, 'calendar'])->name('calendar');
        Route::get('weekend-staff',     [WeekendStaffController::class, 'index'])->name('weekend-staff');
        Route::get('non-weekend-staff', [NonWeekendStaffController::class, 'index'])->name('non-weekend-staff');

        Route::get('reports',        [MeritReportController::class, 'index'])->name('reports');
        Route::get('reports/export', [MeritReportController::class, 'exportCSV'])->name('reports.export');
        // Route::get('reports/generate', [MeritReportController::class, 'generate'])->name('reports.generate');   

        Route::get('gallery',[GalleryController::class,'index'])->name('gallery');

    });

// Head of Department Routes
use App\Http\Controllers\HOD\LeaderController;

Route::prefix('leader')
    ->name('leader.')
    ->middleware('auth', 'role:ld,dv,rd,bs,dc')
    ->group(function () {
       // Route::get('dashboard', [DepartmentOverviewController::class, 'index'])->name('dashboard');
      //  Route::get('programs',  [HODProgramController::class, 'index'])->name('programs');


         Route::get('/dashboard', [LeaderController::class, 'dashboard'])->name('dashboard');

        // Alternate "analytics widget" home page — see dashboardAnalytics() docblock.
        Route::get('/overview', [LeaderController::class, 'dashboardAnalytics'])->name('overview');

        // Programs (scoped to the leader's own department_access rows)
        // The two GET routes below must be registered before anything that
        // could otherwise swallow "edit" as a {program} route parameter.
        Route::get('/programs/{program}/edit', [LeaderController::class, 'editData'])->name('programs.edit');
        Route::get('/programs/{program}/report', [LeaderController::class, 'programReport'])->name('programs.report');
        Route::get('/programs/{program}', [LeaderController::class, 'show'])->name('programs.show');
        Route::post('/programs', [LeaderController::class, 'storeProgram'])->name('programs.store');
        Route::put('/programs/{program}', [LeaderController::class, 'updateProgram'])->name('programs.update');
        Route::post('/programs/{program}/reschedule', [LeaderController::class, 'reschedule'])->name('programs.reschedule');
        Route::post('/programs/{program}/cancel', [LeaderController::class, 'cancel'])->name('programs.cancel');
        Route::get('/staff-search', [LeaderController::class, 'searchStaff'])->name('staff.search');

        // Monthly report
        Route::get('/reports/generate', [LeaderController::class, 'generateReport'])->name('reports.generate');

        // Staff directory
        Route::get('/staff', [LeaderController::class, 'staffDirectory'])->name('staff.index');

        // Calendar (the events route must come before nothing here — no {param} collision)
        Route::get('/calendar', [LeaderController::class, 'calendarView'])->name('calendar.index');
        Route::get('/calendar/events', [LeaderController::class, 'calendarEvents'])->name('calendar.events');

        // My Departments
        Route::get('/departments', [LeaderController::class, 'departmentsOverview'])->name('departments.index');

        // Notifications
        Route::get('/notifications', [LeaderController::class, 'notifications'])->name('notifications.index');
        Route::post('/notifications/{notification}/read', [LeaderController::class, 'markNotificationRead'])->name('notifications.read');
        Route::post('/notifications/read-all', [LeaderController::class, 'markAllNotificationsRead'])->name('notifications.readAll');
    }); 
