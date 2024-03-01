<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class LimiteInsuficienteException extends Exception
{
    public function render() {
        return response()->json(['message' => 'Operação inválida: Limite insuficiente'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
