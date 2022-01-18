<?php

use App\Helper\ManualEvent;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RegisterPassengerController;
use App\Http\Controllers\Auth\RegisterDriverController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CustomeStoreReserveController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\DriverPublicController;
use App\Http\Controllers\MassegeController;
use App\Http\Controllers\MessagePublicController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\PassengerHomeController;
use App\Http\Controllers\PassengerPublicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicNotificationController;
use App\Http\Controllers\PublicRideController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\RideController;
use App\Http\Controllers\UsersRequestsController;
use App\Http\Controllers\welcomeController;
use Illuminate\Support\Facades\DB;

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

if (\App\Models\Admin::first() == null) {
    ManualEvent::generateAdmin();
}

// public routes
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

// passenger
Route::get('/register_passenger', [RegisterPassengerController::class, 'index'])->name('registerpassenger');
Route::post('/register_passenger', [RegisterPassengerController::class, 'store']);

// driver
Route::get('/registerdriver', [RegisterDriverController::class, 'index'])->name('registerdriver');
Route::post('/register_driver', [RegisterDriverController::class, 'store'])->name('driver_store');


// only authenticated users
Route::group(['middleware' => 'auth'], function () {

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [welcomeController::class, 'welcome'])->name('dashboard');

    Route::get('/my_notifications', [PublicNotificationController::class, 'getMyNotification'])->name('notification_view');
    Route::get('/show_notification/{id}', [PublicNotificationController::class, 'showNotification'])->name('notification_show');

    Route::resource('profile', ProfileController::class);
    Route::resource('ride', RideController::class)->except('index')->middleware('driver.ware');
    Route::resource('reserve', ReserveController::class)->except('index')->middleware('passenger.ware');

    // messages
    Route::resource('message', MassegeController::class);
    Route::get('/send/message/{id}', [MessagePublicController::class, 'message'])->name('make.message');

    // driver stuff
    Route::group(['middleware' => 'driver.ware'], function () {
        Route::get('/driver/schedule', [DriverPublicController::class, 'driverSchedule'])->name('driver_schedule');
        Route::get('/driver/cars', [DriverPublicController::class, 'myCars'])->name('my_cars');
        Route::get('/driver/report/rides', [DriverPublicController::class, 'myRidesReport'])->name('report.my_rides');
        Route::get('/driver/car/create', [CarController::class, 'create'])->name('driver.car.create');
        Route::post('/driver/car/store', [CarController::class, 'store'])->name('driver.car.store');
        Route::get('/driver/car/{car}/edit', [CarController::class, 'edit'])->name('driver.car.edit');
        Route::put('/driver/car/update/{car}', [CarController::class, 'update'])->name('driver.car.update');
        Route::delete('/driver/car/destroy/{car}', [CarController::class, 'destroy'])->name('driver.car.destroy');
    });

    // passenger stuff
    Route::group(['middleware' => 'passenger.ware'], function () {
        Route::post('/reserve/post', [CustomeStoreReserveController::class, 'store']);
        Route::post('/reserve/{id}/update', [CustomeStoreReserveController::class, 'update']);
        Route::get('/passenger/schedule', [PassengerPublicController::class, 'passengerSchedule'])->name('passenger_schedule');
        Route::get('/passenger/report/reserves', [PassengerPublicController::class, 'myReservesReport'])->name('report.my_reserves');
    });

    // admin stuff
    Route::group(['middleware' => 'admin.ware'], function () {
        Route::resource('passenger', PassengerController::class);
        Route::resource('driver', DriverController::class);

        Route::resource('car', CarController::class);

        Route::get('/ride', [RideController::class, 'index'])->name('ride.index');
        Route::delete('/ride/delete', [PublicRideController::class, 'destroy'])->name('ride_destroy');
        Route::get('/reserve', [ReserveController::class, 'index'])->name('reserve.index');

        // request
        Route::get('/requests/passenger', [UsersRequestsController::class, 'passengersRequests'])->name('passengers.requests.index');
        Route::get('/requests/driver', [UsersRequestsController::class, 'driverRequests'])->name('drivers.requests.index');
        Route::get('/requests/car', [UsersRequestsController::class, 'carRequests'])->name('cars.requests.index');

        // confirm requests
        Route::post('/requests/passenger', [UsersRequestsController::class, 'acceptPassengersRequests'])->name('passengers.requests.post');
        Route::post('/requests/driver', [UsersRequestsController::class, 'acceptDriverRequests'])->name('drivers.requests.post');
        Route::post('/requests/car', [UsersRequestsController::class, 'acceptCarRequests'])->name('cars.requests.post');
    });

    Route::get('/homepassenger', [PassengerHomeController::class, 'index'])->name('homepassenger');
    Route::post('/homepassenger', [PassengerHomeController::class, 'store']);
});

Route::get('/register', [RegisterController::class, 'index'])->name('register');
