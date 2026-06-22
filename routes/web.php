<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('products.index');
});

// Rutas del CRUD de productos
Route::resource('products', ProductController::class);

// Ruta para el reporte ejecutivo en PDF
Route::get('reports/monthly-pdf', [ReportController::class, 'generateMonthlyPdf'])->name('reports.pdf');
