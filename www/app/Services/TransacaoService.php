<?php

namespace App\Services;

use App\Exceptions\LimiteInsuficienteException;
use App\Models\Cliente;
use Exception;
use Illuminate\Support\Facades\DB;


class TransacaoService {


    static function debito(Cliente $cliente, int $valor, string $descricao) {

        $saldo = $cliente->saldo;
        $novoSaldo = $saldo - $valor;


        if ($novoSaldo < - $cliente->limite) {
            throw new LimiteInsuficienteException;
        }

        try {
            DB::beginTransaction();

            $cliente->update(['saldo' => $novoSaldo]);

            DB::table('transacoes')->updateOrInsert([
                'cliente_id' => $cliente->id,
                'valor' => $valor,
                'tipo' => 'd',
                'realizada_em' => now(),
                'descricao' => $descricao
            ]);

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    static function credito(Cliente $cliente, int $valor, string $descricao) {

        DB::beginTransaction();

        DB::table('clientes')->where('id', $cliente->id)->increment('saldo', $valor);

        DB::table('transacoes')->updateOrInsert([
            'cliente_id' => $cliente->id,
            'valor' => $valor,
            'tipo' => 'c',
            'realizada_em' => now(),
            'descricao' => $descricao
        ]);

        DB::commit();
    }

}
