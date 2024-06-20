<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;

class SalesController extends Controller
{
    public function __construct()
    {
    }

    public function getClientSales()
    {
        $clients = Client::whereNull('data_deleted')->get();

        return response()->json($clients);
    }

    public function getProductsSales()
    {
        $products = Product::whereNull('data_deleted')->get();

        return response()->json($products);
    }

    public function registerSales(Request $request)
    {
        $validatedData = $request->validate([
            'cliente' => 'required|string|max:255',
            'tipoPagamento' => 'required|string|max:100',
            'valorIntegral' => 'required|string|max:100',
            'vendedor' => 'required|string|max:100',
            'produto' => 'required|string|max:100',
            'quantidade' => 'required|string|max:100',
            'valorUnitario' => 'required|string|max:255',
        ]);

        $sale = Sale::create($validatedData);

        return response()->json($sale);
    }
}
