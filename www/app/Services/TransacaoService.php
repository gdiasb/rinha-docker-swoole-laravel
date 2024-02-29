<?php

namespace App\Services;

use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class TransacaoService {


    function first() {



    }

    static function debito(Cliente $cliente, int $valor, string $descricao) {

        DB::beginTransaction();

        $saldo = $cliente->saldo;
        $novoSaldo = $saldo - $valor;

        if ($novoSaldo < - $cliente->limite) {
            DB::rollBack();
            return response()->json('Transação inválida: limite não permite', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        DB::table('clientes')->where('id', $cliente->id)->decrement('saldo', $valor);

        DB::table('transacoes')->updateOrInsert([
            'cliente_id' => $cliente->id,
            'valor' => $valor,
            'tipo' => 'd',
            'descricao' => $descricao
        ]);

        DB::commit();
    }


    static function credito(Cliente $cliente, int $valor, string $descricao) {

        DB::beginTransaction();

        DB::table('clientes')->where('id', $cliente->id)->increment('saldo', $valor);

        DB::table('transacoes')->updateOrInsert([
            'cliente_id' => $cliente->id,
            'valor' => $valor,
            'tipo' => 'c',
            'descricao' => $descricao
        ]);

        DB::commit();
    }

}
