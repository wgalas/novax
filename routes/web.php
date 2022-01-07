<?php

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailVerifyController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Hash;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'registrationPage']);
    Route::get('/register-employer', [RegisterController::class, 'employerRegistrationPage']);
    Route::post('/register', [RegisterController::class, 'postRegister']);
    Route::post('/register-employer', [RegisterController::class, 'postEmployerRegister']);

    Route::get('/login', [LoginController::class, 'loginPage'])->name('login');
    Route::post('/login', [LoginController::class, 'postLogin']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->middleware('auth');
    Route::get('/logout', [LoginController::class, 'logout']);

    //resume
    Route::post('/resume', [ResumeController::class, 'submitResume']);

    //browser
    Route::get('/jobs', [JobController::class, 'browse']);
    Route::post('/applications', [JobController::class, 'submitApplication']);

    //notifications
    Route::get('/notifications', [NotificationController::class, 'showNotification']);
    Route::post('/notifications/{id}', [NotificationController::class, 'markAsRead']);

    //profile
    Route::get('/profile/{user}', [ProfileController::class, 'showProfile']);
    Route::post('/profile-update-picture/{user}', [ProfileController::class, 'updatePicture']);
    Route::post('/profile-save/{user}', [ProfileController::class, 'saveProfile']);


    //skills
    Route::get('/skills/{user}', [SkillController::class, 'getSkills']);
    Route::post('/skills/{user}', [SkillController::class, 'addSkill']);
    Route::delete('/skills/{user}/{id}', [SkillController::class, 'removeSkill']);

    Route::get('/chat', [ChatController::class, 'getChat']);
    Route::post('/send-verification', [EmailVerifyController::class, 'sendVerification']);
});

Route::get('/veriy-email', [EmailVerifyController::class, 'verifyEmail'])->name('verify-email');

Route::post('/check-password', function () {
    return Hash::check(request()->currentPassword, auth()->user()->password);
});

Route::post('/update-account', function () {
    $payload = [
        'mobile_number' => request()->newMobile,
        'address' => request()->newAddress,
        'school' => request()->newSchool,
    ];

    if (request()->has('newPassword')) {
        $payload['password'] = bcrypt(request()->newPassword);
    }

    return auth()->user()->update($payload);
});
