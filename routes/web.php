<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TripayCallbackController;
use App\Http\Controllers\UserController;
use App\Mail\DonationSucceed;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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

if (env('APP_ENV') === 'production') {
    Route::get('/images/{filePath?}', function ($filePath) {
        return response()->file(Storage::path("images/$filePath"));
    })->where('filePath', '(.*)');
}

Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth
Route::get('/daftar', [AuthController::class, 'viewRegister'])->name('register');
Route::get('/masuk', [AuthController::class, 'viewLogin'])->name('login');
Route::post('/daftar', [AuthController::class, 'register']);
Route::post('/masuk', [AuthController::class, 'login']);
Route::post('/keluar', [AuthController::class, 'logout'])->name('logout');

// Campaign
Route::put('/campaigns/{id}/bukti/gambar', [CampaignController::class, 'addImagesProof']);
Route::put('/campaigns/{id}/bukti/komentar', [CampaignController::class, 'addCommentProof']);
Route::get('/campaigns/{id}/submitted', [CampaignController::class, 'submitted'])->name('campaigns.submitted');
Route::get('/campaigns/{id}/payment', [CampaignController::class, 'payment'])->name('payment');
Route::post('/campaigns/{id}/pay', [CampaignController::class, 'pay'])->name('pay');
Route::get('/campaigns/{id}/paid', [CampaignController::class, 'paid'])->name('paid');
Route::resource('campaigns', CampaignController::class)->parameters([
    'campaigns' => 'id',
]);

// User
Route::get('/user/campaigns', [UserController::class, 'campaigns'])->name('my-campaigns');
Route::get('/user/profile', [UserController::class, 'profile'])->name('profile');
Route::patch('/user/profile', [UserController::class, 'updateProfile'])->name('update-profile');

Route::get('/admin', function () {
    return redirect()->route('admin-campaigns');
});
Route::get('/admin/campaigns', [AdminController::class, 'campaigns'])->name('admin-campaigns');
Route::patch('/admin/campaigns/{id}/acceptance', [AdminController::class, 'acceptance'])->name('campaign-acceptance');
Route::get('/admin/campaigns/{id}', [AdminController::class, 'showCampaign'])->name('admin-show-campaign');

Route::get('/donation/{id}', [DonationController::class, 'show'])->name('donation.show');

Route::post('/tripay/handle', [TripayCallbackController::class, 'handle']);

// Route::get('/tes-email', function () {
//     Mail::to('testing@gmail.com')->send(new DonationSucceed(DB::table('donasi')->where('id', '42451cf0-b05d-49cf-9194-d925d5dfb66d')->first()));

//     return "Email";
// });

// Route::get('/createAdmin', function () {
//     User::create([
//         'nama' => 'admin',
//         'email' => 'admin@test.com',
//         'password' => bcrypt('admin'),
//         'admin' => true
//     ]);
// });
