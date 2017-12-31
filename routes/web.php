<?php
use Carbon\Carbon;
use App\Property;
use App\Payment;
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

Route::get('/', 'HomeController@index');

//--Properties
Route::get('/properties', 'PropController@index');
Route::get('/properties/add', 'PropController@create');
Route::post('/properties/add', 'PropController@store')->name('prop-store');
Route::post('/properties/{id}/edit', 'PropController@update')->name('prop-update')->where('id', '^[0-9]*$');
Route::post('/properties/{id}/editfile', 'PropController@updateFile')->name('prop-file-update')->where('id', '^[0-9]*$');
Route::get('/properties/{id}', 'PropController@show')->where('id', '^[0-9]*$');
Route::post('/properties/{id}/delete', 'PropController@destroy')->name('prop-delete');
Route::post('/properties/{id}/furnitures/add', 'PropController@furnStore')->name('prop-furn-store')->where('id', '^[0-9]*$');
Route::post('/properties/{id}/furnitures/delete', 'PropController@furnDestroy')->name('prop-furn-delete')->where('id', '^[0-9]*$');
Route::post('/properties/{id}/furnitures/update', 'PropController@furnUpdate')->name('prop-furn-update')->where('id', '^[0-9]*$');

//--Drawings
Route::post('/properties/{id}/drawings/add', 'DrawController@store')->name('draw-store')->where('id', '^[0-9]*$');
Route::post('/properties/{id}/drawings/delete', 'DrawController@destroy')->name('draw-delete')->where('id', '^[0-9]*$');

//--Furnitures
Route::get('/furnitures', 'FurController@index');
Route::post('/furnitures/add', 'AjaxController@storeFurn');
Route::post('/furnitures/delete', 'AjaxController@deleteFurn');
Route::post('/furnitures/update', 'AjaxController@updateFurn');

//--Renters
Route::get('/renters', 'RenterController@index');
Route::get('/renters/add', 'RenterController@create');
Route::post('/renters/add', 'RenterController@store')->name('renter-store');
Route::get('/renters/{id}', 'RenterController@show')->where('id', '^[0-9]*$');
Route::post('/renters/{id}/update', 'RenterController@update')->name('renter-update')->where('id', '^[0-9]*$');
Route::post('/renters/{id}/delete', 'RenterController@destroy')->name('renter-delete')->where('id', '^[0-9]*$');

//--Owners
Route::get('/users', 'UserController@index');
Route::get('/users/add', 'UserController@create');
Route::post('/users/add', 'UserController@store')->name('user-store');
Route::post('/users/addAdmin', 'UserController@storeAdmin')->name('admin-store');
Route::get('/users/{id}', 'UserController@show')->where('id', '^[0-9]*$');
Route::post('/users/{id}/update', 'UserController@update')->name('user-update')->where('id', '^[0-9]*$');
Route::post('/users/{id}/delete', 'UserController@destroy')->name('user-delete')->where('id', '^[0-9]*$');

//--Payment
Route::post('/payment/{id}/add', 'PaymentController@update')->name('pay-update')->where('id', '^[0-9]*$');
Route::post('/payment/{id}/store', 'PaymentController@store')->name('pay-store')->where('id', '^[0-9]*$');
Route::post('/payment/{id}/batch', 'PaymentController@batch')->name('pay-batch')->where('id', '^[0-9]*$');
Route::post('/payment/{id}/update', 'PaymentController@change')->name('pay-change')->where('id', '^[0-9]*$');
Route::post('/payment/{id}/send', 'PaymentController@send')->name('send-invoice')->where('id', '^[0-9]*$');
Route::get('/payments/{id}', 'PaymentController@index')->where('id', '^[0-9]*$');
Route::get('/payments/{id}/search', 'PaymentController@search')->name('pay-search')->where('id', '^[0-9]*$');
Route::post('/payments/{id}/delete', 'PaymentController@destroy')->name('pay-delete')->where('id', '^[0-9]*$');
Route::get('invoice', 'PaymentController@invoice');

//--AJAX
Route::post('/get-pending-payments', 'AjaxController@getPendingPayment');

//--Maintenance
Route::get('/maintenance/{id}', 'LogsController@show')->where('id', '^[0-9]*$');
Route::post('/maintenance/{id}/close', 'LogsController@close')->name('log-close')->where('id', '^[0-9]*$');
Route::post('/maintenance/{id}/open', 'LogsController@open')->name('log-open')->where('id', '^[0-9]*$');
Route::get('/maintenance/{id}/search', 'LogsController@search')->name('log-search')->where('id', '^[0-9]*$');
Route::get('/maintenance/{id}/add', 'LogsController@create')->where('id', '^[0-9]*$');
Route::post('/maintenance/{id}/add', 'LogsController@store')->name('log-store')->where('id', '^[0-9]*$');
Route::get('/maintenance/{id}/update', 'LogsController@edit')->where('id', '^[0-9]*$');
Route::post('/maintenance/{id}/update', 'LogsController@update')->name('log-update')->where('id', '^[0-9]*$');
Route::post('/maintenance/{id}/delete', 'LogsController@destroy')->name('log-delete')->where('id', '^[0-9]*$');

Route::get('/maintenance-closed/{id}', 'LogsController@showClosed')->where('id', '^[0-9]*$');

//--Progress
Route::get('/maintenance/{id}/progress', 'ProgController@index')->where('id', '^[0-9]*$');
Route::post('/maintenance/{id}/progress/add', 'ProgController@store')->name('prog-store')->where('id', '^[0-9]*$');
Route::post('/maintenance/{id}/progress/delete', 'ProgController@destroy')->name('prog-delete')->where('id', '^[0-9]*$');
Route::post('/maintenance/{id}/progress/update', 'ProgController@update')->name('prog-update')->where('id', '^[0-9]*$');

//--Invoice
Route::get('/maintenance/{id}/invoice', 'InvoiceController@index')->where('id', '^[0-9]*$');
Route::post('/maintenance/{id}/invoice/add', 'InvoiceController@store')->name('invoice-store')->where('id', '^[0-9]*$');
Route::post('/maintenance/{id}/invoice/delete', 'InvoiceController@destroy')->name('invoice-delete')->where('id', '^[0-9]*$');
Route::post('/maintenance/{id}/invoice/update', 'InvoiceController@update')->name('invoice-update')->where('id', '^[0-9]*$');

//--Guarantee
Route::get('/guarantees/{id}', 'GuaranteeController@index')->where('id', '^[0-9]*$');
Route::post('/guarantees/{id}/store', 'GuaranteeController@store')->name('guarantee-store')->where('id', '^[0-9]*$');
Route::post('/guarantees/{id}/update', 'GuaranteeController@update')->name('guarantee-update')->where('id', '^[0-9]*$');
Route::post('/guarantees/{id}/delete', 'GuaranteeController@destroy')->name('guarantee-delete')->where('id', '^[0-9]*$');

//--Expense
Route::get('/expenses/{id}', 'ExpenseController@index')->where('id', '^[0-9]*$');
Route::post('/expenses/{id}/store', 'ExpenseController@store')->name('expense-store')->where('id', '^[0-9]*$');
Route::post('/expenses/{id}/update', 'ExpenseController@update')->name('expense-update')->where('id', '^[0-9]*$');
Route::post('/expenses/{id}/delete', 'ExpenseController@destroy')->name('expense-delete')->where('id', '^[0-9]*$');

//--Settings
Route::get('/settings','AppController@index');
Route::post('/settings/update', 'AppController@update')->name('setting-update');

Route::get('test',function(){
	$data = [];
	$data['to'] = Carbon::createFromFormat('Y-m-d',date('Y').'-'.date('m').'-1');
    $data['from'] = Carbon::createFromFormat('Y-m-d',date('Y').'-'.date('m').'-1')->subMonths(5);
    dd($data);
});

//--Act
Route::get('/act','ActController@index');

//--Admins

Route::get('/admins','UserController@admins');
Route::get('/passwords','UserController@passwords');

Auth::routes();