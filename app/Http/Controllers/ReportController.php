<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $products = Product::query()->latest()->limit(8)->get();

        return view('reports.index', [
            'products' => $products,
            'productCount' => Product::count(),
            'unitCount' => Product::sum('quantity'),
            'inventoryValue' => Product::query()->sum(DB::raw('price * quantity')),
            'lowStockCount' => Product::where('quantity', '<', 10)->count(),
        ]);
    }

    public function dataTable(): View
    {
        $products = Product::query()->latest()->paginate(20)->withQueryString();

        return view('reports.data-table', compact('products'));
    }
}
