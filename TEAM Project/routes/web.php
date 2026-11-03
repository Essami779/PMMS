<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LookupController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\TrashController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\TeamWorkspaceController;
use App\Http\Controllers\TeamInvitationController;
use App\Http\Controllers\TeamTaskController;

// 0. الواجهات العامة والصفحة التعريفية (Public Showcase & Landing Hub)
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/teams', [FrontendController::class, 'teams'])->name('teams.index');
Route::get('/companies', [FrontendController::class, 'companies'])->name('companies.index');
Route::get('/consultants', [FrontendController::class, 'consultants'])->name('consultants.index');

Route::middleware(['auth', 'verified'])->group(function () {
    // 1. Dashboard (لوحة التحكم الرئيسية)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. مساحة عمل الفريق ولوحة تحكم القائد (Team Leader & Workspace Hub)
    Route::get('/my-team', [TeamWorkspaceController::class, 'index'])->name('team.workspace');
    Route::post('/my-team', [TeamWorkspaceController::class, 'store'])->name('team.store');
    Route::put('/my-team/{team}', [TeamWorkspaceController::class, 'update'])->name('team.update');
    Route::get('/my-team/{team}/report', [TeamWorkspaceController::class, 'report'])->name('team.report');
    Route::post('/my-team/{team}/standups', [TeamWorkspaceController::class, 'storeStandup'])->name('team.standups.store');
    Route::post('/my-team/{team}/members/{member}/role', [TeamWorkspaceController::class, 'updateMemberRole'])->name('team.members.role');
    Route::delete('/my-team/{team}/members/{member}', [TeamWorkspaceController::class, 'removeMember'])->name('team.members.remove');
    Route::post('/my-team/profile', [TeamWorkspaceController::class, 'updateProfile'])->name('team.profile.update');

    // دعوات الفريق ورمز الانضمام
    Route::post('/my-team/{team}/invitations', [TeamInvitationController::class, 'send'])->name('team.invitations.send');
    Route::delete('/my-team/{team}/invitations/{invitation}', [TeamInvitationController::class, 'cancel'])->name('team.invitations.cancel');
    Route::get('/my-team/invitations/accept/{token}', [TeamInvitationController::class, 'accept'])->name('team.invitations.accept');
    Route::post('/my-team/join-by-code', [TeamInvitationController::class, 'joinByCode'])->name('team.join.code');

    // مهام ومراحل الفريق
    Route::post('/my-team/{team}/tasks', [TeamTaskController::class, 'store'])->name('team.tasks.store');
    Route::patch('/my-team/{team}/tasks/{task}/status', [TeamTaskController::class, 'updateStatus'])->name('team.tasks.status');
    Route::delete('/my-team/{team}/tasks/{task}', [TeamTaskController::class, 'destroy'])->name('team.tasks.destroy');

    // 3. Global Search Hub (البحث الشامل والتنقل السريع في النظام)
    Route::get('/global-search', [GlobalSearchController::class, 'index'])->name('global.search');

    // 4. System Lookups (إدارة القوائم المساعدة والترميز والعملات)
    Route::middleware('permission:lookups.manage')->group(function () {
        Route::get('/lookups', [LookupController::class, 'index'])->name('lookups.index');

        // Units & Departments
        Route::post('/lookups/units', [LookupController::class, 'storeUnit'])->name('lookups.units.store');
        Route::put('/lookups/units/{unit}', [LookupController::class, 'updateUnit'])->name('lookups.units.update');
        Route::delete('/lookups/units/{unit}', [LookupController::class, 'destroyUnit'])->name('lookups.units.destroy');

        // Governorates & Locations
        Route::post('/lookups/governorates', [LookupController::class, 'storeGovernorate'])->name('lookups.governorates.store');
        Route::put('/lookups/governorates/{governorate}', [LookupController::class, 'updateGovernorate'])->name('lookups.governorates.update');
        Route::delete('/lookups/governorates/{governorate}', [LookupController::class, 'destroyGovernorate'])->name('lookups.governorates.destroy');

        // Currencies & Exchange Rates
        Route::post('/lookups/currencies', [LookupController::class, 'storeCurrency'])->name('lookups.currencies.store');
        Route::put('/lookups/currencies/{currency}', [LookupController::class, 'updateCurrency'])->name('lookups.currencies.update');
        Route::delete('/lookups/currencies/{currency}', [LookupController::class, 'destroyCurrency'])->name('lookups.currencies.destroy');
    });

    // 5. Users Management (إدارة المستخدمين والحسابات)
    Route::middleware('permission:users.manage')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
        Route::patch('/users/{user}/permissions', [UserController::class, 'updatePermissions'])->name('users.updatePermissions');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // 6. Roles & Permissions Management (مركز الأدوار ومصفوفة الصلاحيات)
    Route::middleware('permission:roles.manage')->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
        Route::post('/roles/matrix', [RoleController::class, 'syncMatrix'])->name('roles.matrix.sync');
    });

    // 7. Audit Log & Security (سجل التدقيق والأمان)
    Route::middleware('permission:audit.view')->group(function () {
        Route::get('/audit', [AuditLogController::class, 'index'])->name('audit.index');
        Route::delete('/audit/bulk-destroy', [AuditLogController::class, 'destroyBulk'])->name('audit.bulkDestroy')->middleware('permission:audit.delete');
        Route::delete('/audit/{activity}', [AuditLogController::class, 'destroy'])->name('audit.destroy')->middleware('permission:audit.delete');
    });

    // 8. Database & Project Backups (إدارة النسخ الاحتياطي)
    Route::middleware('permission:backups.manage')->group(function () {
        Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
        Route::post('/backups', [BackupController::class, 'store'])->name('backups.store');
        Route::post('/backups/full', [BackupController::class, 'storeFullBackup'])->name('backups.storeFull');
        Route::post('/backups/upload', [BackupController::class, 'uploadBackup'])->name('backups.upload');
        Route::get('/backups/{filename}/download', [BackupController::class, 'download'])->name('backups.download');
        Route::post('/backups/{filename}/restore', [BackupController::class, 'restore'])->name('backups.restore');
        Route::delete('/backups-bulk-delete', [BackupController::class, 'bulkDestroy'])->name('backups.bulkDestroy');
        Route::delete('/backups/{filename}', [BackupController::class, 'destroy'])->name('backups.destroy');
    });

    // 9. Trash & Soft Deletes (سلة المهملات والمحذوفات)
    Route::middleware('permission:trash.manage|users.manage|lookups.manage')->group(function () {
        Route::get('/trash', [TrashController::class, 'index'])->name('trash.index');
        Route::post('/trash/{type}/bulk-restore', [TrashController::class, 'bulkRestore'])->name('trash.bulkRestore');
        Route::post('/trash/{type}/bulk-force-destroy', [TrashController::class, 'bulkForceDestroy'])->name('trash.bulkForceDestroy');
        Route::post('/trash/{type}/empty', [TrashController::class, 'emptyTrash'])->name('trash.empty');
        Route::post('/trash/{type}/{id}/restore', [TrashController::class, 'restore'])->name('trash.restore');
        Route::delete('/trash/{type}/{id}/force-destroy', [TrashController::class, 'forceDestroy'])->name('trash.forceDestroy');
    });

    // 10. Profile (الملف الشخصي)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
