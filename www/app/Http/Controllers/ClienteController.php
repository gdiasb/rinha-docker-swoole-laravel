<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClienteController extends Controller
{

    public function index(): JsonResponse
    {
        $clientes = Cliente::all();
        return response()->json($clientes, 200);
    }


    public function store(ClienteRequest $request): JsonResponse
    {
        $cliente = Cliente::create($request->validated());
        return response()->json($cliente, 201);
    }


    public function show(int $id)
    {
        $cliente = Cliente::findorFail($id);

        return response()->json([
            "nome" => $cliente->nome,
            "saldo" => $cliente->saldo
        ], 200);
    }


}
