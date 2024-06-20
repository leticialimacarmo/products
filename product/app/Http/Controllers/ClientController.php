<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client; 

class ClientController extends Controller
{
    public function __construct()
    {
    }

    public function getClients()
    {
        $clients = Client::whereNull('data_deleted')->get();

        return response()->json($clients);
    }

    public function registerClient(Request $request)
    {
        $validatedData = $request->validate([
            'nomeFantasia' => 'required|string|max:100',
            'razaoSocial' => 'required|string|max:100',
            'cpf' => 'required|string|max:100',
            'cidade' => 'required|string|max:100',
        ]);

        $client = Client::create($validatedData);

        return response()->json($client);
    }

    public function updateClient(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'nomeFantasia' => 'required|string|max:100',
            'razaoSocial' => 'required|string|max:100',
            'cpf' => 'required|string|max:100',
            'cidade' => 'required|string|max:100',
        ]);

        $client = Client::findOrFail($validatedData['id']);
        $client->update($validatedData);

        return response()->json($client);
    }

    public function deleteClient($id)
    {
        $client = Client::findOrFail($id);
        $client->update(['data_deleted' => now()->toDateString()]);

        return response()->json(['message' => 'Cliente marcado como excluído com sucesso']);
    }
}
