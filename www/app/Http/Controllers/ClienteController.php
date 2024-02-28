<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use App\Models\Transacao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClienteController extends Controller
{

    public function index(): JsonResponse
    {
        $clientes = Cliente::all();
        return response()->json($clientes, Response::HTTP_OK);
    }


    public function store(ClienteRequest $request): JsonResponse
    {
        $cliente = Cliente::create($request->validated());
        return response()->json($cliente, Response::HTTP_CREATED);
    }


    public function show(int $id): JsonResponse
    {
        try {
            $cliente = Cliente::findOrFail($id);
        }
        catch (ModelNotFoundException $e) {
            return response()->json(["message"=> "Cliente não encontrado"], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            "nome" => $cliente->nome,
            "saldo" => $cliente->saldo
        ], Response::HTTP_OK);
    }

    public function extrato(int $id): JsonResponse {

        try {
            $cliente = Cliente::findOrFail($id);
        }
        catch (ModelNotFoundException $e) {
            return response()->json(["message"=> "Cliente não encontrado"], Response::HTTP_NOT_FOUND);
        }

        $transacoes = Transacao::where('cliente_id', $id)->limit(10)->get(['valor', 'tipo', 'descricao', 'realizada_em']);

        return response()->json([
            "saldo" => [
                "total" => $cliente->saldo,
                "data_extrato" => now(),
                "limite" => $cliente->limite
            ],
            "transacoes" => $transacoes
        ], Response::HTTP_OK);
    }


}
