<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct()
    {
    }

    public function getProducts()
    {
        $products = Product::whereNull('data_deleted')->get();

        return response()->json($products);
    }

    public function registerProduct(Request $request)
    {
        $validatedData = $request->validate([
            'codigo' => 'required|string|max:100',
            'descricao' => 'required|string|max:100',
            'valor' => 'required|string|max:100',
            'fornecedor' => 'required|string|max:100',
        ]);

        $product = Product::create($validatedData);

        return response()->json($product);
    }

    public function updateProduct(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'codigo' => 'required|string|max:100',
            'descricao' => 'required|string|max:100',
            'valor' => 'required|string|max:100',
            'fornecedor' => 'required|string|max:100',
        ]);

        $product = Product::findOrFail($validatedData['id']);
        $product->update($validatedData);

        return response()->json($product);
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['data_deleted' => now()->toDateString()]);

        return response()->json(['message' => 'Produto marcado como excluído com sucesso']);
    }
}
