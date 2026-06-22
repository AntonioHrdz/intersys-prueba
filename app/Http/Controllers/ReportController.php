<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;

class ReportController extends Controller
{
    public function generateMonthlyPdf()
    {
        try {
            $startOfMonth = Carbon::now()->startOfMonth()->toDateTimeString();
            $endOfMonth = Carbon::now()->endOfMonth()->toDateTimeString();

            DB::statement("
                CREATE TEMPORARY TABLE tmp_sales_summary (
                    product_id INT,
                    product_name VARCHAR(255),
                    total_quantity INT,
                    total_revenue DECIMAL(10, 2)
                )
            ");

            DB::statement("
                INSERT INTO tmp_sales_summary (product_id, product_name, total_quantity, total_revenue)
                SELECT 
                    p.id, 
                    p.name, 
                    SUM(s.quantity) as total_quantity, 
                    SUM(s.total_price) as total_revenue
                FROM products p
                INNER JOIN sales s ON p.id = s.product_id
                WHERE s.sale_date BETWEEN ? AND ?
                GROUP BY p.id, p.name
            ", [$startOfMonth, $endOfMonth]);

            $reportData = DB::select("SELECT * FROM tmp_sales_summary");

            $grandQuantity = array_sum(array_column($reportData, 'total_quantity'));
            $grandRevenue = array_sum(array_column($reportData, 'total_revenue'));

            $meta = [
                'date' => Carbon::now()->format('d/m/Y H:i'),
                'month' => Carbon::now()->locale('es')->monthName,
                'year' => Carbon::now()->year,
                'grand_quantity' => $grandQuantity,
                'grand_revenue' => $grandRevenue
            ];

            $pdf = Pdf::loadView('monthly_pdf', compact('reportData', 'meta'));
            
            return $pdf->download("Reporte_Ventas_" . $meta['month'] . ".pdf");

        } catch (Exception $e) {
            return response()->json(['error' => 'Error al procesar el reporte: ' . $e->getMessage()], 500);
        } finally {
            DB::statement("DROP TEMPORARY TABLE IF EXISTS tmp_sales_summary");
        }
    }
}
