<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Registro;

class AdminController extends Controller
{
    // 1. Página de inicio (Dashboard)
    public function index()
    {
        $totalUsuarios = Usuario::count();
        $totalRegistros = Registro::count();
        $ultimosRegistros = Registro::orderBy('fecha_hora', 'desc')->take(5)->get();
        
        return view('admin.dashboard', compact('totalUsuarios', 'totalRegistros', 'ultimosRegistros'));
    }

    // 2. Mostrar formulario y lista de usuarios
    public function usuarios()
    {
        $usuarios = Usuario::orderBy('nombre', 'asc')->get();
        return view('admin.usuarios', compact('usuarios'));
    }

    // 3. Guardar un nuevo usuario
    public function crearUsuario(Request $request)
    {
        $request->validate([
            'uid' => 'required|string|unique:usuarios,uid',
            'nombre' => 'required|string|max:100',
        ]);

        Usuario::create([
            'uid' => strtoupper($request->uid),
            'nombre' => $request->nombre,
            'activo' => true,
        ]);

        return redirect()->route('admin.usuarios')->with('success', 'Usuario registrado correctamente.');
    }

    // 4. Activar/Desactivar usuario
    public function toggleActivo($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->activo = !$usuario->activo;
        $usuario->save();

        return redirect()->back()->with('success', 'Estado del usuario actualizado.');
    }

    // 5. Ver asistencias de un usuario específico
        // Ver asistencias de un usuario específico con filtros
       // Ver asistencias en formato de Matriz Mensual
    public function usuarioAsistencias(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        
        // Obtener el mes seleccionado o usar el mes actual por defecto (formato: YYYY-MM)
        $mesSeleccionado = $request->input('mes', date('Y-m'));
        
        // Obtener registros solo de ese mes
        $asistencias = Registro::where('uid', $usuario->uid)
            ->whereMonth('fecha_hora', date('m', strtotime($mesSeleccionado)))
            ->whereYear('fecha_hora', date('Y', strtotime($mesSeleccionado)))
            ->orderBy('fecha_hora', 'asc')
            ->get();

        // Agrupar los registros por día del mes y por tipo (ENTRADA/SALIDA)
        $matrizAsistencia = [];
        foreach ($asistencias as $asistencia) {
            $dia = date('j', strtotime($asistencia->fecha_hora)); // Día del mes (1-31)
            $hora = date('H:i', strtotime($asistencia->fecha_hora)); // Hora (HH:MM)
            
            if (!isset($matrizAsistencia[$dia])) {
                $matrizAsistencia[$dia] = ['ENTRADA' => [], 'SALIDA' => []];
            }
            
            $matrizAsistencia[$dia][$asistencia->tipo][] = $hora;
        }

        // Saber cuántos días tiene el mes seleccionado
        $diasEnElMes = date('t', strtotime($mesSeleccionado));
        
        return view('admin.asistencias', compact('usuario', 'matrizAsistencia', 'mesSeleccionado', 'diasEnElMes'));
    }
}