<?php

use App\Http\Controllers\CronjobController;
use App\Http\Controllers\Finance\CollectFeesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Rams\RamsController;
use App\Http\Controllers\School\AttendanceController;
use App\Http\Controllers\School\DeviceController;
use App\Http\Controllers\School\FinanceController;

Route::any("dompdf", [CollectFeesController::class, 'domPdf'])->middleware("auth:schools");
Route::post("update/device-conected-users", [AttendanceController::class, 'updateDeviceConnectedUserList'])->middleware("auth:schools");

/** cronjob for attendance */
Route::get('cron-job/present', [CronjobController::class, 'callAttendance']);
Route::get('cron-job/absent', [CronjobController::class, 'sendAbsentSmsToPhone']);

/** ---------- upload attendance (SHAHIDUL)
 * =========================================================*/
Route::middleware(['auth:schools', 'language'])
    ->group(function () {
        Route::get("school/attendance/auto/setting", [DeviceController::class, 'autoAttendanceSettings'])->name('auto.attendance');
        Route::post("school/attendance/auto/setting", [DeviceController::class, 'storeAutoAttendanceSettings'])->name('auto.attendance.save');
        Route::get("school/attendance/new/user", [DeviceController::class, 'addNewUserToDevice'])->name('new.user.fingerprint');

        Route::get("school/attendance/input", [AttendanceController::class, 'inputAttendance'])->name('input.attendance');
        Route::get("school/attendance/get-data", [AttendanceController::class, 'inputAttendanceGet'])->name('input.attendance.get');
        Route::post("school/attendance/input", [AttendanceController::class, 'saveInputAttendance'])->name('input.attendance.save');

        Route::post("school/attendance/class/absent/sms", [AttendanceController::class, 'classSelectForAbsentSMS'])->name('classSelect.absent.sms');
    });

/** ========================= upload attendance ==================== */
