<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

//Modelos
use App\Models\Persona;
use Faker\Provider\ar_EG\Person;

class PersonaController extends Controller
{
    public function index()
    {
        $personas = Persona::all();
        return view('persona.index')->with('personas', $personas);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'nombre' => 'required|string',
        //     'edad' => 'required|integer|between:30,99',
        //     'fecha_actual' => 'required|date',
        //     'fecha_inicio_primaria' => 'required|date',
        //     'fecha_inicio_secundaria' => 'required|date',
        // ]);
        $persona = new Persona;
        $persona->nombre = $request->nombre;
        $persona->edad = $request->edad;
        $persona->fecha_actual = $request->fecha_actual;
        $persona->fecha_inicio_primaria = $request->fecha_primaria;
        $persona->fecha_inicio_secundaria = $request->fecha_secundaria;
        $persona->save();
        
        return redirect()->route('persona.index');
    }

    public function show($id)
    {
        $persona = Persona::find($id);
        return response()->json($persona);
    }

    public function update(Request $request, string $id)
    {
        $persona = Persona::where('id', $id)->first();
        $persona->nombre = $request->nombre;
        $persona->edad = $request->edad;
        $persona->fecha_inicio_primaria = $request->fecha_primaria;
        $persona->fecha_inicio_secundaria = $request->fecha_secundaria;
        $persona->save();

        return redirect()->route('persona.index');
    }

    public function delete(string $id)
    {
        Log::info("entra al delete");
        $persona = Persona::findOrFail($id);
        $persona->delete();
        return redirect()->route('persona.index');
    }

    //Funcion para obtener la lista de meses que han pasado dentro del rango de la fecha primaria y secundaria
    public function fechas($id)
    {
        $persona = Persona::findOrFail($id);

        $fechaInicio = new \DateTime($persona->fecha_inicio_primaria);
        $fechaFin = new \DateTime($persona->fecha_inicio_secundaria);

        if ($fechaInicio > $fechaFin) {
            return response()->json(['error' => 'La fecha de secundaria debe ser posterior a la de primaria'], 400);
        }

        $intervalo = new \DateInterval('P1M');
        $periodo = new \DatePeriod($fechaInicio, $intervalo, $fechaFin->modify('+1 month'));

        $fechas = [];

        foreach ($periodo as $fecha) {
            $fechas[] = $fecha->format('Ym');
        }

        $fechasTexto = array_map(function($fecha) {
            $anio = substr($fecha, 0, 4);
            $mes = (int)substr($fecha, 4, 2);
            $nombreMes = \DateTime::createFromFormat('!m', $mes)->format('F');
            return "$anio$nombreMes";
        }, $fechas);

        return view('persona.fechas', ['fechas' => $fechasTexto]);
    }

    //Funcion para saber cuantos dias, meses y años que han pasado dentro del rango de las fechas de primaria y secundaria
    public function calculateDateRange(Request $request)
    {
        $request->validate([
            'fecha_primaria' => 'required|date',
            'fecha_secundaria' => 'required|date',
        ]);
    
        $fechaPrimaria = Carbon::parse($request->fecha_primaria);
        $fechaSecundaria = Carbon::parse($request->fecha_secundaria);
    
        $totalDias = $fechaPrimaria->diffInDays($fechaSecundaria);
        $totalMeses = $fechaPrimaria->diffInMonths($fechaSecundaria);
        $totalAnios = $fechaPrimaria->diffInYears($fechaSecundaria);
    
        return response()->json([
            'dias' => $totalDias,
            'meses' => $totalMeses,
            'anios' => $totalAnios
        ]);
    }
}
