<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogoWebController;  
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

// routes/web.php
Route::prefix('')->name('catalogo.')->group(function () {
    Route::get('/', [CatalogoWebController::class, 'index'])->name('index');
    Route::get('/producto/{codArticulo}', [CatalogoWebController::class, 'show'])->name('show');
    Route::get('/buscar', [CatalogoWebController::class, 'search'])->name('search');
    Route::get('/categoria/{category}', [CatalogoWebController::class, 'category'])->name('category');
    Route::get('/estadisticas', [CatalogoWebController::class, 'getStats'])->name('stats');
    Route::get('/exportar', [CatalogoWebController::class, 'exportCatalog'])->name('export');
    //promociones 
    Route::get('/promociones', [CatalogoWebController::class, 'promociones'])->name('promociones');
    Route::get('/promociones/{id}', [CatalogoWebController::class, 'promocionDetalle'])->name('promociones.detalle');

  

    // API endpoints
    Route::get('/api/especialidad/{codEspecialidad}', [CatalogoWebController::class, 'getProductsByEspecialidad'])->name('api.especialidad');
});
// Rutas de páginas específicas


Route::get('/laboratorio', [CatalogoWebController::class, 'laboratorio'])->name('catalogo.laboratorio');
Route::get('/imagen', [CatalogoWebController::class, 'imagen'])->name('catalogo.imagen');