<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransacaoRequest;
use App\Models\Transacao;
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

        $valor = $request->input('valor');
        $saldo = $cliente->saldo;

        if ($request->input('tipo') === 'd') {
            $novoSaldo = $saldo - $valor;

            if ($novoSaldo < - $cliente->limite) {
                return response()->json('Transação inválida: limite não permite', Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $cliente->update([
                'saldo' => $novoSaldo
            ]);
        }
        else {
            $cliente->update([
                'saldo' => $saldo + $valor
            ]);
        }

        $transacao = Transacao::create([
            'cliente_id' => $id,
            'valor' => $request->input('valor'),
            'tipo' => $request->input('tipo'),
            'descricao' => $request->input('descricao')
        ]);

        return response()->json([
            "limite" => $cliente->limite,
            "saldo" => $cliente->saldo
        ], Response::HTTP_OK);
    }


}
