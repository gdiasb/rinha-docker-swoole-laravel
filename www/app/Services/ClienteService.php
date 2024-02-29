<?php

namespace App\Services;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class ClienteService {


    public static function find(int $id) {
        try {
            $cliente = Cliente::findOrFail($id);
        }
        catch (ModelNotFoundException $e) {
            return response()->json(["message"=> "Cliente não encontrado"], Response::HTTP_NOT_FOUND);
        }

    }
}
