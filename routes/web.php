<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\InvoiceAttachmentController;
use App\Http\Controllers\invoice_Archives_Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Invoices_Reports;
use App\Http\Controllers\Customer_Reports;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\two_factorController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [HomeController::class , 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile_show', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update_profile'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('/tow_factor',two_factorController::class);

Route::resource('/section',SectionController::class);

Route::resource('/Invoices',InvoiceController::class);

Route::resource('/products',ProductController::class);

Route::get('/get_products/{id}',[InvoiceController::class , 'get_products']);

Route::get('/open_file/{invoice_number}/{file_name}',[InvoiceAttachmentController::class,'show_file']);

Route::get('/download_file/{invoice_number}/{file_name}',[InvoiceAttachmentController::class,'download']);

Route::post('/delete_file',[InvoiceAttachmentController::class,'delete_file'])->name('delete_file');

Route::get('/invoice_details/{id}',[InvoiceDetailsController::class , 'index']);

Route::get('/Archive_invoice_details/{id}',[InvoiceDetailsController::class , 'Archive_invoice_details']);

Route::resource('/invoice_attahment',InvoiceAttachmentController::class);

Route::get('edit_invoice/{id}',[InvoiceController::class , 'edit']);

Route::get('show_status/{id}',[InvoiceController::class , 'show'])->name('Show_status');

Route::post('status_update/{id}',[InvoiceController::class , 'status_update'])->name('Update_Status');

Route::get('/Paid_invoices',[InvoiceController::class , 'Paid_invoices']);

Route::get('/Unpaid_bills',[InvoiceController::class , 'Unpaid_bills']);

Route::get('/Partially_paid_bills',[InvoiceController::class , 'Partially_paid_bills']);

Route::resource('invoice_Archives',invoice_Archives_Controller::class);

Route::get('print_invoice/{id}',[InvoiceController::class , 'Print_Invoice']);

Route::group(['middleware' => ['auth']] , function(){
    Route::resource('roles',RoleController::class);
    Route::resource('users',UserController::class);
});

Route::post('/upload_file_owner',[UserController::class , 'Upload_file_owner']);

Route::get('invoices_reports',[Invoices_Reports::class , 'index']);

Route::post('search_invoices',[Invoices_Reports::class , 'Search_Invoices']);

Route::get('/customer_reports',[Customer_Reports::class , 'index']);

Route::post('/search_customer',[Customer_Reports::class , 'Search_customer']);

Route::get('Mark_As_Read_All',[InvoiceController::class , 'Mark_Read'])->name('mark_read_all');

require __DIR__.'/auth.php';

// -------------------------------------------------------
Route::get('/{page}', [AdminController::class , 'index']);
// -------------------------------------------------------

