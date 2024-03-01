<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransacaoRequest;
use App\Models\Transacao;
use App\Services\TransacaoService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use App\Models\Cliente;
use Illuminate\Http\Response;

class TransacaoController extends Controller
{

    public function store(TransacaoRequest $request, int $id): JsonResponse
    {

        try {
            $cliente = Cliente::findOrFail($id);
        }
        catch (ModelNotFoundException $e) {
            return response()->json(["message"=> "Cliente não encontrado"], Response::HTTP_NOT_FOUND);
        }


        if ($request->input('tipo') === 'd') {
            TransacaoService::debito($cliente, $request->valor, $request->descricao);
        } else {
            TransacaoService::credito($cliente, $request->valor, $request->descricao);
        }

        return response()->json([
            "limite" => $cliente->limite,
            "saldo" => $cliente->saldo
        ], Response::HTTP_OK);
    }


}
