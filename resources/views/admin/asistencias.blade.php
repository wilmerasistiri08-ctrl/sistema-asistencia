@extends('layouts.app')

@section('title', 'Historial de Asistencias')

@section('content')
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-5">
    <div>
        <a href="{{ route('admin.usuarios') }}" class="text-emerald-400 hover:text-emerald-300 text-sm font-bold flex items-center gap-2 mb-3 transition bg-slate-800/50 w-max px-3 py-1.5 rounded-lg border border-slate-700">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </a>
        <h2 class="text-3xl font-bold text-white">Registro de: <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-300">{{ $usuario->nombre }}</span></h2>
        <p class="text-slate-400 font-medium mt-1">UID Tarjeta: <span class="bg-emerald-900/40 text-emerald-400 border border-emerald-800 px-2.5 py-1 rounded-md font-mono text-sm font-bold">{{ $usuario->uid }}</span></p>
    </div>
    
    <!-- Filtro de Mes -->
    <form action="{{ route('admin.usuario.asistencias', $usuario->id) }}" method="GET" class="flex gap-2 glass-card p-2.5 rounded-2xl">
        <input type="month" name="mes" value="{{ $mesSeleccionado }}" class="bg-slate-900 text-slate-300 border border-slate-700 rounded-xl px-4 py-2 text-sm font-semibold focus:border-emerald-500 outline-none transition">
        <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-2 px-5 rounded-xl text-sm transition flex items-center gap-2 shadow-md">
            <i class="fa-solid fa-filter"></i> Ver Mes
        </button>
    </form>
</div>

<!-- Tabla Matriz -->
<div class="glass-card overflow-hidden">
    <!-- CONTENEDOR CON SCROLL Y ENCABEZADO FIJO -->
    <div class="max-h-[70vh] overflow-y-auto relative">
        <table class="w-full text-left border-collapse text-sm">
            <!-- ENCABEZADO FIJO (sticky top-0) -->
            <thead class="sticky top-0 z-10 bg-slate-800 text-white shadow-md">
                <tr class="border-b border-slate-700">
                    <th class="p-5 font-bold text-center w-24 border-r border-slate-700">Día</th>
                    <th class="p-5 font-bold text-center w-32 border-r border-slate-700">Estado</th>
                    <th class="p-5 font-bold text-center text-blue-400 border-r border-slate-700"><i class="fa-solid fa-arrow-right-to-bracket mr-1"></i> Entradas</th>
                    <th class="p-5 font-bold text-center text-orange-400"><i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Salidas</th>
                </tr>
            </thead>
            <tbody class="bg-slate-800/20 divide-y divide-slate-700/50">
                @for ($dia = 1; $dia <= $diasEnElMes; $dia++)
                    @php
                        $fechaActual = $mesSeleccionado . '-' . str_pad($dia, 2, '0', STR_PAD_LEFT);
                        $nombreDia = \Carbon\Carbon::parse($fechaActual)->translatedFormat('l');
                        $esFinDeSemana = \Carbon\Carbon::parse($fechaActual)->isWeekend();
                        
                        $entradas = isset($matrizAsistencia[$dia]['ENTRADA']) ? $matrizAsistencia[$dia]['ENTRADA'] : [];
                        $salidas = isset($matrizAsistencia[$dia]['SALIDA']) ? $matrizAsistencia[$dia]['SALIDA'] : [];
                        
                        $estado = "Faltó";
                        $estadoBg = "bg-red-900/40 text-red-400 border border-red-900";
                        if (count($entradas) > 0 || count($salidas) > 0) {
                            if (count($entradas) > 0 && count($salidas) > 0) {
                                $estado = "Completo";
                                $estadoBg = "bg-green-900/40 text-green-400 border border-green-900";
                            } else {
                                $estado = "Incompleto";
                                $estadoBg = "bg-amber-900/40 text-amber-400 border border-amber-900";
                            }
                        }
                    @endphp
                    
                    <tr class="hover:bg-slate-800/60 transition {{ $esFinDeSemana ? 'bg-slate-900/40' : '' }}">
                        <td class="p-4 text-center border-r border-slate-700/50">
                            <div class="font-extrabold text-white text-xl">{{ $dia }}</div>
                            <div class="text-xs font-bold {{ $esFinDeSemana ? 'text-emerald-400' : 'text-slate-500' }}">{{ $nombreDia }}</div>
                        </td>
                        <td class="p-4 text-center border-r border-slate-700/50">
                            <span class="text-xs font-bold px-3 py-1.5 rounded-lg {{ $estadoBg }}">{{ $estado }}</span>
                        </td>
                        <td class="p-4 text-center border-r border-slate-700/50">
                            @if(count($entradas) > 0)
                                <div class="flex flex-wrap justify-center gap-2">
                                    @foreach($entradas as $hora)
                                        <span class="bg-slate-800 border border-blue-700 text-blue-400 px-2.5 py-1 rounded-lg text-xs font-bold shadow-sm">{{ $hora }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-slate-600 font-bold">-</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            @if(count($salidas) > 0)
                                <div class="flex flex-wrap justify-center gap-2">
                                    @foreach($salidas as $hora)
                                        <span class="bg-slate-800 border border-orange-700 text-orange-400 px-2.5 py-1 rounded-lg text-xs font-bold shadow-sm">{{ $hora }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-slate-600 font-bold">-</span>
                            @endif
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
@endsection