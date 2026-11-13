<?php

namespace App\Http\Controllers;

use App\Models\Proveedores;
use Illuminate\Http\Request;

class ProveedoresController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $proveedores = Proveedores::when($buscar, function ($query, $buscar) {
            return $query->where('empresa', 'LIKE', "%{$buscar}%")
                         ->orWhere('rtn', 'LIKE', "%{$buscar}%");
        })->paginate(10);

        return view('proveedores', compact('proveedores', 'buscar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rtn' => ['required', 'string', 'size:14', 'unique:proveedores,rtn', 'regex:/^[0-9]+$/'],
            'empresa' => 'required|string|max:255',
            'telefono' => ['required', 'string', 'size:8', 'regex:/^[2389][0-9]{7}$/'],
            'contacto' => 'required|string|max:255',
            'categoria' => 'required|string',
            'limite_credito' => 'required|numeric|min:0',
            'dias_credito' => 'required|integer|in:15,30,45,60',
            'estado' => 'required|in:Activo,Inactivo',
        ]);

        Proveedores::create($request->except('_token'));

        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado exitosamente.');
    }

    public function update(Request $request, string $id)
    {
        $proveedor = Proveedores::findOrFail($id);

        $request->validate([
            'rtn' => ['required', 'string', 'size:14', 'unique:proveedores,rtn,' . $id, 'regex:/^[0-9]+$/'],
            'empresa' => 'required|string|max:255',
            'telefono' => ['required', 'string', 'size:8', 'regex:/^[2389][0-9]{7}$/'],
            'contacto' => 'required|string|max:255',
            'categoria' => 'required|string',
            'limite_credito' => 'required|numeric|min:0',
            'dias_credito' => 'required|integer|in:15,30,45,60',
            'estado' => 'required|in:Activo,Inactivo',
        ]);

        $proveedor->update($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $proveedor = Proveedores::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado.');
    }
}