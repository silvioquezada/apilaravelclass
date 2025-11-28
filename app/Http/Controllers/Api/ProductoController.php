<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    
    public function index()
    {
        return Producto::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'descripcion' => 'required',
            'stock' => 'required|numeric',
            'precio' => 'required|numeric',
            'iva' => 'required|numeric'
        ]);

        // Crear el producto
        Producto::create([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'stock' => $request->stock,
            'precio' => $request->precio,
            'iva' => $request->iva
        ]);

        return response()->json([
            'estado' => 1,
            'data' => $producto
        ], 201);
    }

    public function show(string $id)
    {
        return Producto::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->update($request->all());
        return response()->json($producto);
    }

    public function destroy($id)
    {
        Producto::destroy($id);
        return response()->json(null, 204);
    }
}
