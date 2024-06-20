<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Carbon\Carbon;

class ListController extends Controller
{
    public function __construct()
    {
    }

    public function getList()
    {
        $sales = Sale::whereNull('data_deleted')->get();

        return response()->json(['data' =>$sales]);
    }

    public function updateList(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'cliente' => 'required|string|max:255',
            'tipoPagamento' => 'required|string|max:100',
            'valorIntegral' => 'required|string|max:100',
            'vendedor' => 'nullable|string|max:100',
            'produto' => 'nullable|string|max:100',
            'quantidade' => 'nullable|string|max:100',
            'valorUnitario' => 'nullable|string|max:255',
        ]);

        $sale = Sale::find($validated['id']);

        if (!$sale) return response()->json(['error' => 'Venda não encontrada.'], 404);


        $sale->cliente = $validated['cliente'];
        $sale->tipoPagamento = $validated['tipoPagamento'];
        $sale->valorIntegral = $validated['valorIntegral'];
        $sale->vendedor = $request->input('vendedor');
        $sale->produto = $request->input('produto');
        $sale->quantidade = $request->input('quantidade');
        $sale->valorUnitario = $request->input('valorUnitario');
        $sale->save();

        return response()->json($sale);
    }

    public function deleteList(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
        ]);

        $sale = Sale::find($validated['id']);

        $sale->data_deleted = Carbon::now();
        $sale->save();
        return response()->json(['success' => 'Venda excluída com sucesso.']);
    }
}
