<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/',[WelcomeController::class,'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/home','HomeController@index')->name('home');
    //To update my profile
    Route::get('/showprofile',[HomeController::class,'profile'])->name('profile');
    Route::post('/saveProfile',[HomeController::class,'saveProfile'])->name('saveprofile');
    //To create and see my blog after login
    Route::get('/shout',[HomeController::class,'shoutHome'])->name('shout');
    Route::post('/saveStatus',[HomeController::class,'saveStatus'])->name('shout.save');
    ///To see blog of a individual person
    Route::get('/shout/{nickname}',[HomeController::class,'publicTimeline'])->name('shout.public');
    //To make friend and unfriend
    Route::get('/shout/makefriend/{friendId}',[HomeController::class,'makeFriend'])->name('shout.makefriend');
    Route::get('/shout/unfriend/{friendId}',[HomeController::class,'unFriend'])->name('shout.unfriend');
    //Auth routes by default
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
