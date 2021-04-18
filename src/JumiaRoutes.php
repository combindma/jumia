<?php


namespace Combindma\Jumia;

use Combindma\Jumia\Http\Controllers\JumiaController;
use Illuminate\Support\Facades\Route;

class JumiaRoutes
{
    public static function routes(string $prefix = 'dash')
    {
        Route::group(['prefix' => $prefix, 'as' => 'jumia::'], function () {
            Route::get('/jumia', [JumiaController::class, 'index'])->name('jumia.index');
            Route::get('/jumia/test-api', [JumiaController::class, 'testApi'])->name('jumia.testApi');
            Route::get('/jumia/getproducts', [JumiaController::class, 'getProducts'])->name('jumia.getProducts');
            Route::get('/jumia/getproductsimages', [JumiaController::class, 'getProductsImages'])->name('jumia.getProductsImages');
            Route::get('/jumia/syncproducts', [JumiaController::class, 'syncProducts'])->name('jumia.syncProducts');
            Route::get('/jumia/syncimages', [JumiaController::class, 'syncImages'])->name('jumia.syncImages');
            Route::get('/jumia/exportproducts', [JumiaController::class, 'exportProducts'])->name('jumia.exportProducts');
        });
    }
}
