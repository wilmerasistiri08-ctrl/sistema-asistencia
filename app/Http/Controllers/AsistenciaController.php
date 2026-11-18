<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Registro;

class AsistenciaController extends Controller
{
    public function registrar(Request $request)
    {
        // 1. Validar que el ESP32 envíe los datos necesarios
        $request->validate([
            'uid' => 'required|string',
            'tipo' => 'required|in:ENTRADA,SALIDA',
        ]);

        $uid = $request->input('uid');
        $tipo = $request->input('tipo');

        // 2. Buscar al usuario por su UID (verificando que esté activo)
        $usuario = Usuario::where('uid', $uid)->where('activo', true)->first();

        // 3. Si el usuario existe y está activo, registrar la asistencia
        if ($usuario) {
            Registro::create([
                'uid' => $uid,
                'tipo' => $tipo,
            ]);

            return response("ACCESO_PERMITIDO|" . $usuario->nombre, 200)
                ->header('Content-Type', 'text/plain');
        } else {
            return response("ACCESO_DENEGADO", 200)
                ->header('Content-Type', 'text/plain');
        }
    }
}