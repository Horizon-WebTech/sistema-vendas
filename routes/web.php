<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\ProdutoVendaController;
use App\Http\Controllers\ParcelaController;
use App\Models\ProdutoVenda;

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

Route::resource('clientes', ClienteController::class);
Route::resource('produtos', ProdutoController::class);
Route::resource('vendas', VendaController::class);


Route::post('produtos_venda', [ProdutoVendaController::class, 'store'])->name('produtos_venda.store');
Route::post('parcelas', [ParcelaController::class, 'store'])->name('parcelas.store');
