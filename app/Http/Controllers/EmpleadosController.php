<?php

namespace App\Http\Controllers;

use App\Models\Empleados;
use Illuminate\Http\Request;

class EmpleadosController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $empleados = Empleados::when($buscar, function ($query, $buscar) {
            return $query->where('nombre', 'LIKE', "%{$buscar}%")
                         ->orWhere('apellido', 'LIKE', "%{$buscar}%")
                         ->orWhere('identidad', 'LIKE', "%{$buscar}%");
        })->paginate(10);

        return view('empleados', compact('empleados', 'buscar'));
    }

    public function store(Request $request)
    {
        $datosValidados = $request->validate([
            'identidad' => ['required', 'string', 'size:13', 'unique:empleados,identidad', 'regex:/^[0-9]+$/'],
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'cargo' => 'required|string',
            'salario' => 'required|numeric|gt:0',
            'fecha_ingreso' => 'required|date',
            'estado' => 'required|in:Activo,Inactivo',
        ]);

        Empleados::create($datosValidados);

        return redirect()->route('empleados.index')->with('success', 'Registrado exitosamente');
    }

    public function update(Request $request, string $id)
    {
        $empleado = Empleados::findOrFail($id);

        $request->validate([
            'identidad' => ['required', 'string', 'size:13', 'unique:empleados,identidad,' . $id, 'regex:/^[0-9]+$/'],
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'cargo' => 'required|string',
            'salario' => 'required|numeric|gt:0',
            'fecha_ingreso' => 'required|date',
            'estado' => 'required|in:Activo,Inactivo',
        ]);

        $empleado->update($request->validated());

        return redirect()->route('empleados.index')->with('success', 'Actualizado correctamente');
    }

    public function destroy(string $id)
    {
        $empleado = Empleados::findOrFail($id);
        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado elimnado ');
    }
}