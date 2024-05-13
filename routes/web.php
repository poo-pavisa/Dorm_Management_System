<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\InvoiceController;

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


Route::get('/', [HomeController::class, 'home'])
->name('index');

Route::get('/home', [HomeController::class, 'index'])
->name('home');

// Bank Account
Route::get('/information', [HomeController::class, 'information'])
->name('information');


// Rooms
Route::get('/all_room', [HomeController::class, 'all_room'])
->name('all_room');

Route::get('/room_detail/{id}', [HomeController::class,'room_detail'])
->where('id', '[0-9]+')
->name('room_detail');


// Booking
Route::get('/all_booking', [HomeController::class, 'all_booking'])
->name('all_booking');

Route::get('/add_booking/{id}', [BookingController::class,'booking_room'])
->where('id', '[0-9]+')
->name('booking_room');

Route::post('/add_booking/{id}', [BookingController::class,'add_booking'])
->where('id', '[0-9]+')
->name('add_booking');

Route::get('/edit_booking/{id}', [BookingController::class,'edit_booking'])
->where('id', '[0-9]+')
->name('edit_booking');

Route::post('/update_booking/{id}', [BookingController::class,'update_booking'])
->where('id', '[0-9]+')
->name('update_booking');

Route::get('/cancel_booking/{id}', [BookingController::class,'cancel_booking'])
->where('id', '[0-9]+')
->name('cancel_booking');

Route::get('/payment_form/{id}', [BookingController::class,'payment_form'])
->where('id', '[0-9]+')
->name('payment_form');

Route::post('/payment_booking/{id}', [BookingController::class,'payment_booking'])
->where('id', '[0-9]+')
->name('payment_booking');

// Service Request
Route::get('/all_request', [RequestController::class, 'all_request'])
->name('all_request')
->middleware(['auth', 'check_tenant']);

Route::get('/request_form', [RequestController::class, 'request_form'])
->name('request_form')
->middleware(['auth', 'check_tenant']);

Route::post('/add_request', [RequestController::class,'add_request'])
->where('id', '[0-9]+')
->name('add_request')
->middleware(['auth', 'check_tenant']);

Route::get('/delete_request/{id}', [RequestController::class, 'delete_request'])
->where('id', '[0-9]+')
->name('delete_request')
->middleware(['auth', 'check_tenant']);

Route::get('/detail_request/{id}', [RequestController::class, 'detail_request'])
->where('id', '[0-9]+')
->name('detail_request')
->middleware(['auth', 'check_tenant']);

// Announcement
Route::get('/announcement', [PostController::class, 'announcement'])
->name('announcement')
->middleware(['auth', 'check_tenant']);


Route::post('/add_comment/{id}', [PostController::class,'add_comment'])
->where('id', '[0-9]+')
->name('add_comment')
->middleware(['auth', 'check_tenant']);

Route::get('/delete_comment/{id}', [PostController::class, 'delete_comment'])
->name('delete_comment')
->where('id', '[0-9]+')
->middleware(['auth', 'check_tenant']);


// Invoice
Route::get('/all_invoice', [InvoiceController::class, 'index'])
->name('all_invoice')
->middleware(['auth', 'check_tenant']);

Route::get('/invoice_detail/{id}', [InvoiceController::class,'invoice_detail'])
->where('id', '[0-9]+')
->name('invoice_detail')
->middleware(['auth', 'check_tenant']);

Route::get('/form_payment/{id}', [InvoiceController::class,'form_payment'])
->where('id', '[0-9]+')
->name('form_payment')
->middleware(['auth', 'check_tenant']);

Route::post('/payment_invoice/{id}', [InvoiceController::class,'payment_invoice'])
->where('id', '[0-9]+')
->name('payment_invoice')
->middleware(['auth', 'check_tenant']);

// PDF
Route::get('generate-pdf/{id}', [InvoiceController::class, 'generatePDF'])
->where('id', '[0-9]+')
->name('generate-pdf');

Route::get('download-pdf/{id}', [HomeController::class, 'DownloadContract'])
->where('id', '[0-9]+')
->name('download-contract');





// // POST
// Route::resource('posts', PostController::class);

