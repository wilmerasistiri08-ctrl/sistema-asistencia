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

            // Mantenemos el formato: ESTADO|MENSAJE
            return response("ACCESO_PERMITIDO|" . $usuario->nombre, 200)
                ->header('Content-Type', 'text/plain');
        } else {
            // Cambio FC-RFID-001: Mantenemos el estado para el ESP32 y agregamos el mensaje para el usuario
            return response("ACCESO_DENEGADO|Tarjeta no registrada, acérquese a administración", 200)
                ->header('Content-Type', 'text/plain');
        }
    }
}