<?php

use App\Http\Controllers\WebscrapeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/home', function(){
	return view('welcome');
});

Route::get('/', [WebscrapeController::class,'index']);

Route::post('/requestapi', [WebscrapeController::class,'requestapi']);
