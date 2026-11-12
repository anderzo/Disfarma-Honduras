<?php

namespace App\Http\Controllers;

use App\Models\Medicamentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicamentosController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $medicamentos = Medicamentos::when($buscar, function ($query, $buscar) {
            return $query->where('nombreMedicamento', 'LIKE', "%{$buscar}%")
                         ->orWhere('codigo', 'LIKE', "%{$buscar}%");
        })->paginate(10);

        return view('medicamentos', compact('medicamentos', 'buscar'));
    }

    public function create()
    {
        return view('medicamentos_create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|unique:medicamentos,codigo',
            'nombreMedicamento' => 'required|string|max:255',
            'categoria' => 'required|string',
            'precio' => 'required|numeric|gt:0',
            'costo' => 'required|numeric|gt:0',
            'inventario' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'laboratorio' => 'required|string',
            'numero_lote' => 'required|string',
            'vencimiento' => 'required|date',
        ]);

        $data = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            $nombreImagen = time() . '_' . $request->file('imagen')->getClientOriginalName();
            $data['imagen'] = $request->file('imagen')->storeAs('uploads/medicamentos', $nombreImagen, 'public');
        }

        Medicamentos::create($data);

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento creado exitosamente.');
    }

    public function edit(string $id)
    {
        $medicamento = Medicamentos::findOrFail($id);
        return view('medicamentos_edit', compact('medicamento'));
    }

    public function update(Request $request, string $id)
    {
        $medicamento = Medicamentos::findOrFail($id);

        $request->validate([
            'codigo' => 'required|string|unique:medicamentos,codigo,' . $id,
            'nombreMedicamento' => 'required|string|max:255',
            'categoria' => 'required|string',
            'precio' => 'required|numeric|gt:0',
            'costo' => 'required|numeric|gt:0',
            'inventario' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'laboratorio' => 'required|string',
            'numero_lote' => 'required|string',
            'vencimiento' => 'required|date',
        ]);

        $data = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            if ($medicamento->imagen && Storage::disk('public')->exists($medicamento->imagen)) {
                Storage::disk('public')->delete($medicamento->imagen);
            }
            $nombreImagen = time() . '_' . $request->file('imagen')->getClientOriginalName();
            $data['imagen'] = $request->file('imagen')->storeAs('uploads/medicamentos', $nombreImagen, 'public');
        }

        $medicamento->update($data);

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento actualizado');
    }

    public function destroy(string $id)
    {
        $medicamento = Medicamentos::findOrFail($id);

        if ($medicamento->imagen && Storage::disk('public')->exists($medicamento->imagen)) {
            Storage::disk('public')->delete($medicamento->imagen);
        }

        $medicamento->delete();

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento eliminado');
    }
}