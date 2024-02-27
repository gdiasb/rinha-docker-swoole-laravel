<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransacaoRequest;
use App\Models\Transacao;
use Illuminate\Http\JsonResponse;
use App\Models\Cliente;

class TransacaoController extends Controller
{

    public function store(TransacaoRequest $request, int $id): JsonResponse
    {

        $cliente = Cliente::findOrFail($id);

        $valor = $request->input('valor');
        $saldo = $cliente->saldo;

        if ($request->input('tipo') === 'd') {
            $novoSaldo = $saldo - $valor;

            if ($novoSaldo < - $cliente->limite) {
                return response()->json('Transação inválida: limite não permite', 400);
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

        return response()->json($transacao, 201);
    }


}
